<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Entity\SalleEvenement;
use Monolog\DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ReservationController extends AbstractController
{
    /**
     * @Route("/CreateRes/{id}", name="CreateRes")
     * @IsGranted("ROLE_USER")
     */
    public function CreateRes(?SalleEvenement $salle,EntityManagerInterface $manage,Request $r): Response
    {       $date=$r->query->get('date');

            $res = new Reservation();  
            $QR=$manage->getRepository(Reservation::class);
           $test=$QR->findby(["date_ev"=>$date,"salle_evenement"=>$salle]);
            if($test ==null)
            {  $prix=$salle->getPrix();
                $res->setAvancePayee($prix*0.2);
                $res->setResteAPayer($prix-($prix*0.2));
                $res->setUser($this->getUser());
                $res->setSalleEvenement($salle);
                $res->setDateEv($date);
                $res->setCreatedAt(new \DateTime());
                $manage->persist($res);
                $manage->flush();
                $this->addFlash('success',"votre Reservation a été effectuer avec succée");
                return $this->redirectToRoute("MesReservations");
            }else{
                $this->addFlash('erreur',"La salle d'évenement est réservée .. veuillez choisir une autre date");
            }
        return $this->render('reservation/index.html.twig');
    }
    /**
     * @Route("/MesReservations", name="MesReservations")
     */
    public function MesReservations(EntityManagerInterface $manage): Response
    {   $QR=$manage->getRepository(Reservation::class);
        $reservations=$QR->findby(['user'=>$this->getUser()]);
        return $this->render('reservation/mesReservations.html.twig', 
        [ "reservations"=> $reservations] );
    }
    /**
     * @Route("/Reservations", name="Reservations")
     */
    public function Reservations(EntityManagerInterface $manage): Response
    {   $QR=$manage->getRepository(Reservation::class);
        $reservations=$QR->findAll();
        return $this->render('reservation/Reservations.html.twig', 
        [ "reservations"=> $reservations] );
    }
}
