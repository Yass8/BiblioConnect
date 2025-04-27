<?php

namespace App\Repository;

use App\Entity\Books;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Books>
 */
class BooksRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Books::class);
    }

    //    /**
    //     * @return Books[] Returns an array of Books objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('b.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Books
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    /**
     * Undocumented function
     *
     * @param [type] $authorId
     * @param [type] $categoryId
     * @param [type] $themeId
     * @param [type] $search
     * @return Books[] Returns an array of Books objects
     */
    public function findBooksByFilters($authorId = null, $categoryId = null, $themeId = null, $search = null)
    {
        $qb = $this->createQueryBuilder('b')
            ->leftJoin('b.author', 'a')
            ->leftJoin('b.category', 'c')
            ->leftJoin('b.themes', 't')
            ->addSelect('a', 'c', 't');

        if ($authorId) {
            $qb->andWhere('a.id = :authorId')
            ->setParameter('authorId', $authorId);
        }

        if ($categoryId) {
            $qb->andWhere('c.id = :categoryId')
            ->setParameter('categoryId', $categoryId);
        }

        if ($themeId) {
            $qb->andWhere('t.id = :themeId')
            ->setParameter('themeId', $themeId);
        }

        if ($search) {
            $qb->andWhere('b.title LIKE :search')
               ->setParameter('search', '%' . $search . '%');
        }

        return $qb->getQuery()->getResult();
    }

}
