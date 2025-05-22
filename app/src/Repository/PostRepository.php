<?php

/**
 * Post repository.
 */

namespace App\Repository;

use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * PostRepository class.
 */
class PostRepository extends ServiceEntityRepository
{
    /**
     * PostRepository constructor.
     *
     * @param ManagerRegistry $registry The registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    /**
     * Query all posts.
     *
     * @return QueryBuilder The query builder
     */
    public function queryAll(): QueryBuilder
    {
        return $this->createQueryBuilder('post')
            ->orderBy('post.createdAt', 'DESC');
    }

    /**
     * Query posts by category.
     *
     * @param int $categoryId The category ID
     *
     * @return QueryBuilder The query builder
     */
    public function queryByCategory(int $categoryId): QueryBuilder
    {
        return $this->createQueryBuilder('post')
            ->andWhere('post.category = :category')
            ->setParameter('category', $categoryId)
            ->orderBy('post.createdAt', 'DESC');
    }




    //    /**
    //     * @return Post[] Returns an array of Post objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Post
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
