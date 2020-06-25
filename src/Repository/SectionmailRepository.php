<?php

namespace App\Repository;

use App\Entity\Sectionmail;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Sectionmail|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sectionmail|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sectionmail[]    findAll()
 * @method Sectionmail[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SectionmailRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sectionmail::class);
    }

    // /**
    //  * @return Sectionmail[] Returns an array of Sectionmail objects
    //  */
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
    public function findOneBySomeField($value): ?Sectionmail
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
