<?php

namespace MinSal\SCA\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{    
    public function indexAction()
    {
        $opciones=$this->getRequest()->getSession()->get('opciones');        
        return $this->render('MinSalSCAAdminBundle:Default:index.html.twig', array('opciones' => $opciones));
        //return $this->render('MinSalSCAAdminBundle:Default:index.html.twig', array('opciones' => $opciones));
    }
}
