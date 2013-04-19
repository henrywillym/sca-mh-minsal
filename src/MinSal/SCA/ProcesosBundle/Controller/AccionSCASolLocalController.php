<?php


namespace MinSal\SCA\ProcesosBundle\Controller;

use MinSal\SCA\AdminBundle\Entity\Cuota;
use MinSal\SCA\AdminBundle\EntityDao\AlcoholDao;
use MinSal\SCA\AdminBundle\EntityDao\CuotaDao;
use MinSal\SCA\AdminBundle\EntityDao\EntidadDao;
use MinSal\SCA\AdminBundle\EntityDao\ListadoDNMDao;
use MinSal\SCA\ProcesosBundle\Entity\Estado;
use MinSal\SCA\ProcesosBundle\Entity\Etapa;
use MinSal\SCA\ProcesosBundle\Entity\Flujo;
use MinSal\SCA\ProcesosBundle\Entity\Inventario;
use MinSal\SCA\ProcesosBundle\Entity\InventarioDet;
use MinSal\SCA\ProcesosBundle\Entity\SolLocal;
use MinSal\SCA\ProcesosBundle\Entity\SolLocalDet;
use MinSal\SCA\ProcesosBundle\Entity\Transicion;
use MinSal\SCA\ProcesosBundle\EntityDao\InventarioDao;
use MinSal\SCA\ProcesosBundle\EntityDao\InventarioDetDao;
use MinSal\SCA\ProcesosBundle\EntityDao\SolLocalDao;
use MinSal\SCA\ProcesosBundle\EntityDao\SolLocalDetDao;
use MinSal\SCA\ProcesosBundle\EntityDao\TransicionDao;
use MinSal\SCA\ProcesosBundle\Form\Type\SolLocalDetType;
use MinSal\SCA\UsersBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
* Mantenimineto de Ingreso de Solicitudes Locales
* @author Henry Willy Melara
*/

class AccionSCASolLocalController extends Controller {

    /**
     * Retorna la página de ingreso de solicitud de local
     * pendiente El redireccionamiento Dinamico.
     * 
     * @return HTML.twig
     */
    public function mantSolLocalIngresoAction() {
        $opciones = $this->getRequest()->getSession()->get('opciones');
        $user = $this->get('security.context')->getToken()->getUser();
        
        $solLocalDet = new SolLocalDet();

        $form = $this->createForm(new SolLocalDetType($this->getDoctrine()), $solLocalDet);
        
        if($user->getEntidad()==null){
            return $this->render('MinSalSCAProcesosBundle:Default:mantNoEntidad.html.twig', array(
                        'opciones' => $opciones
                    )
            );
        }else{
            $entidad = $user->getEntidad();
            
            $year = new \DateTime();
            $listadoDNMDao = new ListadoDNMDao($this->getDoctrine());
            
            $autorizadoDNM = $listadoDNMDao->estaAutorizado($year->format('Y')+0, $entidad->getEntNrc(), $entidad->getEntNit());
            $autorizadoDNMText = null;
            if(!$autorizadoDNM){
                $autorizadoDNMText = ListadoDNMDao::$MSG_ERROR_DNM_NOAUTH;
            }
            
            if( !$entidad->getEntHabilitado()){
                $this->get('session')->setFlash('notice', EntidadDao::$NO_HABILITADA. ' debido a: '. $entidad->getEntComentario());
            }
            
            return $this->render('MinSalSCAProcesosBundle:SolLocalDet:ingresarSolLocalDet.html.twig', array(
                        'form' => $form->createView(),
                        'opciones' => $opciones,
                        'entNombComercial'=> $user->getEntidad()->getEntNombComercial(),
                        'comentario' => null,
                        'transiciones' => null,
                        'invId' => null,
                        'autorizadoDNM' => $autorizadoDNM,
                        'autorizadoDNMText' => $autorizadoDNMText,
                        'entHabilitado' => $entidad->getEntHabilitado(),
                        'autorizadoDNMProv' => true,
                        'autorizadoDNMProvText' => null
                    )
            );
        }
    }
    
    /**
     * Redirecciona a la pagina para ver las solicitudes asociadas a la empresa del usuario o para evaluar solicitudes de acuerdo a su rol
     * 
     * @return html.twig
     */
    public function mantSolLocalVerSolicitudesAction() {
        $opciones = $this->getRequest()->getSession()->get('opciones');
        $user = $this->get('security.context')->getToken()->getUser();
        $roles = $user->getRols();
        $tieneEtapas = false;
        
        foreach($roles as $rol){
            $transiciones = $rol->getTransiciones();
            
            if(count($transiciones)>0){
                $tieneEtapas = true;
                break;
            }
        }
        
        $paramArray = array();
        
        if($tieneEtapas == true){
            $paramArray['urlJSONSolXEtapas'] = $this->generateUrl('MinSalSCAProcesosBundle_consultarSolLocalDetJSON', 
                array('etpId' => 'etpId')//Se coloca el mismo nombre para que con javascript se pueda substituir dinamicamente el parametro
            );
        }
        
        $paramArray['opciones']= $opciones;
        
        if($user->getEntidad()!=null){
            $paramArray['entNombComercial']= $user->getEntidad()->getEntNombComercial();
            $paramArray['urlJSONSolXEntidad'] = $this->generateUrl('MinSalSCAProcesosBundle_verSolLocalesJSON');
        }else{
            $paramArray['entNombComercial']= null;
            $paramArray['urlJSONSolXEntidad'] = null;
        }

        return $this->render('MinSalSCAProcesosBundle:SolLocalDet:verSolLocales.html.twig', $paramArray);
    }
    
    

