<?php

/**
 * @author Daniel E. Diaz
 */

namespace MinSal\SCA\ProcesosBundle\Controller;

use MinSal\SCA\AdminBundle\EntityDao\AlcoholDao;
use MinSal\SCA\ProcesosBundle\Entity\RegMensual;
use MinSal\SCA\ProcesosBundle\EntityDao\RegMensualDao;
use MinSal\SCA\ProcesosBundle\Form\Type\RegMensualType;
use MinSal\SCA\UsersBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
* Mantenimineto de Ingreso inicial a Registro de Ventas...
* 
*/
class AccionSCARegMensualController extends Controller {

    /**
     * Retorna la página principal del mantenimiento
     * @return type HTML.twig
     */
    public function mantRegMensualAction() {
        $opciones = $this->getRequest()->getSession()->get('opciones');
        $user = $this->get('security.context')->getToken()->getUser();
        
        if($user->getEntidad()==null){
            return $this->render('MinSalSCAProcesosBundle:Default:mantNoEntidad.html.twig', array(
                        'opciones' => $opciones
                    )
            );
        }else{
            return $this->render('MinSalSCAProcesosBundle:RegMensual:mantRegMensual.html.twig', array(
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
    public function consultarRegMensualJSONAction() {
        //CARGA LA TABLA PRINCIPAL
        $user = $this->get('security.context')->getToken()->getUser();
        
        $RegMensualDao = new RegMensualDao($this->getDoctrine());
        $registros = $RegMensualDao->getJasonRegMensual($user->getEntidad()->getEntId());
        $numfilas = count($registros);
         
            $i = 0;
            //PARA MOSTRAR EL MES CORRECTAMENTE
            foreach ($registros as $reg) {
                if($reg['regmen_mes']==1) $registros[$i]['regmen_mes']="Enero";
                if($reg['regmen_mes']==2) $registros[$i]['regmen_mes']="Febrero";
                if($reg['regmen_mes']==3) $registros[$i]['regmen_mes']="Marzo";
                if($reg['regmen_mes']==4) $registros[$i]['regmen_mes']="Abril";
                if($reg['regmen_mes']==5) $registros[$i]['regmen_mes']="Mayo";
                if($reg['regmen_mes']==6) $registros[$i]['regmen_mes']="Junio";
                if($reg['regmen_mes']==7) $registros[$i]['regmen_mes']="Julio";
                if($reg['regmen_mes']==8) $registros[$i]['regmen_mes']="Agosto";
                if($reg['regmen_mes']==9) $registros[$i]['regmen_mes']="Septiembre";
                if($reg['regmen_mes']==10) $registros[$i]['regmen_mes']="Octubre";
                if($reg['regmen_mes']==11) $registros[$i]['regmen_mes']="Noviembre";
                if($reg['regmen_mes']==12) $registros[$i]['regmen_mes']="Diciembre";
                $i=$i+1;
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

    /*
     * Se encarga de ejecutar las acciones de Eliminar, agregar y editar
     * del mantenimiento
     */
    public function mantRegMensualEdicionAction(request $request) {
        $RegMensual=new RegMensual();
        $RegMensualDao = new RegMensualDao($this->getDoctrine());
	$form = $this->createForm(new RegMensualType($this->getDoctrine()), $RegMensual);
        $form->bindRequest($request);
        
         $user = $this->get('security.context')->getToken()->getUser();
         $idEnt=$user->getEntidad()->getEntId();
        
        
        $id = $RegMensual->getRegMenId('RegMenId');
        $eliminar = $request->get('eliminar');
        //Verifica si se esta seleccionando la opcion de eliminar
   
        if ($eliminar == 'true') {
             /**
         * Eliminacion logica del registro en la tabla. Se encargada colocar el flag audit_deleted =true
         */
         $RegMensualDao->delRegMensual($id,$user);
         $this->get('session')->setFlash('notice', 'El registro se elimino exitosamente');
        } else {
           
         //SINO SE SELECCIONO LA OPCION DE ELIMINAR SE ACTUALIZARA O SE AGREGARA UN NUEVO REGISTRO   
          $operacion = $request->get('btnGuardar');
        
          $year=$RegMensual->getRegmenyear("year");
          $regmen_mes= $RegMensual->getRegmenmes("mes");
          $regmen_exc=$RegMensual->getRegmenexcedenteant("excednt");
          $regmen_prod=$RegMensual->getRegmenprod("Prod");
          $regmen_imp =$RegMensual->getRegmenimp("import");
          $regmen_c_l =$RegMensual->getRegmencompralocal("comp_local");
          $regmen_v_l =$RegMensual->getRegmenventalocal("venta_local");
          $regmen_v_i =$RegMensual->getRegmenventainter("venta_inter");
          $regmen_util=$RegMensual->getRegmenutilizacion("utilizacion");
          $regmen_perd=$RegMensual->getRegmenperdida("perdida");

         if ($operacion == 'Guardar') {
            $RegMensualDao->addRegMensual($year,$idEnt,$regmen_mes, $regmen_exc, $regmen_prod, $regmen_imp,$regmen_c_l,$regmen_v_l,$regmen_v_i,$regmen_util,$regmen_perd,$user);
            $this->get('session')->setFlash('notice', 'Los datos se han guardado exitosamente');
            
        }
        
        if ($operacion == 'Actualizar') {
            $RegMensualDao->editRegMensual($id,$idEnt,$year,$regmen_mes, $regmen_exc, $regmen_prod, $regmen_imp,$regmen_c_l,$regmen_v_l,$regmen_v_i,$regmen_util,$regmen_perd,$user);
        
            $this->get('session')->setFlash('notice', 'Los datos se han actualizado exitosamente');
        }

       
        
        }
        return $this->redirect($this->generateUrl('MinSalSCAProcesosBundle_mantRegMensual'));
        
    }
    
    
    /*
     * Se encarga de cargar los datos de la RegMensual para que sean editados
     */
    public function mantCargarRegMensualAction($RegMenId) {
        $opciones = $this->getRequest()->getSession()->get('opciones');
        $user = $this->get('security.context')->getToken()->getUser();
        
        $RegMensualDao = new RegMensualDao($this->getDoctrine());
        $RegMensual = $RegMensualDao->getRegMensual($RegMenId);
        
        
//        if( !$RegMensual ){
//            $RegMensual = new RegMensual();
//        }else{
//        }
        
        $form = $this->createForm(new RegMensualType($this->getDoctrine()), $RegMensual);

        return $this->render('MinSalSCAProcesosBundle:RegMensual:showRegMensual.html.twig', array(
            'form' => $form->createView(),
            'opciones' => $opciones,
            'RegMenId' => $RegMenId,
            'entNombComercial'=> $user->getEntidad()->getEntNombComercial()
        ));
    }
    
   
}
?>