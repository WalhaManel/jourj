<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\Evenement;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\SalleEvenementRepository;

/**
 * @ORM\Entity(repositoryClass=SalleEvenementRepository::class)
 */
class SalleEvenement
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez saisir le nom")
     * @Assert\Length(min=5,minMessage="Minimum 5 caratcères")
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez saisir la localisation")
     */
    private $location;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez saisir l'image'")
     */
    private $img;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez saisir le prix")
     * @Assert\Length(min=2,minMessage="Minimum 2 caratcères")
     */
    private $prix;

    /**
     * @ORM\ManyToOne(targetEntity=Evenement::class, inversedBy="salleEvenements")
     */
    private $event;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getImg(): ?string
    {
        return $this->img;
    }

    public function setImg(string $img): self
    {
        $this->img = $img;

        return $this;
    }

    public function getPrix(): ?string
    {
        return $this->prix;
    }

    public function setPrix(string $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getEvent(): ?Evenement
    {
        return $this->event;
    }

    public function setEvent(?Evenement $event): self
    {
        $this->event = $event;

        return $this;
    }
}
