<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\EvenementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EvenementRepository::class)
 */
class Evenement
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
     * @Assert\NotBlank(message="Veuillez saisir l'image")
     */
    private $img;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="Veuillez saisir le détail")
     * @Assert\Length(min=50,minMessage="Minimum 50 caratcères")
     */
    private $detail;

    /**
     * @ORM\OneToMany(targetEntity=SalleEvenement::class, mappedBy="event")
     */
    private $salleEvenements;

    public function __construct()
    {
        $this->salleEvenements = new ArrayCollection();
    }

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

    public function getImg(): ?string
    {
        return $this->img;
    }

    public function setImg(string $img): self
    {
        $this->img = $img;

        return $this;
    }

    public function getDetail(): ?string
    {
        return $this->detail;
    }

    public function setDetail(string $detail): self
    {
        $this->detail = $detail;

        return $this;
    }

    /**
     * @return Collection<int, SalleEvenement>
     */
    public function getSalleEvenements(): Collection
    {
        return $this->salleEvenements;
    }

    public function addSalleEvenement(SalleEvenement $salleEvenement): self
    {
        if (!$this->salleEvenements->contains($salleEvenement)) {
            $this->salleEvenements[] = $salleEvenement;
            $salleEvenement->setEvent($this);
        }

        return $this;
    }

    public function removeSalleEvenement(SalleEvenement $salleEvenement): self
    {
        if ($this->salleEvenements->removeElement($salleEvenement)) {
            // set the owning side to null (unless already changed)
            if ($salleEvenement->getEvent() === $this) {
                $salleEvenement->setEvent(null);
            }
        }

        return $this;
    }
}
