<?php
namespace App\Controller\User;

use App\Application\Handler\ParkingArea\ListParkingAreaHandler;
use App\Application\Handler\User\CreateUserHandler;
use App\Domain\ParkingArea\ParkingAreaRepositoryInterface;
use App\Domain\Vehicle\VehicleRepositoryInterface;
use Exception;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AdminController
{
    protected ListParkingAreaHandler $listParkingHandler;
//    protected ParkingAreaRepositoryInterface $parkingAreaRepository;
//    protected VehicleRepositoryInterface $vehicleRepository;
//
    protected Security $security;

    public function __construct(
        ListParkingAreaHandler $listParkingHandler,
        Security $security)
    {
        $this->security = $security;
        $this->listParkingHandler = $listParkingHandler;
    }

    #[Route('/api/parking-area', name: 'api_admin_dashboard', methods: ['GET'])]
    public function index(): JsonResponse
    {
        // $username = $this->security->getUser()->getUserIdentifier();

        $parkingAreas = $this->listParkingHandler->handle();
        $allParkingAreas = array();

        foreach ($parkingAreas as $parkingArea)
        {
            $allParkingAreas[] = [
                'id' => $parkingArea->getId(),
                'name' => $parkingArea->getName(),
                'capacity' => $parkingArea->getCapacity(),
                'weekdayRate' => $parkingArea->getWeekdayRate(),
                'weekendRate' => $parkingArea->getWeekendRate(),
                // check how many vehicle
            //    'vehicle' => $this->hasParkingAreaVehicles()
            ];
        }

        return new JsonResponse($allParkingAreas, Response::HTTP_OK);
    }






    protected function hasParkingAreaVehicles()
    {
        /*
         * enumerating cars in the parking lot depends
         * on the method of checking parking space occupancy, e.g. proximity sensor
         */
    }

}
