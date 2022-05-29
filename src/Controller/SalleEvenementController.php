<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Form\SalleEventType;
use App\Entity\SalleEvenement;
use App\Repository\SalleEvenementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SalleEvenementController extends AbstractController
{
    
    /**
     * Création d'une salle d'événement
     * 
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
     * Affichage des détails d'une salle d'événement
     * 
     * @Route("/show_details/{id}", name="show_details")
     */
    public function show_details(?SalleEvenement $salle): Response
    { 
        return $this->render("salle_evenement/salleDétails.html.twig",['s'=>$salle]);

    }

    /**
     * Modification d'une salle d'événement
     * 
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
     * Suppression d'une salle d'événement
     * 
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

    /**
     * Filtrage des résultats des salles d'événements
     * 
     * @Route("/filter/{id}", name="filter")
     */
    public function filter($id,SalleEvenementRepository $rep,Request $r): Response
    {               $minp = $r->get("minp");
                    $maxp = $r->get("maxp");
                    $loc = $r->get("loc");
                    if($minp != null && $maxp == null && $loc == null)
                    {
                        $result=$rep->getSalleByPrice($id,$minp,9999999999);

                    }
                    else if($maxp != null && $minp == null && $loc == null){
                        $result= $rep->getSalleByPrice($id,0,$maxp);

                    }
                    else if($maxp != null && $minp != null && $loc == null){
                        $result= $rep->getSalleByPrice($id,$minp,$maxp);

                    }else if($maxp != null && $minp != null && $loc != null)
                    {
                        $result= $rep->getSalleByPriceAloc($id,$minp,$maxp,$loc);

                    }else if($maxp == null && $minp == null && $loc != null)
                    {
                        $result= $rep->getSalleByPriceAloc($id,0,9999999999,$loc);
                    }
                    if(!isset($result) || empty($result) ) {
                        $this->addFlash('erreur',"Aucune salle d'évenement correspond à votre choix");
                        $result=$rep->findby(["event"=>$id]);
                    }
        return $this->render("evenement/index.html.twig",['id'=>$id,'SE'=>$result]);

    }

    /**
     * Recherche avec le nom d'une salle d'événement
     * 
     * @Route("/search", name="search")
     */
    public function search(SalleEvenementRepository $rep,Request $r): Response
    {               $key = $r->get("key");
                $salle=$rep->findOneByNom($key);
        return $this->render("salle_evenement/salleDétails.html.twig",['s'=>$salle]);

    }
}
