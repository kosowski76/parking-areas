<?php
namespace App\Controller\User;

use App\Application\Handler\User\CreateUserHandler;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UserController
{
    private CreateUserHandler $createUser;

    public function __construct(CreateUserHandler $createUser)
    {
        $this->createUser = $createUser;
    }

    #[Route('/api/users', name: 'api_user_create', methods: ['POST'])]
    public function registerUserApi(Request $request): JsonResponse
    {
        $userArray = json_decode($request->getContent(), true);

        try {

            $this->createUser->handle(
                [
                    'username' => $userArray['username'],
                    'email'    => $userArray['email'],
                    'password' => $userArray['password']
                ]
            );

        } catch (Exception $e) {
            return new JsonResponse($e->getMessage(), Response::HTTP_NOT_ACCEPTABLE);
        }

        return new JsonResponse('User created', Response::HTTP_CREATED);
    }
}