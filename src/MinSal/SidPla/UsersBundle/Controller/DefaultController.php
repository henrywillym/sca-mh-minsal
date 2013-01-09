<?php

namespace MinSal\SidPla\UsersBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Controller\RegistrationController as BaseController;
use MinSal\SidPla\AdminBundle\Entity\Empleado;
use MinSal\SidPla\AdminBundle\Entity\RolSistema;
use MinSal\SidPla\AdminBundle\EntityDao\EmpleadoDao;
use MinSal\SidPla\AdminBundle\EntityDao\EntidadDao;
use MinSal\SidPla\AdminBundle\EntityDao\RolDao;
use MinSal\SidPla\UsersBundle\Entity\User;
use MinSal\SidPla\UsersBundle\EntityDao\UserDao;
use MinSal\SidPla\UsersBundle\Form\Type\RegistrationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends BaseController {

    /**
     * Retorna la página principal donde se muestra el listado de usuarios Internos u Externos
     * @return type HTML.twig
     */
    public function mantUsersAction($entId, $userInterno) {
        $opciones = $this->container->get("request")->getSession()->get('opciones');
        $entNombre = null;
        
        if($userInterno == 'false'){
            $entidadDao = new EntidadDao($this->container->get("doctrine"));
            $entNombre = $entidadDao->getEntidad($entId)->getEntNombre();
        }
        
        return $this->container->get('templating')->renderResponse('MinSalSidPlaUsersBundle:Usuarios:mantUsuarios.html.twig', array(
            'opciones' => $opciones, 
            'userInterno'=>$userInterno, 
            'entId'=>$entId,
            'entNombre'=>$entNombre,
        ));
    }

    /**
     * Devuelve el listado principal de registros del mantenimiento
     * @return Response
     */
    public function consultarUsuariosJSONAction($entId, $userInterno) {
        $userDao = new UserDao($this->container->get("doctrine"));
        $usuarios =null;
        
        if($userInterno == 'true'){
            $usuarios = $userDao->getUsersInternos();
        }else{
            $usuarios = $userDao->getUsersExternos($entId);
        }

        $numfilas = count($usuarios);
        
        
        if ($numfilas != 0) {
            //array_multisort($usuarios, SORT_ASC);
            $usuario = new User();
            $i=0;
            foreach ($usuarios as $usu) {
                $usuario->setUserInternoTipo($usu['userInternoTipo']);
                $usuario->setUserTipo($usu['userTipo']);
                
                $usuarios[$i]['userInternoTipoText']= $usuario->getUserInternoTipoText();
                $usuarios[$i]['userTipoText']= $usuario->getUserTipoText();
                $i=$i+1;
            }
        } else {
            //$rows[0]['id'] = 0;
            //$rows[0]['cell'] = array(' ', ' ',' ', ' ', ' ', ' ', ' ', ' ');
        }

        $datos = json_encode($usuarios);
        $pages = floor($numfilas / 10) + 1;

        $jsonresponse = '{
               "page":"1",
               "total":"' . $pages . '",
               "records":"' . $numfilas . '", 
               "rows":' . $datos . '}';

        return new Response($jsonresponse);
    }
    
    public function mantCargarUsuarioAction($userInterno, $idUsuario, $entId){
        $opciones = $this->container->get("request")->getSession()->get('opciones');
        $entNombre = null;
        
        if($userInterno == 'false'){
            $entidadDao = new EntidadDao($this->container->get("doctrine"));
            $entNombre = $entidadDao->getEntidad($entId)->getEntNombre();
        }
        
        $userDao = new UserDao($this->container->get("doctrine"));
        $usuario = $userDao->getUserEspecifico($idUsuario);
        
        if( !$usuario ){
            $usuario = new User();
        }
        
        $form = $this->container->get('fos_user.registration.form');//$form = $this->createForm(new RegistrationFormType(), $usuario);
        $form->setData($usuario);

        return $this->container->get('templating')->renderResponse('MinSalSidPlaUsersBundle:Registration:register.html.twig', array(
            'form' => $form->createView(),
            'theme' => $this->container->getParameter('fos_user.template.theme'),
            'userInterno' => $userInterno,
            'entId' => $entId,
            'entNombre' => $entNombre,
            'opciones' => $opciones,
        ));
    }
    
    public function registerAction(){
        $request = $this->container->get("request");
        $opciones = $request->getSession()->get('opciones');
        
        $userInterno = $request->get("userInterno");
        $eliminar = $request->get("eliminar");
        
        if($eliminar === 'true'){
            return $this->eliminarAction($request);
        }
        
        $entId = '';
        $entNombre = '';
        if($userInterno == 'false'){
            $entId = $request->get("entId");
            $entidadDao = new EntidadDao($this->container->get("doctrine"));//fos_user.user_manager
            $entNombre = $entidadDao->getEntidad($entId)->getEntNombre();
        }
        
        $form = $this->container->get('fos_user.registration.form');
        $formHandler = $this->container->get('fos_user.registration.form.handler');
        
        $auditUser = $this->container->get('security.context')->getToken()->getUser();
        //$this->container->get('session')->set('auditUserIns', $auditUser->getUsername());
        
        $confirmationEnabled = $this->container->getParameter('fos_user.registration.confirmation.enabled');
        
        $process = $formHandler->processIns($entId, $auditUser, $confirmationEnabled);
        
        if ($process) {
            $user = $form->getData();
            
            /*****************************************************
             * Add new functionality (e.g. log the registration) *
             *****************************************************/
            
            $url= null;
            if ($confirmationEnabled) {
                $this->container->get('session')->set('fos_user_send_confirmation_email/email', $user->getEmail());
                $route = 'fos_user_registration_check_email';
                
                $this->setFlash('fos_user_success', 'registration.flash.user_created');
                $url = $this->container->get('router')->generate($route);

            } else {
                //$this->authenticateUser($user);
                //$route = 'fos_user_registration_confirmed';
                $this->setFlash('fos_user_success', 'El usuario ha sido guardado exitosamente');
                
                $route = 'MinSalSidPlaUsersBundle_mantMostrarUsuarios';
                $url = $this->container->get('router')->generate($route, array(
                    'userInterno' => $userInterno,
                    'entId' => $entId,
                    'entNombre' => $entNombre,
                    'opciones' => $opciones,
                ));
            }
            return new RedirectResponse($url);
        }
        
        
        //FOSUserBundle:Registration:register.html
        return $this->container->get('templating')->renderResponse('MinSalSidPlaUsersBundle:Registration:register.html.'.$this->getEngine(), array(
            'form' => $form->createView(),
            'theme' => $this->container->getParameter('fos_user.template.theme'),
            'userInterno' => $userInterno,
            'entId' => $entId,
            'entNombre' => $entNombre,
            'opciones' => $opciones,
        ));
    }
    
    /*
    public function mostrarUsuariosSinRolAction() {
        $opciones = $this->getRequest()->getSession()->get('opciones');

        $rolDao = new RolDao($this->getDoctrine());
        $roles = $rolDao->getRoles();
        $aux = new RolSistema();
        $cadena = '';
        $i = 1;
        $n = count($roles);
        foreach ($roles as $aux) {
            if ($i != $n)
                $cadena.=$aux->getIdRol() . ':' . $aux->getNombreRol() . ';';
            else
                $cadena.=$aux->getIdRol() . ':' . $aux->getNombreRol();
            $i++;
        }

        return $this->render('MinSalSidPlaUsersBundle:Usuarios:manttUsuariosSinRol.html.twig', array('opciones' => $opciones, 'roles' => $cadena));
    }

    public function consultarUsuarioSinRolJSONAction() {

        $usuarioDao = new UserDao($this->getDoctrine());
        $usuarios = $usuarioDao->getUserSinRol();

        $numfilas = count($usuarios);

        $aux = new User();
        $i = 0;

        foreach ($usuarios as $aux) {
            $rows[$i]['id'] = $aux->getIdUsuario();
            $rows[$i]['cell'] = array($aux->getIdUsuario(),
                $aux->getUsername(),
                $aux->getUserPrimerNombre() . ' ' . $aux->getUserApellidos(),
                $aux->getUserInternoTipo()
            );
            $i++;
        }

        if ($numfilas != 0) {
            array_multisort($rows, SORT_ASC);
        } else {
            $rows[0]['id'] = 0;
            $rows[0]['cell'] = array(' ', ' ', ' ', ' ');
        }

        $datos = json_encode($rows);
        $pages = floor($numfilas / 10) + 1;

        $jsonresponse = '{
               "page":"1",
               "total":"' . $pages . '",
               "records":"' . $numfilas . '", 
               "rows":' . $datos . '}';


        $response = new Response($jsonresponse);
        return $response;
    }

    public function editarUsuarioSinRolAction() {
        $request = $this->getRequest();
        $codigoUsuario = $request->get('id');
        $numRol = $request->get('rol');

        $userDao = new UserDao($this->getDoctrine());
        $userDao->editUserSinRol($codigoUsuario, $numRol);

        return new Response("{sc:true,msg:''}");
    }/**/

    public function verificaCreacionAction() {
        $request = $this->container->get("request");
        $idUsuario = $request->get('idUsuario');
        $username = $request->get('username');
        $email = $request->get('email');

        //$empleadoDao = new EmpleadoDao($this->getDoctrine());
        
        //$be = $empleadoDao->existeEmpleado($idEmpleado);

        $userDao = new UserDao($this->container->get("doctrine"));
        
        //Se verifica si se encuentra registrado el usuario registrado 
        //$bu = $userDao->tieneOtroUsuario($idEmpleado);
        $bud = $userDao->usernameDisponible($username, $idUsuario);
        $bemail = $userDao->emailDisponible($email, $idUsuario);
        /*
        if ($be == 0) {
            $msj[0][0] = 'NO EXISTE EL EMPLEADO';
            $msj[0][1] = FALSE;
        } else {
            if ($bu != 0) {
                $msj[0][0] = 'NO SE PUEDE CREAR UN USUARIO PARA ESTE EMPLEADO PORQUE YA TIENE ASIGNADO UNO';
                $msj[0][1] = FALSE;
            } else {/**/
                if ($bud != 0) {
                    $msj[0][0] = 'ESTE USUARIO YA ESTA EN USO, ESCRIBA UN NUEVO NOMBRE DE USUARIO';
                    $msj[0][1] = FALSE;
                } else {
                    if ($bemail != 0) {
                        $msj[0][0] = 'ESTE EMAIL NO PUEDE UTILIZARSE PORQUE YA TIENE USUARIO ASIGNADO';
                        $msj[0][1] = FALSE;
                    } else {
                        $msj[0][0] = 'SE HA CREADO EXITOSAMENTE';
                        $msj[0][1] = TRUE;
                    }
                }
            /*}
        }/**/
        $datos = json_encode($msj);
        $numfilas = 1;
        $pages = floor($numfilas / 10) + 1;

        $jsonresponse = '{
               "page":"1",
               "total":"' . $pages . '",
               "records":"' . $numfilas . '", 
               "msj":' . $datos . '}';


        $response = new Response($jsonresponse);
        return $response;
    }
    
    private function eliminarAction($request){
        $opciones = $request->getSession()->get('opciones');
        $userInterno = $request->get("userInterno");
        $auditUser = $this->container->get('security.context')->getToken()->getUser();
        
        $entId = '';
        $entNombre = '';
        
        if($userInterno == 'false'){
            $entId = $request->get("entId");
            $entidadDao = new EntidadDao($this->container->get("doctrine"));//fos_user.user_manager
            $entNombre = $entidadDao->getEntidad($entId)->getEntNombre();
        }
        
        $user = new User();
        
        $form = $this->container->get('fos_user.registration.form');//$form = $this->createForm(new RegistrationFormType(), $usuario);
        $form->setData($user);
        $form->bindRequest($request);
        
        $userDao= new UserDao($this->container->get("doctrine"));
        $user = $userDao->eliminarUsuario($user->getIdUsuario(), $auditUser);
                
        $this->setFlash('fos_user_success', '#### El usuario "'.$user->getUsername().'" ha sido eliminado ####');
                
        $route = 'MinSalSidPlaUsersBundle_mantMostrarUsuarios';
        $url = $this->container->get('router')->generate($route, array(
            'userInterno' => $userInterno,
            'entId' => $entId,
            'entNombre' => $entNombre,
            'opciones' => $opciones,
        ));
        return new RedirectResponse($url);
    }

}