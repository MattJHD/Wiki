<?php
namespace WikiBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Description of RoleRepository
 *
 * @author williambloch
 */
class RoleRepository extends EntityRepository{
  public function getAllRoles(){
    $qb = $this->_em->createQueryBuilder()
            ->select('role')
            ->from("WikiBundle:Role", "role");
    $query = $qb->getQuery();
    $results = $query->getResult();
    return $results;
  }
}
