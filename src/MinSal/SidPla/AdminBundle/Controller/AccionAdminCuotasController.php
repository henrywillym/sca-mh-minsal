<?php
/**
 * Description of AccionAdminCuotasController
 *
 * @author Henry Willy Melara
 */

namespace MinSal\SidPla\AdminBundle\Controller;

use MinSal\SidPla\AdminBundle\Entity\Cuota;
use MinSal\SidPla\AdminBundle\Entity\Alcohol;
use MinSal\SidPla\AdminBundle\Entity\Entidad;
use MinSal\SidPla\AdminBundle\EntityDao\AlcoholDao;
use MinSal\SidPla\AdminBundle\EntityDao\CuotaDao;
use MinSal\SidPla\AdminBundle\EntityDao\EntidadDao;
use MinSal\SidPla\AdminBundle\Form\Type\CuotaType;
use MinSal\SidPla\AdminBundle\Form\Type\EntidadType;
use MinSal\SidPla\UsersBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
* Mantenimineto de Productores, Importadores y Compradores Locales...
* 
*/
class AccionAdminCuotasController extends Controller {
    
    /**
     * Retorna la página principal del mantenimiento
     * @return type HTML.twig
     */
    public function mantCuotasAction($entId, $cuoTipo) {
        $opciones = $this->getRequest()->getSession()->get('opciones');
        return $this->render('MinSalSidPlaAdminBundle:Cuota:mantCuotas.html.twig', 
                array('opciones' => $opciones, 'cuoTipo'=>$cuoTipo, 'entId'=>$entId));
    }

