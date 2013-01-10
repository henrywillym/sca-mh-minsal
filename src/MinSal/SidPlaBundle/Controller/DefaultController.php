<?php

namespace MinSal\SidPlaBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use MinSal\SidPla\UsersBundle\Entity\User;
use MinSal\SidPla\AdminBundle\Entity\RolSistema;
use MinSal\SidPla\AdminBundle\Entity\OpcionSistema;
use MinSal\SidPla\AdminBundle\EntityDao\OpcionSistemaDao;

/**
    *  Merge the arrays passed to the function and keep the keys intact.
    *  If two keys overlap then it is the last added key that takes precedence.
    * 
    * @return Array the merged array
    */
    function array_merge_maintain_keys() {
       $args = func_get_args();
       $result = array();
       foreach ( $args as &$array ) {
           foreach ( $array as $key => &$value ) {
               $result[$key] = $value;
           }
       }
       return $result;
    }
class DefaultController extends Controller {
    
    
    
    public function indexAction() {
        $user = new User();
        $rol = new RolSistema();
        $opciones = new ArrayCollection();//new OpcionSistema();

        $user = $this->get('security.context')->getToken()->getUser();

        if ($user != 'anon.' && $user->getAuditDeleted() == false) {
            $roles = $user->getRols();
            
            if (isset($roles)){
                foreach ($roles as $rol ){
                    //$opciones = $rol->getOpcionesSistema();
                     $opciones = new ArrayCollection(array_merge_maintain_keys($opciones->toArray(), $rol->getOpcionesSistema()->toArray())); 
                }
            
                $peticion = $this->getRequest();
                $sesion = $peticion->getSession();
                $sesion->set('opciones', $opciones);

                return $this->render('MinSalSidPlaBundle:Default:index.html.twig', array('opciones' => $opciones));
            }
        }else{
            if ($user != 'anon.' && $user->getAuditDeleted() == true) {
                $this->get('session')->setFlash('notice', 'El usuario "" se encuentra inactivo');
            }
            
            return $this->render('MinSalSidPlaBundle:Default:index.html.twig');
        }
    }

}
