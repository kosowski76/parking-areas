<?php
namespace App\Controller\Main;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class MainController
{
    public function index(): JsonResponse
    {
        $result = array();

        $result[] = 'Welcome';
        $result[] = 'Dashboard';


        return new JsonResponse($result, Response::HTTP_OK);
    }

}