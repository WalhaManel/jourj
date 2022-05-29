<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\CreateUserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserController extends AbstractController
{
    /**
     * Modification des info du compte
     * 
     * @Route("/profileSettings/{id}", name="profileSettings")
     */
    public function profileSettings(?User $user,Request $R,EntityManagerInterface $manage, UserPasswordHasherInterface $hasher){

        $RF=$this->createForm(CreateUserType::class,$user);
        $RF->handleRequest($R);
        if($RF->isSubmitted() and $RF->isValid()){
                $pw=$hasher->hashPassword($user,$user->getPassword());
                $user->setPassword($pw);
                $manage->persist($user);
                $manage->flush();
            $this->addFlash('success','le profil a bien été modifié !');
            return $this->redirectToRoute("accueil");
        }
        return $this->render('user/index.html.twig', ['RegisterForm'=>$RF->createView()]);

    } 

    /**
     * Inscription d'un client
     * 
     * @Route("/CreateUser", name="CreateUser")
     */
    public function CreateUser(Request $R,EntityManagerInterface $manage, UserPasswordHasherInterface $hasher): Response
    {   
        $user= new User();
        $RF=$this->createForm(CreateUserType::class,$user);
        $RF->handleRequest($R);
        if($RF->isSubmitted() and $RF->isValid()){
                $pw=$hasher->hashPassword($user,$user->getPassword());
                $user->setPassword($pw);
                $manage->persist($user);
                $manage->flush();
                return $this->redirect('auth');
        }

        return $this->render('user/index.html.twig', ['RegisterForm'=>$RF->createView()]);
    }

    /**
     * Création d'un admin
     * 
     * @Route("/CreateAdmin", name="CreateAdmin")
     */
    public function CreateAdmin(Request $R,EntityManagerInterface $manage, UserPasswordHasherInterface $hasher): Response
    {   
        $user= new User();
        $RF=$this->createForm(CreateUserType::class,$user);
        $RF->handleRequest($R);
        if($RF->isSubmitted() and $RF->isValid()){
                $pw=$hasher->hashPassword($user,$user->getPassword());
                $user->setPassword($pw);
                $user->setRoles(['ROLE_ADMIN']);
                $manage->persist($user);
                $manage->flush();
                return $this->redirect('auth');
        }

        return $this->render('user/index.html.twig', ['RegisterForm'=>$RF->createView()]);
    }

    /**
     * Authentification 
     * 
     * @Route("/auth", name="auth")
     */
    public function login(AuthenticationUtils $AU ,EntityManagerInterface $manage){
        $error= $AU->getLastAuthenticationError();
        $username = $AU->getLastUsername();   
        return $this->render('user/authentification.html.twig', [
            'error'=> $error,
            'username'=>$username
        ]);

    }

    /**
     * Déconnection
     * 
     * @Route("/logout", name="logout")
     */
    public function logout(AuthenticationUtils $AU){
        

    }
}