    /**
     * Devuelve el listado principal de registros del mantenimiento
     * @return Response
     */
    public function consultarCuotasJSONAction($entId, $cuoTipo) {
        $rows = null;
        $request = $this->getRequest();
        $cuotaDao = new CuotaDao($this->getDoctrine());
        $year = new \DateTime();
        $cuotas = $cuotaDao->getCuotas($entId, $cuoTipo, $year->format('Y'));

        $numfilas = count($cuotas);
        
        if ($numfilas != 0) {
            //array_multisort($cuotas, SORT_ASC);
        } else {
            //$rows[0]['id'] = 0;
            //$rows[0]['cell'] = array(' ', ' ',' ', ' ', ' ', ' ', ' ', ' ');
        }

        $datos = json_encode($cuotas);
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
    
    public function mantCuotaEdicionAction($entId, $cuoTipo) {
        $request = $this->getRequest();
        $cuota = new Cuota();
        $operacion = $request->get('oper');
        $user = $this->get('security.context')->getToken()->getUser();

        $cuotaDao = new CuotaDao($this->getDoctrine());
        $alcoholDao = new AlcoholDao($this->getDoctrine());
        $entidadDao = new EntidadDao($this->getDoctrine());
        
        //$entId = $request->get('entId');
        $alcId = $request->get('alcId');
        $cuoId= $request->get('id');
        
        if ($operacion == 'edit' || $operacion == 'del') {
            $cuota = $cuotaDao->getCuota($cuoId);
        }else{
            $cuoId = null;
        }
        
        if ($operacion != 'del') {
            //$cuoTipo= $request->get('cuoTipo');
            $cuoNombreEsp= trim($request->get('cuoNombreEsp'));
            $cuoGrado= $request->get('cuoGrado');
            $cuoLitros= $request->get('cuoLitros');
            $t = new \DateTime();
            $cuoYear = $t->format('Y')+0;
            
            $cuota->setCuoYear($cuoYear);
            $cuota->setCuoTipo($cuoTipo);
            $cuota->setCuoNombreEsp($cuoNombreEsp);
            $cuota->setCuoGrado($cuoGrado);
            $cuota->setCuoLitros($cuoLitros);
            
            
            //Asociamos el objeto seleccionado en el formulario
            //$cuota->setAlcohol($alcoholDao->getAlcohol($alcId));

            //$alcohol = new Alcohol();
            $alcohol = $alcoholDao->getAlcohol($alcId);
            $alcohol->getCuotas()->add($cuota);

            $entidad = $entidadDao->getEntidad($entId);
            $entidad->getCuotas()->add($cuota);

            $cuota->setEntidad($entidad);
            $cuota->setAlcohol($alcohol);
            /*
            $validator = $this->get('validator');
            $errors = $validator->validate($cuota);
            
            if (count($errors) > 0) {
                $msg = '';
                foreach($errors as $error){
                    //var_dump($error->message);
                    $msg = $msg.$error->getMessage();
                } 
                return new Response("{sc:false,msg:'".$msg."' }");
                //json_encode($errors)
            }/**/
            
            $cantidad = $cuotaDao->existeCuota($cuoId, $entId, $alcId, $cuoYear, $cuoTipo, $cuoGrado, $cuoNombreEsp);
            if( $cantidad>0 ){
                $resp = new Response('{"status":false,"msg":"Registro duplicado, ya existe un registro con estos datos"}');
                //$resp->setStatusCode(418, 'Errores duplicados');//json_encode($form->getErrors())
                return $resp;
            }
        }
        
        if($cuota->getEntidad() && $cuota->getAlcohol()  ){
            if ($operacion == 'edit') {
                //#### Auditoría 
                $cuota->setAuditUserUpd($user->getUsername());
                $cuota->setAuditDateUpd(new \DateTime());
                $cuotaDao->editCuota($cuota);
                
            }else if ($operacion == 'del') {
                //#### Auditoría 
                $cuota->setAuditUserUpd($user->getUsername());
                $cuota->setAuditDateUpd(new \DateTime());
                $cuota->setAuditDeleted(true);

                $cuotaDao->editCuota($cuota);
            }else if ($operacion == 'add') {
                $cuota->setAuditUserIns($user->getUsername());
                $cuota->setAuditDateIns(new \DateTime());
                $cuotaDao->editCuota($cuota);
            }
            
            return new Response('{"status":true,"msg":""}');
        }else{
            return new Response('{"status":false,"msg":"No se encuentra la Entidad o Nombre Alcohol"}');
        };
    }
    
    /*
    public function mantCuotaEdicionAction(Request $request) {
        //$request = $this->getRequest();
        //$user = new User();
        //Request 
        //$request = $this->get('request');
        
        $cuotaTmp = new Cuota();
        $form = $this->createForm(new CuotaType(),$cuotaTmp);
        $form->bindRequest($request);
        
        $cuota = new Cuota();
        
        $cuotaDao = new CuotaDao($this->getDoctrine());
        $alcoholDao = new AlcoholDao($this->getDoctrine());
        $entidadDao = new EntidadDao($this->getDoctrine());
        
        $user = $this->get('security.context')->getToken()->getUser();

        if( $cuotaTmp->getCuoId() ){
            $cuota = $cuotaDao->getCuota($cuotaTmp->getCuoId());
            //#### Auditoría 
            $cuota->setAuditUserUpd($user->getUsername());
            $cuota->setAuditDateUpd(new \DateTime());
        }else{
            //#### Auditoría 
            $cuota->setAuditUserIns($user->getUsername());
            $cuota->setAuditDateIns(new \DateTime());
        }
        
        $form = $this->createForm(new CuotaType(),$cuota);
        
        //if ($this->getRequest()->getMethod() == 'POST') {
            $form->bindRequest($request);
            //if($form->isValid()){
                $cuota->setCuoYear(date('yyyy')+0);

                $operacion = $request->get('oper');
                
                //Asociamos el objeto seleccionado en el formulario
                $cuota->setAlcohol($alcoholDao->getAlcohol($request->get('alcohol.alcId')));
                
                $cuota->setEntidad($entidadDao->getEntidad($request->get('entidad.entId')));
                
                if($cuota->getEntidad()){
                    if ($operacion == 'edit') {
                        $cuotaDao->editCuota($cuota);
                    }else if ($operacion == 'del') {
                        $cuota->setAuditDeleted(true);

                        $cuotaDao->editCuota($cuota);
                    }else if ($operacion == 'add') {
                        $cuotaDao->editCuota($cuota);
                    }
                    return new Response("{sc:true,msg:'' }");
                }
                //$cuotaDao->editCuota($cuota);

                return new Response("{sc:true,msg:'NO ENTIDAD' }");
        /*    }else{
                return new Response(json_encode($form->getErrors()));//"{sc:false,msg:'Hubo errores en la actualización'}");
            }
        }else{
            return new Response("{sc:true,msg:'NO POST METHOD', }");
        }* /
        $this->get('session')->setFlash('notice', 'Los datos se han guardado con éxito!!!');
    }
    /***/
    
    /*
     * Se encarga de cargar los datos de la cuota para que sean editados
     * /
    public function mantCargarCuotaAction($entId) {
        $opciones = $this->getRequest()->getSession()->get('opciones');
        //$cuota = new Cuota();
        //$form->bindRequest($this->getRequest());//Capturar datos de Request a Form
        
        $cuotaDao = new CuotaDao($this->getDoctrine());
        $cuota = $cuotaDao->getCuota($entId);
        
        if( !$cuota ){
            $cuota = new Cuota();
        }
        
        $form = $this->createForm(new CuotaType(), $cuota);

        return $this->render('MinSalSidPlaAdminBundle:Cuota:showCuota.html.twig', 
                array('form' => $form->createView(),'opciones'=>$opciones)
        );
    }*/
    
    
}
?>