    /**
     * Devuelve el listado solicitudes que se encuentran en una etapa especifica
     * @return Response
     */
    public function consultarSolLocalJSONAction($etpId) {
        $user = $this->get('security.context')->getToken()->getUser();
        $solLocalDetDao = new SolLocalDetDao($this->getDoctrine());
        
        if($user->getEntidad() != null){
            $comprador = false;
            $vendedor = false;
            foreach($user->getRols() as $rolTmp){
                if($rolTmp->getRolTipo() == User::$COMPRADOR){
                    $comprador = true;
                }else if($rolTmp->getRolTipo() == User::$VENDEDOR){
                    $vendedor = true;
                }
            }
            
            $registros = $solLocalDetDao->getSolLocalesDetByEtapa($etpId, $user->getEntidad()->getEntId(), $comprador, $vendedor);
        }else{
            $registros = $solLocalDetDao->getSolLocalesDetByEtapa($etpId);
        }

        $numfilas = count($registros);
        
        if ($numfilas != 0) {
            $solLocal = new SolLocal();
            $solLocalDet = new SolLocalDet();
            $i = 0;
            
            foreach ($registros as $ent) {
                $solLocal->setSolLocalFecha($ent['solLocalFecha']);
                $solLocal->setAuditDateIns($ent['auditDateIns']);
                
                if($ent['entHabilitado'] == false || $ent['HAB'] == 0){
                    $registros[$i]['estNombre']= SolLocal::$BLOQUEADA;
                }
                
                $registros[$i]['solLocalFechaText']= $solLocal->getSolLocalFechaText();
                $registros[$i]['auditDateInsText']= $solLocal->getAuditDateInsText();
                //$registros[$i]['localDetProvNom']= $solLocal->get();
                $i=$i+1;
            }
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
    public function verSolLocalesJSONAction() {
        $user = $this->get('security.context')->getToken()->getUser();
        
        $solLocalDetDao = new SolLocalDetDao($this->getDoctrine());
        $registros = array();
        
        if($user->getEntidad() != null){
            $registros = $solLocalDetDao->getSolLocalesDetByEntidad($user->getEntidad()->getEntId());
        }
        $numfilas = count($registros);
        
        if ($numfilas != 0) {
            $solLocal = new SolLocal();
            $i = 0;
            
            foreach ($registros as $ent) {
                $solLocal->setSolLocalFecha($ent['solLocalFecha']);
                $solLocal->setAuditDateIns($ent['auditDateIns']);
                
                if($ent['entHabilitado'] == false || $ent['HAB'] == 0){
                    $registros[$i]['estNombre']= SolLocal::$BLOQUEADA;
                }
                
                $registros[$i]['solLocalFechaText']= $solLocal->getSolLocalFechaText();
                $registros[$i]['auditDateInsText']= $solLocal->getAuditDateInsText();
                $i=$i+1;
            }
        }
        
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
        $localDetId = $request->get('localDetId');
        
        $cuotaDao = new CuotaDao($this->getDoctrine());
        //$inventarioDetDao = new InventarioDetDao($this->getDoctrine());
        $solLocalDao = new SolLocalDao($this->getDoctrine());
        $solLocalDetDao = new SolLocalDetDao($this->getDoctrine());
        $solLocalDet = $solLocalDao->getSolLocalDet($localDetId);
        
        $verSolicitud =   $localDetId != '0';
        
        if($verSolicitud){
            $entId = $solLocalDet->getSolLocal()->getEntidad()->getEntId();
        }else{
            $entId = $user->getEntidad()->getEntId();
        }
        
        $registros = $cuotaDao->getCuotas($entId, Cuota::$cuoTipoLocal, $year->format('Y'));

        $numfilas = count($registros);
        $debug = array();
        $htmlResponse = '';
        if ($numfilas != 0) {
            $i = 0;
            $selected ='';
            
            foreach($registros as $reg){
                $litrosInventario = $solLocalDetDao->getLitrosInventarioXCuota($entId, $reg['cuoId']);
                $litrosSolicitudesPendientes = $solLocalDao->getLitrosSolicitudXCuota($entId, $reg['cuoId']);
                
                $disponible = $reg['cuoLitros'] - $litrosInventario - $litrosSolicitudesPendientes;
                
                $debug[$i]['$litrosInventario']=$litrosInventario;
                $debug[$i]['$litrosSolicitudesPendientes']=$litrosSolicitudesPendientes;
                $debug[$i]['cuoLitros']=$reg['cuoLitros'];
                
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
            //var_dump($debug);die;
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
    
    /**
     * Devuelve el listado de cuotas asignadas a la entidad
     * @return Response
     */
    public function getProveedoresAction(Request $request) {
        $user = $this->get('security.context')->getToken()->getUser();
        $entId = 0;
        $localDetId = $request->get('localDetId');
        $cuoId = $request->get('cuoId');
        
        $solLocalDetDao = new SolLocalDetDao($this->getDoctrine());
        $solLocalDao = new SolLocalDao($this->getDoctrine());
        $solLocalDet = $solLocalDao->getSolLocalDet($localDetId);
        
        $verSolicitud =   $localDetId != '0';
        
        if($verSolicitud){
            $entId = $solLocalDet->getSolLocal()->getEntidad()->getEntId();
            
            if(!empty($cuoId)){
                $registros = $solLocalDetDao->getProveedorSolicitud($localDetId, $entId, $cuoId);
            }
        }else{
            $entId = $user->getEntidad()->getEntId();
            
            if(!empty($cuoId)){
                $registros = $solLocalDetDao->getProveedores($entId, $cuoId);
            }
        }
        
        $numfilas = count($registros);
        $debug = array();
        $htmlResponse = '';
        if ($numfilas != 0) {
            $i = 0;
            $selected ='';
            
            foreach($registros as $reg){
                //$litrosInventario = $inventarioDetDao->getLitrosVendidosYReservaXInventario($reg['entId'], $reg['invId']);
                //$litrosSolicitudesPendientes = $solLocalDetDao->getLitrosSolicitudXCuotaProveedor($reg['entId'], $reg['invId']);
                
                /*if(round($reg['invLitros']+0, 2) != round($litrosSolicitudesPendientes+0,2)){
                    throw new Exception("El detalle de inventario (".round($reg['invLitros']+0, 2).")no coincide con el total de inventario invId -> ".$reg['invId']." almacenado (".round($litrosSolicitudesPendientes, 2).")");
                }*/
                $disponible = $reg['invLitros'];// - $litrosSolicitudesPendientes;
                $habilitadoDNM = $reg['HAB']>0 && $reg['entHabilitado'] ==true;
                
                //PRacticamente el productor tiene ilimitado su stock
                if($reg['entProductor']==true){
                    $disponible = 50000;
                }
                
                //$debug[$i]['$litrosInventario']=$litrosInventario;
                //$debug[$i]['$litrosSolicitudesPendientes']=$litrosSolicitudesPendientes;
                $debug[$i]['invLitros']=$reg['invLitros'];
                $debug[$i]['entId']=$reg['entId'];
                
                if(($disponible > 0 && $habilitadoDNM) || $verSolicitud){
                    if($i ==0){
                        $selected = 'selected';
                    }else{
                        $selected = '';
                    }
                    
                    $htmlResponse = $htmlResponse. "<option value=" . $reg['invId'] . " grado=" . $reg['invGrado'] . " disponible=" . round($disponible,2) . " provDireccion=\"". $reg['entDireccionMatriz'] ."\">" . $reg['invNombreEsp'] . ' ('. $reg['invGrado'] .'%) - ' . $reg['entNombComercial']. "</option>";
                    $i++;
                }
            }
            
            if($i == 0){
                $htmlResponse = $htmlResponse.'<option value="">No Existen proveedores con inventario disponible</option>';
            }
        } else {
            $htmlResponse = $htmlResponse.'<option value="">No Existen proveedores con inventario disponible</option>';
        }
        
        //$htmlResponse = $htmlResponse.'</select>';
        
        $response = new Response($htmlResponse);
        return $response;
    }
    
    public function getEtapasAction() {
        $user = $this->get('security.context')->getToken()->getUser();
        $solLocalDao = new SolLocalDao($this->getDoctrine());
        
        $roles = $user->getRols();
        $traIdSeries = array();
        $registros= array();
        $entId = 0;
        $result = array();
        
        if($user->getEntidad()){
            $entId = $user->getEntidad()->getEntId();
        }
        
        $comprador = false;
        $vendedor = false;
        foreach($roles as $rolTmp){
            if($rolTmp->getRolTipo() == User::$COMPRADOR){
                $comprador = true;
            }else if($rolTmp->getRolTipo() == User::$VENDEDOR){
                $vendedor = true;
            }
        }
        
        foreach($roles as $rol){
            $transiciones = $rol->getTransiciones();

            foreach($transiciones as $transicion){
                foreach($transicion->getParentsTransicion() as $reg){
                    if($reg->getFlujo()->getFluId() == Flujo::$LOCAL && !array_key_exists($reg->getEtpFin()->getEtpId(), $traIdSeries)){
                        $tmp['traId'] = $reg->getTraId();
                        $tmp['id'] = $reg->getEtpFin()->getEtpId();
                        $tmp['nombre'] = $reg->getEtpFin()->getEtpNombre();
                        $tmp['cantidad'] = $solLocalDao->getCantidadSolicitudesXEtapa($entId, $reg->getEtpFin()->getEtpId(), $comprador, $vendedor);
                        //$tmpIndex[$reg->getEtpFin()->getEtpId()] = true;

                        $traIdSeries[$tmp['id']] = $tmp;
                    }
                }
            }
            
            foreach($traIdSeries as $etapa){
                $result[$etapa['traId']]=$etapa;
            }
        }
        
        $registros['registros'] = $result;
        
        $datos = json_encode($registros);
        
        $response = new Response($datos);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
    
    public function getSearchEstadosAction() {
        $user = $this->get('security.context')->getToken()->getUser();
        $entId =null;
        if($user->getEntidad() != null){
            $entId = $user->getEntidad()->getEntId();
        }
        
        $solLocalDao = new SolLocalDao($this->getDoctrine());
        
        $registros = $solLocalDao->getSearchEstados($entId);

        $numfilas = count($registros);
        
        $htmlResponse = '<select>';
        if ($numfilas != 0) {
            $i = 0;
            foreach($registros as $reg){
                if($i == 0){
                    $htmlResponse = $htmlResponse. "<option value='' >Seleccione</option>";
                    $htmlResponse = $htmlResponse. "<option value='".SolLocal::$BLOQUEADA."' >".SolLocal::$BLOQUEADA."</option>";
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
    
    public function getSearchEtapasAction() {
        $user = $this->get('security.context')->getToken()->getUser();
        $entId = null;
        if($user->getEntidad() != null){
            $entId = $user->getEntidad()->getEntId();
        }
        
        $solLocalDao = new SolLocalDao($this->getDoctrine());
        
        $registros = $solLocalDao->getSearchEtapas($entId);

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
     * Se encarga de ejecutar las acciones de ingresar las solicitudes de local
     * del mantenimiento
     * pendiente TODA LA FUNCION
     */
    public function mantSolLocalEdicionAction(Request $request) {
        $solLocalDetTmp = new SolLocalDet();
        $solLocalDet = new SolLocalDet();
        $user = $this->get('security.context')->getToken()->getUser();
        
        $form = $this->createForm(new SolLocalDetType($this->getDoctrine()), $solLocalDetTmp);
        $form->bindRequest($request);
        
        $cuotaDao = new CuotaDao($this->getDoctrine());
        $solLocalDetTmp->setCuota($cuotaDao->getCuota($request->get('cuota'))) ;
        
        $solLocalDao = new SolLocalDao($this->getDoctrine());
        $solLocalDetDao = new SolLocalDetDao($this->getDoctrine());
        $transicionDao = new TransicionDao($this->getDoctrine());
        $inventarioDao = new InventarioDao($this->getDoctrine());
        
        $transicion = null;
        
        $errores = $solLocalDetTmp->isValid($this->getDoctrine(), $user->getEntidad(), $request->get('invId'));
        
        
        //Validacion DNM y Habilitado de Empresa que ingresa solicitud
        $entidad = $user->getEntidad();
            
        $year = new \DateTime();
        $listadoDNMDao = new ListadoDNMDao($this->getDoctrine());

        $autorizadoDNM = $listadoDNMDao->estaAutorizado($year->format('Y')+0, $entidad->getEntNrc(), $entidad->getEntNit());

        //###### Validacion de empresa seleccionada como proveedor
        $provEntidad = $inventarioDao->getInventario($request->get('invId'))->getEntidad();
        $autorizadoDNMProv = true;
        $autorizadoDNMProvText = '';

        if($provEntidad == null){
            $provEntidad = true;
        }else{
            $autorizadoDNMProv = $listadoDNMDao->estaAutorizado($year->format('Y')+0, $provEntidad->getEntNrc(), $provEntidad->getEntNit());
        }
        
        if($form->isValid() && count($errores)==0 && 
                $autorizadoDNM == true && $entidad->getEntHabilitado() == true &&
                $autorizadoDNMProv == true && $provEntidad->getEntHabilitado() == true
          ){
            if( $solLocalDetTmp->getLocalDetId() ){
                $solLocalDet = $solLocalDao->getSolLocalDet($solLocalDetTmp->getLocalDetId());

            }else{
                //#### Encabezado de Solicitud
                $transicion = $transicionDao->getTransicionInicial(Flujo::$LOCAL); 
                
                $solLocal = new SolLocal();
                $solLocalDet->setSolLocal($solLocal);
                $solLocalDet->getSolLocal()->setEntidad($user->getEntidad());
                $solLocalDet->getSolLocal()->setTransicion($transicion);
                $solLocalDet->getSolLocal()->setSolLocalFecha(new \DateTime());
                $solLocalDet->getSolLocal()->setAuditUserIns($user->getUsername());
                $solLocalDet->getSolLocal()->setAuditDateIns(new \DateTime());
                
                //## Detalle de solicitud
                $solLocal->addSolLocalDet($solLocalDet);
                $solLocalDet->setCuota($cuotaDao->getCuota($request->get('cuota')));
                
                $inventarioDet = $this->agregarInventarioProveedor(
                    new SolLocalDet(),
                    $request->get('invId'),
                    $solLocalDetTmp->getLocalDetLitros(),
                    $solLocalDetTmp->getCuota()->getCuoGrado(),
                    true,
                    false
                );
                
                $inventarioDet->setSolLocalDet($solLocalDet);
                $solLocalDet->addInventarioDet($inventarioDet);
            }
            //##################################################################################################
            $form = $this->createForm(new SolLocalDetType($this->getDoctrine()), $solLocalDet);
            $form->bindRequest($request);
            
            $solLocalDetDao->addSolLocalDet($solLocalDet);
            $this->generarEmailEtapaNotificacion($solLocalDet, $transicion, $inventarioDet->getInventario()->getEntidad()->getEntId());
            $this->get('session')->setFlash('notice', 'Los datos se han guardado con éxito!!!');
            
            return $this->redirect($this->generateUrl('MinSalSCAProcesosBundle_mantSolLocalIngreso'));
        }else{
            if(!$autorizadoDNMProv || !$provEntidad->getEntHabilitado()){
                $autorizadoDNMProvText = 'Problema con el Proveedor ->';

                if(!$autorizadoDNMProv){
                    $autorizadoDNMProvText = $autorizadoDNMProvText . ListadoDNMDao::$MSG_ERROR_DNM_NOAUTH;
                }

                if(!$provEntidad->getEntHabilitado()){
                    $autorizadoDNMProvText = $autorizadoDNMProvText . EntidadDao::$NO_HABILITADA;
                    $autorizadoDNMProv = false;
                }
            }
            
            $autorizadoDNMText = null;
            if(!$autorizadoDNM){
                $autorizadoDNMText = ListadoDNMDao::$MSG_ERROR_DNM_NOAUTH;
            }
            
            if( !$entidad->getEntHabilitado()){
                $this->get('session')->setFlash('notice', EntidadDao::$NO_HABILITADA. ' debido a: '. $entidad->getEntComentario());
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
            }
            
            $opciones = $this->getRequest()->getSession()->get('opciones');
            return $this->render('MinSalSCAProcesosBundle:SolLocalDet:ingresarSolLocalDet.html.twig', array(
                    'opciones' => $opciones, 
                    'form' => $form->createView(), 
                    'entNombComercial'=> $user->getEntidad()->getEntNombComercial(),
                    'comentario' => null,
                    'transiciones' => null,
                    'invId' => $request->get('invId'),
                    'autorizadoDNM' => $autorizadoDNM,
                    'autorizadoDNMText' => $autorizadoDNMText,
                    'entHabilitado' => $entidad->getEntHabilitado(),
                    'autorizadoDNMProv' => $autorizadoDNMProv,
                    'autorizadoDNMProvText' => $autorizadoDNMProvText
                )
            );
        }
    }
    
    
    /*
     * Se encarga de cargar los datos de la SolLocalDet para que sean editados
     * 
     * pendiente revisar a que pagina se redirecciona
     */
    public function mantCargarSolLocalAction($localDetId) {
        $opciones = $this->getRequest()->getSession()->get('opciones');
        $user = $this->get('security.context')->getToken()->getUser();
        $result = array();
        $tmpIndex = array();
        
        $solLocalDao = new SolLocalDao($this->getDoctrine());
        $solLocalDet = $solLocalDao->getSolLocalDet($localDetId);
        $entNombComercial = $solLocalDet->getSolLocal()->getEntidad()->getEntNombComercial();
        
        if( !$solLocalDet ){
            $solLocalDet = new SolLocalDet();
        }else{
            $transicionDao = new TransicionDao($this->getDoctrine());
            $nextTransiciones = $transicionDao->getTransicionesSiguientes($solLocalDet->getSolLocal()->getTransicion()->getTraId());
            $roles = $user->getRols();
            $inventarioProv = null;
            
            $invsDetTemp = $solLocalDet->getInventariosDet();
            foreach($invsDetTemp as $tmp){
                if( $solLocalDet->getSolLocal()->getEntidad()->getEntId() != $tmp->getInventario()->getEntidad()->getEntId()){
                    $inventarioProv = $tmp->getInventario();
                }
            }
            /*var_dump('Comprador EntId= '.$solLocalDet->getSolLocal()->getEntidad()->getEntId());
            var_dump('User EntId= '.$user->getEntidad()->getEntId());
            
            var_dump('Proveedor EntId= '.$solLocalDet->getCuota()->getEntidad()->getEntId());
            */
            //Validacion para asegurarse que el usuario que esta visualizando la solicitud tiene autorizacion para evaluarla y pasarla a la siguiente etapa
            foreach($roles as $rol){
                $transicionesRol = $rol->getTransiciones();

                foreach($transicionesRol as $transicionRol){
                    foreach($nextTransiciones as $reg){
                        if($transicionRol->getTraId() == $reg->getTraId()){
                            if($reg->getFlujo()->getFluId() == Flujo::$LOCAL && !array_key_exists($reg->getTraId(), $tmpIndex)){
                                $proseguir = false;
                                foreach($user->getRols() as $rolTmp){
                                    
                                    if(($solLocalDet->getSolLocal()->getEntidad()->getEntId() == $user->getEntidad()->getEntId() && $rolTmp->getRolTipo() == User::$COMPRADOR)
                                        ||
                                        ($inventarioProv->getEntidad()->getEntId() == $user->getEntidad()->getEntId() && $rolTmp->getRolTipo() == User::$VENDEDOR)
                                    ){
                                        $proseguir = true;
                                    }
                                }

                                
                                if($proseguir){
                                    $arrayTrans = array();

                                    $arrayTrans['id'] = $reg->getTraId();
                                    $arrayTrans['nombre'] = $reg->getEstado()->getEstNombreBoton();
                                    $arrayTrans['comentario'] = $reg->getTraComentario()?"true":"false";
                                    $arrayTrans['litrosLibera'] = $reg->getTraLitrosLibera()?"true":"false";

                                    $tmpIndex[$reg->getTraId()]=true;

                                    $result[] = $arrayTrans;
                                }
                            }
                        }
                    }
                }
            }
        }
        
        $form = $this->createForm(new SolLocalDetType($this->getDoctrine()), $solLocalDet);
        $comentario = $solLocalDet->getSolLocal()->getSolLocalComentario();
        $etapa = $solLocalDet->getSolLocal()->getTransicion()->getEtpFin()->getEtpNombre();
        $estado = $solLocalDet->getSolLocal()->getTransicion()->getEstado()->getEstNombre();
        
        $inventarioDetTmp = $solLocalDet->getInventariosDet();
        $inventarioDetTmp = $inventarioDetTmp[0];
        $provEntidad = $inventarioDetTmp->getInventario()->getEntidad();
        
        //Validacion de la empresa que ingresa la solicitud
        $entidad = $solLocalDet->getSolLocal()->getEntidad();
            
        $year = new \DateTime();
        $listadoDNMDao = new ListadoDNMDao($this->getDoctrine());
        
        $autorizadoDNM = $listadoDNMDao->estaAutorizado($year->format('Y')+0, $entidad->getEntNrc(), $entidad->getEntNit());
        $autorizadoDNMText = null;
        if(!$autorizadoDNM){
            $autorizadoDNMText = ListadoDNMDao::$MSG_ERROR_DNM_NOAUTH;
        }

        if( !$entidad->getEntHabilitado()){
            $this->get('session')->setFlash('notice', EntidadDao::$NO_HABILITADA. ' debido a: '. $entidad->getEntComentario());
        }
        
        //###### Validacion de empresa seleccionada como proveedor
        $autorizadoDNMProv = true;
        $autorizadoDNMProvText = '';

        if($provEntidad == null){
            $provEntidad = true;
        }else{
            $autorizadoDNMProv = $listadoDNMDao->estaAutorizado($year->format('Y')+0, $provEntidad->getEntNrc(), $provEntidad->getEntNit());
        }
        
        if(!$autorizadoDNMProv || !$provEntidad->getEntHabilitado()){
            $autorizadoDNMProvText = 'Problema con el Proveedor ->';

            if(!$autorizadoDNMProv){
                $autorizadoDNMProvText = $autorizadoDNMProvText . ListadoDNMDao::$MSG_ERROR_DNM_NOAUTH. '. ';
            }

            if(!$provEntidad->getEntHabilitado()){
                $autorizadoDNMProvText = $autorizadoDNMProvText . EntidadDao::$NO_HABILITADA;
                $autorizadoDNMProv = false;
            }
        }
        
        return $this->render('MinSalSCAProcesosBundle:SolLocalDet:ingresarSolLocalDet.html.twig', array(
            'form' => $form->createView(),
            'opciones' => $opciones,
            'localDetId' => $localDetId,
            'entNombComercial'=> $entNombComercial, 
            'transiciones' => $result,
            'comentario' => $comentario,
            'etapa' => $etapa,
            'estado' => $estado,
            'invId' => $inventarioDetTmp->getInventario()->getInvId(),
            'autorizadoDNM' => $autorizadoDNM,
            'autorizadoDNMText' => $autorizadoDNMText,
            'entHabilitado' => $entidad->getEntHabilitado(),
            'autorizadoDNMProv' => $autorizadoDNMProv,
            'autorizadoDNMProvText' => $autorizadoDNMProvText
        ));
    }
    
    /**
     * Actualiza el estado/transicion de la solicitud de local
     * 
     * pendiente revisar a que pagina se redirecciona de forma dinamica
     * pendiente extraer la nueva transicion a la que se actualizara la solicitud
     * pendiente validar si la solicitud no ha sido previamente cambiada de estado y se quiere volver a cambiar. (submit + back + submit again)
     * 
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param type $localDetId
     * @param type $traId
     * @return type
     */
    public function cambiarEstadoAction(Request $request, $localDetId, $traId){
        $auditUser = $this->container->get('security.context')->getToken()->getUser();
        $errorList = '';
        $proseguir = false;
        
        $solLocalDao = new SolLocalDao($this->getDoctrine());
        $solLocalDetDao = new SolLocalDetDao($this->getDoctrine());
        $transicionDao = new TransicionDao($this->getDoctrine());
        $inventarioDetDao = new InventarioDetDao($this->getDoctrine());
        
        //Buscamos el encabezado para realizar la transicion
        $solLocalDet = new SolLocalDet();
        $solLocalDet = $solLocalDao->getSolLocalDet($localDetId);
        
        $invsDetTemp = $solLocalDet->getInventariosDet();
        foreach($invsDetTemp as $tmp){
            if( $solLocalDet->getSolLocal()->getEntidad()->getEntId() != $tmp->getInventario()->getEntidad()->getEntId()){
                $inventarioProv = $tmp->getInventario();
            }
        }
        
        $roles = $auditUser->getRols();
        $nextTransiciones = $transicionDao->getTransicionesSiguientes($solLocalDet->getSolLocal()->getTransicion()->getTraId());
        
        //Validacion para asegurarse que el usuario que esta visualizando la solicitud tiene autorizacion para evaluarla y pasarla a la siguiente etapa
        foreach($roles as $rol){
            $transicionesRol = $rol->getTransiciones();

            foreach($transicionesRol as $transicionRol){
                foreach($nextTransiciones as $reg){
                    if($reg->getFlujo()->getFluId() == Flujo::$LOCAL && $transicionRol->getTraId() == $reg->getTraId() && $traId == $reg->getTraId()){
                        
                        //Validacion de empresa que ingresa la solicitud
                        $entidad = $solLocalDet->getSolLocal()->getEntidad();
                        $year = new \DateTime();
                        $listadoDNMDao = new ListadoDNMDao($this->getDoctrine());
                        
                        $autorizadoDNM = $listadoDNMDao->estaAutorizado($year->format('Y')+0, $entidad->getEntNrc(), $entidad->getEntNit());
                        
                        //Validacion de la empresa seleccionada como proveedor
                        $autorizadoDNMProv = true;

                        $inventarioDetTmp = $solLocalDet->getInventariosDet();
                        $inventarioDetTmp = $inventarioDetTmp[0];
                        $provEntidad = $inventarioDetTmp->getInventario()->getEntidad();

                        if($provEntidad == null){
                            $provEntidad = true;
                        }else{
                            $autorizadoDNM = $listadoDNMDao->estaAutorizado($year->format('Y')+0, $provEntidad->getEntNrc(), $provEntidad->getEntNit());
                            $provEntidad = $autorizadoDNM && $provEntidad->getEntHabilitado();
                        }
                        
                        if( $autorizadoDNM == true && $entidad->getEntHabilitado() == true && $provEntidad == true){
                            
                            if(($solLocalDet->getSolLocal()->getEntidad()->getEntId() == $auditUser->getEntidad()->getEntId() && $rol->getRolTipo() == User::$COMPRADOR)
                                ||
                                ($inventarioProv->getEntidad()->getEntId() == $auditUser->getEntidad()->getEntId() && $rol->getRolTipo() == User::$VENDEDOR)
                            ){
                                $proseguir = true;
                            }
                            
                            if($proseguir == false){
                                $errorList = $errorList.'#### AUDITORIA: Su usuario no tiene permisos para cambiar el estado de esta solicitud ####';
                            }else{
                                if($reg->getTraComentario()){
                                    $solLocalComentario = $request->get('solLocalComentario');
                                    if($solLocalComentario==null || $solLocalComentario==''){
                                        $errorList = $errorList.'- Es necesario detallar un comentario para pasar a la siguiente etapa';
                                    }else{
                                        $solLocalDet->getSolLocal()->setSolLocalComentario($solLocalComentario);
                                    }
                                }

                                if($reg->getTraLitrosLibera() || $reg->getTraLiberaTotal()){
                                    $localDetLitrosLib = $solLocalDet->getLocalDetLitrosLib();
                                    $localDetLitros = $solLocalDet->getLocalDetLitros();
                                    $litrosLib = $request->get('localDetLitrosLib');

                                    if($reg->getTraLiberaTotal()){
                                        $solLocalDet->setLocalDetLitrosLib($localDetLitros);
                                        $inventarioDet = $this->agregarInventario($solLocalDet->getCuota(), $localDetLitros - $localDetLitrosLib);

                                        $inventarioDet->setSolLocalDet($solLocalDet);
                                        $solLocalDet->addInventarioDet($inventarioDet);

                                        $inventarioDetProv = $this->agregarInventarioProveedor(
                                            $solLocalDet,
                                            $inventarioProv->getInvId(),
                                            $localDetLitros - $localDetLitrosLib ,
                                            $solLocalDet->getCuota()->getCuoGrado(),
                                            false,
                                            false
                                        );
                                        $inventarioDetProv->setSolLocalDet($solLocalDet);
                                        $inventarioDetProv->getSolLocalDet()->addInventarioDet($inventarioDet);

                                    }else if($reg->getTraLitrosLibera()){

                                        try{
                                            $litrosLib = (float) $litrosLib;
                                            $localDetLitrosLib = (float) $localDetLitrosLib;
                                            $localDetLitros = (float) $localDetLitros;

                                            if($litrosLib ==null || $litrosLib ==''){
                                                $errorList = $errorList.'- Debe ingresar los litros a liberar';
                                            }else if($localDetLitros - $localDetLitrosLib - $litrosLib <= 0){
                                                $errorList = $errorList.'- La cantidad de litros liberados debe ser menor a la cantidad pendiente por liberar '.($localDetLitros - $localDetLitrosLib);
                                            }else if($litrosLib <=0){
                                                $errorList = $errorList.'- Debe ingresar una cantidad mayor a 0';
                                            }else{
                                                $solLocalDet->setLocalDetLitrosLib($localDetLitrosLib + $litrosLib);

                                                $inventarioDet = $this->agregarInventario($solLocalDet->getCuota(), $litrosLib);

                                                $inventarioDet->setSolLocalDet($solLocalDet);
                                                $solLocalDet->addInventarioDet($inventarioDet);

                                                $inventarioDetProv = $this->agregarInventarioProveedor(
                                                    $solLocalDet,
                                                    $inventarioProv->getInvId(),
                                                    $litrosLib,
                                                    $solLocalDet->getCuota()->getCuoGrado(),
                                                    false,
                                                    true
                                                );
                                                $inventarioDetProv->setSolLocalDet($solLocalDet);
                                                $inventarioDetProv->getSolLocalDet()->addInventarioDet($inventarioDet);
                                            }
                                        }  catch (Exception $e){
                                            $errorList = $errorList.'- Debe ingresar un número valido';
                                        }
                                    }
                                }
                            }
                        }else{
                            $errorList = ' ';
                        }

                        if($errorList == ''){
                            if($reg->getEtpFin()->getEtpId() == Etapa::$FINALIZADA_OBS 
                                    && ($reg->getEstado()->getEstId() == Estado::$CANCELADO
                                    || $reg->getEstado()->getEstId() == Estado::$RECHAZADO)
                                ){
                                    /*NOTA: Solo se busca el registro de inventario que esten en R (reserva) para eliminarse
                                     * Los demás se asumen que si ya entraron a inventario no hay reversa 
                                     */
                                    $inventarioDetTmp = $inventarioDetDao->findInventarioDet($inventarioProv->getInvId(), $localDetId, 'R');
                                    $inventarioDetTmp = $this->eliminarInventarioDetProveedorAction($inventarioDetTmp);
                            }
                            
                            $solLocalDet->getSolLocal()->setTransicion($reg);

                            $solLocalDet->getSolLocal()->setAuditUserUpd($auditUser->getUsername());
                            $solLocalDet->getSolLocal()->setAuditDateUpd(new \DateTime());
                            
                            $solLocalDetDao->editSolLocalDet($solLocalDet);
                            
                            $this->generarEmailEtapaNotificacion($solLocalDet, $reg, $inventarioProv->getEntidad()->getEntId());

                            $this->get('session')->setFlash('notice', '#### El registro paso a etapa "'. $reg->getEtpFin()->getEtpNombre() .'" con estado "'.$reg->getEstado()->getEstNombre().'" ####');
                            return $this->redirect($this->generateUrl('MinSalSCAProcesosBundle_mantSolLocalVerSolicitudes'));
                        }
                    }
                }
            }
        }
        
        if($errorList == ''){
            $this->get('session')->setFlash('notice', '#### AUDITORIA: Su usuario no tiene permisos para cambiar el estado en esta etapa "'.$solLocalDet->getSolLocal()->getTransicion()->getEtpFin()->getEtpNombre().'" ####');
        }else{
            $this->get('session')->setFlash('notice', $errorList);
        }
        return $this->redirect($this->generateUrl('MinSalSCAProcesosBundle_mantCargarSolLocal', 
                    array('localDetId' => $localDetId)
                )
        );
    }
    
    /**
     * 
     * @param Cuota $cuota
     * @param double $litros
     * @return InventarioDet
     */
    private function agregarInventario(Cuota $cuota, $litros){
        $user = $this->get('security.context')->getToken()->getUser();
        $inventarioDao = new InventarioDao($this->getDoctrine());
        //$inventarioDetDao = new InventarioDetDao($this->getDoctrine());
        $alcoholDao = new AlcoholDao($this->getDoctrine());
        
        $inventarioDet = new InventarioDet();

        //Buscamos si el encabezado en la tabla de "Inventario" existe
        $inventario = $inventarioDao->findInventario(
                            $cuota->getEntidad()->getEntId(),
                            $cuota->getAlcohol()->getAlcId(),
                            $cuota->getCuoGrado(),
                            $cuota->getCuoNombreEsp()
                        );

        if($inventario != null){
            $invLitros = $inventario->getInvLitros();
            $inventario->setInvLitros( $invLitros + $litros);
            $inventario->setAuditUserUpd($user->getUsername());
            $inventario->setAuditDateUpd(new \DateTime());
            $inventarioDet->setInventario($inventario);
        }else{
            //#### Encabezado de Inventario
            $inventarioDet->setInventario(new Inventario());
            $inventarioDet->getInventario()->setEntidad($cuota->getEntidad());
            $inventarioDet->getInventario()->setAlcohol($alcoholDao->getAlcohol($cuota->getAlcohol()->getAlcId()));
            $inventarioDet->getInventario()->setInvLitros($litros);
            $inventarioDet->getInventario()->setAuditUserIns($user->getUsername());
            $inventarioDet->getInventario()->setAuditDateIns(new \DateTime());
            $inventarioDet->getInventario()->setInvGrado($cuota->getCuoGrado());
            $inventarioDet->getInventario()->setInvNombreEsp($cuota->getCuoNombreEsp());
        }

        //## Detalle de inventario
        $inventarioDet->getInventario()->addInventarioDet($inventarioDet);
        $inventarioDet->setInvDetFecha(new \DateTime());

        //#### Auditoría 
        $inventarioDet->setAuditUserIns($user->getUsername());
        $inventarioDet->setAuditDateIns(new \DateTime());
        
        $inventarioDet->setInvDetAccion("+");
        $inventarioDet->setInvDetLitros($litros);
        
        //$inventarioDetDao->editInventarioDet($inventarioDet);
        //$this->getDoctrine()->getEntityManager()->persist($inventarioDet);
        
        return $inventarioDet;
    }
    
    //############# AGREGAR LOS VALORES A LOS CAMPOS DE DETALLE DE INVENTARIO
    private function agregarInventarioProveedor(SolLocalDet $solLocalDet, $invId, $litros, $grados, $reserva, $liberarParcial){
        $user = $this->get('security.context')->getToken()->getUser();
        $inventarioDao = new InventarioDao($this->getDoctrine());
        $inventarioDetDao = new InventarioDetDao($this->getDoctrine());
        //$inventarioDetDao = new InventarioDetDao($this->getDoctrine());
        //$alcoholDao = new AlcoholDao($this->getDoctrine());
        $inventarioDet = null;
        $localDetId = $solLocalDet->getLocalDetId();
        
        //Buscamos si el encabezado en la tabla de "Inventario" existe
        $inventario = $inventarioDao->getInventario($invId);

        if($inventario != null){
            $invLitros = $inventario->getInvLitros();
            $invReservado = $inventario->getInvReservado();
            $invGrado = $inventario->getInvGrado();
            
            if($reserva){
                //Esta formula es para convertir los litros en el grado del inventario del proveedor
                $inventario->setInvReservado($invReservado + $litros*$grados/$invGrado);
                
                $inventarioDet = new InventarioDet();
                $inventarioDet->setInvDetFecha(new \DateTime());
                
                $inventarioDet->setAuditUserIns($user->getUsername());
                $inventarioDet->setAuditDateIns(new \DateTime());
                
                $inventarioDet->setInvDetLitros($litros*$grados/$invGrado);
                $inventarioDet->setInvDetAccion("R");
            }else{
                $inventario->setInvLitros($invLitros - $litros*$grados/$invGrado);
                $inventario->setInvReservado($invReservado - $litros*$grados/$invGrado);
                
                $inventarioDet = $inventarioDetDao->findInventarioDet($invId, $localDetId, 'R');
                
                $inventarioDet->setAuditUserUpd($user->getUsername());
                $inventarioDet->setAuditDateUpd(new \DateTime());
                
                if($liberarParcial){
                    $inventarioDetParcial = new InventarioDet();
                    $inventarioDetParcial->setInvDetFecha(new \DateTime());

                    $inventarioDetParcial->setAuditUserIns($user->getUsername());
                    $inventarioDetParcial->setAuditDateIns(new \DateTime());

                    $inventarioDetParcial->setInvDetLitros($litros*$grados/$invGrado);
                    $inventarioDetParcial->setInvDetAccion("-");
                    $inventarioDetParcial->setSolLocalDet($solLocalDet);
                    
                    $inventarioDetParcial->setInventario($inventario);
                    $inventarioDetParcial->getInventario()->addInventarioDet($inventarioDetParcial);
                    
                    $inventarioDet->setInvDetLitros($inventarioDet->getInvDetLitros() - $litros*$grados/$invGrado);
                }else{
                    $inventarioDet->setInvDetAccion("-");
                }
            }
            
            $inventario->setAuditUserUpd($user->getUsername());
            $inventario->setAuditDateUpd(new \DateTime());
            
            $inventarioDet->setInventario($inventario);
            
            //## Detalle de inventario
            $inventarioDet->getInventario()->addInventarioDet($inventarioDet);
        }else{
            throw new Exception('No existe inventario de Proveedor');
        }

        return $inventarioDet;
    }
    
    private function generarEmailEtapaNotificacion(SolLocalDet $solLocalDet, Transicion $transicion, $provEntId){
        $transicionDao = new TransicionDao($this->getDoctrine());
        $entidadDao = new EntidadDao($this->getDoctrine());
        
        $localDetId = $solLocalDet->getLocalDetId();
        $etpNombre = $transicion->getEtpFin()->getEtpNombre();
        $entNombComercial = $solLocalDet->getSolLocal()->getEntidad()->getEntNombComercial();
        $traId = $transicion->getTraId();
        $entId = $solLocalDet->getSolLocal()->getEntidad()->getEntId();
        
                            
        $url = urlencode($this->generateUrl('MinSalSCAProcesosBundle_mantCargarSolLocal', array('localDetId' => $localDetId), true));
        $url = $this->generateUrl('MinSalSCABundle_homepage', array(), true). '?url='.$url;
        
        $subject = 'Registro de Compra Local #'.$localDetId." se encuentra en etapa de \"".$etpNombre."\"";
        $emails = $transicionDao->getEmailsXTransicion($entId, $traId, $provEntId);
        
        if($transicion->getTraNotificaEmpresa()){
            $emailsXEmpresa = $entidadDao->getEmailsXEmpresa($entId);
            
            foreach($emailsXEmpresa as $reg){
                if(!in_array($reg, $emails)){
                    $emails[] = $reg;
                }
            }
        }
        
        foreach($emails as $email){
            $message = \Swift_Message::newInstance($subject)
                ->setFrom(array($this->container->getParameter('contact_email') => 'SCA'))
                ->setTo($email) 
                ->setBody($this->renderView('MinSalSCAProcesosBundle:SolLocalDet\Email:newSolicitud.html.twig', array(
                            'solLocalId' => $localDetId,
                            'entNombComercial' => $entNombComercial,
                            'etpNombre' => $etpNombre,
                            'url' => $url
                        )
                    ), 'text/html'
                )->addPart($this->renderView('MinSalSCAProcesosBundle:SolLocalDet\Email:newSolicitud.txt.twig', array(
                            'solLocalId' => $localDetId,
                            'entNombComercial' => $entNombComercial,
                            'etpNombre' => $etpNombre,
                            'url' => $url
                        )
                    ), 'text/plain'
                );

            $this->get('mailer')->send($message);
        }
    }
    
    /**
     * Eliminacion logica del registro en la tabla. Se encargada colocar el flag audit_deleted =true
     * 
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    private function eliminarInventarioDetProveedorAction(InventarioDet $inventarioDet){
        $auditUser = $this->container->get('security.context')->getToken()->getUser();
        
        //Buscamos el encabezado para quitarle la cantidad a eliminar
        $inventarioOld = $inventarioDet->getInventario();
        
        $invLitros = $inventarioOld->getInvLitros();
        $invReservado = $inventarioOld->getInvReservado();
        
        if($inventarioDet->getInvDetAccion() == '+'){
            $inventarioOld->setInvLitros($invLitros - $inventarioDet->getInvDetLitros());
        
        }else if($inventarioDet->getInvDetAccion() == 'R'){
            //$inventarioOld->setInvLitros($invLitros - $inventarioDet->getInvDetLitros());
            $inventarioOld->setInvReservado($invReservado - $inventarioDet->getInvDetLitros());
            
        }else if($inventarioDet->getInvDetAccion() == '-'){
            $inventarioOld->setInvLitros($invLitros + $inventarioDet->getInvDetLitros());
        }
        
        $inventarioOld->setAuditUserUpd($auditUser->getUsername());
        $inventarioOld->setAuditDateUpd(new \DateTime());
        
        $inventarioDet->setAuditUserUpd($auditUser->getUsername());
        $inventarioDet->setAuditDateUpd(new \DateTime());
        $inventarioDet->setAuditDeleted(true);
        $inventarioDet->setInvDetComentario("Solicitud #".$inventarioDet->getSolLocalDet()->getLocalDetId()." Cancelada/Rechazada");
        
        return $inventarioDet;
    }
}
?>