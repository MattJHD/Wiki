<?php
namespace WikiBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Description of ThemeRepository
 *
 * @author matthieudurand
 */
class ThemeRepository extends EntityRepository{
  public function getAllThemes(){
    $qb = $this->_em->createQueryBuilder()
            ->select('theme')
            ->from("WikiBundle:Theme", "theme");
    $query = $qb->getQuery();
    $results = $query->getResult();
    return $results;
  }
}
