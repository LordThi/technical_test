<?php

// src/Entity/User.php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\Table(name="User")
 */
#[ORM\Entity(repositoryClass: 'App\Repository\UserRepository')]
#[ORM\Table(name: 'User')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    public const STATUT_ADMIN = 'ADMIN';
    public const STATUT_RECRUTEUR = 'RECRUTEUR';

    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    #[ORM\Column(type: 'integer')]
    #[Groups('user:read')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups('user:read')]
    private string $prenom;

    #[ORM\Column(type: 'string', length: 255, unique: true)]
    #[Groups('user:read')]
    private string $login;

    #[ORM\Column(type: 'string', length: 255)]
    private string $password;

    #[ORM\Column(type: 'string', length: 50)]
    #[Groups('user:read')]
    private string $statut;

    // Getters and Setters

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrenom(): string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;
        return $this;
    }

    public function getLogin(): string
    {
        return $this->login;
    }

    public function setLogin(string $login): self
    {
        $this->login = $login;
        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    public function getStatut(): string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): self
    {
        if (!in_array($statut, [self::STATUT_ADMIN, self::STATUT_RECRUTEUR])) {
            throw new \InvalidArgumentException("Invalid statut");
        }
        $this->statut = $statut;
        return $this;
    }

    public function getRoles(): array
    {
        return [$this->statut];
    }

    public function getSalt(): ?string
    {
        return null;
    }

    public function eraseCredentials()
    {
    }

    public function getUserIdentifier(): string
    {
        // TODO: Implement getUserIdentifier() method.
    }
}
