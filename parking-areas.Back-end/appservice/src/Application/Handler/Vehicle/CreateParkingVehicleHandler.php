<?php
namespace App\Application\Handler\Vehicle;

use App\Domain\Vehicle\Vehicle;
use App\Domain\Vehicle\VehicleRepositoryInterface;
use Doctrine\ORM\Exception\ORMException;
use Exception;
use Symfony\Component\Uid\Uuid;

class CreateParkingVehicleHandler
{
    protected VehicleRepositoryInterface $vehicleRepository;

    public function __construct(
        VehicleRepositoryInterface $vehicleRepository
    )
    {
        $this->vehicleRepository = $vehicleRepository;
    }
    /**
     * @param array $parkingArea
     * @throws Exception|ORMException
     */
    public function handle(array $parkingArea): Vehicle
    {
        $vehicle = new Vehicle();
        $vehicle->setId(Uuid::v7());
        $vehicle->setName($parkingArea['name']);
        $vehicle->setParkingArea($parkingArea['parkingArea']);
        $vehicle->setCreatedAt($parkingArea['parkingStart']);
        $vehicle->setParkingTime($parkingArea['parkingTime']);

        try {
            $this->vehicleRepository->save($vehicle);
        } catch (Exception $exception) {
            throw new Exception ('Vehicle can not be saved, probably already taken.');
        }

        return $vehicle;
    }
}
