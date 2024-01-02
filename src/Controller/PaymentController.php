<?php

namespace App\Controller;

use Stripe\Stripe;
use App\Service\CartService;
use Stripe\Checkout\Session;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
class PaymentController extends AbstractController

{

    private UrlGeneratorInterface $generator;

    public function __construct(UrlGeneratorInterface $generator)
    {
        $this->generator = $generator;
    }

    #[Route('/payment/create-session-stripe', name: 'payment_stripe')]
    public function stripeCheckout(CartService $cs): RedirectResponse
    {
        $cartWithData = $cs->cartWithData();
        // dd($cartWithData);
       Stripe::setApiKey($_ENV['STRIPE_PRIVATE_KEY_TEST']);
       //! tableau des products pour stripe vide pour le moment.
        $productStripe = [];

        //! parcourir notre panier et remplir le tableau de product pour stripe
       foreach($cartWithData as $data)
       {
        $productStripe[] = [
            'price_data' => [
                'currency' => 'eur',
                'unit_amount' => $data['product']->getPrice() * 100,
                'product_data' => [
                    'name' => $data['product']->getQuantity(), // Ajoutez le nom du produit ici
                    // Ajoutez d'autres informations du produit si nécessaire
                ],
            ],
            'quantity' => $data['quantity'],
        ];
       }
    //    dd($productStripe);
       $checkout_session = Session::create([
        'customer_email' => $this->getUser()->getEmail(),
        'payment_method_types' => ['card'],
        'line_items' => [[
            $productStripe,
        ]],
        'mode' => 'payment',
        'success_url' => $this->generator->generate('payment_success', [], UrlGeneratorInterface::ABSOLUTE_URL ),
        'cancel_url' => $this->generator->generate('payment_error', [], UrlGeneratorInterface::ABSOLUTE_URL ),
        ]);

        return new RedirectResponse($checkout_session->url);

    }

    #[Route('/payment/success', name:'payment_success')]
    public function stripeSuccess() : Response
    {
        return $this->redirectToRoute('cart_commande');
    }

    #[Route('/payment/error', name:'payment_error')]
    public function stripeError() : Response
    {
        $this->addFlash('danger', 'payment refusé');
        return $this->redirectToRoute('cart');
    }
}