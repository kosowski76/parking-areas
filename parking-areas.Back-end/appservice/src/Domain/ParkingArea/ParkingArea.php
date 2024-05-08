<?php
namespace App\Domain\ParkingArea;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Uid\Uuid;

class ParkingArea
{
    protected Uuid $id;
    protected $name;
    protected $capacity;
    protected float $weekdayRate;
    protected float $weekendRate;
    protected Collection $vehicles;

    function __construct($name, $capacity)
    {
        $this->id = Uuid::v7();
        $this->name = $name;
        $this->capacity = $capacity;
        $this->vehicles = new ArrayCollection();
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

    /**
     * @return mixed
     */
    public function getCapacity()
    {
        return $this->capacity;
    }

    public function getWeekdayRate(): float
    {
        return $this->weekdayRate;
    }

    public function setWeekdayRate(float $weekdayRate): void
    {
        $this->weekdayRate = $weekdayRate;
    }

    public function getWeekendRate(): float
    {
        return $this->weekendRate;
    }

    public function setWeekendRate(float $weekendRate): void
    {
        $this->weekendRate = $weekendRate;
    }

    /**
     * @param mixed $capacity
     */
    public function setCapacity($capacity): void
    {
        $this->capacity = $capacity;
    }

    public function getVehicles(): Collection
    {
        return $this->vehicles;
    }

    public function setVehicles(Collection $vehicles): void
    {
        $this->vehicles = $vehicles;
    }

    public function parkVehicle($vehicle)
    {
        if(count($this->vehicles) >= $this->capacity) {
            echo "Parking Area has not empty slot". PHP_EOL;
        } else {
            $this->vehicles[] = $vehicle;
            echo $vehicle->name . " parked ". PHP_EOL;
        }
    }
}
