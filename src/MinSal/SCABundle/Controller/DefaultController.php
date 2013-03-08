<?php

namespace MinSal\SCABundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use MinSal\SCA\AdminBundle\Entity\OpcionSistema;
use MinSal\SCA\AdminBundle\Entity\RolSistema;
use MinSal\SCA\AdminBundle\EntityDao\OpcionSistemaDao;
use MinSal\SCA\UsersBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

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
               $result[$value->getIdOpcionSistema()] = $value;
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

                return $this->render('MinSalSCABundle:Default:index.html.twig', array('opciones' => $opciones));
            }
        }else{
            if ($user != 'anon.' && $user->getAuditDeleted() == true) {
                $this->get('session')->setFlash('notice', 'El usuario "'.$user->getUsername().'" se encuentra inactivo');
                $this->getRequest()->getSession()->set('notice', 'El usuario "'.$user->getUsername().'" se encuentra inactivo');
                return new RedirectResponse($this->generateUrl('fos_user_security_logout'));
                //return $this->redirect($this->generateUrl('fos_user_security_logout'));
            }
            
            return $this->render('MinSalSCABundle:Default:index.html.twig');
        }
    }

}
