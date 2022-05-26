<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Form\SalleEventType;
use App\Entity\SalleEvenement;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SalleEvenementController extends AbstractController
{
    
    /**
     * @Route("/create_SE/{id}", name="create_SE")
     */
    public function create(?Evenement $event,$id,EntityManagerInterface $manage,Request $r): Response
    {  
        $SE = new SalleEvenement();
        $eventform= $this->createForm(SalleEventType::class,$SE);
        $eventform->handleRequest($r);
        if($eventform->isSubmitted() and $eventform->isValid()){
            $SE->setEvent($event);
            $manage->persist($SE);
            $manage->flush();
            $this->addFlash('success',"la salle d'évenement est ajoutée avec succée");
            return $this->redirectToRoute("Voir_salles",["id"=>$id]);
        
        }
        return $this->render("salle_evenement/create.html.twig",['eventform'=>$eventform->createView()]);

    }
    /**
     * @Route("/update_SE/{id}", name="update_SE")
     */
    public function Modifier(?SalleEvenement $SE,$id,EntityManagerInterface $manage,Request $r): Response
    {  if($SE ==null)
        $SE = new SalleEvenement();

        $eventform= $this->createForm(SalleEventType::class,$SE);
        $eventform->handleRequest($r);
        if($eventform->isSubmitted() and $eventform->isValid()){
            $manage->persist($SE);
            $manage->flush();
            $this->addFlash('success',"la salle d'évenement est modifiée avec succée");
            return $this->redirectToRoute("Voir_salles",["id"=>$id]);
        
        }
        return $this->render("salle_evenement/create.html.twig",['eventform'=>$eventform->createView()]);

    }

    /**
     * @Route("/delete_SE/{id}", name="delete_SE")
     */
    public function Delete(?SalleEvenement $SE,EntityManagerInterface $manage,Request $r): Response
    {       $ev=$SE->getEvent();
            $id_ev=$ev->getId();
            $manage->remove($SE);
            $manage->flush();
            $this->addFlash('success',"la salle d'évenement est supprimée avec succée");
            return $this->redirectToRoute("Voir_salles",["id"=>$id_ev]);

    }
}
