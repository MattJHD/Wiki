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
        $roles = $em->getRepository(Role::class)->findAll();

        $data = $serializer->serialize($roles, 'json');

        return new Response($data);

    }
}
