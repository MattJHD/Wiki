<?php
namespace WikiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use WikiBundle\Entity\Role;
use JMS\Serializer\SerializerBuilder;
use Doctrine\Common\Collections\ArrayCollection;

 /**
 * Description of RoleController
 *
 * @author williambloch
 *
 */
class RoleController extends Controller{

  /**
  * @Method("GET")
  * @Route("/roles")
  */
  public function getRolesAction(){
    $serializer = SerializerBuilder::create()->build();
    $em = $this->getDoctrine()->getManager();
    // We call the function to get all roles
    $roles = $em->getRepository(Role::class)->getAllRoles();

    $data = $serializer->serialize($roles, 'json');

    return new Response($data);
  }

  /**
  * @Route("/roles/{id}", requirements={"id":"\d+"})
  * @Method("GET")
  */
  public function getRoleAction($id){
    $serializer = SerializerBuilder::create()->build();
    $em = $this->getDoctrine()->getManager();
    // We call the function to get a single role
    $role = $em->getRepository(Role::class)->getOneRole($id);
    if(empty($role))
    {
      return new JsonResponse(['message' => 'Role not found'], Response::HTTP_NOT_FOUND);
    }
    $data = $serializer->serialize($role, 'json');

    return new Response($data);
  }

 /**
 * @Route("/roles")
 * @Method("POST")
 */
  public function postRoleAction(Request $request){
    $serializer = SerializerBuilder::create()->build();
    $jsonData = $request->getContent();
    $role = $serializer->deserialize($jsonData, Role::class, 'json');
    $errors = $this->get("validator")->validate($role);

    if(count($errors) == 0){
      $em = $this->getDoctrine()->getManager();
      // We call the function to create a role
      $em->getRepository(Role::class)->createRole($em, $role);

      return new JsonResponse("OK");
    }else{
      return $errors;
    }
  }

  /**
  * @Route("/roles/{id}", requirements={"id":"\d+"})
  * @Method("PUT")
  */
  public function putRoleAction($id, Request $request){
    $serializer = SerializerBuilder::create()->build();
    $em = $this->getDoctrine()->getManager();
    $jsonData = $request->getContent();
    $role = $serializer->deserialize($jsonData, Role::class, 'json');
    $errors = $this->get("validator")->validate($role);

    if (count($errors) == 0) {
      $em = $this->getDoctrine()->getManager();
      // We call the function to update a role
      $em->getRepository(Role::class)->updateRole($id, $role);

      return new JsonResponse("OK UPDATE");
    } else {
      return new JsonResponse("ERROR-NOT-VALID");
    }
  }

  /**
  * @Route("/roles/delete/{id}", requirements={"id":"\d+"})
  * @Method("GET|POST")
  */
  public function deleteRoleAction($id, Request $request){
    $serializer = SerializerBuilder::create()->build();
    $em = $this->getDoctrine()->getManager();
    $jsonData = $request->getContent();
    $role = $serializer->deserialize($jsonData, Role::class, 'json');
    $errors = $this->get("validator")->validate($role);

    if (count($errors) == 0) {
      $em = $this->getDoctrine()->getManager();
      // We call the function to delete a role
      $em->getRepository(Role::class)->deleteRole($id, $role);

      return new JsonResponse("OK - ROLE DELETED");
    } else {
      return new JsonResponse("ERROR-NOT-VALID");
    }
  }
}
