<?php
namespace App\Application\Handler\ParkingArea;

use App\Domain\ParkingArea\ParkingAreaRepositoryInterface;

class ListParkingAreaHandler
{
    private ParkingAreaRepositoryInterface $parkingAreaRepository;

    public function __construct(ParkingAreaRepositoryInterface $parkingAreaRepository)
    {
        $this->parkingAreaRepository = $parkingAreaRepository;
    }

    /**
     * @return array
     */
    public function handle(): array
    {
        return $this->parkingAreaRepository->findAll();
    }
}
