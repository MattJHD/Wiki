<?php
namespace WikiBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Description of ArticleRepository
 *
 * @author williambloch
 */
class ArticleRepository extends EntityRepository{
  public function getAllArticles(){
    $qb = $this->_em->createQueryBuilder()
            ->select('article')
            ->from("WikiBundle:Article", "article");
    $query = $qb->getQuery();
    $results = $query->getResult();
    return $results;
  }
}
