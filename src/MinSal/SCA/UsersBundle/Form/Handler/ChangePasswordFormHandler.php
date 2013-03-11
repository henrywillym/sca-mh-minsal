<?php

namespace  MinSal\SCA\UsersBundle\Form\Handler;

use FOS\UserBundle\Form\Handler\ChangePasswordFormHandler as BaseHandler;
use FOS\UserBundle\Model\UserInterface;
use MinSal\SCA\UsersBundle\Entity\User;
use MinSal\SCA\AdminBundle\EntityDao\EntidadDao;
use MinSal\SCA\AdminBundle\EntityDao\RolDao;
use MinSal\SCA\UsersBundle\EntityDao\UserDao;

/**
 * @author Henry Willy Melara
 */
class ChangePasswordFormHandler extends BaseHandler{
    
    public function __construct($form, $request, $userManager, $container){
        parent::__construct($form, $request, $userManager);
        $this->container = $container;
    }
    
    public function process(UserInterface $user){
        $this->form->setData(new ChangePassword($user));

        if ('POST' == $this->request->getMethod()) {
            $this->form->bindRequest($this->request);

            if ($this->form->isValid()) {
                $this->onSuccess($user);

                return true;
            }
        }

        return false;
    }

    protected function onSuccess(UserInterface $user){
        parent::onSuccess($user);
    }
}
