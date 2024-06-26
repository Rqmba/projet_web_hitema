<?php

namespace App\Repository;

use App\Entity\Article;
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
            ->where('article.deletedAt IS NULL')
            ->orderBy('article.releaseDate', 'DESC')
            ->getQuery();
    }

    public function getDataFigurines():Query
    {
        return $this->createQueryBuilder('article')
        ->join('article.category', 'category')
        ->where('category.name = :categoryName')
        ->andWhere('article.deletedAt IS NULL')
        ->setParameter('categoryName', 'Figurine')
        ->orderBy('article.releaseDate', 'DESC')
        ->getQuery();
    }

    public function getDataGoodies():Query
    {
        return $this->createQueryBuilder('article')
        ->join('article.category', 'category')
        ->where('category.name = :categoryName')
        ->andWhere('article.deletedAt IS NULL')
        ->setParameter('categoryName', 'Goodie')
        ->getQuery();
    }

    public function getDataVetements(): Query
    {
        return $this->createQueryBuilder('article')
            ->join('article.category', 'category')
            ->where('category.name = :categoryName')
            ->andWhere('article.deletedAt IS NULL')
            ->setParameter('categoryName', 'Vetements')
            ->getQuery();
    }

    public function getDataArticleDB():Query
    {
        return $this->createQueryBuilder('article')
        ->join('article.manga', 'manga')
        ->where('manga.name = :mangaName')
        ->andWhere('article.deletedAt IS NULL')
        ->setParameter('mangaName', 'Dragon Ball')
        ->getQuery();
    }

    public function getOneArticleByClick(string $title):Query
    {
        return $this->createQueryBuilder('article')
        ->where('article.title = :title')
        ->setParameter('title', $title)
        ->getQuery();
    }

    // public function getOneArticleByClick(string $slug):Query
    // {
    //     return $this->createQueryBuilder('article')
    //     ->where('article.slug = :slug')
    //     ->setParameter('slug', $slug)
    //     ->getQuery();
    // }

    // public function getOneMangaByclick(string $manga):Query
    // {
    //     return $this->createQueryBuilder('article')
    //     ->select('article')
    //     ->leftJoin('article.manga', 'manga')
    //     ->where('manga.name = :name')
    //     ->setParameter('name', $manga)
    //     ->getQuery();
    // }

    public function findArticleBySearch(string $query): array
    {
        return $this->createQueryBuilder('article')
            ->join('article.manga', 'manga')
            ->join('article.category', 'category')
            ->where('article.title LIKE :query OR article.description LIKE :query')
            ->orWhere('manga.name LIKE :query')
            ->orWhere('category.name LIKE :query')
            ->andWhere('article.deletedAt IS NULL')
            ->setParameter('query', '%' . $query . '%')
            ->getQuery()
            ->getResult();
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
