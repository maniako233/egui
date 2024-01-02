<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductformType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{
    #[Route('/admin/produits',name: 'admin_products')]

    public function product(ProductRepository $repo): Response
    {
        $products = $repo->findAll();
        return $this->render('admin/product/product.html.twig',[
            'products'=>$products,
            'controller_name' => 'ProductController',
            
        ]);
    }

    
    #[Route('/admin/product/update/{id}', name: "admin_product_update")]
    #[Route('/admin/product/new', name: "admin_product_new")]
    public function form(Request $request, EntityManagerInterface $manager, Product $product = null)
    {
        if ($product == null) {
            $product = new Product;
        }
    
        $form = $this->createForm(ProductformType::class, $product);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('image')->getData();
    
            if ($file instanceof UploadedFile) {
                $fileName = uniqid().'.'.$file->guessExtension();
                $file->move(
                    $this->getParameter('photo_dir'), // Répertoire de destination pour les fichiers
                    $fileName
                );
                $product->setImage($fileName); // Assurez-vous que votre entité a une propriété "photo" pour stocker le chemin du fichier
            }
    
            $manager->persist($product);
            $manager->flush();
    
            return $this->redirectToRoute('admin_products');
        }
    
        return $this->render('admin/product/productform.html.twig', [
            'form' => $form,
            'editMode' => $product->getId() != null,
            'product' => $product
        ]);
    }
    
    #[Route('/admin/product/delete/{id}', name: "admin_product_delete")]
    public function deleteType(Product $product, EntityManagerInterface $manager)
    {
        $manager->remove($product);
        $manager->flush();
    
        return $this->redirectToRoute('admin_products');
    }
}