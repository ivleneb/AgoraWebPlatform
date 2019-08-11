<?php

namespace App\Repository;

use App\Entity\MemberDonation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method MemberDonation|null find($id, $lockMode = null, $lockVersion = null)
 * @method MemberDonation|null findOneBy(array $criteria, array $orderBy = null)
 * @method MemberDonation[]    findAll()
 * @method MemberDonation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MemberDonationRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, MemberDonation::class);
    }

    // /**
    //  * @return MemberDonation[] Returns an array of MemberDonation objects
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
    public function findOneBySomeField($value): ?MemberDonation
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
