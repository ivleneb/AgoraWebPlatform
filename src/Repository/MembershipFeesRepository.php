<?php

namespace App\Repository;

use App\Entity\MembershipFees;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method MembershipFees|null find($id, $lockMode = null, $lockVersion = null)
 * @method MembershipFees|null findOneBy(array $criteria, array $orderBy = null)
 * @method MembershipFees[]    findAll()
 * @method MembershipFees[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MembershipFeesRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, MembershipFees::class);
    }

    // /**
    //  * @return MembershipFees[] Returns an array of MembershipFees objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MembershipFees
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
