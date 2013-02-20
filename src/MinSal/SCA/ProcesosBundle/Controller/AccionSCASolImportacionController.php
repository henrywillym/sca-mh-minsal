<?php

/**
 * @author Henry Willy Melara
 */

namespace MinSal\SCA\ProcesosBundle\Controller;

use MinSal\SCA\AdminBundle\Entity\Cuota;
use MinSal\SCA\AdminBundle\EntityDao\CuotaDao;
use MinSal\SCA\ProcesosBundle\Entity\Flujo;
use MinSal\SCA\ProcesosBundle\Entity\SolImportacion;
use MinSal\SCA\ProcesosBundle\Entity\SolImportacionDet;
use MinSal\SCA\ProcesosBundle\EntityDao\InventarioDetDao;
use MinSal\SCA\ProcesosBundle\EntityDao\SolImportacionDao;
use MinSal\SCA\ProcesosBundle\EntityDao\SolImportacionDetDao;
use MinSal\SCA\ProcesosBundle\EntityDao\TransicionDao;
use MinSal\SCA\ProcesosBundle\Form\Type\SolImportacionDetType;
use MinSal\SCA\UsersBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
* Mantenimineto de Ingreso de Solicitudes de Importacion...
* 
*/
class AccionSCASolImportacionController extends Controller {

    /**
     * Retorna la página de ingreso de solicitud de importacion
     * pendiente El redireccionamiento Dinamico.
     * 
     * @return HTML.twig
     */
    public function mantSolImportacionIngresoAction() {
        $opciones = $this->getRequest()->getSession()->get('opciones');
        $user = $this->get('security.context')->getToken()->getUser();
        
        $solImportacionDet = new SolImportacionDet();

        $form = $this->createForm(new SolImportacionDetType($this->getDoctrine()), $solImportacionDet);
        
        if($user->getEntidad()==null){
            return $this->render('MinSalSCAProcesosBundle:Default:mantNoEntidad.html.twig', array(
                        'opciones' => $opciones
                    )
            );
        }else{
            return $this->render('MinSalSCAProcesosBundle:SolImportacionDet:ingresarSolImportacionDet.html.twig', array(
                        'form' => $form->createView(),
                        'opciones' => $opciones,
                        'entNombComercial'=> $user->getEntidad()->getEntNombComercial()
                    )
            );
        }
    }
    
    /**
     * Redirecciona a la pagina para ver las solicitudes asociadas a la empresa del usuario
     * 
     * @return html.twig
     */
    public function mantSolImportacionVerSolicitudesAction($etpEntidad =null) {
        $opciones = $this->getRequest()->getSession()->get('opciones');
        $user = new User();
        $user = $this->get('security.context')->getToken()->getUser();
        
        $paramArray = array();
        $traIdSeries = array();

        if($etpEntidad == null){
            $paramArray['urlJSON'] = $this->generateUrl('MinSalSCAProcesosBundle_verSolImportacionesJSON');
        }else{
            $paramArray['urlJSON'] = $this->generateUrl('MinSalSCAProcesosBundle_consultarSolImportacionDetJSON', 
                array('etpId' => 'etpId')//Se coloca el mismo nombre para que con javascript se pueda substituir dinamicamente el parametro
            );
        }
        $paramArray['traIdSeries'] = $traIdSeries;
        $paramArray['opciones']= $opciones;
        
        if($user->getEntidad()!=null){
            $paramArray['entNombComercial']= $user->getEntidad()->getEntNombComercial();
        }else{
            $paramArray['entNombComercial']= null;
        }

        return $this->render('MinSalSCAProcesosBundle:SolImportacionDet:verSolImportaciones.html.twig', $paramArray);
    }
    
    

    /**
     * Devuelve el listado principal de registros del mantenimiento
     * @return Response
     */
    public function consultarSolImportacionJSONAction($etpId) {
        $user = $this->get('security.context')->getToken()->getUser();
        $solImportacionDetDao = new SolImportacionDetDao($this->getDoctrine());
        
        if($user->getEntidad() != null){
            $registros = $solImportacionDetDao->getSolImportacionesDetByEtapa($etpId, $user->getEntidad()->getEntId());
        }else{
            $registros = $solImportacionDetDao->getSolImportacionesDetByEtapa($etpId);
        }

        $numfilas = count($registros);
        
        if ($numfilas != 0) {
            //array_multisort($registros, SORT_ASC);
            
        } else {
            //$rows[0]['id'] = 0;
            //$rows[0]['cell'] = array(' ', ' ',' ', ' ', ' ', ' ', ' ', ' ');
        }

        $datos = json_encode($registros);
        $pages = floor($numfilas / 10) + 1;

        $jsonresponse = '{
               "page":"1",
               "total":"' . $pages . '",
               "records":"' . $numfilas . '", 
               "rows":' . $datos . '}';

