<?php

namespace App\Repository;

use App\Entity\FeesValue;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method FeesValue|null find($id, $lockMode = null, $lockVersion = null)
 * @method FeesValue|null findOneBy(array $criteria, array $orderBy = null)
 * @method FeesValue[]    findAll()
 * @method FeesValue[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FeesValueRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, FeesValue::class);
    }

    // /**
    //  * @return FeesValue[] Returns an array of FeesValue objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FeesValue
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
