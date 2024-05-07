<?php
namespace App\Infrastructure\Doctrine;

use App\Domain\ParkingArea\ParkingArea;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
class ParkingAreaRepository extends ServiceEntityRepository implements ParkingAreaRepositoryInterface
{
    protected EntityManagerInterface $entityManager;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $entityManager)
    {
        parent::__construct($registry, ParkingArea::class);
        $this->entityManager = $entityManager;
    }

    /**
     * @param ParkingArea $parkingArea
     */
    public function save(ParkingArea $parkingArea): void
    {
        $this->entityManager->persist($parkingArea);
        $this->entityManager->flush();
    }
}
