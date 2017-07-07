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
    if(empty($article)){
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
    // We get the current user in session
    $currentUser = $this->get('security.token_storage')->getToken()->getUser();

    // Create an article if role < 3 (1 = admin, 2 = auteur)
    if($currentUser->getRole()->getId() <= 2){
      if(count($errors) == 0){
        $em = $this->getDoctrine()->getManager();
        
        //$this->get('app.upload.file')->uploadArticle($article);
        
        $em->getRepository(Article::class)->createArticle($em, $article, $currentUser);
        // We associate Themes to the new Article
        $em->getRepository(Article::class)->createArticleTheme($em, $article, $currentUser);

        return new JsonResponse("OK");
      }else{
        return $errors;
      }
    } else{
      return new JsonResponse("ADMIN OR AUTEUR ROLE NEEDED FOR ARTICLE CREATION");
    }
  }

  /**
  * @Route("/articles/{id}", requirements={"id":"\d+"})
  * @Method("PUT")
  */
  public function putArticlesAction($id, Request $request){
    $serializer = SerializerBuilder::create()->build();
    $em = $this->getDoctrine()->getManager();
    $jsonData = $request->getContent();
    $article = $serializer->deserialize($jsonData, Article::class, 'json');
    $errors = $this->get("validator")->validate($article);
    // We get the current user in session
    $currentUser = $this->get('security.token_storage')->getToken()->getUser();

    // We update an article if the role is 'Administrateur' or if the role is 'Auteur' and it is the author of the article
    if(($currentUser->getRole()->getId() == 1) || ($currentUser->getId() == $article->getUser()->getId() && $currentUser->getRole()->getId() <= 2)){
      if (count($errors) == 0) {
        $em = $this->getDoctrine()->getManager();
        $em->getRepository(Article::class)->updateArticle($id, $article);
        // We update associated Themes to the updated Article
        $em->getRepository(Article::class)->updateArticleTheme($em, $article);

        return new JsonResponse("OK UPDATE");
      } else {
        return new JsonResponse("ERROR-NOT-VALID");
      }
    } else {
      return new JsonResponse("YOU MUST BE ADMIN TO UPDATE AN ARTICLE OR AUTHOR TO UPDATE YOUR ARTICLES");
    }
  }

  /**
  * @Route("/articles/delete/{id}", requirements={"id":"\d+"})
  * @Method("GET|POST")
  */
  public function deleteArticleAction($id, Request $request){
    $serializer = SerializerBuilder::create()->build();
    $em = $this->getDoctrine()->getManager();
    $jsonData = $request->getContent();
    $article = $serializer->deserialize($jsonData, Article::class, 'json');
    $errors = $this->get("validator")->validate($article);
    // We get the current user in session
    $currentUser = $this->get('security.token_storage')->getToken()->getUser();

    // Create an article if role < 3 (1 = admin, 2 = auteur)
    if($currentUser->getRole()->getId() == 1){

      if (count($errors) == 0) {
        $em = $this->getDoctrine()->getManager();
        // We call the function to delete an article
        $em->getRepository(Article::class)->deleteArticle($id, $article);

        return new JsonResponse("OK - ARTICLE DELETED");
      } else {
        return new JsonResponse("ERROR-NOT-VALID");
      }
    } else {
      return new JsonResponse("YOU MUST BE ADMIN TO DELETE ARTICLES");
    }
  }
}
