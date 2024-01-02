<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\Detailorder;
use App\Service\CartService;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
#[Route('/cart')]


class CartController extends AbstractController
{
    #[Route('/panier', name: 'cart')]
    public function index(CartService $cs)
    {
        return $this->render('cart/cart.html.twig', [
            'items' => $cs->CartWithData(),
            'total' => $cs->Total()
        ]);
    }

    #[Route('/cart/add/{id}', name: "cart_add")]
    public function add($id, CartService $cs)
    {
        $cs->add($id);
        return $this->redirectToRoute('cart');
    }

    #[Route('/cart/remove/{id}', name: 'cart_remove')]
    public function remove($id, CartService $cs)
    {
        $cs->remove($id);
        return $this->redirectToRoute('cart');
    }

    #[Route('/cart/drop', name: 'cart_drop')]
    public function delete($id, CartService $cs)
    {
        $cs->remove($id);
        return $this->redirectToRoute('cart');
    }

    #[Route('/commande', name:'cart_commande')]
    public function addOrder(SessionInterface $session, ProductRepository $productRepository, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $panier = $session->get('cart', []);

        if ($panier === []) {
            $this->addFlash('message', 'Votre panier est vide');
            return $this->redirectToRoute('main');
        }

        // Le panier n'est pas vide, on crée la commande
        $order = new Order();

        // On remplit la commande
        $order->setUser($this->getUser());
        $order->setStatut('En cours'); // Vous devrez ajuster cela en fonction de votre logique métier

        // On parcourt le panier pour créer les détails de commande
        foreach ($panier as $item => $quantity) {
            $detailorder = new Detailorder();

            // On va chercher le produit
            $product = $productRepository->find($item);

            $price = $product->getPrice();

            // On crée le détail de commande
            $detailorder->setProduct($product);
            $detailorder->setQuantity($quantity);

            $order->addDetailorder($detailorder);
            $em->persist($detailorder);
        }

        // Calculer le total de la commande (à adapter selon votre logique)
        $total = $this->calculateTotal($order);
        $order->setTotal($total);

        // On persiste et on flush
        $em->persist($order);
        $em->flush();

        $session->remove('cart');

        $this->addFlash('message', 'Commande créée avec succès');
        return $this->redirectToRoute('avis_create');
    }

    // Méthode pour calculer le total de la commande
    private function calculateTotal(Order $order): int
    {
        $total = 0;

        foreach ($order->getDetailorders() as $detailorder) {
            $total += $detailorder->getQuantity() * $detailorder->getProduct()->getPrice();
        }

        return $total;
    }

    // #[Route('/update-cart-count', name: 'update_cart_count', methods: ['GET'])]
    // public function updateCartCount(CartService $cartService)
    // {
    //     $count = count($cartService->cart());
    
    //     return $this->json(['cartCount' => $count]);
    // }

}