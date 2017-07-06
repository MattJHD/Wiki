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
    * @Route("/users/username={username}", requirements={"username":"[a-zA-Z0-9-]+"})
    * @Method("GET")
    */
   public function getUserByUsernameAction($username){

       $serializer = SerializerBuilder::create()->build();

       $em = $this->getDoctrine()->getManager();
       $objectUser = $em->getRepository(User::class)->loadUserByUsername($username);

       $data = $serializer->serialize($objectUser, 'json');

       return new Response($data);

   }

   /**
 * @Route("/creation")
 * @Method("POST")
 */
  public function postUserByUserAction(Request $request){
    $serializer = SerializerBuilder::create()->build();
    $jsonData = $request->getContent();
    $user = $serializer->deserialize($jsonData, User::class, 'json');

    $user->setRawPassword($user->getPassword());

    $errors = $this->get("validator")->validate($user);

    if(count($errors) == 0){
      $em = $this->getDoctrine()->getManager();


      $encodedPassword = $this->get('encoder.password')->encode($user);

      $password = $user->getPassword();

      // We call the function to create a user
      $em->getRepository(User::class)->createUser($em, $user, $password);

      //$this->get('mailer.contact_mailer')->sendPwd($user);

      return new JsonResponse("OK");
    }else{
      return $errors;
    }
  }

 /**
 * @Route("/users")
 * @Method("POST")
 */
  public function postUserByAdminAction(Request $request){
    $serializer = SerializerBuilder::create()->build();
    $jsonData = $request->getContent();
    $user = $serializer->deserialize($jsonData, User::class, 'json');

    // We get the current user in session
    $currentUser = $this->get('security.token_storage')->getToken()->getUser();

    // We check that the user is an admin
    // If yes, he can create another user, if not, he can't
    if($currentUser->getRole()->getId() == 1){
      $user->setRawPassword(uniqid());

      $errors = $this->get("validator")->validate($user);

      if(count($errors) == 0){
        $em = $this->getDoctrine()->getManager();
        $encodedPassword = $this->get('encoder.password')->encode($user);
        $password = $user->getPassword();

        // We call the function to create a user
        $em->getRepository(User::class)->createUser($em, $user, $password);
        $this->get('mailer.contact_mailer')->sendPwd($user);

        return new JsonResponse("OK");
      }else{
        return $errors;
      }
    } else {
      return new JsonResponse("ADMIN ROLE NEEDED FOR USER CREATION");
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

    // We get the current user in session
    $currentUser = $this->get('security.token_storage')->getToken()->getUser();

    // We check that the user is an admin
    // If yes, he can update another user, if not, he can't
    if($currentUser->getRole()->getId() == 1){
      if (count($errors) == 0) {
        $em = $this->getDoctrine()->getManager();
        // We call the function to update a user
        $em->getRepository(User::class)->updateUser($id, $user);

        return new JsonResponse("OK UPDATE");
      } else {
        return new JsonResponse("ERROR-NOT-VALID");
      }
    } else {
      return new JsonResponse("ADMIN ROLE NEEDED FOR USER UPDATE");
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
    // We get the current user in session
    $currentUser = $this->get('security.token_storage')->getToken()->getUser();

    // We check that the user is an admin
    // If yes, he can update another user, if not, he can't
    if($currentUser->getRole()->getId() == 1){
      if (count($errors) == 0) {
        $em = $this->getDoctrine()->getManager();
        // We call the function to delete a user
        $em->getRepository(User::class)->deleteUser($id, $user);

        return new JsonResponse("OK - USER DELETED");
      } else {
        return new JsonResponse("ERROR-NOT-VALID");
      }
    } else {
      return new JsonResponse("ADMIN ROLE NEEDED TO DELETE USER");
    }
  }
}
