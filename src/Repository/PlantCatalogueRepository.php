<?php

namespace App\Repository;

use App\Entity\PlantCatalogue;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PlantCatalogue>
 *
 * @method PlantCatalogue|null find($id, $lockMode = null, $lockVersion = null)
 * @method PlantCatalogue|null findOneBy(array $criteria, array $orderBy = null)
 * @method PlantCatalogue[]    findAll()
 * @method PlantCatalogue[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlantCatalogueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PlantCatalogue::class);
    }

//    /**
//     * @return PlantCatalogue[] Returns an array of PlantCatalogue objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?PlantCatalogue
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
