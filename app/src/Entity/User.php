<?php

/**
 * User entity.
 */

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Class User.
 *
 * Represents a user entity.
 */
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: 'users')]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
#[UniqueEntity(fields: ['nickname'], message: 'This nickname is already in use')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    #[Assert\NotBlank]
    #[Assert\Email]
    private ?string $email = null;

    #[ORM\Column(type: 'json')]
    private array $roles = ['ROLE_USER'];

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 20)]
    #[ORM\Column(length: 20, nullable: false, unique: true)]
    private ?string $nickname = null;

    /**
     * User constructor.
     *
     * Initializes the roles property with an empty array.
     *
     * @return int|null the ID of the user
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Gets the email of the user.
     *
     * @return string|null the email of the user
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Sets the email of the user.
     *
     * @param string $email the email of the user
     *
     * @return static the current instance for method chaining
     */
    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Gets the roles of the user.
     *
     * @return array the roles of the user
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * Check if the user has a specific role.
     *
     * @param string $role the role to check
     *
     * @return bool true if the user has the role, false otherwise
     */
    public function hasRole(string $role): bool
    {
        return in_array($role, $this->getRoles(), true);
    }

    /**
     * Sets the roles of the user.
     *
     * @param array $roles the roles of the user
     *
     * @return static the current instance for method chaining
     */
    public function setRoles(array $roles): self
    {
        if (!in_array('ROLE_USER', $roles, true)) {
            $roles[] = 'ROLE_USER';
        }
        $this->roles = $roles;

        return $this;
    }

    /**
     * Gets the password of the user.
     *
     * @return string|null the password of the user
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * Sets the password of the user.
     *
     * @param string $password the password of the user
     *
     * @return static the current instance for method chaining
     */
    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Gets the nickname of the user.
     *
     * @return string|null the nickname of the user
     */
    public function getNickname(): ?string
    {
        return $this->nickname;
    }

    /**
     * Sets the nickname of the user.
     *
     * @param string|null $nickname the nickname of the user
     *
     * @return static the current instance for method chaining
     */
    public function setNickname(?string $nickname): static
    {
        $this->nickname = $nickname;

        return $this;
    }

    /**
     * Gets the salt of the user.
     *
     * @return string|null the salt of the user
     */
    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    /**
     * Gets the string representation of the user.
     *
     * @return string the string representation of the user
     */
    public function eraseCredentials(): void
    {
        // $this->plainPassword = null;
    }
}
