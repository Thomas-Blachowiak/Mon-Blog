<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: Annonce::class)]
    private Collection $annonces;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $Quand = null;

    #[ORM\Column(length: 255)]
    private ?string $Ou = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $Pourquoi = null;

    public function __construct()
    {
        $this->annonces = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return Collection<int, Annonce>
     */
    public function getAnnonces(): Collection
    {
        return $this->annonces;
    }

    public function addAnnonce(Annonce $annonce): static
    {
        if (!$this->annonces->contains($annonce)) {
            $this->annonces->add($annonce);
            $annonce->setCategory($this);
        }

        return $this;
    }

    public function removeAnnonce(Annonce $annonce): static
    {
        if ($this->annonces->removeElement($annonce)) {
            // set the owning side to null (unless already changed)
            if ($annonce->getCategory() === $this) {
                $annonce->setCategory(null);
            }
        }

        return $this;
    }
    public function __toString(): string
    {
        return $this->name;
    }

    public function getQuand(): ?string
    {
        return $this->Quand;
    }

    public function setQuand(string $Quand): static
    {
        $this->Quand = $Quand;

        return $this;
    }

    public function getOu(): ?string
    {
        return $this->Ou;
    }

    public function setOu(string $Ou): static
    {
        $this->Ou = $Ou;

        return $this;
    }

    public function getPourquoi(): ?string
    {
        return $this->Pourquoi;
    }

    public function setPourquoi(string $Pourquoi): static
    {
        $this->Pourquoi = $Pourquoi;

        return $this;
    }
}
