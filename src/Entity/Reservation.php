<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReservationRepository::class)
 */
class Reservation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="integer")
     */
    private $avance_payee;

    /**
     * @ORM\Column(type="integer")
     */
    private $reste_a_payer;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="reservations")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=SalleEvenement::class, inversedBy="reservations")
     */
    private $salle_evenement;

    /**
     * @ORM\Column(type="string")
     */
    private $date_ev;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTime $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getAvancePayee(): ?string
    {
        return $this->avance_payee;
    }

    public function setAvancePayee(string $avance_payee): self
    {
        $this->avance_payee = $avance_payee;

        return $this;
    }

    public function getResteAPayer(): ?string
    {
        return $this->reste_a_payer;
    }

    public function setResteAPayer(string $reste_a_payer): self
    {
        $this->reste_a_payer = $reste_a_payer;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getSalleEvenement(): ?SalleEvenement
    {
        return $this->salle_evenement;
    }

    public function setSalleEvenement(?SalleEvenement $salle_evenement): self
    {
        $this->salle_evenement = $salle_evenement;

        return $this;
    }

    public function getDateEv(): ?string
    {
        return $this->date_ev;
    }

    public function setDateEv(string $date_ev): self
    {
        $this->date_ev = $date_ev;

        return $this;
    }
}
