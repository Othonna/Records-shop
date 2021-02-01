<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function filterDate()
    {
        $qb = $this->createQueryBuilder('p')
            // select = from product orderby
                   ->orderBy('p.release_at', 'DESC')
                   ->setMaxResults(4)
                   ->setFirstResult(0);
        //dump($qb->getQuery()->getResult());
        return $qb->getQuery()->getResult();
    }

    public function filterFavorite($style = 'release')
    {
        $qb = $this->createQueryBuilder('p')
                   ->andWhere('p.style = :style')
                   ->setParameter('style', $style)
                   ->setMaxResults(1)
                   ->setFirstResult(rand(20, 32));
        //dump($qb->getQuery()->getResult());
        return $qb->getQuery()->getResult();
    }

    public function randView(?int $limit = 6): ?iterable
    {
        $count = $this->count([]);

        $qb = $this->createQueryBuilder('p')
                   ->setMaxResults($limit)
                   ->setFirstResult(rand(0, $count -1));
        dump($qb->getQuery()->getResult());
        return $qb->getQuery()->getResult();
    }

    // /**
    //  * @return Product[] Returns an array of Product objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Product
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
