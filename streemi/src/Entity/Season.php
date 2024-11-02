<?php

namespace App\Entity;

use App\Repository\SeasonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SeasonRepository::class)]
class Season
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $serieId = null;

    #[ORM\Column]
    private ?int $seasonNumber = null;

    #[ORM\ManyToOne(inversedBy: 'seasonsSerie')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Serie $serie = null;

    /**
     * @var Collection<int, Episode>
     */
    #[ORM\OneToMany(targetEntity: Episode::class, mappedBy: 'season')]
    private Collection $seasonEpisode;

    public function __construct()
    {
        $this->seasonEpisode = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSerieId(): ?int
    {
        return $this->serieId;
    }

    public function setSerieId(int $serieId): static
    {
        $this->serieId = $serieId;

        return $this;
    }

    public function getSeasonNumber(): ?int
    {
        return $this->seasonNumber;
    }

    public function setSeasonNumber(int $seasonNumber): static
    {
        $this->seasonNumber = $seasonNumber;

        return $this;
    }

    public function getSerie(): ?Serie
    {
        return $this->serie;
    }

    public function setSerie(?Serie $serie): static
    {
        $this->serie = $serie;

        return $this;
    }

    /**
     * @return Collection<int, Episode>
     */
    public function getSeasonEpisode(): Collection
    {
        return $this->seasonEpisode;
    }

    public function addSeasonEpisode(Episode $seasonEpisode): static
    {
        if (!$this->seasonEpisode->contains($seasonEpisode)) {
            $this->seasonEpisode->add($seasonEpisode);
            $seasonEpisode->setSeason($this);
        }

        return $this;
    }

    public function removeSeasonEpisode(Episode $seasonEpisode): static
    {
        if ($this->seasonEpisode->removeElement($seasonEpisode)) {
            // set the owning side to null (unless already changed)
            if ($seasonEpisode->getSeason() === $this) {
                $seasonEpisode->setSeason(null);
            }
        }

        return $this;
    }
}
