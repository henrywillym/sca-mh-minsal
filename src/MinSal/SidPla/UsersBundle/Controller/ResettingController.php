<?php

namespace MinSal\SidPla\UsersBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Controller\ResettingController as BaseController;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @author: Henry Melara
 */
class ResettingController extends BaseController{
    
    /**
     * Reset user password
     */
    public function resetAction($token)
    {
        $user = $this->container->get('fos_user.user_manager')->findUserByConfirmationToken($token);

        if (null === $user){
            throw new NotFoundHttpException(sprintf('The user with "confirmation token" does not exist for value "%s"', $token));
        }

        if (!$user->isPasswordRequestNonExpired($this->container->getParameter('fos_user.resetting.token_ttl'))) {
            return new RedirectResponse($this->container->get('router')->generate('fos_user_resetting_request'));
        }

        $form = $this->container->get('fos_user.resetting.form');
        $formHandler = $this->container->get('fos_user.resetting.form.handler');
        $process = $formHandler->process($user);

        if ($process) {
            $this->authenticateUser($user);

            //$this->setFlash('fos_user_success', 'resetting.flash.success');

            //return new RedirectResponse($this->getRedirectionUrl($user));
            
            $request = $this->container->get("request");
            $this->generateOpciones($user);
            $opciones = $request->getSession()->get('opciones');

            return $this->container->get('templating')->renderResponse('MinSalSidPlaUsersBundle:Registration:confirmed.html.twig', array(
                'user' => $user,
                'opciones' => $opciones
            ));
        }

        return $this->container->get('templating')->renderResponse('FOSUserBundle:Resetting:reset.html.'.$this->getEngine(), array(
            'token' => $token,
            'form' => $form->createView(),
            'theme' => $this->container->getParameter('fos_user.template.theme'),
        ));
    }
    
    
    /**
     * Generate the redirection url when the resetting is completed.
     *
     * @param UserInterface $user
     * @return string
     */
    protected function getRedirectionUrl(UserInterface $user){
        $request = $this->container->get("request");
        $opciones = $request->getSession()->get('opciones');
        
        return $this->container->get('templating')->renderResponse('MinSalSidPlaUsersBundle:Registration:confirmed.html.twig', array(
            'user' => $user,
            'opciones' => $opciones 
        ));
    }

    protected function setFlash($action, $value){
        $this->container->get('session')->setFlash('notice', $value);
    }
    
    private function generateOpciones($user){
        $request = $this->container->get("request");
        $roles = $user->getRols();
        $opciones = new ArrayCollection();
        
        if (isset($roles)){
            foreach ($roles as $rol ){
                $opciones = new ArrayCollection($this->array_merge_maintain_keys($opciones->toArray(), $rol->getOpcionesSistema()->toArray())); 
            }

            $request->getSession()->set('opciones', $opciones);
        }
    }
    
    /**
    *  Merge the arrays passed to the function and keep the keys intact.
    *  If two keys overlap then it is the last added key that takes precedence.
    * 
    * @return Array the merged array
    */
    private function array_merge_maintain_keys() {
       $args = func_get_args();
       $result = array();
       foreach ( $args as &$array ) {
           foreach ( $array as $key => &$value ) {
               $result[$key] = $value;
           }
       }
       return $result;
    }
}
