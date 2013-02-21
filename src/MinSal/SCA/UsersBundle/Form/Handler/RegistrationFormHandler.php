<?php

namespace  MinSal\SCA\UsersBundle\Form\Handler;

use FOS\UserBundle\Form\Handler\RegistrationFormHandler as BaseHandler;
use FOS\UserBundle\Model\UserInterface;
use MinSal\SCA\UsersBundle\Entity\User;
use MinSal\SCA\AdminBundle\EntityDao\EntidadDao;
use MinSal\SCA\AdminBundle\EntityDao\RolDao;
use MinSal\SCA\UsersBundle\EntityDao\UserDao;
/**
 * @author Henry Willy Melara
 */
class RegistrationFormHandler extends BaseHandler{
    private $auditUser;
    private $entId;
    private $userInterno;
    
    private $container;

    public function __construct($form, $request, $userManager, $mailer, $container){
        parent::__construct($form, $request, $userManager, $mailer);
        $this->container = $container;
    }
    
    public function processIns($entId, $userInterno, $auditUserIns, $confirmation = false){
        $this->auditUser = $auditUserIns;
        $this->entId = $entId;
        $this->userInterno = $userInterno;
        
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
                
                
                //Si es update
                if(empty($tmp) ){
                    $user->setAuditUserIns($this->auditUser);
                    $user->setAuditDateIns(new \DateTime());
                    
                    $tmp = $this->entId;
                    if( !empty($tmp)){
                        $entidadDao = new EntidadDao($this->container->get("doctrine"));
                        $entidad = $entidadDao->getEntidad($this->entId);
                        $user->setEntidad($entidad);
                    }
                
                //Si es Insert    
                }else{
                    $userDao = new UserDao($this->container->get("doctrine"));
                    
                    //Se obtiene el registro de la BD
                    $tmp = $userDao->getUserEspecifico($user->getIdUsuario());
                    
                    //Se le asigna al Formulario
                    $this->form->setData($tmp);
                    
                    //Se realiza un merge con lo que se envio en el Request
                    $this->form->bindRequest($this->request);
                    
                    $user = $tmp;
                    $tmp->setAuditUserUpd($this->auditUser);
                    $tmp->setAuditDateUpd(new \DateTime());
                }
                
                $rolDao= new RolDao($this->container->get("doctrine"));
                
                //Se asignan roles dependiendo del usuario interno
                if($this->userInterno =='false'){
                    $user->setRols($rolDao->getRolesEspecificos(
                            $user->getEntidad()->getEntImportador(),
                            $user->getEntidad()->getEntProductor(),
                            $user->getEntidad()->getEntComprador(),
                            $user->getEntidad()->getEntCompVend(),
                            $user->getUserTipo(),
                            $user->getUserInterno(),
                            $user->getUserInternoTipo()
                    ));
                }else{
                    $user->setRols($rolDao->getRolesEspecificos(
                            false,
                            false,
                            false,
                            false,
                            $user->getUserTipo(),
                            $user->getUserInterno(),
                            $user->getUserInternoTipo()
                    ));
                }
                
                
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

        //parent::onSuccess($user, $confirmation);
        
        if ($confirmation) {
            $user->setEnabled(false);
            $user->generateConfirmationToken();
            $this->mailer->sendConfirmationEmailMessage($user);
        } else {
            $user->setConfirmationToken(null);
            $user->setEnabled(true);
        }

        $this->userManager->updateUser($user);

        // otherwise add your functionality here
    }
}