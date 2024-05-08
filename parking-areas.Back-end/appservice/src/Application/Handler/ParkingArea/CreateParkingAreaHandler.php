<?php

namespace App\Application\Handler\ParkingArea;

use App\Domain\ParkingArea\ParkingArea;
use App\Infrastructure\Doctrine\ParkingAreaRepository;
use Exception;
use Symfony\Component\Uid\Uuid;

class CreateParkingAreaHandler
{
    protected ParkingAreaRepository $parkingAreaRepository;

    public function __construct(
        ParkingAreaRepository $parkingAreaRepository
    )
    {
        $this->parkingAreaRepository = $parkingAreaRepository;
    }
    public function handle(array $parkingAreaArray)
    {
        $parkingArea = new ParkingArea($parkingAreaArray['name'], $parkingAreaArray['capacity']);

        $parkingAreaEntity = Uuid::v7();
        $parkingArea->setId($parkingAreaEntity);
        $parkingArea->setWeekdayRate($parkingAreaArray['weekdayRate']);
        $parkingArea->setWeekendRate($parkingAreaArray['weekendRate']);

        try {
            $this->parkingAreaRepository->save($parkingArea);
        } catch (Exception $exception) {
            throw new Exception ('User can not be saved, probably username or email already taken.');
        }
    }

}