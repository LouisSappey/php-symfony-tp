<?php

namespace App\Entity;

use App\Repository\SerieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SerieRepository::class)]
class Serie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'serieType')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Media $media = null;

    /**
     * @var Collection<int, Season>
     */
    #[ORM\OneToMany(targetEntity: Season::class, mappedBy: 'serie')]
    private Collection $seasonsSerie;

    public function __construct()
    {
        $this->seasonsSerie = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getMedia(): ?Media
    {
        return $this->media;
    }

    public function setMedia(?Media $media): static
    {
        $this->media = $media;

        return $this;
    }

    /**
     * @return Collection<int, Season>
     */
    public function getSeasonsSerie(): Collection
    {
        return $this->seasonsSerie;
    }

    public function addSeasonsSerie(Season $seasonsSerie): static
    {
        if (!$this->seasonsSerie->contains($seasonsSerie)) {
            $this->seasonsSerie->add($seasonsSerie);
            $seasonsSerie->setSerie($this);
        }

        return $this;
    }

    public function removeSeasonsSerie(Season $seasonsSerie): static
    {
        if ($this->seasonsSerie->removeElement($seasonsSerie)) {
            // set the owning side to null (unless already changed)
            if ($seasonsSerie->getSerie() === $this) {
                $seasonsSerie->setSerie(null);
            }
        }

        return $this;
    }
}
