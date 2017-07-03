<?php
namespace WikiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use WikiBundle\Entity\Theme;
use JMS\Serializer\SerializerBuilder;


/**
 * Description of ThemeController
 *
 * @author williambloch
 *
 */
class ThemeController extends Controller{

    /**
     * @Method("GET")
     * @Route("/themes")
     */
    public function getThemesAction(){

        $serializer = SerializerBuilder::create()->build();

        $em = $this->getDoctrine()->getManager();
        $themes = $em->getRepository(Theme::class)->getAllThemes();

        $data = $serializer->serialize($themes, 'json');

        return new Response($data);
    }
}
