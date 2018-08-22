<?php

namespace App\Repository;

use App\Entity\Haulier;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Class HaulierRepository.
 *
 * @method Haulier|null find($id, $lockMode = null, $lockVersion = null)
 * @method Haulier|null findOneBy(array $criteria, array $orderBy = null)
 * @method Haulier[]    findAll()
 * @method Haulier[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HaulierRepository extends ServiceEntityRepository
{
    /**
     * HaulierRepository constructor.
     *
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Haulier::class);
    }

//    /**
//     * @return Haulier[] Returns an array of Haulier objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('h.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Haulier
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}