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
  public function createTheme($em, $theme){
    $RAW_QUERY = 'INSERT
                  INTO THEME (user_id, name)
                  VALUES ("'.$theme->getUser()->getId().'", "'.$theme->getName().'");';
    $statement = $em->getConnection()->prepare($RAW_QUERY);
    $result = $statement->execute();

    return $result;
  }
}
