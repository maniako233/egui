<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
   

    #[Route('/admin/users', name: 'users_admin')]
    public function product(UserRepository $repo): Response
    {
        $users = $repo->findAll();
        return $this->render('user/users.html.twig',[
            'users'=>$users,
            'controller_name' => 'UserctController',
            
        ]);
    }

    
    #[Route('/admin/user/update/{id}', name: "user_edit")]
    #[Route('/admin/user/new', name: "admin_user_new")]
    public function form(Request $request, EntityManagerInterface $manager, User $user = null)
    {
        if ($user == null) {
            $user = new User;
        }
    
        $form = $this->createForm(RegistrationFormType  ::class, $user);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
           
           
    
            $manager->persist($user);
            $manager->flush();
    
            return $this->redirectToRoute('users_admin');
        }
    
        return $this->render('user/user/userform.html.twig', [
            'form' => $form,
            'editMode' => $user->getId() != null,
            'user' => $user
        ]);
    }
    
    #[Route('/admin/user/delete/{id}', name: "user_delete")]
    public function deleteType(User $user, EntityManagerInterface $manager)
    {
        $manager->remove($user);
        $manager->flush();
    
        return $this->redirectToRoute('users_admin');
    }


}