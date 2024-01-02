<?php
namespace App\Controller;
use App\Entity\Order;
use App\Entity\Detailorder;
use App\Form\OrderformType;
use App\Form\DetailorderformType;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\DetailorderRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrderController extends AbstractController
{
    
    #[Route('/admin/commandes', name: 'admin_orders')]

    public function order(OrderRepository $orderRepository): Response
    {
        $orders = $orderRepository->findAll();


      
        return $this->render('admin/order/adminorders.html.twig', [
            'orders' => $orders,
           

        ]);


        
    }


    #[Route('/admin/commande/update/{id}', name: "admin_order_update")]
    #[Route('/admin/commande/new', name: "admin_order_new")]
    public function formOrder(Request $request, EntityManagerInterface $manager, Order $order = null)
    {

        if ($order == null) {
            $order =  new Order;
           
        }


        $form = $this->createForm(OrderformType::class, $order);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $manager->persist($order);
            $manager->flush();
            return $this->redirectToRoute('admin_orders');
        }
        return $this->render('admin/order/adminorderform.html.twig', [
            'form' => $form,
            'editMode' => $order->getId() != null,
            'order' => $order
        ]);
    }

    #[Route('/admin/commande/delete/{id}', name: "admin_order_delete")]
    public function deleteOrder(Order $order, EntityManagerInterface $manager)
    {
        $manager->remove($order);
        $manager->flush();
        return $this->redirectToRoute('admin_orders');
    }

    #[Route('/admin/detailcommande', name: 'admin_detailorders')]

    public function detailorder( DetailorderRepository $repoDet): Response
    {
        $detailorders = $repoDet->findAll();
        return $this->render('admin/order/admindetailorders.html.twig', [
            'detailorders' => $detailorders,
           

        ]);
    }


    #[Route('/admin/detailcommande/update/{id}', name: "admin_detailorder_update")]
    #[Route('/admin/detailcommande/nouveau', name: "admin_detailorder_new")]
    public function formDetailorder(Request $request, EntityManagerInterface $manager, Detailorder $detailorder = null)
    {

        if ($detailorder == null) {
            $detailorder =  new Detailorder;
        }


        $form = $this->createForm(DetailorderformType::class, $detailorder);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $manager->persist($detailorder);
            $manager->flush();
            return $this->redirectToRoute('admin_detailorders');
        }
        return $this->render('admin/order/admindetailorderform.html.twig', [
            'form' => $form,
            'editMode' => $detailorder->getId() != null,
            'detailorder' => $detailorder
        ]);
    }

    #[Route('/admin/detailcommande/delete/{id}', name: "admin_detailorder_delete")]
    public function deletedetailorder(Detailorder $detailorder, EntityManagerInterface $manager)
    {
        $manager->remove($detailorder);
        $manager->flush();
        return $this->redirectToRoute('admin_detailorders');
    }


}


    







    