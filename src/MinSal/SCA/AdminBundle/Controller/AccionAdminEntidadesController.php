<?php

/**
 * Description of AccionAdminEntidadController
 *
 * @author Henry Willy Melara
 */

namespace MinSal\SCA\AdminBundle\Controller;

use MinSal\SCA\AdminBundle\Entity\Entidad;
use MinSal\SCA\AdminBundle\EntityDao\CuotaDao;
use MinSal\SCA\AdminBundle\EntityDao\EntidadDao;
use MinSal\SCA\AdminBundle\EntityDao\ListadoDNMDao;
use MinSal\SCA\AdminBundle\EntityDao\RolDao;
use MinSal\SCA\AdminBundle\Form\Type\EntidadType;
use MinSal\SCA\ProcesosBundle\EntityDao\ListadoMHDao;
use MinSal\SCA\UsersBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
* Mantenimineto de Productores, Importadores y Compradores Locales...
* 
*/
class AccionAdminEntidadesController extends Controller {

    /**
     * Retorna la página principal del mantenimiento
     * @return type HTML.twig
     */
    public function mantEntidadesAction() {
        $opciones = $this->getRequest()->getSession()->get('opciones');
        return $this->render('MinSalSCAAdminBundle:Entidad:mantEntidades.html.twig', 
                array('opciones' => $opciones));
    }

    /**
     * Devuelve el listado principal de registros del mantenimiento
     * @return Response
     */
    public function consultarEntidadesJSONAction() {
        $rows = null;
        $request = $this->getRequest();
        $entidadDao = new EntidadDao($this->getDoctrine());
        $entidades = $entidadDao->getEntidades();

        $numfilas = count($entidades);
        
        //$emple = new Entidad();

        if ($numfilas != 0) {
            //array_multisort($entidades, SORT_ASC);
            $entidad = new Entidad();
            $i = 0;
            
            foreach ($entidades as $ent) {
                $entidad->setEntImportador($ent['entImportador']);
                $entidad->setEntProductor($ent['entProductor']);
                $entidad->setEntComprador($ent['entComprador']);
                $entidad->setEntCompVend($ent['entCompVend']);
                $entidad->setEntHabilitado($ent['entHabilitado']);
                $entidad->setEntTipoPersona($ent['entTipoPersona']);
                
                $entidades[$i]['entImportadorText']= $entidad->getEntImportadorText();
                $entidades[$i]['entProductorText']= $entidad->getEntProductorText();
                $entidades[$i]['entCompradorText']= $entidad->getEntCompradorText();
                $entidades[$i]['entCompVendText']= $entidad->getEntCompVendText();
                $entidades[$i]['entHabilitadoText']= $entidad->getEntHabilitadoText();
                $entidades[$i]['entTipoPersonaText']= $entidad->getEntTipoPersonaText();
                $i=$i+1;
            }
        } else {
            //$rows[0]['id'] = 0;
            //$rows[0]['cell'] = array(' ', ' ',' ', ' ', ' ', ' ', ' ', ' ');
        }

        $datos = json_encode($entidades);
        $pages = floor($numfilas / 10) + 1;

        $jsonresponse = '{
               "page":"1",
               "total":"' . $pages . '",
               "records":"' . $numfilas . '", 
               "rows":' . $datos . '}';

