<?php
namespace WikiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use WikiBundle\Entity\User;
use JMS\Serializer\SerializerBuilder;


/**
 * Description of UserController
 *
 * @author williambloch
 *
 */
class UserController extends Controller{

    /**
     * @Method("GET")
     * @Route("/users")
     */
    public function getUsersAction(){

        $serializer = SerializerBuilder::create()->build();

        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository(User::class)->getAllUsers();

        $data = $serializer->serialize($users, 'json');

        return new Response($data);
    }

    /**
   * @Route("/users/{id}", requirements={"id":"\d+"})
   * @Method("GET")
   */
  public function getUserAction($id){
      $serializer = SerializerBuilder::create()->build();
      $em = $this->getDoctrine()->getManager();
      $user = $em->getRepository(User::class)->getOneUser($id);
      if(empty($user))
      {
          return new JsonResponse(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
      }
      $data = $serializer->serialize($user, 'json');

      return new Response($data);
  }
}
