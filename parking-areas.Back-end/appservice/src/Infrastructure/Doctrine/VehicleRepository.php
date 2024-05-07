<?php
namespace App\Infrastructure\Doctrine;

use App\Domain\Vehicle\Vehicle;
use App\Domain\Vehicle\VehicleRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

class VehicleRepository extends ServiceEntityRepository implements VehicleRepositoryInterface
{
    protected EntityManagerInterface $entityManager;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $entityManager)
    {
        parent::__construct($registry, Vehicle::class);
        $this->entityManager = $entityManager;
    }

    /**
     * @param Vehicle $vehicle
     */
    public function save(Vehicle $vehicle): void
    {
        $this->entityManager->persist($vehicle);
        $this->entityManager->flush();
    }
}
