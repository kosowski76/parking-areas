<?php
namespace App\Application\Handler\User;


use Doctrine\ORM\Exception\ORMException;
use App\Domain\User\User;
use Exception;
use App\Domain\User\UserRepositoryInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Uid\Uuid;

class CreateUserHandler
{
    private UserRepositoryInterface $userRepository;
    private UserPasswordHasherInterface $hasher;

    public function __construct(
        UserRepositoryInterface $userRepository,
        UserPasswordHasherInterface $hasher
    )
    {
        $this->userRepository = $userRepository;
        $this->hasher = $hasher;
    }

    /**
     * @param array $userArray
     * @throws Exception|ORMException
     */
    public function handle(array $userArray): void
    {
        $user = new User();
        $user->setId(Uuid::v7());
        $user->setUsername($userArray['username']);
        $user->setEmail($userArray['email']);

        $password = $this->hasher->hashPassword($user, $userArray['password']);
        $user->setPassword($password);


        try {
            $this->userRepository->save($user);
        } catch (Exception $exception) {
            throw new Exception ('User can not be saved, probably username or email already taken.');
        }
    }
}
