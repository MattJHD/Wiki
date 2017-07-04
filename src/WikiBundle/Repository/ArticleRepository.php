<?php
namespace WikiBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Validator\Constraints\DateTime;

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

  // Query - Insert Article in Db
  public function createArticle($em, $article){
    // We need to convert date from DateTime Format to String
    $creationDate = $article->getDate_creation()->format('Y-m-d h:m:s');

    $RAW_QUERY = 'INSERT
                  INTO ARTICLE (name, description, date_creation, pathname)
                  VALUES ("'.$article->getName().'", "'.$article->getDescription().'", "'.$creationDate.'", "'.$article->getPathname().'");';
    $statement = $em->getConnection()->prepare($RAW_QUERY);
    $result = $statement->execute();
    return $result;
  }


  // Query - Insert User in Db
  public function createArticleTheme($em, $article){
    // We get the last inserted id
    // It will be the article id
    $last_id = $em->getConnection()->lastInsertId();

    $themes = $article->getThemes();
    foreach ($themes as $theme) {
      $RAW_QUERY = 'INSERT
                    INTO ARTICLE_THEME (article_id, theme_id)
                    VALUES ("'.$last_id.'", "'.$theme->getId().'");';
      $statement = $em->getConnection()->prepare($RAW_QUERY);
      $result = $statement->execute();
    }
    return $result;
  }
}
