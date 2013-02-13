<?php

/**
 * @author Henry Willy Melara
 */

namespace MinSal\SCA\ProcesosBundle\Controller;

use MinSal\SCA\AdminBundle\Entity\Cuota;
use MinSal\SCA\AdminBundle\EntityDao\AlcoholDao;
use MinSal\SCA\AdminBundle\EntityDao\CuotaDao;
use MinSal\SCA\ProcesosBundle\Entity\SolImportacion;
use MinSal\SCA\ProcesosBundle\Entity\SolImportacionDet;
use MinSal\SCA\ProcesosBundle\Entity\Flujo;
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
     * @return type HTML.twig
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
     * Devuelve el listado principal de registros del mantenimiento
     * @return Response
     */
    public function consultarSolImportacionJSONAction($etpId) {
        $user = $this->get('security.context')->getToken()->getUser();
        
        $solImportacionDao = new SolImportacionDao($this->getDoctrine());
        $registros = $solImportacionDao->getSolImportacionesByEtapa($user->getEntidad()->getEntId(), $etpId);

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
     * Devuelve el listado de cuotas asignadas a la entidad
     * @return Response
     */
    public function getCuotasAction() {
        $user = $this->get('security.context')->getToken()->getUser();
        $entId = $user->getEntidad()->getEntId();
        $year = new \DateTime();
        
        $cuotaDao = new CuotaDao($this->getDoctrine());
        $inventarioDetDao = new InventarioDetDao($this->getDoctrine());
        $solImportacionDao = new SolImportacionDao($this->getDoctrine());
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
                
                if($disponible > 0){
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
        
        $solImportacionDao = new SolImportacionDao($this->getDoctrine());
        $solImportacionDet = $solImportacionDao->getSolImportacionDet($impDetId);
        
        if( !$solImportacionDet ){
            $solImportacionDet = new SolImportacionDet();
        }
        
        $form = $this->createForm(new SolImportacionDetType($this->getDoctrine()), $solImportacionDet);

        return $this->render('MinSalSCAProcesosBundle:SolImportacion:ingresarSolImportacionDet.html.twig', array(
            'form' => $form->createView(),
            'opciones' => $opciones,
            'impDetId' => $impDetId,
            'entNombComercial'=> $user->getEntidad()->getEntNombComercial()
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
    public function cambiarEstadoAction($solImpId, $traId){
        $auditUser = $this->container->get('security.context')->getToken()->getUser();
        
        $solImportacionDao = new SolImportacionDao($this->getDoctrine());
        $transicionDao = new TransicionDao($this->getDoctrine());
        
        //Buscamos el encabezado para realizar la transicion
        $solImportacion = new SolImportacion();
        $solImportacion = $solImportacionDao->getSolImportacion($solImpId);
        
        $transicion = $transicionDao->getTransicion($traId);
        
        $solImportacion->setTransicion($transicion);
        $solImportacion->setAuditUserUpd($auditUser->getUsername());
        $solImportacion->setAuditDateUpd(new \DateTime());
        
        $solImportacionDao->addSolImportacion($solImportacion);
        
        $this->get('session')->setFlash('notice', '#### El registro ha sido actualizado ####');

        return $this->redirect($this->generateUrl('MinSalSCAProcesosBundle_mantSolImportacion'));
    }
}
?>