        $response = new Response($jsonresponse);
        return $response;
    }

    /*
     * Se encarga de ejecutar las acciones de Eliminar, agregar y editar
     * del mantenimiento
     */
    public function mantEntidadEdicionAction(Request $request) {
        $autorizadoDNM = null;
        $autorizadoDNMText = null;
        $entidadTmp = new Entidad();
        $form = $this->createForm(new EntidadType(), $entidadTmp);
        $form->bindRequest($request);
        
        $entidad = new Entidad();
        $entidadDao = new EntidadDao($this->getDoctrine());
        $listadoDNMDao = new ListadoDNMDao($this->getDoctrine());
        $listadoMHDao = new ListadoMHDao($this->getDoctrine());
        
        $user = $this->get('security.context')->getToken()->getUser();
        $errores = null;
        
        //Validaciones de NIT de Representante y Empresa
        $tmpEntidad = $entidadDao->getRepresentanteByNIT($entidadTmp->getEntRepNit(), $entidadTmp->getEntId());
        if($tmpEntidad != null){
            $errores = 'ERROR: El NIT del representante "'.$entidadTmp->getEntRepNit().'" ya existe como representante de la empresa con nombre comercial "'.$tmpEntidad->getEntNombComercial().'".';
        }
        
        $tmpEntidad = $entidadDao->getRepresentanteByNIT($entidadTmp->getEntNit(), $entidadTmp->getEntId());
        if($tmpEntidad != null){
            $errores = 'ERROR: El NIT de la empresa "'.$entidadTmp->getEntNit().'" ya existe como representante de la empresa con nombre comercial "'.$tmpEntidad->getEntNombComercial().'"';
        }
        
        $tmpEntidad = $entidadDao->getEntidadByNIT($entidadTmp->getEntRepNit(), $entidadTmp->getEntId());
        if($tmpEntidad != null){
            $errores = 'ERROR: El NIT del representante "'.$entidadTmp->getEntRepNit().'" ya existe como NIT de la empresa con nombre comercial "'.$tmpEntidad->getEntNombComercial().'".';
        }
        /*
        $tmpEntidad = $entidadDao->getEntidadByNIT($entidadTmp->getEntNit(), $entidadTmp->getEntId());
        if($tmpEntidad != null){
            $errores = 'ERROR: El NIT de la empresa "'.$entidadTmp->getEntNit().'" ya existe como representante de la empresa con nombre comercial "'.$tmpEntidad->getEntNombComercial().'"';
        }/**/
        
        //Validacion para verificar que el NIT/NRC se encuentran registrados en el listado de MH
        $tmpEntidad = $listadoMHDao->getEntidadByNITNRC($entidadTmp->getEntNit(), $entidadTmp->getEntNrc(), $entidadTmp->getEntTipoPersona());
        if($tmpEntidad === false){
            $errores = 'ERROR: La combinación Tipo Persona-NIT-NRC de la empresa no existe en el listado del Ministerio de Hacienda';
        }
        
        /**********************/
        
        if( $entidadTmp->getEntId() ){
            $entidad = $entidadDao->getEntidad($entidadTmp->getEntId());
            //#### Auditoría 
            $entidad->setAuditUserUpd($user->getUsername());
            $entidad->setAuditDateUpd(new \DateTime());
            
            //## Mensaje de validacion de DNM
            $year = new \DateTime();
            $autorizadoDNM = $listadoDNMDao->estaAutorizado($year->format('Y')+0, $entidad->getEntNrc(), $entidad->getEntNit());
            
            if(!$autorizadoDNM){
                $autorizadoDNMText = ListadoDNMDao::$MSG_ERROR_DNM_NOAUTH;
            }
        }else{
            //#### Auditoría 
            $entidad->setAuditUserIns($user->getUsername());
            $entidad->setAuditDateIns(new \DateTime());
        }
        
        $form = $this->createForm(new EntidadType(),$entidad);
        
        $form->bindRequest($request);
        
        $errores = $this->validarFormulario($entidad);
        if($form->isValid() && $errores == null){
            $entidad->setEntYear($entidad->getEntVenc()->format("Y"));
            
            $entidad->setEntRegMinsal(strtoupper($entidad->getEntRegMinsal()));
            $entidad->setEntRegDgii(strtoupper($entidad->getEntRegDgii()));
            $entidad->setEntGiro(strtoupper($entidad->getEntGiro()));
            $entidad->setEntEmail(strtoupper($entidad->getEntEmail()));
            $entidad->setEntNombre(strtoupper($entidad->getEntNombre()));
            $entidad->setEntNombComercial(strtoupper($entidad->getEntNombComercial()));
            $entidad->setEntRepNombre(strtoupper($entidad->getEntRepNombre()));
            $entidad->setEntDireccionMatriz(strtoupper($entidad->getEntDireccionMatriz()));
            $entidad->setEntUsosAlcohol(strtoupper($entidad->getEntUsosAlcohol()));
            $entidad->setEntComentario(strtoupper($entidad->getEntComentario()));
            
            //Eliminar cuotas de importación y compras locales
            if(!$entidad->getEntImportador() || !$entidad->getEntComprador()){

                //Se realiza una busqueda de todas las cuotas que no cumplen con el nuevo perfil (Importador, Productor, Comprador Local)
                //Luego se dejan eliminadas logicamente en la BD
                foreach( $entidad->getCuotas() as $cuota){
                    if(($cuota->getCuoTipo()=='I' && !$entidad->getEntImportador() || 
                       $cuota->getCuoTipo()=='L' && !$entidad->getEntComprador()) && $cuota->getAuditDeleted()==false
                    ){
                        $cuota->setAuditDeleted(true);
                        $cuota->setAuditUserUpd($user->getUsername());
                        $cuota->setAuditDateUpd(new \DateTime());
                    }

                }
            }

            //Se verifican todos los usuarios asociados a la Entidad/Empresa para que se actualicen los roles 
            //de acuerdo a las actividades de la empresa y la de cada uno de los usuarios
            $i=0;
            $usuarios = array();
            foreach( $entidad->getUsers() as $usuario){
                $rolDao = new RolDao($this->getDoctrine());

                $usuario->setRols($rolDao->getRolesEspecificos(
                        $entidad->getEntImportador(),
                        $entidad->getEntProductor(),
                        $entidad->getEntComprador(),
                        $entidad->getEntCompVend(),
                        $usuario->getUserTipo(),
                        $usuario->getUserInterno(),
                        $usuario->getUserInternoTipo()
                ));

                $usuarios[$i] = $usuario;
                $i+=1;
            }
            $entidad->setUsers($usuarios);

            $entidadDao->editEntidad($entidad);
            
            if( $entidadTmp->getEntId()){
                $this->get('session')->setFlash('notice', 'Los datos se han guardado con éxito!!!');
            
                return $this->redirect(
                    $this->generateUrl('MinSalSCAAdminBundle_mantCargarEntidad', 
                            array('entId'=>$entidad->getEntId()))
                    );
            }else{
                $this->get('session')->setFlash('notice', 'Los datos se han guardado con éxito!!!');
            
                $opciones = $this->getRequest()->getSession()->get('opciones');
                $formReg = $this->container->get('fos_user.registration.form');//$form = $this->createForm(new RegistrationFormType(), $usuario);
                $usuario = new User();
                
                if($entidad->getEntTipoPersona() ==='N'){
                    $usuario->setEmail($entidad->getEntEmail());
                    $usuario->setUserNit($entidad->getEntNit());
                    $usuario->setUserTelefono($entidad->getEntTel());
                    
                    $usuario->setUserPrimerNombre($entidad->getEntNombre());
                    $usuario->setUserApellidos($entidad->getEntNombre());
                    $usuario->setUserCargo('Representante');
                }else{
                    //$usuario->setEmail($entidad->getEntEmail());
                    if($entidad->getEntTipoDoc()== 'D'){
                        $usuario->setUserDui($entidad->getEntRepDoc());
                    }
                    
                    $usuario->setUserNit($entidad->getEntRepNit());
                    $usuario->setUserTelefono($entidad->getEntTel());
                    
                    $usuario->setUserPrimerNombre($entidad->getEntRepNombre());
                    $usuario->setUserApellidos($entidad->getEntRepNombre());
                    $usuario->setUserCargo('Representante');
                }
                
                $formReg->setData($usuario);
                return $this->render('MinSalSCAUsersBundle:Registration:register.html.twig', array(
                        'opciones' => $opciones, 
                        'form' => $formReg->createView(), 
                        'entId'=>$entidad->getEntId(), 
                        'entHabilitado'=>$entidad->getEntHabilitado(),
                        'autorizadoDNM' => $autorizadoDNM,
                        'autorizadoDNMText' => $autorizadoDNMText,
                        'userInterno' => 'false',
                        'entNombre' => $entidad->getEntNombre()
                    )
                );
            }
        }else{
            if($errores == null){
                $errores = '**** ERROR **** Existen errores con el formulario, por favor revise los valores ingresados';
            }
            
            $this->get('session')->setFlash('notice', $errores);
            
            $opciones = $this->getRequest()->getSession()->get('opciones');
            return $this->render('MinSalSCAAdminBundle:Entidad:showEntidad.html.twig', array(
                    'opciones' => $opciones, 
                    'form' => $form->createView(), 
                    'entId'=>$entidad->getEntId(), 
                    'entHabilitado'=>$entidad->getEntHabilitado(),
                    'autorizadoDNM' => $autorizadoDNM,
                    'autorizadoDNMText' => $autorizadoDNMText
                )
            );
        }
    }
    
    
    /*
     * Se encarga de cargar los datos de la entidad para que sean editados
     */
    public function mantCargarEntidadAction($entId) {
        $opciones = $this->getRequest()->getSession()->get('opciones');
        
        $entidadDao = new EntidadDao($this->getDoctrine());
        $listadoDNMDao = new ListadoDNMDao($this->getDoctrine());
        $entidad = $entidadDao->getEntidad($entId);
        $autorizadoDNM = null;
        $autorizadoDNMText = null;
        
        if( !$entidad ){
            $entidad = new Entidad();
        }else{
            $year = new \DateTime();
            $autorizadoDNM = $listadoDNMDao->estaAutorizado($year->format('Y')+0, $entidad->getEntNrc(), $entidad->getEntNit());
            
            if(!$autorizadoDNM){
                $autorizadoDNMText = ListadoDNMDao::$MSG_ERROR_DNM_NOAUTH;
            }
        }
        
        $form = $this->createForm(new EntidadType(), $entidad);

        return $this->render('MinSalSCAAdminBundle:Entidad:showEntidad.html.twig', 
                array('form' => $form->createView(),
                    'opciones' => $opciones,
                    'entId' => $entId,
                    'entHabilitado' => $entidad->getEntHabilitado(),
                    'autorizadoDNM' => $autorizadoDNM,
                    'autorizadoDNMText' => $autorizadoDNMText
                )
        );
    }
    
    private function validarFormulario(Entidad $entidad){
        if($entidad->getEntRegMinsal() == null || $entidad->getEntRegMinsal()==''){
            return 'ERROR: El Registro de Usuario (MINSAL) se encuentra vacío';
            
        /*}else if($entidad->getEntRegDgii() == null || $entidad->getEntRegDgii()==''){
            return 'ERROR: El Número Resolución DGII se encuentra vacío';/**/
            
        }else if($entidad->getEntTel() == null || $entidad->getEntTel()==''){
            return 'ERROR: El Teléfono se encuentra vacío';
            
        }else if($entidad->getEntGiro() == null || $entidad->getEntGiro()==''){
            return 'ERROR: El Giro o Actividad Económica se encuentra vacío';
         
        }else if($entidad->getEntEmail() == null || $entidad->getEntEmail()==''){
            return 'ERROR: El E-mail se encuentra vacío';
            
        }else if(filter_var($entidad->getEntEmail(), FILTER_VALIDATE_EMAIL) != true) {
            return 'ERROR: El E-mail ('.$entidad->getEntEmail().') es un correo invalido';
            
        }else if($entidad->getEntNombre() == null || $entidad->getEntNombre()==''){
            return 'ERROR: El Nombre propietario, Denominación o Razón Social se encuentra vacío';
        
        }else if($entidad->getEntNombComercial() == null || $entidad->getEntNombComercial()==''){
            return 'ERROR: El Nombre Comercial se encuentra vacío';
        
        }else if($entidad->getEntDireccionMatriz() == null || $entidad->getEntDireccionMatriz()==''){
            return 'ERROR: La Dirección Casa Matriz se encuentra vacío';
            
        }else if($entidad->getEntUsosAlcohol() == null || $entidad->getEntUsosAlcohol()==''){
            return 'ERROR: El Usos del Alcohol se encuentra vacío';
            
        }
        
        return "";
    }
}
?>