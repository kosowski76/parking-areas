<?php
namespace App\Controller\Main;

use DateTime;
use DateTimeImmutable;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use function Symfony\Component\Clock\now;

class MainController
{
    public function index(): JsonResponse
    {
        $date = new DateTime();
        $content =
            [
                "title" => "Welcome on Parking Area",
                "content" => "Dashboard",
                "date" => $date->format('Y-m-d H:i:s')
            ];

        //$result = json_encode($content);
        return new JsonResponse($content, Response::HTTP_OK);
    }

}