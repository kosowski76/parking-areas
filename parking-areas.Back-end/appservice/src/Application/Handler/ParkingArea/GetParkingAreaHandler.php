<?php
namespace App\Application\Handler\ParkingArea;

use App\Domain\ParkingArea\ParkingArea;
use App\Domain\ParkingArea\ParkingAreaRepositoryInterface;
use Exception;

class GetParkingAreaHandler
{
    private ParkingAreaRepositoryInterface $parkingAreaRepository;

    public function __construct(ParkingAreaRepositoryInterface $parkingAreaRepository)
    {
        $this->parkingAreaRepository = $parkingAreaRepository;
    }

    /**
     * @return ParkingArea
     */
    public function handle(string $parkingAreaId): ParkingArea
    {

        try {
            $parkingArea = $this->parkingAreaRepository->findOneBy(['id' => $parkingAreaId]);
        } catch (Exception $exception)
        {
            throw new Exception('No this Parking Area in database'.PHP_EOL.
                'Error message: '.$exception->getMessage());
        }

        return $parkingArea;
    }

}