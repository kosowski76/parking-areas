<?php

namespace App\Controller\User;


use App\Application\Handler\ParkingArea\GetParkingAreaHandler;
use App\Application\Handler\ParkingArea\ListParkingAreaHandler;
use App\Application\Handler\Vehicle\CreateParkingVehicleHandler;
use App\Domain\ParkingArea\ParkingAreaRepositoryInterface;
use App\Domain\User\UserRepositoryInterface;
use App\Infrastructure\Services\FetchCurrencyInterface;
use DateInterval;
use DateTime;
use DateTimeImmutable;
use Exception;
use stdClass;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Uid\Uuid;

class ParkingVehicleController extends AbstractController
{
    protected CreateParkingVehicleHandler $createParkingVehicleHandler;
    protected FetchCurrencyInterface $fetchCurrency;
    protected GetParkingAreaHandler $getParkingAreaHandler;
    protected ListParkingAreaHandler $listParkingHandler;
    protected ParkingAreaRepositoryInterface $parkingAreaRepository;
    protected Security $security;
    protected UserRepositoryInterface $userRepository;

    public function __construct(
        CreateParkingVehicleHandler $createParkingVehicleHandler,
        FetchCurrencyInterface $fetchCurrency,
        GetParkingAreaHandler $getParkingAreaHandler,
        ListParkingAreaHandler $listParkingHandler,
        ParkingAreaRepositoryInterface $parkingAreaRepository,
        Security $security,
        UserRepositoryInterface $userRepository)
    {
        $this->createParkingVehicleHandler = $createParkingVehicleHandler;
        $this->fetchCurrency = $fetchCurrency;
        $this->getParkingAreaHandler = $getParkingAreaHandler;
        $this->listParkingHandler = $listParkingHandler;
        $this->parkingAreaRepository = $parkingAreaRepository;
        $this->security = $security;
        $this->userRepository = $userRepository;
    }

    #[Route('/api/user/parking', name: 'api_user_parking', methods: ['POST'])]
    public function index(Request $request): JsonResponse
    {
        $parkingArray = json_decode($request->getContent(), true);

        $parkingArea = $this->getParkingAreaHandler->handle($parkingArray['parking_area']);

        /***
         * get User ***/
        try {
            $user = $this->userRepository->findOneBy(
                ['username' => $this->security->getUser()->getUserIdentifier()]);
        } catch (Exception $exception)
        {
            throw new Exception('No this Client in database'.PHP_EOL.
                'Error message: '.$exception->getMessage());
        }

        $parkingTime = round($parkingArray['paring_time']);

        $vehicle = $this->createParkingVehicleHandler->handle(
            [
                'id' => Uuid::v7(),
                'name' => $parkingArray['name'],
                'parkingArea' => $parkingArea,
                'parkingStart' => new DateTime(),
                'parkingTime' => $parkingTime,
            ]
        );

        $result = new stdClass();
        $result->title = 'Parking vehicle: '. $vehicle->getName() .' has been done';
        $result->startParking = $vehicle->getCreatedAt();

        $newDate = new DateTimeImmutable($result->startParking->format('Y-m-d H:i:s'));
        $intervalFormat = "PT{$vehicle->getParkingTime()}H";
        $result->endParking = $newDate->add(new DateInterval($intervalFormat));

        $currencies = $this->fetchCurrency->fetch([]);
        foreach ($currencies as $currency)
        {
            $usd = $currency['usd'];
            $pln = $currency['pln'];
        }
        if(date('D') === 'Sat' || date('D') === 'Sun')
        {
            $result->Euro = $parkingArea->getWeekendRate() * $vehicle->getParkingTime();
            $result->Dollar = $result->Euro * $usd;
            $result->PLN = $result->Euro * $pln;
        } else {
            $result->Euro = $parkingArea->getWeekdayRate() * $vehicle->getParkingTime();
            $result->Dollar = $result->Euro * $usd;
            $result->PLN = $result->Euro * $pln;
        }

        return new JsonResponse($result, Response::HTTP_CREATED);
    }


    protected function hasParkingAreaVehicles()
    {
        /*
         * enumerating cars in the parking lot depends
         * on the method of checking parking space occupancy, e.g. proximity sensor
         */
    }

}