        $response = new Response($jsonresponse);
        return $response;
    }
    
    /**
     * Devuelve el listado de solicitudes asociadas a la empresa del usuario
     * 
     * @return Response
     */
    public function verSolImportacionesJSONAction() {
        $user = $this->get('security.context')->getToken()->getUser();
        
        $solImportacionDetDao = new SolImportacionDetDao($this->getDoctrine());
        $registros = $solImportacionDetDao->getSolImportacionesDetByEntidad($user->getEntidad()->getEntId());

        $numfilas = count($registros);
        
        $datos = json_encode($registros);
        $pages = floor($numfilas / 10) + 1;

        $jsonresponse = '{
               "page":"1",
               "total":"' . $pages . '",
               "records":"' . $numfilas . '", 
               "rows":' . $datos . '}';

        $response = new Response($jsonresponse);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
    
    /**
     * Devuelve el listado de cuotas asignadas a la entidad
     * @return Response
     */
    public function getCuotasAction(Request $request) {
        $user = $this->get('security.context')->getToken()->getUser();
        $entId = 0;
        $year = new \DateTime();
        $impDetId = $request->get('impDetId');
        
        $cuotaDao = new CuotaDao($this->getDoctrine());
        $inventarioDetDao = new InventarioDetDao($this->getDoctrine());
        $solImportacionDao = new SolImportacionDao($this->getDoctrine());
        $solImportacionDet = $solImportacionDao->getSolImportacionDet($impDetId);
        
        $verSolicitud =   $impDetId != '0';
        
        if($verSolicitud){
            $entId = $solImportacionDet->getSolImportacion()->getEntidad()->getEntId();
        }else{
            $entId = $user->getEntidad()->getEntId();
        }
        
        $registros = $cuotaDao->getCuotas($entId, Cuota::$cuoTipoImportacion, $year->format('Y'));

        $numfilas = count($registros);
        
        $htmlResponse = '';
        if ($numfilas != 0) {
            $i = 0;
            $selected ='';
            
            foreach($registros as $reg){
                $litrosInventario = $inventarioDetDao->getLitrosInventarioXCuota($entId, $reg['cuoId']);
                $litrosSolicitudesPendientes = $solImportacionDao->getLitrosSolicitudXCuota($entId, $reg['cuoId']);
                
                $disponible = $reg['cuoLitros'] - $litrosInventario - $litrosSolicitudesPendientes;
                
                if($disponible > 0 || $verSolicitud){
                    if($i ==0){
                        $selected = 'selected';
                    }else{
                        $selected = '';
                    }
                    
                    $htmlResponse = $htmlResponse. "<option value=" . $reg['cuoId'] . " grado=" . $reg['cuoGrado'] . " disponible=" . $disponible . ">" . $reg['cuoNombreEsp'] . "</option>";
                    $i++;
                }
            }
            
            if($i == 0){
                $htmlResponse = $htmlResponse.'<option value="">No Existen cuotas asociadas</option>';
            }
        } else {
            $htmlResponse = $htmlResponse.'<option value="">No Existen cuotas asociadas</option>';
        }
        
        //$htmlResponse = $htmlResponse.'</select>';
        
        $response = new Response($htmlResponse);
        return $response;
    }
    
    public function getTransicionesAction(Request $request) {
        $user = $this->get('security.context')->getToken()->getUser();
        $solImportacionDao = new SolImportacionDao($this->getDoctrine());
        
        $roles = $user->getRols();
        $traIdSeries = array();
        $registros= array();
        $tmpIndex = array();
        
        foreach($roles as $rol){
            $transiciones = $rol->getTransiciones();

            foreach($transiciones as $reg){
                if(!array_key_exists($reg->getEtpFin()->getEtpId(), $tmpIndex)){
                    $tmp['id'] = $reg->getEtpFin()->getEtpId();
                    $tmp['nombre'] = $reg->getEtpFin()->getEtpNombre();
                    $tmp['cantidad'] = $solImportacionDao->getCantidadSolicitudesXEtapa($reg->getEtpFin()->getEtpId());
                    $tmpIndex[$reg->getEtpFin()->getEtpId()] = true;

                    $traIdSeries[] = $tmp;
                }
            }
        }
        
        $registros['registros'] = $traIdSeries;
        
        $datos = json_encode($registros);
        
        $response = new Response($datos);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
    
    public function getSearchEstadosAction(Request $request) {
        $user = $this->get('security.context')->getToken()->getUser();
        $entId = $user->getEntidad()->getEntId();
        
        $solImportacionDao = new SolImportacionDao($this->getDoctrine());
        
        $registros = $solImportacionDao->getSearchEstados($entId);

        $numfilas = count($registros);
        
        $htmlResponse = '<select>';
        if ($numfilas != 0) {
            $i = 0;
            foreach($registros as $reg){
                if($i == 0){
                    $htmlResponse = $htmlResponse. "<option value='' >Seleccione</option>";
                }
                $htmlResponse = $htmlResponse. "<option value='" . $reg['estNombre'] . "' >" . $reg['estNombre'] . "</option>";
                $i++;
            }
            
            if($i == 0){
                $htmlResponse = $htmlResponse.'<option value="">No existen registros</option>';
            }
        } else {
            $htmlResponse = $htmlResponse.'<option value="">No existen registros</option>';
        }
        
        $htmlResponse = $htmlResponse.'</select>';
        
        $response = new Response($htmlResponse);
        return $response;
    }
    
    public function getSearchEtapasAction(Request $request) {
        $user = $this->get('security.context')->getToken()->getUser();
        $entId = $user->getEntidad()->getEntId();
        
        $solImportacionDao = new SolImportacionDao($this->getDoctrine());
        
        $registros = $solImportacionDao->getSearchEtapas($entId);

        $numfilas = count($registros);
        
        $htmlResponse = '<select>';
        if ($numfilas != 0) {
            $i = 0;
            foreach($registros as $reg){
                if($i == 0){
                    $htmlResponse = $htmlResponse. "<option value='' >Seleccione</option>";
                }
                $htmlResponse = $htmlResponse. "<option value='" . $reg['etpNombre'] . "' >" . $reg['etpNombre'] . "</option>";
                $i++;
            }
            
            if($i == 0){
                $htmlResponse = $htmlResponse.'<option value="">No existen registros</option>';
            }
        } else {
            $htmlResponse = $htmlResponse.'<option value="">No existen registros</option>';
        }
        
        $htmlResponse = $htmlResponse.'</select>';
        
        $response = new Response($htmlResponse);
        return $response;
    }

    /*
     * Se encarga de ejecutar las acciones de ingresar las solicitudes de importacion
     * del mantenimiento
     * pendiente TODA LA FUNCION
     */
    public function mantSolImportacionEdicionAction(Request $request) {
        $solImportacionDetTmp = new SolImportacionDet();
        $solImportacionDet = new SolImportacionDet();
        $user = $this->get('security.context')->getToken()->getUser();
        
        $form = $this->createForm(new SolImportacionDetType($this->getDoctrine()), $solImportacionDetTmp);
        $form->bindRequest($request);
        
        $cuotaDao = new CuotaDao($this->getDoctrine());
        //$solImportacionDetTmp->setCuota($cuotaDao->getCuota($request->get('cuota'))) ;
        
        $solImportacionDao = new SolImportacionDao($this->getDoctrine());
        $solImportacionDetDao = new SolImportacionDetDao($this->getDoctrine());
        $transicionDao = new TransicionDao($this->getDoctrine());
        
        $errores = $solImportacionDetTmp->isValid();
        
        if(($form->isValid() && count($errores)==0)){
            if( $solImportacionDetTmp->getImpDetId() ){
                $solImportacionDet = $solImportacionDao->getSolImportacionDet($solImportacionDetTmp->getImpDetId());

                //#### Auditoría 
                //$solImportacionDet->setAuditUserUpd($user->getUsername());
                //$solImportacionDet->setAuditDateUpd(new \DateTime());
            }else{
                //#### Encabezado de Solicitud
                $solImportacion = new SolImportacion();
                $solImportacionDet->setSolImportacion($solImportacion);
                $solImportacionDet->getSolImportacion()->setEntidad($user->getEntidad());
                $solImportacionDet->getSolImportacion()->setTransicion($transicionDao->getTransicionInicial(Flujo::$IMPORTACION));
                $solImportacionDet->getSolImportacion()->setSolImpFecha(new \DateTime());
                $solImportacionDet->getSolImportacion()->setAuditUserIns($user->getUsername());
                $solImportacionDet->getSolImportacion()->setAuditDateIns(new \DateTime());
                
                $solImportacionDao->addSolImportacion($solImportacion);
            
                //## Detalle de solicitud
                //$solImportacionDet->getSolImportacion()->addSolImportacionDet($solImportacionDet);
                $solImportacion->addSolImportacionDet($solImportacionDet);
                $solImportacionDet->setCuota($cuotaDao->getCuota($request->get('cuota')));
                
                //#### Auditoría 
                //$solImportacionDet->setAuditUserIns($user->getUsername());
                //$solImportacionDet->setAuditDateIns(new \DateTime());
            }
            //##################################################################################################
            $form = $this->createForm(new SolImportacionDetType($this->getDoctrine()), $solImportacionDet);
            $form->bindRequest($request);
            
            $solImportacionDetDao->addSolImportacionDet($solImportacionDet);
            $this->get('session')->setFlash('notice', 'Los datos se han guardado con éxito!!!');
            
            return $this->redirect($this->generateUrl('MinSalSCAProcesosBundle_mantSolImportacionIngreso'));
        }else{
            $listaErrores = '';
            
            foreach($errores as $error){
                $listaErrores = $listaErrores.$error;
            }
            
            if($listaErrores != ''){
                $this->get('session')->setFlash('notice', $listaErrores);
            }else{
                $this->get('session')->setFlash('notice', '**** ERROR **** Existen errores con el formulario, por favor revise los valores ingresados');
            }
            
            $opciones = $this->getRequest()->getSession()->get('opciones');
            return $this->render('MinSalSCAProcesosBundle:SolImportacionDet:ingresarSolImportacionDet.html.twig', array(
                    'opciones' => $opciones, 
                    'form' => $form->createView(), 
                    'impDetId'=>$solImportacionDet->getImpDetId(),
                    'entNombComercial'=> $user->getEntidad()->getEntNombComercial()
                )
            );
        }
    }
    
    
    /*
     * Se encarga de cargar los datos de la SolImportacionDet para que sean editados
     * 
     * pendiente revisar a que pagina se redirecciona
     */
    public function mantCargarSolImportacionAction($impDetId) {
        $opciones = $this->getRequest()->getSession()->get('opciones');
        $user = $this->get('security.context')->getToken()->getUser();
        $result = array();
        
        $solImportacionDao = new SolImportacionDao($this->getDoctrine());
        $solImportacionDet = $solImportacionDao->getSolImportacionDet($impDetId);
        $entNombComercial = $solImportacionDet->getSolImportacion()->getEntidad()->getEntNombComercial();
        
        if( !$solImportacionDet ){
            $solImportacionDet = new SolImportacionDet();
        }else{
            $transicionDao = new TransicionDao($this->getDoctrine());
            $nextTransiciones = $transicionDao->getTransicionesSiguientes($solImportacionDet->getSolImportacion()->getTransicion()->getTraId());
            $roles = $user->getRols();
            
            //Validacion para asegurarse que el usuario que esta visualizando la solicitud tiene autorizacion para evaluarla y pasarla a la siguiente etapa
            foreach($roles as $rol){
                $transicionesRol = $rol->getTransiciones();

                foreach($transicionesRol as $regTra){
                    if($regTra->getTraId() == $solImportacionDet->getSolImportacion()->getTransicion()->getTraId()){
                        if(count($result)==0){
                            foreach($nextTransiciones as $reg){
                                $arrayTrans = array();

                                $arrayTrans['id'] = $reg->getTraId();
                                $arrayTrans['nombre'] = $reg->getEstado()->getEstNombre();
                                $arrayTrans['comentario'] = $reg->getTraComentario()?"true":"false";
                                $arrayTrans['litrosLibera'] = $reg->getTraLitrosLibera()?"true":"false";

                                $result[] = $arrayTrans;
                            }
                        }
                    }
                }
            }
        }
        
        $form = $this->createForm(new SolImportacionDetType($this->getDoctrine()), $solImportacionDet);
        $comentario = $solImportacionDet->getSolImportacion()->getSolImpComentario();
        
        return $this->render('MinSalSCAProcesosBundle:SolImportacionDet:ingresarSolImportacionDet.html.twig', array(
            'form' => $form->createView(),
            'opciones' => $opciones,
            'impDetId' => $impDetId,
            'entNombComercial'=> $entNombComercial, 
            'transiciones' => $result,
            'comentario' => $comentario
        ));
    }
    
    /**
     * Actualiza el estado/transicion de la solicitud de importacion
     * 
     * pendiente revisar a que pagina se redirecciona de forma dinamica
     * pendiente extraer la nueva transicion a la que se actualizara la solicitud
     * pendiente validar si la solicitud no ha sido previamente cambiada de estado y se quiere volver a cambiar. (submit + back + submit again)
     * 
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function cambiarEstadoAction(Request $request, $impDetId, $traId){
        $auditUser = $this->container->get('security.context')->getToken()->getUser();
        $errorList = '';
        
        $solImportacionDao = new SolImportacionDao($this->getDoctrine());
        $solImportacionDetDao = new SolImportacionDetDao($this->getDoctrine());
        $transicionDao = new TransicionDao($this->getDoctrine());
        
        //Buscamos el encabezado para realizar la transicion
        $solImportacionDet = new SolImportacionDet();
        $solImportacionDet = $solImportacionDao->getSolImportacionDet($impDetId);
        
        $roles = $auditUser->getRols();
        $transiciones = $transicionDao->getTransicionesSiguientes($solImportacionDet->getSolImportacion()->getTransicion()->getTraId());
        
        //Validacion para asegurarse que el usuario que esta visualizando la solicitud tiene autorizacion para evaluarla y pasarla a la siguiente etapa
        foreach($roles as $rol){
            $transicionesRol = $rol->getTransiciones();

            foreach($transicionesRol as $regTra){
                if($regTra->getTraId() == $solImportacionDet->getSolImportacion()->getTransicion()->getTraId()){
                    
                    foreach($transiciones as $reg){
                        if($traId == $reg->getTraId()){
                            if($reg->getTraComentario()){
                                $solImpComentario = $request->get('solImpComentario');
                                if($solImpComentario==null || $solImpComentario==''){
                                    $errorList = $errorList.'- Es necesario detallar un comentario para pasar a la siguiente etapa';
                                }else{
                                    $solImportacionDet->getSolImportacion()->setSolImpComentario();
                                }
                            }
                            
                            if($reg->getTraLitrosLibera()){
                                $impDetLitrosLib = $solImportacionDet->getImpDetLitrosLib();
                                $impDetLitros = $solImportacionDet->getImpDetLitros();
                                $litrosLib = $request->get('impDetLitrosLib');
                                
                                try{
                                    $litrosLib = (float) $litrosLib;
                                    $impDetLitrosLib = (float) $impDetLitrosLib;
                                    $impDetLitros = (float) $impDetLitros;
                                    
                                    if($litrosLib ==null || $litrosLib ==''){
                                        $errorList = $errorList.'- Debe ingresar los litros a liberar';
                                    }else if($impDetLitros - $impDetLitrosLib - $litrosLib <= 0){
                                        $errorList = $errorList.'- La cantidad de litros liberados debe ser menor a la cantidad pendiente por liberar '.($impDetLitros - $impDetLitrosLib);
                                    }else if($litrosLib <=0){
                                        $errorList = $errorList.'- Debe ingresar una cantidad mayor a 0';
                                    }else{
                                        $solImportacionDet->setImpDetLitrosLib($impDetLitrosLib + $litrosLib);
                                    }
                                }  catch (Exception $e){
                                    $errorList = $errorList.'- Debe ingresar un número valido';
                                }
                                
                            }
                            
                            if($errorList == ''){
                                $solImportacionDet->getSolImportacion()->setTransicion($reg);

                                $solImportacionDet->getSolImportacion()->setAuditUserUpd($auditUser->getUsername());
                                $solImportacionDet->getSolImportacion()->setAuditDateUpd(new \DateTime());

                                $solImportacionDetDao->editSolImportacionDet($solImportacionDet);

                                $this->get('session')->setFlash('notice', '#### El registro paso a etapa "'. $reg->getEtpFin()->getEtpNombre() .'" con estado "'.$reg->getEstado()->getEstNombre().'" ####');
                                return $this->redirect($this->generateUrl('MinSalSCAProcesosBundle_mantSolImportacionVerSolicitudesMINSAL'));
                            }
                        }
                    }
                }
            }
        }
        
        if($errorList == ''){
            $this->get('session')->setFlash('notice', '#### AUDITORIA: Su usuario no tiene permisos para cambiar el estado en esta etapa "'.$solImportacionDet->getSolImportacion()->getTransicion()->getEtpFin()->getEtpNombre().'" ####');
        }else{
            $this->get('session')->setFlash('notice', $errorList);
        }
        return $this->redirect($this->generateUrl('MinSalSCAProcesosBundle_mantCargarSolImportacion', 
                    array('impDetId' => $impDetId)
                )
        );
    }
}
?>