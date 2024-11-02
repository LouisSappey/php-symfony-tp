<?php

namespace App\Entity;

use App\Enum\CommentStatusEnum;
use App\Repository\CommentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentRepository::class)]
class Comment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[ORM\Column(enumType: CommentStatusEnum::class)]
    private ?CommentStatusEnum $status = null;

    #[ORM\ManyToOne(inversedBy: 'comments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $author = null;

    #[ORM\ManyToOne(inversedBy: 'comments')]
    private ?Media $commentMedia = null;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'commentsReplies')]
    #[ORM\JoinColumn(nullable: false)]
    private ?self $replies = null;

    /**
     * @var Collection<int, self>
     */
    #[ORM\OneToMany(targetEntity: self::class, mappedBy: 'replies')]
    private Collection $commentsReplies;

    public function __construct()
    {
        $this->commentsReplies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getStatus(): ?CommentStatusEnum
    {
        return $this->status;
    }

    public function setStatus(CommentStatusEnum $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): static
    {
        $this->author = $author;

        return $this;
    }

    public function getCommentMedia(): ?Media
    {
        return $this->commentMedia;
    }

    public function setCommentMedia(?Media $commentMedia): static
    {
        $this->commentMedia = $commentMedia;

        return $this;
    }

    public function getReplies(): ?self
    {
        return $this->replies;
    }

    public function setReplies(?self $replies): static
    {
        $this->replies = $replies;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getCommentsReplies(): Collection
    {
        return $this->commentsReplies;
    }

    public function addCommentsReply(self $commentsReply): static
    {
        if (!$this->commentsReplies->contains($commentsReply)) {
            $this->commentsReplies->add($commentsReply);
            $commentsReply->setReplies($this);
        }

        return $this;
    }

    public function removeCommentsReply(self $commentsReply): static
    {
        if ($this->commentsReplies->removeElement($commentsReply)) {
            // set the owning side to null (unless already changed)
            if ($commentsReply->getReplies() === $this) {
                $commentsReply->setReplies(null);
            }
        }

        return $this;
    }
}