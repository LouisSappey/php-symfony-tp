<?php

namespace App\Entity;

use App\Repository\WatchHistoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WatchHistoryRepository::class)]
class WatchHistory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $userId = null;

    #[ORM\Column]
    private ?int $mediaId = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $lastWatched = null;

    #[ORM\Column]
    private ?int $numberOfViews = null;

    /**
     * @var Collection<int, User>
     */
    #[ORM\OneToMany(targetEntity: User::class, mappedBy: 'watchHistory')]
    private Collection $userWatchHistory;

    #[ORM\ManyToOne(inversedBy: 'watchHistories')]
    private ?Media $watchHistoryMedia = null;

    public function __construct()
    {
        $this->userWatchHistory = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): static
    {
        $this->userId = $userId;

        return $this;
    }

    public function getMediaId(): ?int
    {
        return $this->mediaId;
    }

    public function setMediaId(int $mediaId): static
    {
        $this->mediaId = $mediaId;

        return $this;
    }

    public function getLastWatched(): ?\DateTimeInterface
    {
        return $this->lastWatched;
    }

    public function setLastWatched(\DateTimeInterface $lastWatched): static
    {
        $this->lastWatched = $lastWatched;

        return $this;
    }

    public function getNumberOfViews(): ?int
    {
        return $this->numberOfViews;
    }

    public function setNumberOfViews(int $numberOfViews): static
    {
        $this->numberOfViews = $numberOfViews;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUserWatchHistory(): Collection
    {
        return $this->userWatchHistory;
    }

    public function addUserWatchHistory(User $userWatchHistory): static
    {
        if (!$this->userWatchHistory->contains($userWatchHistory)) {
            $this->userWatchHistory->add($userWatchHistory);
            $userWatchHistory->setWatchHistory($this);
        }

        return $this;
    }

    public function removeUserWatchHistory(User $userWatchHistory): static
    {
        if ($this->userWatchHistory->removeElement($userWatchHistory)) {
            // set the owning side to null (unless already changed)
            if ($userWatchHistory->getWatchHistory() === $this) {
                $userWatchHistory->setWatchHistory(null);
            }
        }

        return $this;
    }

    public function getWatchHistoryMedia(): ?Media
    {
        return $this->watchHistoryMedia;
    }

    public function setWatchHistoryMedia(?Media $watchHistoryMedia): static
    {
        $this->watchHistoryMedia = $watchHistoryMedia;

        return $this;
    }
}
