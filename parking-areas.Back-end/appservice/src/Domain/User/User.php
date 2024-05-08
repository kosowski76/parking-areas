<?php
namespace App\Domain\User;

use AllowDynamicProperties;
use App\Domain\Vehicle\Vehicle;
use DateTime;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Exception;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Uid\Uuid;

#[AllowDynamicProperties] class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    protected Uuid $id;
    protected string $username;
    protected string $email;
    protected string $password;
    protected Collection $vehicles;
    protected $roles = [];
    protected bool $isActive;
    protected DateTimeInterface $createdAt;

    function __construct()
    {
        $this->createdAt = new DateTime();
        $this->isActive = true;
    }
    public function getId(): Uuid
    {
        return $this->id;
    }
    public function setId(Uuid $id): self
    {
        $this->id = $id;

        return $this;
    }
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
        // return (string) $this->email;
    }
    public function getUsername(): string
    {
        return $this->username;
    }
    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }
    public function getEmail(): string
    {
        return $this->email;
    }
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getVehicle(): Vehicle
    {
        return $this->vehicle;
    }

    public function setVehicle(Vehicle $vehicle): void
    {
        $this->vehicle = $vehicle;
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
    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }
    public function setCreatedAt(DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
    public function isActive(): bool
    {
        return $this->isActive;
    }
    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }
    public function getSalt()
    {
        return null;
    }
    public function eraseCredentials(): void
    {}
}
