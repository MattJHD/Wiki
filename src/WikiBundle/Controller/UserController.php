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
    // We call the function to get all users
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
    // We call the function to get a single user
    $user = $em->getRepository(User::class)->getOneUser($id);

    if(empty($user)){
      return new JsonResponse(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
    }
    $data = $serializer->serialize($user, 'json');

    return new Response($data);
  }

 /**
 * @Route("/users")
 * @Method("POST")
 */
  public function postUserAction(Request $request){
    $serializer = SerializerBuilder::create()->build();
    $jsonData = $request->getContent();
    $user = $serializer->deserialize($jsonData, User::class, 'json');
    $errors = $this->get("validator")->validate($user);

    if(count($errors) == 0){
      $em = $this->getDoctrine()->getManager();
      // We call the function to create a user
      $em->getRepository(User::class)->createUser($em, $user);

      return new JsonResponse("OK");
    }else{
      return $errors;
    }
  }

  /**
  * @Route("/users/{id}", requirements={"id":"\d+"})
  * @Method("PUT")
  */
  public function putUsersAction($id, Request $request){
    $serializer = SerializerBuilder::create()->build();
    $em = $this->getDoctrine()->getManager();
    $jsonData = $request->getContent();
    $user = $serializer->deserialize($jsonData, User::class, 'json');
    $errors = $this->get("validator")->validate($user);

    if (count($errors) == 0) {
      $em = $this->getDoctrine()->getManager();
      // We call the function to update a user
      $em->getRepository(User::class)->updateUser($id, $user);

      return new JsonResponse("OK UPDATE");
    } else {
      return new JsonResponse("ERROR-NOT-VALID");
    }
  }

  /**
  * @Route("/users/delete/{id}", requirements={"id":"\d+"})
  * @Method("GET|POST")
  */
  public function deleteUserAction($id, Request $request){
    $serializer = SerializerBuilder::create()->build();
    $em = $this->getDoctrine()->getManager();
    $jsonData = $request->getContent();
    $user = $serializer->deserialize($jsonData, User::class, 'json');
    $errors = $this->get("validator")->validate($user);

    if (count($errors) == 0) {
      $em = $this->getDoctrine()->getManager();
      // We call the function to delete a user
      $em->getRepository(User::class)->deleteUser($id, $user);

      return new JsonResponse("OK - USER DELETED");
    } else {
      return new JsonResponse("ERROR-NOT-VALID");
    }
  }
}
