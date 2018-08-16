<?php

namespace App\Repository;

use App\Entity\Individual;
use App\Entity\ShoppingCartProduct;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Class ShoppingCartProductRepository.
 *
 * @method ShoppingCartProduct|null find($id, $lockMode = null, $lockVersion = null)
 * @method ShoppingCartProduct|null findOneBy(array $criteria, array $orderBy = null)
 * @method ShoppingCartProduct[]    findAll()
 * @method ShoppingCartProduct[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShoppingCartProductRepository extends ServiceEntityRepository
{
    /**
     * ShoppingCartProductRepository constructor.
     *
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ShoppingCartProduct::class);
    }

//    /**
//     * @return ShoppingCartProduct[] Returns an array of ShoppingCartProduct objects
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
    public function findOneBySomeField($value): ?ShoppingCartProduct
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