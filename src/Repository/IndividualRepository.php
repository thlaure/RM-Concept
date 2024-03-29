<?php

namespace App\Repository;

use App\Entity\Individual;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class IndividualRepository.
 *
 * @method Individual|null find($id, $lockMode = null, $lockVersion = null)
 * @method Individual|null findOneBy(array $criteria, array $orderBy = null)
 * @method Individual[]    findAll()
 * @method Individual[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IndividualRepository extends ServiceEntityRepository implements UserLoaderInterface
{
    /**
     * IndividualRepository constructor.
     *
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Individual::class);
    }

    /**
     * Charge un particulier grâce à son adresse mail.
     *
     * @param string $username
     *
     * @return mixed|null|\Symfony\Component\Security\Core\User\UserInterface
     *
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function loadUserByUsername($username)
    {
        return $this->createQueryBuilder('i')
            ->where('i.email = :email')
            ->setParameter('email', $username)
            ->getQuery()
            ->getOneOrNullResult();
    }

//    /**
//     * @return Individual[] Returns an array of Individual objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Individual
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}