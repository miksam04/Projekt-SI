<?php

/**
 * Post repository.
 */

namespace App\Repository;

use App\Entity\Post;
use App\Entity\Category;
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

    /**
     * Save a post.
     *
     * @param Post $post The post to save
     *
     * @return void returns nothing
     */
    public function savePost(Post $post): void
    {
        $this->getEntityManager()->persist($post);
        $this->getEntityManager()->flush();
    }

    /**
     * Delete a post.
     *
     * @param Post $post The post to delete
     *
     * @return void returns nothing
     */
    public function deletePost(Post $post): void
    {
        $this->getEntityManager()->remove($post);
        $this->getEntityManager()->flush();
    }

    /**
     * Count posts by category.
     *
     * @param Category $category The category to count posts for
     *
     * @return int The count of posts in the category
     */
    public function countByCategory(Category $category): int
    {
        $qb = $this->createQueryBuilder('post');

        return $qb->select($qb->expr()->countDistinct('post.id'))
            ->andWhere('post.category = :category')
            ->setParameter(':category', $category)
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * Query posts by tag.
     *
     * @param int $id The tag ID
     *
     * @return QueryBuilder The query builder
     */
    public function queryByTag(int $id): QueryBuilder
    {
        return $this->createQueryBuilder('post')
            ->innerJoin('post.tags', 'tag')
            ->andWhere('tag.id = :id')
            ->setParameter('id', $id)
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
