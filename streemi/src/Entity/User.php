<?php

namespace App\Entity;

use App\Enum\UserAccountStatusEnum;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;


#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $username = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column(enumType: UserAccountStatusEnum::class)]
    private ?UserAccountStatusEnum $accountStatus = null;

    /**
     * @var Collection<int, Comment>
     */
    #[ORM\OneToMany(targetEntity: Comment::class, mappedBy: 'author')]
    private Collection $comments;

    /**
     * @var Collection<int, Playlist>
     */
    #[ORM\OneToMany(targetEntity: Playlist::class, mappedBy: 'creator')]
    private Collection $playlists;

    /**
     * @var Collection<int, PlaylistSubscriptions>
     */
    #[ORM\OneToMany(targetEntity: PlaylistSubscriptions::class, mappedBy: 'subscriber')]
    private Collection $playlistSubscriptions;

    /**
     * @var Collection<int, SubscriptionHistory>
     */
    #[ORM\OneToMany(targetEntity: SubscriptionHistory::class, mappedBy: 'subscriber')]
    private Collection $subscriptionHistories;

    #[ORM\ManyToOne(inversedBy: 'users')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Subscription $current_subscription = null;

    #[ORM\ManyToOne(inversedBy: 'userWatchHistory')]
    private ?WatchHistory $watchHistory = null;

    #[ORM\Column]
    private array $roles = [];

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $resetPasswordToken = null;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->playlists = new ArrayCollection();
        $this->playlistSubscriptions = new ArrayCollection();
        $this->subscriptionHistories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getAccountStatus(): ?UserAccountStatusEnum
    {
        return $this->accountStatus;
    }

    public function setAccountStatus(UserAccountStatusEnum $accountStatus): static
    {
        $this->accountStatus = $accountStatus;

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): static
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setAuthor($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): static
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getAuthor() === $this) {
                $comment->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Playlist>
     */
    public function getPlaylists(): Collection
    {
        return $this->playlists;
    }

    public function addPlaylist(Playlist $playlist): static
    {
        if (!$this->playlists->contains($playlist)) {
            $this->playlists->add($playlist);
            $playlist->setCreator($this);
        }

        return $this;
    }

    public function removePlaylist(Playlist $playlist): static
    {
        if ($this->playlists->removeElement($playlist)) {
            // set the owning side to null (unless already changed)
            if ($playlist->getCreator() === $this) {
                $playlist->setCreator(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PlaylistSubscriptions>
     */
    public function getPlaylistSubscriptions(): Collection
    {
        return $this->playlistSubscriptions;
    }

    public function addPlaylistSubscription(PlaylistSubscriptions $playlistSubscription): static
    {
        if (!$this->playlistSubscriptions->contains($playlistSubscription)) {
            $this->playlistSubscriptions->add($playlistSubscription);
            $playlistSubscription->setSubscriber($this);
        }

        return $this;
    }

    public function removePlaylistSubscription(PlaylistSubscriptions $playlistSubscription): static
    {
        if ($this->playlistSubscriptions->removeElement($playlistSubscription)) {
            // set the owning side to null (unless already changed)
            if ($playlistSubscription->getSubscriber() === $this) {
                $playlistSubscription->setSubscriber(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, SubscriptionHistory>
     */
    public function getSubscriptionHistories(): Collection
    {
        return $this->subscriptionHistories;
    }

    public function addSubscriptionHistory(SubscriptionHistory $subscriptionHistory): static
    {
        if (!$this->subscriptionHistories->contains($subscriptionHistory)) {
            $this->subscriptionHistories->add($subscriptionHistory);
            $subscriptionHistory->setSubscriber($this);
        }

        return $this;
    }

    public function removeSubscriptionHistory(SubscriptionHistory $subscriptionHistory): static
    {
        if ($this->subscriptionHistories->removeElement($subscriptionHistory)) {
            // set the owning side to null (unless already changed)
            if ($subscriptionHistory->getSubscriber() === $this) {
                $subscriptionHistory->setSubscriber(null);
            }
        }

        return $this;
    }

    public function getCurrentSubscription(): ?Subscription
    {
        return $this->current_subscription;
    }

    public function setCurrentSubscription(?Subscription $current_subscription): static
    {
        $this->current_subscription = $current_subscription;

        return $this;
    }

    public function getWatchHistory(): ?WatchHistory
    {
        return $this->watchHistory;
    }

    public function setWatchHistory(?WatchHistory $watchHistory): static
    {
        $this->watchHistory = $watchHistory;

        return $this;
    }

    public function getRoles(): array
{
    // Retourne un tableau contenant les rôles de l'utilisateur
    // Exemple : si vous avez une propriété `roles` stockée en base de données
    return $this->roles ?? ['ROLE_USER'];
}

public function getUserIdentifier(): string
{
    // Retourne l'identifiant unique de l'utilisateur (par exemple, l'email)
    return $this->email;
}

public function eraseCredentials(): void
{
    // Utilisé pour nettoyer les données sensibles (non obligatoire dans un cas simple)
}

public function setRoles(array $roles): static
{
    $this->roles = $roles;

    return $this;
}

public function getResetPasswordToken(): ?string
{
    return $this->resetPasswordToken;
}

public function setResetPasswordToken(?string $resetPasswordToken): self
{
    $this->resetPasswordToken = $resetPasswordToken;
    return $this;
}
}