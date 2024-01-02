<?php
namespace App\Controller;

use App\Entity\Slider;
use App\Form\SliderformType;
use App\Repository\SliderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SliderController extends AbstractController
{

    #[Route('/admin/sliders', name: 'admin_sliders')]
    public function slider(SliderRepository $repo): Response
    {
        $sliders = $repo->findAll();
        return $this->render('admin/slider/slider.html.twig',[
            'sliders'=>$sliders,
            'controller_name' => 'SliderController',
            
        ]);
    }

    
    #[Route('/admin/slider/update/{id}', name: "admin_slider_update")]
    #[Route('/admin/slider/new', name: "new_slider")]    public function sliderform(Request $request, EntityManagerInterface $manager, Slider $slider = null)
    {
        if ($slider == null) {
            $slider = new Slider;
        }
    
        $form = $this->createForm(SliderformType::class, $slider);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('image')->getData();
    
            if ($file instanceof UploadedFile) {
                $fileName = uniqid().'.'.$file->guessExtension();
                $file->move(
                    $this->getParameter('photo_dir'), // Répertoire de destination pour les fichiers
                    $fileName
                );
                $slider->setImage($fileName); // Assurez-vous que votre entité a une propriété "photo" pour stocker le chemin du fichier
            }
    
            $manager->persist($slider);
            $manager->flush();
    
            return $this->redirectToRoute('admin_sliders');
        }
    
        return $this->render('admin/slider/sliderform.html.twig', [
            'form' => $form,
            'editMode' => $slider->getId() != null,
            'slider' => $slider
        ]);
    }
    
    #[Route('/admin/slider/delete/{id}', name: "admin_slider_delete")]
    public function deleteSlider(Slider $slider, EntityManagerInterface $manager)
    {
        $manager->remove($slider);
        $manager->flush();
    
        return $this->redirectToRoute('admin_sliders');
    }
}