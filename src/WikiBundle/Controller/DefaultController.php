<?php

namespace WikiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/wiki")
     */
    public function indexAction()
    {
        return $this->render('default/index.html.twig');
    }
}
