<?php

namespace App\Repository;

use App\Entity\Detailorder;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Detailorder>
 *
 * @method Detailorder|null find($id, $lockMode = null, $lockVersion = null)
 * @method Detailorder|null findOneBy(array $criteria, array $orderBy = null)
 * @method Detailorder[]    findAll()
 * @method Detailorder[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DetailorderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Detailorder::class);
    }

//    /**
//     * @return Detailorder[] Returns an array of Detailorder objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Detailorder
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
