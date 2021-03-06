<?php

namespace App\Repository;

use App\Entity\Fpicount;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Fpicount|null find($id, $lockMode = null, $lockVersion = null)
 * @method Fpicount|null findOneBy(array $criteria, array $orderBy = null)
 * @method Fpicount[]    findAll()
 * @method Fpicount[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FpicountRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Fpicount::class);
    }

    // /**
    //  * @return Count[] Returns an array of Count objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    // public function findOneByref($value): ?Count
    // {
    //     return $this->createQueryBuilder('c')
    //         ->andWhere('c.ref = :val')
    //         ->setParameter('val', $value)
    //         ->getQuery()
    //         ->getOneOrNullResult()
    //     ;
    // }

    /**
     * @return Fpicount[] Returns an array of Fpicount objects
     */
    public function findByref($value): ?Fpicount
    {
        return $this->createQueryBuilder('c')
            ->where('c.ref = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult()
        ;
    }
}
