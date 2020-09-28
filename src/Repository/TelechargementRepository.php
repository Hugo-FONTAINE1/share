<?php

namespace App\Repository;

use App\Entity\Telechargement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Telechargement|null find($id, $lockMode = null, $lockVersion = null)
 * @method Telechargement|null findOneBy(array $criteria, array $orderBy = null)
 * @method Telechargement[]    findAll()
 * @method Telechargement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TelechargementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Telechargement::class);
    }

    // /**
    //  * @return Telechargement[] Returns an array of Telechargement objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Telechargement
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
