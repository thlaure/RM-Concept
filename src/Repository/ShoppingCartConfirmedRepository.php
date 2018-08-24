<?php

namespace App\Repository;

use App\Entity\ShoppingCartConfirmed;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ShoppingCartConfirmed|null find($id, $lockMode = null, $lockVersion = null)
 * @method ShoppingCartConfirmed|null findOneBy(array $criteria, array $orderBy = null)
 * @method ShoppingCartConfirmed[]    findAll()
 * @method ShoppingCartConfirmed[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShoppingCartConfirmedRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ShoppingCartConfirmed::class);
    }

//    /**
//     * @return ShoppingCartConfirmed[] Returns an array of ShoppingCartConfirmed objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ShoppingCartConfirmed
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
