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

  /**
  * @Route("/themes/{id}", requirements={"id":"\d+"})
  * @Method("GET")
  */
  public function getThemeAction($id){
    $serializer = SerializerBuilder::create()->build();
    $em = $this->getDoctrine()->getManager();
    $theme = $em->getRepository(Theme::class)->getOneTheme($id);
    if(empty($theme)){
        return new JsonResponse(['message' => 'Theme not found'], Response::HTTP_NOT_FOUND);
    }
    $data = $serializer->serialize($theme, 'json');

    return new Response($data);
  }

 /**
 * @Route("/themes")
 * @Method("POST")
 */
  public function postThemeAction(Request $request){
    $serializer = SerializerBuilder::create()->build();
    $jsonData = $request->getContent();
    $theme = $serializer->deserialize($jsonData, Theme::class, 'json');
    $errors = $this->get("validator")->validate($theme);
    // We get the current user in session
    $currentUser = $this->get('security.token_storage')->getToken()->getUser();

    // Create an article if role < 3 (1 = admin, 2 = auteur)
    if($currentUser->getRole()->getId() == 1){
      if(count($errors) == 0){
        $em = $this->getDoctrine()->getManager();
        $em->getRepository(Theme::class)->createTheme($em, $theme, $currentUser);

        return new JsonResponse("OK");
      }else{
          return $errors;
      }
    } else {
        return new JsonResponse("YOU MUST BE ADMIN TO CREATE NEW THEMES");
    }
  }

  /**
  * @Route("/themes/{id}", requirements={"id":"\d+"})
  * @Method("PUT")
  */
  public function putThemesAction($id, Request $request){
    $serializer = SerializerBuilder::create()->build();
    $em = $this->getDoctrine()->getManager();
    $jsonData = $request->getContent();
    $theme = $serializer->deserialize($jsonData, Theme::class, 'json');
    $errors = $this->get("validator")->validate($theme);
    // We get the current user in session
    $currentUser = $this->get('security.token_storage')->getToken()->getUser();

    // Create an article if role < 3 (1 = admin, 2 = auteur)
    if($currentUser->getRole()->getId() == 1){
      if (count($errors) == 0) {
        $em = $this->getDoctrine()->getManager();
        $em->getRepository(Theme::class)->updateTheme($id, $theme);

        return new JsonResponse("OK UPDATE");
      } else {
        return new JsonResponse("ERROR-NOT-VALID");
      }
    } else {
        return new JsonResponse("YOU MUST BE ADMIN TO UPDATE THEMES");
    }
  }

  /**
  * @Route("/themes/delete/{id}", requirements={"id":"\d+"})
  * @Method("GET|POST")
  */
  public function deleteThemeAction($id, Request $request){
    $serializer = SerializerBuilder::create()->build();
    $em = $this->getDoctrine()->getManager();
    $jsonData = $request->getContent();
    $theme = $serializer->deserialize($jsonData, Theme::class, 'json');
    $errors = $this->get("validator")->validate($theme);
    // We get the current user in session
    $currentUser = $this->get('security.token_storage')->getToken()->getUser();

    // Create an article if role < 3 (1 = admin, 2 = auteur)
    if($currentUser->getRole()->getId() == 1){
      if (count($errors) == 0) {
        $em = $this->getDoctrine()->getManager();
        // We call the function to delete a theme
        $em->getRepository(Theme::class)->deleteTheme($id, $theme);

        return new JsonResponse("OK - THEME DELETED");
      } else {
        return new JsonResponse("ERROR-NOT-VALID");
      }
    } else {
      return new JsonResponse("YOU MUST BE ADMIN TO DELETE THEMES");
    }
  }
}
