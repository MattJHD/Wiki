<?php
namespace WikiBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Description of ArticleRepository
 *
 * @author williambloch
 */
class ArticleRepository extends EntityRepository{

  // Query - Get all Articles
  public function getAllArticles(){
    $qb = $this->_em->createQueryBuilder()
            ->select('article')
            ->from("WikiBundle:Article", "article");
    $query = $qb->getQuery();
    $results = $query->getResult();
    return $results;
  }

  // Query - Get a single Article
  public function getOneArticle($id){
    $qb = $this->_em->createQueryBuilder()
              ->select("article")
              ->from("WikiBundle:Article", "article")
              ->andWhere("article.id = :id")
              ->setParameter("id", $id);
      $query = $qb->getQuery();
      $results = $query->getResult();
      return $results;
  }
}
