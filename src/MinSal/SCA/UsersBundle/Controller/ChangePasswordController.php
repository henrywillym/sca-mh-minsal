<?php

namespace MinSal\SCA\UsersBundle\Controller;

use FOS\UserBundle\Controller\ChangePasswordController as BaseController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use FOS\UserBundle\Model\UserInterface;

/**
 * @author: Henry Melara
 */
class ChangePasswordController extends BaseController{
    
    
    /**
     * Se encarga de presentar el formulario para actualización de clave
     * 
     * @param type $idUsuario
     * @return RenderResponse
     */
    public function mantChangePasswordAction(){
        $opciones = $this->container->get("request")->getSession()->get('opciones');
        
        $form = $this->container->get('fos_user.change_password.form');
        
        return $this->container->get('templating')->renderResponse('MinSalSCAUsersBundle:ChangePassword:changePassword.html.twig', array(
            'form' => $form->createView(),
            //'theme' => $this->container->getParameter('fos_user.template.theme'),
            'opciones' => $opciones
        ));
    }

    /**
     * Change user password
     */
    public function changePasswordAction(){
        $user = $this->container->get('security.context')->getToken()->getUser();
        $opciones = $this->container->get("request")->getSession()->get('opciones');
        
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $form = $this->container->get('fos_user.change_password.form');
        $formHandler = $this->container->get('fos_user.change_password.form.handler');

        $process = $formHandler->process($user);
        if ($process) {
            $this->setFlash('notice', 'Clave Actualizada');

            return new RedirectResponse($this->getRedirectionUrl($user));
        }
        
        return $this->container->get('templating')->renderResponse(
            'MinSalSCAUsersBundle:ChangePassword:changePassword.html.'.$this->container->getParameter('fos_user.template.engine'),
            array(
                'form' => $form->createView(), 
                //'theme' => $this->container->getParameter('fos_user.template.theme'),
                'opciones' => $opciones
            )
        );
    }

    /**
     * Generate the redirection url when the resetting is completed.
     *
     * @param UserInterface $user
     * @return string
     */
    protected function getRedirectionUrl(UserInterface $user)
    {
        return $this->container->get('router')->generate('MinSalSCAUsersBundle_mantChangePassword');
    }

    protected function setFlash($action, $value)
    {
        $this->container->get('session')->setFlash($action, $value);
    }
}
