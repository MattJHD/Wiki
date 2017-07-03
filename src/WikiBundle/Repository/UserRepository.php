<?php
namespace WikiBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Description of UserRepository
 *
 * @author williambloch
 */
class UserRepository extends EntityRepository{
  public function getAllUsers(){
    $qb = $this->_em->createQueryBuilder()
            ->select('user')
            ->from("WikiBundle:User", "user");
    $query = $qb->getQuery();
    $results = $query->getResult();
    return $results;
  }
}
