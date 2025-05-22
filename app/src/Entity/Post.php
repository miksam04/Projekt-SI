<?php

/**
 * Post entity.
 */

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Post.
 *
 * Represents a post entity.
 */
#[ORM\Entity(repositoryClass: PostRepository::class)]
#[ORM\Table(name: 'posts')]
class Post
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $updatedAt = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $author = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: true)]
    private ?Category $category = null;

    /**
     * Post constructor.
     *
     * Initializes the createdAt property with the current date and time.
     */
    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    /**
     * Gets the ID of the post.
     *
     * @return int|null the ID of the post
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Gets the title of the post.
     *
     * @return string|null the title of the post
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * Sets the title of the post.
     *
     * @param string $title the title of the post
     *
     * @return static the current instance for method chaining
     */
    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Gets the content of the post.
     *
     * @return string|null the content of the post
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * Sets the content of the post.
     *
     * @param string $content the content of the post
     *
     * @return static the current instance for method chaining
     */
    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Gets the creation date and time of the post.
     *
     * @return \DateTimeImmutable|null the creation date and time of the post
     */
    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * Sets the creation date and time of the post.
     *
     * @param \DateTimeImmutable $createdAt the creation date and time of the post
     *
     * @return static the current instance for method chaining
     */
    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Gets the last updated date and time of the post.
     *
     * @return \DateTime|null the last updated date and time of the post
     */
    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    /**
     * Sets the last updated date and time of the post.
     *
     * @param \DateTime|null $updatedAt the last updated date and time of the post
     *
     * @return static the current instance for method chaining
     */
    public function setUpdatedAt(?\DateTime $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Gets the author of the post.
     *
     * @return User|null the author of the post
     */
    public function getAuthor(): ?User
    {
        return $this->author;
    }

    /**
     * Sets the author of the post.
     *
     * @param User|null $author the author of the post
     *
     * @return static the current instance for method chaining
     */
    public function setAuthor(?User $author): static
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Gets the category of the post.
     *
     * @return Category|null the category of the post
     */
    public function getCategory(): ?Category
    {
        return $this->category;
    }

    /**
     * Sets the category of the post.
     *
     * @param Category|null $category the category of the post
     *
     * @return static the current instance for method chaining
     */
    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }
}
