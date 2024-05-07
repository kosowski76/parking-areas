<?php
namespace App\DataFixtures;

use App\Domain\BankAccount\FirmBankAccount;
use App\Domain\ParkingArea\ParkingArea;
use App\Domain\User\User;
use App\Domain\User\UserRepositoryInterface;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Exception;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Uid\Uuid;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;
    protected UserRepositoryInterface $userRepository;

    public function __construct(
        UserPasswordHasherInterface $hasher,
        UserRepositoryInterface $userRepository
    ) {
        $this->hasher = $hasher;
        $this->userRepository = $userRepository;
    }
    public function load(ObjectManager $manager): void
    {
        $userValues = array(
            [
                'Id'    => '018F2522-5E4D-7C2A-BB9C-E8C0AEA8A77E',
                'Email' => 'user@test.com',
                'Name'  => 'user', 'Password' => '123123'
            ],
            [
                'Id'    => '018F2A27-1E4C-4C2D-BF9C-E8C0AEA8E39A',
                'Email' => 'admin@test.com',
                'Name'  => 'admin', 'Password' => '321ewq'
            ]);

        foreach ($userValues as $value)
        {
            /***
             * User ***/
            $user = new User();
            $userEntity = Uuid::fromString($value['Id']);
            $user->setId($userEntity);
            $user->setEmail($value['Email']);
            $user->setUsername($value['Name']);
            $password = $this->hasher->hashPassword($user, $value['Password']);
            $user->setPassword($password);
            $user->setCreatedAt(new DateTime());

            $manager->persist($user);
            $manager->flush();
        }

        $bankAccountValues = array(
            [
                'Id'        => '018F2521-8C87-71EF-B326-054F4DEE82E0',
                'UserId'  => '018F2522-5E4D-7C2A-BB9C-E8C0AEA8A77E',
                'Name'      => 'Firm Bank Account of Company',
                'Balance'   => 21732.347
            ]);

        foreach($bankAccountValues as $value)
        {
            /***
             * get User ***/
            try {
                $user = $this->userRepository->findOneBy(
                    ['id' => Uuid::fromString($value['UserId'])]);
            } catch (Exception $exception)
            {
                throw new Exception('No this User in database'.PHP_EOL.
                    'Error message: '.$exception->getMessage()); }
            /***
             * FirmBankAccount ***/
            $bankAccount = new FirmBankAccount();
            $bankAccountEntity = Uuid::fromString($value['Id']);
            $bankAccount->setId($bankAccountEntity);
            $bankAccount->setName($value['Name']);
            $bankAccount->setUser($user);
            $bankAccount->setBalance($value['Balance']);

            $manager->persist($bankAccount);
            $manager->flush();

            unset($bankAccount);
            unset($user);
        }


        $parkingAreaValues = array(
            [
                'Id'        => '8F252521-0AEA-F25F-B326-054F4DEA8A77',
                'Name'      => 'Parking Area 1',
                'Capacity'   => 50
            ],
            [
                'Id'        => 'F4DE2522-5E4D-7C2A-BB9C-E8C0AEA8F252',
                'Name'      => 'Parking Area 2',
                'Capacity'   => 60
            ]);

        foreach($parkingAreaValues as $value)
        {
            $parkingArea = new ParkingArea($value['Name'], $value['Capacity']);
            $parkingAreaEntity = Uuid::fromString($value['Id']);
            $parkingArea->setId($parkingAreaEntity);

            $manager->persist($parkingArea);
            $manager->flush();

            unset($parkingArea);
        }


    }
}
