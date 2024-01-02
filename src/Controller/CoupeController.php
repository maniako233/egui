<?php

namespace App\Controller;

use App\Entity\Type;
use App\Entity\Coupe;
use App\Form\CoupeformType;
use App\Form\ThetypeformType;
use App\Repository\TypeRepository;
use App\Repository\CoupeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CoupeController extends AbstractController
{
    #[Route('/admin/coupes', name: 'admin_coupes')]

    public function coupe(CoupeRepository $repo): Response
    {
        $coupes = $repo->findAll();
        return $this->render('admin/admincoupes.html.twig', [
            'coupes' => $coupes,
            'controller_name' => 'CoupeController',

        ]);
    }


    #[Route('/admin/coupe/update/{id}', name: "admin_coupe_update")]
    #[Route('/admin/coupe/new', name: "admin_coupe_new")]
    public function formCoupe(Request $request, EntityManagerInterface $manager, Coupe $coupe = null)
    {

        if ($coupe == null) {
            $coupe =  new Coupe;
        }


        $form = $this->createForm(CoupeformType::class, $coupe);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $manager->persist($coupe);
            $manager->flush();
            return $this->redirectToRoute('admin_coupes');
        }
        return $this->render('admin/admincoupeform.html.twig', [
            'form' => $form,
            'editMode' => $coupe->getId() != null,
            'coupe' => $coupe
        ]);
    }

    #[Route('/admin/coupe/delete/{id}', name: "admin_coupe_delete")]
    public function deleteCoupe(Coupe $coupe, EntityManagerInterface $manager)
    {
        $manager->remove($coupe);
        $manager->flush();
        return $this->redirectToRoute('admin_coupes');
    }


    #[Route('/admin/types', name: 'admin_types')]

    public function type(TypeRepository $repo): Response
    {
        $types = $repo->findAll();
        return $this->render('admin/admintypes.html.twig', [
            'types' => $types,

        ]);
    }


    #[Route('/admin/type/update/{id}', name: "admin_type_update")]
    #[Route('/admin/type/new', name: "admin_type_new")]
    public function form(Request $request, EntityManagerInterface $manager, Type $type = null)
    {
        if ($type == null) {
            $type = new Type;
        }

        $form = $this->createForm(ThetypeformType::class, $type);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('image')->getData();

            if ($file instanceof UploadedFile) {
                $fileName = uniqid() . '.' . $file->guessExtension();
                $file->move(
                    $this->getParameter('photo_dir'), // Répertoire de destination pour les fichiers
                    $fileName
                );
                $type->setImage($fileName); // Assurez-vous que votre entité a une propriété "photo" pour stocker le chemin du fichier
            }

            $manager->persist($type);
            $manager->flush();

            return $this->redirectToRoute('admin_types');
        }

        return $this->render('admin/admintypeform.html.twig', [
            'form' => $form,
            'editMode' => $type->getId() != null,
            'type' => $type
        ]);
    }

    #[Route('/admin/type/delete/{id}', name: "admin_type_delete")]
    public function deleteType(Type $type, EntityManagerInterface $manager)
    {
        $manager->remove($type);
        $manager->flush();

        return $this->redirectToRoute('admin_types');
    }






}