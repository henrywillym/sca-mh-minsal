<?php

namespace  MinSal\SidPla\UsersBundle\Form\Handler;

use FOS\UserBundle\Form\Handler\RegistrationFormHandler as BaseHandler;
use FOS\UserBundle\Model\UserInterface;
use MinSal\SidPla\UsersBundle\Entity\User;
use MinSal\SidPla\AdminBundle\EntityDao\EntidadDao;
use MinSal\SidPla\AdminBundle\EntityDao\RolDao;
use MinSal\SidPla\UsersBundle\EntityDao\UserDao;
/**
 * @author Henry Willy Melara
 */
class RegistrationFormHandler extends BaseHandler{
    private $auditUser;
    private $entId;
    
    private $container;

    public function __construct($form, $request, $userManager, $mailer, $container){
        parent::__construct($form, $request, $userManager, $mailer);
        $this->container = $container;
    }
    
    public function processIns($entId, $auditUserIns, $confirmation = false){
        $this->auditUser = $auditUserIns;
        $this->entId = $entId;
        
        return $this->process($confirmation);
    }
    
    /*public function processUpd($confirmation = false, $auditUserUpd){
        $this->auditUserUpd = $auditUserUpd;
        return $this->process($confirmation);
    }*/
    
    public function process($confirmation = false){
        $user = $this->userManager->createUser();
        $this->form->setData($user);

        if ('POST' == $this->request->getMethod()) {
            $this->form->bindRequest($this->request);
            
            if ($this->form->isValid()) {
                
                $tmp = $user->getIdUsuario();
                
                if(empty($tmp) ){
                    $user->setAuditUserIns($this->auditUser);
                    $user->setAuditDateIns(new \DateTime());
                    
                    $tmp = $this->entId;
                    if( !empty($tmp)){
                        $entidadDao = new EntidadDao($this->container->get("doctrine"));
                        $entidad = $entidadDao->getEntidad($this->entId);
                        $user->setEntidad($entidad);
                    }
                }else{
                    $userDao = new UserDao($this->container->get("doctrine"));
                    $tmp = $userDao->getUserEspecifico($user->getIdUsuario());
                    
                    $this->form->setData($tmp);
                    $this->form->bindRequest($this->request);
                    $user = $tmp;
                    $tmp->setAuditUserUpd($this->auditUser);
                    $tmp->setAuditDateUpd(new \DateTime());
                }
                
                $rolDao= new RolDao($this->container->get("doctrine"));
                $user->setRols($rolDao->getRolesEspecificos(
                        $user->getEntidad()->getEntImportador(),
                        $user->getEntidad()->getEntProductor(),
                        $user->getEntidad()->getEntComprador(),
                        $user->getUserTipo(),
                        $user->getUserInterno(),
                        $user->getUserInternoTipo()
                ));
                
                //Hacer busqueda de los roles segun los campos de tipos y obtener el listado de objetos.
                $this->onSuccess($user, $confirmation);
                // do your custom logic here
                return true;
            }
        }

        return false;
    }
    
    protected function onSuccess(UserInterface $user, $confirmation){
        // Note: if you plan on modifying the user then do it before calling the 
        // parent method as the parent method will flush the changes

        parent::onSuccess($user, $confirmation);

        // otherwise add your functionality here
    }
}