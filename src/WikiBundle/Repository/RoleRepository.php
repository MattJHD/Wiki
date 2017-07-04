<?php
namespace WikiBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Description of RoleRepository
 *
 * @author williambloch
 */
class RoleRepository extends EntityRepository{

  // Query - Get all Roles
  public function getAllRoles(){
    $qb = $this->_em->createQueryBuilder()
            ->select('role')
            ->from("WikiBundle:Role", "role");
    $query = $qb->getQuery();
    $results = $query->getResult();
    return $results;
  }

  // Query - Get a single Role
  public function getOneRole($id){
    $qb = $this->_em->createQueryBuilder()
              ->select("role")
              ->from("WikiBundle:Role", "role")
              ->andWhere("role.id = :id")
              ->setParameter("id", $id);
      $query = $qb->getQuery();
      $results = $query->getResult();
      return $results;
  }

  // Query - Insert Role in Db
  public function createRole($em, $role){
    $name = $role->getName();
    $RAW_QUERY = 'INSERT
                  INTO ROLE (ID, NAME)
                  VALUES ("", "'.$name.'");';
    $statement = $em->getConnection()->prepare($RAW_QUERY);
    $result = $statement->execute();

    return $result;
  }
}