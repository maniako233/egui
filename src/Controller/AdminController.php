<?php

namespace App\Controller;

use App\Entity\Supplier;
use App\Repository\ProductRepository;
use App\Repository\SupplierRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'admin')]
    public function admin(): Response
    {
        return $this->render('admin/admin.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    #[Route('/admin/fournisseurs', name: 'admin_supplier')]

    public function supplieradmin(SupplierRepository $repo): Response
    {
        $suppliers = $repo->findAll();
        return $this->render('admin/supplier/adminsup.html.twig', [
            'suppliers'=>$suppliers,
           
            
        ]);
    }

    #[Route('/admin/supplier/delete/{id}', name: "admin_supplier_delete")]
    public function deleteSupplier(Supplier $supplier, EntityManagerInterface $manager)
    {
        $manager->remove($supplier);
        $manager->flush();
    
        return $this->redirectToRoute('admin_supplier');

    }

    #[Route('/admin/products', name: 'admin_products')]

    public function prodadmin(ProductRepository $repo): Response
    {
        $products = $repo->findAll();
        return $this->render('admin/product/product.html.twig', [
            'products'=>$products,
           
            
        ]);
    
}



    
#[Route('/admin/prodsup', name: 'show_suppliers_with_products')]
public function showSuppliersWithProducts(SupplierRepository $supplierRepository, ProductRepository $productRepository): Response
{
    // Vérifiez si l'utilisateur a le rôle d'administrateur
    if (!$this->isGranted('ROLE_ADMIN')) {
        throw new AccessDeniedException('Accès refusé. Vous n\'avez pas les droits d\'administrateur.');
    }

    // Logique pour afficher les fournisseurs avec les produits associés
    $suppliers = $supplierRepository->createQueryBuilder('s')
        ->addSelect('p') // Charge les produits associés
        ->leftJoin('s.products', 'p')
        ->getQuery()
        ->getResult();

    // Logique pour afficher les produits dans la boutique
    $products = $productRepository->findAll();

    return $this->render('admin/showsuppliersproducts.html.twig', [
        'suppliers' => $suppliers,
        'products' => $products,
    ]);
}



}