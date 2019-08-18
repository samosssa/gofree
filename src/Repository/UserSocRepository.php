<?php

namespace App\Repository;

use App\Entity\UserSoc;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method UserSoc|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserSoc|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserSoc[]    findAll()
 * @method UserSoc[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserSocRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, UserSoc::class);
    }

    // /**
    //  * @return UserSoc[] Returns an array of UserSoc objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UserSoc
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
