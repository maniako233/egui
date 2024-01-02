<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Supplier;
use App\Form\ProductformType;
use App\Form\SupplierformType;
use App\Repository\SupplierRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SupplierController extends AbstractController
{
  
    public function supplier(SupplierRepository $repo): Response
    {
        $suppliers = $repo->findAll();
        return $this->render('supplier/index.html.twig',[
            'suppliers'=>$suppliers,
            'controller_name' => 'SupplierController',
            
        ]);
    }



   

    
    #[Route('/supplier/update/{id}', name: "admin_supplier_update")]
    #[Route('/supplier', name: 'new_supplier')]
    public function form(Request $request, EntityManagerInterface $manager, Supplier $supplier = null)
    {
        if ($supplier == null) {
            $supplier = new Supplier;
        }
    
        $form = $this->createForm(SupplierformType::class, $supplier);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid())
         {
            $manager->persist($supplier);
            $manager->flush();
    
            return $this->redirectToRoute('new_productsup');
        }
    
        return $this->render('supplier/supform.html.twig', [
            'suppliers' => $manager->getRepository(Supplier::class)->findAll(),
            'form'=> $form,
            'editMode' =>$supplier->getId()!=null,
            'coupe' => $supplier
        ]);
 }

}


    
 