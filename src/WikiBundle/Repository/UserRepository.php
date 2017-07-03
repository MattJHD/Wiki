<?php
namespace WikiBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Description of UserRepository
 *
 * @author williambloch
 */
class UserRepository extends EntityRepository{

  // Query - Get all Users
  public function getAllUsers(){
    $qb = $this->_em->createQueryBuilder()
            ->select('user')
            ->from("WikiBundle:User", "user");
    $query = $qb->getQuery();
    $results = $query->getResult();
    return $results;
  }

  // Query - Get a single User
  public function getOneUser($id){
    $qb = $this->_em->createQueryBuilder()
              ->select("user")
              ->from("WikiBundle:User", "user")
              ->andWhere("user.id = :id")
              ->setParameter("id", $id);
      $query = $qb->getQuery();
      $results = $query->getResult();
      return $results;
  }
}
