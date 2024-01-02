<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MentionslegalesController extends AbstractController
{
    #[Route('/mentionslegales', name: 'app_mentionslegales')]
        public function mentions(): Response
        {
           
           
            return $this->render('app/mentionslegales/mentions.html.twig', [
                
            ]);
        }

    
    
    #[Route('/cgu', name: 'app_cgu')]
        public function cgu(): Response
        {
           
           
            return $this->render('app/mentionslegales/cgu.html.twig', [
                
            ]);
        }
    
    #[Route('/rgpd', name: 'app_rgpd')]
        public function rgpd(): Response
        {
           
           
            return $this->render('app/mentionslegales/rgpd.html.twig', [
                
            ]);
        }
    
    #[Route('/quisommesnous', name: 'app_qsn')]
        public function qsn(): Response
        {
           
           
            return $this->render('app/mentionslegales/quisommesnous.html.twig', [
                
            ]);
        }
    
    #[Route('/conditionsgeneralesdeventes', name: 'app_cgv')]
        public function cgv(): Response
        {
           
           
            return $this->render('app/mentionslegales/cgv.html.twig', [
                
            ]);
        }
}