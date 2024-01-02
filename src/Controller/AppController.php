<?php
namespace App\Controller;
use DateTime;
use App\Entity\Avis;
use App\Entity\Product;
use App\Form\AvisformType;
use App\Form\ProductformType;
use App\Repository\AvisRepository;
use App\Repository\SliderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class AppController extends AbstractController
{

 #[Route('/', name: 'accueil')]
    public function accueil(SliderRepository $repoSlid, ): Response
    {   
        $sliders = $repoSlid->findAll();

        return $this->render('app/index.html.twig', [
             'sliders' => $sliders,   
           
        ]);
    }
         #[Route('/a-propos', name: 'propos')]
         public function apropo(): Response
    {   
      
        return $this->render('app/apropos.html.twig', [
              
           
        ]);
    }

         #[Route('/notreequipe', name: 'app_equipe')]
         public function equipe(): Response
    {   
      
        return $this->render('app/equipe.html.twig', [
              
           
        ]);
    }


   
    #[Route('/fournisseur/annonce', name: "new_productsup")]
    public function formprod(Request $request, EntityManagerInterface $manager, Product $product = null)
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
    
            return $this->redirectToRoute('supplier_merci');
        }
    
        return $this->render('supplier/productform.html.twig', [
            'form' => $form,
            'editMode' => $product->getId() != null,
            'product' => $product
        ]);
    }


    #[Route('/remerciement/fournisseur', name: 'supplier_merci')]
        public function merci(): Response
        {
           
           
            return $this->render('shop/mercisupplier.html.twig', [
                
            ]);
        }
    

    #[Route('/avis/clients', name: 'app_avis_affiche')]
    public function aviaffichel(AvisRepository $repoAvis, ): Response
    {   
        $avis = $repoAvis->findAll();
     
        return $this->render('app/afficheavis.html.twig', [
             'avis' => $avis,   
           
        ]);
    }
        
    
 
    #[Route('/create/avis/{id}', name: "avis_update")]
    #[Route('/create/avis/new', name: "avis_create")]
    public function formCoupe(Request $request, EntityManagerInterface $manager, Security $security, Avis $avis = null): Response
    {
        // Utilisez le service Security pour obtenir l'utilisateur connecté
        $user = $security->getUser();

        if ($avis == null) {
            $avis = new Avis();
            $avis->setDate(new DateTime());
            $avis->setUser($user); // Assurez-vous que la relation User est correctement configurée dans votre entité Avis
        }

        $form = $this->createForm(AvisformType::class, $avis);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($avis);
            $manager->flush();
            return $this->redirectToRoute('avis_affiche');
        }

        return $this->render('app/merciavis.html.twig', [
            'form' => $form->createView(),
            'editMode' => $avis->getId() !== null,
            'avis' => $avis,
        ]);
    }
   
   
        

        #[Route('/compte', name: 'account')]
        public function adddvis(): Response
        {
            // Récupérer l'utilisateur connecté
            $user = $this->getUser();
          
    
            return $this->render('app/account.html.twig', [
                'user' => $user,
                
            ]);
        }


        


    }
    





        


        
           
    
    






      
   



        
    

    