<?php

namespace App\Repository;

use App\Entity\ShoppingCartNotConfirmed;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ShoppingCartNotConfirmed|null find($id, $lockMode = null, $lockVersion = null)
 * @method ShoppingCartNotConfirmed|null findOneBy(array $criteria, array $orderBy = null)
 * @method ShoppingCartNotConfirmed[]    findAll()
 * @method ShoppingCartNotConfirmed[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShoppingCartNotConfirmedRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ShoppingCartNotConfirmed::class);
    }

//    /**
//     * @return ShoppingCartNotConfirmed[] Returns an array of ShoppingCartNotConfirmed objects
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
    public function findOneBySomeField($value): ?ShoppingCartNotConfirmed
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
