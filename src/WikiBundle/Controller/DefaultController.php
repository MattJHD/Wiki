<?php

namespace WikiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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
}
