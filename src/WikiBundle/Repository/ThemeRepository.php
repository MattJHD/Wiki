<?php
namespace WikiBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Description of ThemeRepository
 *
 * @author matthieudurand
 */
class ThemeRepository extends EntityRepository{

  // Query - Get all Themes
  public function getAllThemes(){
    $qb = $this->_em->createQueryBuilder()
            ->select('theme')
            ->from("WikiBundle:Theme", "theme");
    $query = $qb->getQuery();
    $results = $query->getResult();
    return $results;
  }

  // Query - Get a single Theme
  public function getOneTheme($id){
    $qb = $this->_em->createQueryBuilder()
              ->select("theme")
              ->from("WikiBundle:Theme", "theme")
              ->andWhere("theme.id = :id")
              ->setParameter("id", $id);
      $query = $qb->getQuery();
      $results = $query->getResult();
      return $results;
  }

  // Query - Insert Theme in Db
  public function createTheme($em, $theme, $currentUser){
    $RAW_QUERY = 'INSERT
                  INTO THEME (user_id, name)
                  VALUES ("'.$currentUser->getId().'", "'.$theme->getName().'");';
    $statement = $em->getConnection()->prepare($RAW_QUERY);
    $result = $statement->execute();

    return $result;
  }

  // Query - Update Theme in Db
  public function updateTheme($id, $theme){
    $name = $theme->getName();
    $user_id = $theme->getUser()->getId();

    $qb = $this->_em->createQueryBuilder()
              ->update("WikiBundle:Theme", "theme")
              ->set("theme.user", ":user_id")
              ->set("theme.name", ":name")
              ->andWhere("theme.id = :id")
              ->setParameter("id", $id)
              ->setParameter("user_id", $user_id)
              ->setParameter("name", $name);
      $query = $qb->getQuery();
      $results = $query->getResult();
      return $results;
  }

  // Query - Delete Theme in Db
  public function deleteTheme($id, $theme){
    $qb = $this->_em->createQueryBuilder()
              ->delete("WikiBundle:Theme", "theme")
              ->where('theme.id = :id')
              ->setParameter('id', $id);
    $query = $qb->getQuery();
    $results = $query->getResult();

    return $results;
  }
}
