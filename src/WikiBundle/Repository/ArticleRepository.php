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


  // Query - Insert themes associated to an article in Db
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


  // Query - Update Article in Db
  public function updateArticle($id, $article){
    $name = $article->getName();
    $description = $article->getDescription();
    $date_creation = $article->getDate_creation();
    //$date_creation = $article->getDate_creation()->format('Y-m-d h:m:s');
    $pathname = $article->getPathname();

    $qb = $this->_em->createQueryBuilder()
              ->update("WikiBundle:Article", "article")
              ->set("article.name", ":name")
              ->set("article.description", ":description")
              ->set("article.date_creation", ":date_creation")
              ->set("article.pathname", ":pathname")
              ->andWhere("article.id = :id")
              ->setParameter("id", $id)
              ->setParameter("name", $name)
              ->setParameter("description", $description)
              ->setParameter("date_creation", $date_creation)
              ->setParameter("pathname", $pathname);
      $query = $qb->getQuery();
      $results = $query->getResult();
      return $results;
  }

  // Query - Update themes associated to an article in Db
  public function updateArticleTheme($em, $article){
    $themes = $article->getThemes();

    // We delete the associated themes
    $RAW_QUERY = 'DELETE FROM ARTICLE_THEME
                  WHERE article_id = "'.$article->getId().'"';
    $statement = $em->getConnection()->prepare($RAW_QUERY);
    $result = $statement->execute();

    // Foreach new theme we create a new associated theme
    foreach ($themes as $theme) {
      $RAW_QUERY = 'INSERT
                    INTO ARTICLE_THEME (article_id, theme_id)
                    VALUES ("'.$article->getId().'", "'.$theme->getId().'");';
      $statement = $em->getConnection()->prepare($RAW_QUERY);
      $result = $statement->execute();
    }
    return $result;
  }

  // Query - Delete Article in Db
  public function deleteArticle($id, $article){
    $qb = $this->_em->createQueryBuilder()
              ->delete("WikiBundle:Article", "article")
              ->where('article.id = :id')
              ->setParameter('id', $id);
    $query = $qb->getQuery();
    $results = $query->getResult();

    return $results;
  }
}
