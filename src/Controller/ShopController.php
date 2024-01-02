<?php
namespace App\Controller;

use App\Repository\TypeRepository;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
 
class ShopController extends AbstractController
{
    #[Route('/boutique', name: 'boutique')]
    public function shoprod( ProductRepository $repoProd): Response
    {   
        
        $products = $repoProd->findAll();
     

        return $this->render('shop/boutique.html.twig', [
            
             'products' => $products,
           
        ]);
    }


    #[Route('/types/bois', name: 'app_shop_types')]
    public function typepro(TypeRepository $repoType, ): Response
    {   
        $types = $repoType->findAll();
      
         

        return $this->render('shop/typesbois.html.twig', [
             'types' => $types,
           
           
        ]);
    }
}





   
  