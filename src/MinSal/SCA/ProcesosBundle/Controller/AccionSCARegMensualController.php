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
            return $this->render('MinSalSCAProcesosBundle:RegMensual:mantRegMensualNoEntidad.html.twig', array(
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
           $RegMensualDao->delRegMensual($id);
         $this->get('session')->setFlash('notice', 'El registro se Elimino Exitosamente');
        } else {
           
         //SINO SE SELECCIONO LA OPCION DE ELIMINAR SE ACTUALIZARA O SE AGREGARA UN NUEVO REGISTRO   
          $operacion = $request->get('btnGuardar');
        
          $nit=$RegMensual->getregveNIT("nit");
          $nombcliente=  $RegMensual->getregveNombre("nombcliente");
          $reg_user=$RegMensual->getregveMinsal("reg_user");
          $fecha=$RegMensual->getregveFecha("fecha");
          $n_res = $RegMensual->getregvedgii("n_res");                
          $AlcId =$RegMensual->getAlcohol("AlcId");
          $RegMensualLitros =$RegMensual->getregveLitros("RegMensualLitros");
          $RegMensualGrado =$RegMensual->getregveGrado("RegMensualGrado");
     

        if ($operacion == 'Actualizar') {
            $RegMensualDao->editRegMensual($id,$idEnt, $fecha,$nit, $nombcliente, $reg_user, $n_res,$AlcId,$RegMensualLitros,$RegMensualGrado);
        
            $this->get('session')->setFlash('notice', 'Los datos se han Actualizado exitosamente');
        }

        if ($operacion == 'Guardar') {
            $RegMensualDao->addRegMensual($fecha,$idEnt,$nit, $nombcliente, $reg_user, $n_res,$AlcId,$RegMensualLitros,$RegMensualGrado);
            $this->get('session')->setFlash('notice', 'Los datos se han Guardado exitosamente');
            
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