<?php

namespace App\Repository;

use App\Entity\Coupe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Coupe>
 *
 * @method Coupe|null find($id, $lockMode = null, $lockVersion = null)
 * @method Coupe|null findOneBy(array $criteria, array $orderBy = null)
 * @method Coupe[]    findAll()
 * @method Coupe[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CoupeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Coupe::class);
    }

//    /**
//     * @return Coupe[] Returns an array of Coupe objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Coupe
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
