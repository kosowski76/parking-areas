<?php
namespace App\Domain\Vehicle;

use App\Domain\ParkingArea\ParkingArea;
use App\Domain\User\User;
use DateTime;
use DateTimeInterface;
use Symfony\Component\Uid\Uuid;

class Vehicle
{
    protected Uuid $id;
    protected string $name;
    protected User $user;
    protected ParkingArea $parkingArea;
    protected DateTimeInterface $createdAt;
    protected float $parkingTime;

    function __construct() {
    }
    public function getId(): Uuid
    {
        return $this->id;
    }
    public function setId(Uuid $id): void
    {
        $this->id = $id;
    }
    public function getParkingArea(): ParkingArea
    {
        return $this->parkingArea;
    }
    public function setParkingArea(ParkingArea $parkingArea): void
    {
        $this->parkingArea = $parkingArea;
    }
    public function getName()
    {
        return $this->name;
    }
    public function setName($name): void
    {
        $this->name = $name;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeInterface $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getParkingTime(): float
    {
        return $this->parkingTime;
    }

    public function setParkingTime(float $parkingTime): void
    {
        $this->parkingTime = $parkingTime;
    }

}