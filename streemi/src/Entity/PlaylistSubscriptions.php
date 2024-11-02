<?php

namespace App\Entity;

use App\Repository\PlaylistSubscriptionsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlaylistSubscriptionsRepository::class)]
class PlaylistSubscriptions
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $userId = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $subscribedAt = null;

    #[ORM\ManyToOne(inversedBy: 'subscription')]
    private ?Playlist $subscription = null;

    #[ORM\ManyToOne(inversedBy: 'playlistSubscriptions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $subscriber = null;

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

    public function getSubscribedAt(): ?\DateTimeImmutable
    {
        return $this->subscribedAt;
    }

    public function setSubscribedAt(\DateTimeImmutable $subscribedAt): static
    {
        $this->subscribedAt = $subscribedAt;

        return $this;
    }

    public function getSubscription(): ?Playlist
    {
        return $this->subscription;
    }

    public function setSubscription(?Playlist $subscription): static
    {
        $this->subscription = $subscription;

        return $this;
    }

    public function getSubscriber(): ?User
    {
        return $this->subscriber;
    }

    public function setSubscriber(?User $subscriber): static
    {
        $this->subscriber = $subscriber;

        return $this;
    }
}
