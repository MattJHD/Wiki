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
}
