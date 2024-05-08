<?php
namespace App\Domain\Vehicle;

use App\Domain\ParkingArea\ParkingArea;
use Symfony\Component\Uid\Uuid;

class Vehicle
{
    protected Uuid $id;
    protected ParkingArea $parkingArea;
    protected string $name;

    function __construct(string $name,
                         ParkingArea $parkingArea) {
        $this->name = $name;
        $this->parkingArea = $parkingArea;
    }
    public function getId(): Uuid
    {
        return $this->id;
    }
    public function setId(Uuid $id): void
    {
        $this->id = $id;
    }
    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }
    public function getParkingArea(): ParkingArea
    {
        return $this->parkingArea;
    }
    public function setParkingArea(ParkingArea $parkingArea): void
    {
        $this->parkingArea = $parkingArea;
    }
}