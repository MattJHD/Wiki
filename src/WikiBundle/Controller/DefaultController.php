<?php

namespace WikiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render('default/index.html.twig');
    }
    
    /**
     * @Route("/test", name="test")
     */
    public function apiAction(Request $request)
    {
        return new Response(sprintf('Logged in as %s', $this->getUser()->getUsername()));
    }
    
    /**
    * @Route("/contact")
    * @Method("POST")
    */
     public function contactAction(Request $request){
         
        $jsonData = json_decode($request->getContent(), true);
        
        $name = $jsonData['lastname'];
        $firstName = $jsonData['firstname'];
        $email = $jsonData['email'];
        $body = $jsonData['message'];

        $this->get('mailer.contact_mailer')->sendMail($name, $firstName, $email, $body);
        
        return new JsonResponse('mail sent');
     }
}
