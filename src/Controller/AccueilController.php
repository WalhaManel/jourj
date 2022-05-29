<?php

namespace App\Controller;

use App\Entity\Evenement;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccueilController extends AbstractController
{   
    /**
     * Redirection vers l'accueil selon le role de l'utilisateur
     * 
     * 
     * @Route("/", name="accueil")
     */
    public function index(EntityManagerInterface $manager): Response
    {   if( $this->getUser()!= null){
        $role=$this->getUser()->getRoles();
        if(in_array("ROLE_ADMIN",$role)){
         return $this->redirect("show_events");
         
        }}
        $QR=$manager->getRepository(Evenement::class);
        $e=$QR->findAll();
        return $this->render('accueil/index.html.twig', [
            'evenements'=> $e
        ]);
    }
}
