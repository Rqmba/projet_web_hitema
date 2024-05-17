<?php

namespace App\Repository;

use App\Entity\Article;
use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Article>
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }


    public function getDataAllArticles(): Query
    {
        return $this->createQueryBuilder('article')
            ->select('article.title', 'article.picture', 'article.description', 'category.name as categoryName')
            ->leftJoin('article.category', 'category')
            ->orderBy('article.releaseDate', 'DESC')
            ->setMaxResults(8)
            ->getQuery();
    }

    public function getDataFigurines():Query
    {
        return $this->createQueryBuilder('article')
        ->select('article.title, article.picture, article.description, article.price, manga.name as mangaName')
        ->leftJoin('article.manga', 'manga')
        ->where('article.category = :category')
        ->setParameter('category', 1)
        ->setMaxResults(8)
        ->getQuery();
    }

    public function getDataGoodies():Query
    {
        return $this->createQueryBuilder('article')
        ->select('article.title, article.picture','article.description')
        ->where('article.category = :category')
        ->setParameter('category', 2)
        ->setMaxResults(8)
        ->getQuery();

    }

    public function getDataVetements():Query
    {
        return $this->createQueryBuilder('article')
        ->select('article.title, article.picture, article.description, article.price')
        ->where('article.category = :category')
        ->setParameter('category', 3)
        ->setMaxResults(8)
        ->getQuery();

    }

    public function getDataArticleDB():Query
    {
        return $this->createQueryBuilder('article')
        ->select('article.title, article.picture, article.description, category.name as categoryName')
        ->leftJoin('article.category', 'category')
        ->where('article.manga = :manga')
        ->setParameter('manga', 1)
        ->setMaxResults(8)
        ->getQuery();
    }

    public function getOneArticleByClick(string $title):Query
    {
        return $this->createQueryBuilder('article')
        ->select('article.title, article.picture, article.description, article.price, article.statut, category.name as categoryName')
        ->leftJoin('article.category', 'category')
        ->where('article.title = :title')
        ->setParameter('title', $title)
        ->getQuery();
    }

    //    /**
    //     * @return Article[] Returns an array of Article objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('a.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Article
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
