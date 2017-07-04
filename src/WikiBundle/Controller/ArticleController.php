<?php
namespace WikiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use WikiBundle\Entity\Article;
use JMS\Serializer\SerializerBuilder;


/**
 * Description of ArticleController
 *
 * @author williambloch
 *
 */
class ArticleController extends Controller{

    /**
     * @Method("GET")
     * @Route("/articles")
     */
    public function getArticlesAction(){

        $serializer = SerializerBuilder::create()->build();

        $em = $this->getDoctrine()->getManager();
        //$articles = $em->getRepository(Article::class)->findAll();
        $articles = $em->getRepository(Article::class)->getAllArticles();

        $data = $serializer->serialize($articles, 'json');

        return new Response($data);
    }

    /**
   * @Route("/articles/{id}", requirements={"id":"\d+"})
   * @Method("GET")
   */
  public function getArticleAction($id){
      $serializer = SerializerBuilder::create()->build();
      $em = $this->getDoctrine()->getManager();
      $article = $em->getRepository(Article::class)->getOneArticle($id);
      if(empty($article))
      {
          return new JsonResponse(['message' => 'Article not found'], Response::HTTP_NOT_FOUND);
      }
      $data = $serializer->serialize($article, 'json');

      return new Response($data);
  }


  /**
 * @Route("/articles")
 * @Method("POST")
 */
  public function postArticleAction(Request $request){
    $serializer = SerializerBuilder::create()->build();
    $jsonData = $request->getContent();
    $article = $serializer->deserialize($jsonData, Article::class, 'json');
    $errors = $this->get("validator")->validate($article);

    if(count($errors) == 0){
      $em = $this->getDoctrine()->getManager();
      $em->getRepository(Article::class)->createArticle($em, $article);
      // We associate Themes to the new Article
      $em->getRepository(Article::class)->createArticleTheme($em, $article);

      return new JsonResponse("OK");
    }else{
        return $errors;
    }
  }
}