<?php

namespace App\Entity;

use App\Repository\LanguageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LanguageRepository::class)]
class Language
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $code = null;

    /**
     * @var Collection<int, Media>
     */
    #[ORM\ManyToMany(targetEntity: Media::class, inversedBy: 'languages')]
    private Collection $languageMedia;

    public function __construct()
    {
        $this->languageMedia = new ArrayCollection();
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): static
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return Collection<int, Media>
     */
    public function getLanguageMedia(): Collection
    {
        return $this->languageMedia;
    }

    public function addLanguageMedium(Media $languageMedium): static
    {
        if (!$this->languageMedia->contains($languageMedium)) {
            $this->languageMedia->add($languageMedium);
        }

        return $this;
    }

    public function removeLanguageMedium(Media $languageMedium): static
    {
        $this->languageMedia->removeElement($languageMedium);

        return $this;
    }
}
