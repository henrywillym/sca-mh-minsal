<?php

namespace Acme\HolaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    
    public function indexAction($name)
    {
        return $this->render('AcmeHolaBundle:Default:index.html.twig', array('name' => $name));
    }
}
