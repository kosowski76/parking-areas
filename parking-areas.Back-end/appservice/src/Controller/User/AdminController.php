<?php
namespace App\Controller\User;

use App\Application\Handler\ParkingArea\CreateParkingAreaHandler;
use App\Application\Handler\ParkingArea\ListParkingAreaHandler;
use App\Application\Handler\User\CreateUserHandler;
use App\Domain\ParkingArea\ParkingArea;
use App\Domain\ParkingArea\ParkingAreaRepositoryInterface;
use App\Domain\Vehicle\Vehicle;
use App\Domain\Vehicle\VehicleRepositoryInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Uid\Uuid;

class AdminController extends AbstractController
{
    protected CreateParkingAreaHandler $createParkingAreaHandler;
    protected ListParkingAreaHandler $listParkingHandler;
    protected VehicleRepositoryInterface $vehicleRepository;

    protected Security $security;

    public function __construct(
        CreateParkingAreaHandler $createParkingAreaHandler,
        ListParkingAreaHandler $listParkingHandler,
        VehicleRepositoryInterface $vehicleRepository,
        Security $security)
    {
        $this->security = $security;
        $this->listParkingHandler = $listParkingHandler;
        $this->vehicleRepository = $vehicleRepository;
        $this->createParkingAreaHandler = $createParkingAreaHandler;
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
                'vehicles' => $this->hasParkingAreaVehicles($parkingArea)
            ];
        }

        return new JsonResponse($allParkingAreas, Response::HTTP_OK);
    }

    #[Route('/api/parking-area', name: 'api_admin_create_area', methods: ['POST'])]
    public function createArea(Request $request): JsonResponse
    {
        $parkingArray = json_decode($request->getContent(), true);

        $this->createParkingAreaHandler->handle(
            [
                'id' => Uuid::v7(),
                'name' => $parkingArray['name'],
                'capacity' => $parkingArray['capacity'],
                'weekdayRate' => $parkingArray['weekday_rate'],
                'weekendRate' => $parkingArray['weekend_rate']
            ]
        );

        return new JsonResponse('Parking Area has been made', Response::HTTP_CREATED);
    }


    protected function hasParkingAreaVehicles(ParkingArea $parkingArea): array
    {
        /*
         * enumerating cars in the parking lot depends
         * on the method of checking parking space occupancy, e.g. proximity sensor
         */
        $allVehicles = array();
        $vehicles = array();

        $vehicles = $this->vehicleRepository->findBy([
           'parkingArea' => $parkingArea->getId()
        ]);

        /** @var Vehicle $vehicle */
        foreach ($vehicles as $vehicle) {
            $allVehicles[] = [
                'name' => $vehicle->getName(),
                'data' => $vehicle->getCreatedAt(),
                'parkingTime' => $vehicle->getParkingTime()
            ];
        }

        return $allVehicles;
    }

}
