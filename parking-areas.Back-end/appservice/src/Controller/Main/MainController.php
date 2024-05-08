<?php
namespace App\Controller\Main;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class MainController
{
    public function index(): JsonResponse
    {
       // $content = array();

        $content = ["Welcome on Parking Area", "Dashboard"];

        $result = json_encode($content);


        return new JsonResponse($content, Response::HTTP_OK);
    }

}