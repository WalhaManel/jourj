<?php

namespace App\Controller;

use App\Form\EventType;
use App\Entity\Evenement;
use App\Entity\SalleEvenement;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EvenementController extends AbstractController
{
    /**
     * @Route("/salle_event/{id}", name="salle_event")
     */
    public function salle_event(?Evenement $event ,EntityManagerInterface $manager): Response
    {   $SE=$event->getSalleEvenements();
        return $this->render('evenement/index.html.twig', [
            'SE' =>$SE
        ]);
    }
    
    /**
     * @Route("/Voir_salles/{id}", name="Voir_salles")
     */
    public function Voir_salles(?Evenement $event ,EntityManagerInterface $manager): Response
    {   $SE=$event->getSalleEvenements();
        $id_ev=$event->getId();
        return $this->render('salle_evenement/salles.html.twig', [
            'SE' =>$SE ,'id'=>$id_ev
        ]);
    }
    /**
     * @Route("/show_events", name="show_events")
     */
    public function show_events(EntityManagerInterface $manager): Response
    {   $QR=$manager->getRepository(Evenement::class);
        $e=$QR->findAll();
        return $this->render('evenement/events.html.twig', [
            'events' =>$e
        ]);
    }
    /**
     * @Route("/create_event", name="create_event")
     */
    public function create(EntityManagerInterface $manage,Request $r): Response
    {  
        $event = new Evenement();
        $eventform= $this->createForm(EventType::class,$event);
        $eventform->handleRequest($r);
        if($eventform->isSubmitted() and $eventform->isValid()){
            $manage->persist($event);
            $manage->flush();
            $this->addFlash('success',"l'évenement est ajoutée avec succée");
            return $this->redirectToRoute("create_event");
        
        }
        return $this->render("evenement/create.html.twig",['eventform'=>$eventform->createView()]);

    }
    /**
     * @Route("/update_event/{id}", name="update_event")
     */
    public function Modifier(?Evenement $event,EntityManagerInterface $manage,Request $r): Response
    {  if($event ==null)
        $event = new Evenement();

        $eventform= $this->createForm(EventType::class,$event);
        $eventform->handleRequest($r);
        if($eventform->isSubmitted() and $eventform->isValid()){
            $manage->persist($event);
            $manage->flush();
            $this->addFlash('success',"l'évenement est modifiée avec succée");
            return $this->redirectToRoute("show_events");
        
        }
        return $this->render("evenement/create.html.twig",['eventform'=>$eventform->createView()]);

    }

    /**
     * @Route("/delete_event/{id}", name="delete_event")
     */
    public function Delete(?Evenement $event,EntityManagerInterface $manage,Request $r): Response
    {       try{
            $manage->remove($event);
            $manage->flush();
    }
    catch(\Exception $e){
        $this->addFlash('erreur',"Impossible de supprimée cette évenement !");
        return $this->redirectToRoute("show_events");

    }
            $this->addFlash('success',"l'évenement est supprimée avec succée");
            return $this->redirectToRoute("show_events");

    }
}
