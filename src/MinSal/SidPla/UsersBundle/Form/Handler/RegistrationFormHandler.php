<?php

namespace  MinSal\SidPla\UsersBundle\Form\Handler;

use FOS\UserBundle\Form\Handler\RegistrationFormHandler as BaseHandler;
use FOS\UserBundle\Model\UserInterface;
use MinSal\SidPla\UsersBundle\Entity\User;

/**
 * @author Henry Willy Melara
 */
class RegistrationFormHandler extends BaseHandler{
    private $auditUserIns;
    private $auditUserUpd;
    
    public function processIns($confirmation = false, $auditUserIns){
        $this->auditUserIns = $auditUserIns;
        $this->process($confirmation);
    }
    
    public function processUpd($confirmation = false, $auditUserUpd){
        $this->auditUserUpd = $auditUserUpd;
        $this->process($confirmation);
    }
    
    public function process($confirmation = false){
        $user = $this->userManager->createUser();
        //$user->setUserInterno(true);
        $this->form->setData($user);

        if ('POST' == $this->request->getMethod()) {
            $this->form->bindRequest($this->request);
            
            if ($this->form->isValid()) {
                $user->setAuditUserIns($this->auditUserIns);
                $user->setAuditDateIns(new \DateTime());
                //var_dump($user);die;
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