<?php

/**
 * @author Daniel E. Diaz
 */

namespace MinSal\SCA\ProcesosBundle\Controller;

use MinSal\SCA\AdminBundle\EntityDao\AlcoholDao;
use MinSal\SCA\ProcesosBundle\Entity\RegVenta;
use MinSal\SCA\ProcesosBundle\EntityDao\RegVentaDao;
use MinSal\SCA\ProcesosBundle\Form\Type\RegVentaType;
use MinSal\SCA\UsersBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
* Mantenimineto de Ingreso inicial a Registro de Ventas...
* 
*/
class AccionSCARegVentaController extends Controller {

    /**
     * Retorna la página principal del mantenimiento
     * @return type HTML.twig
     */
    public function mantRegVentaAction() {
        $opciones = $this->getRequest()->getSession()->get('opciones');
        $user = $this->get('security.context')->getToken()->getUser();
        
        if($user->getEntidad()==null){
            return $this->render('MinSalSCAProcesosBundle:RegVenta:mantRegVentaNoEntidad.html.twig', array(
                        'opciones' => $opciones
                    )
            );
        }else{
            return $this->render('MinSalSCAProcesosBundle:RegVenta:mantRegVenta.html.twig', array(
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
    public function consultarRegVentaJSONAction() {
        $user = $this->get('security.context')->getToken()->getUser();
        
        $RegVentaDao = new RegVentaDao($this->getDoctrine());
        $registros = $RegVentaDao->getRegVenta($user->getEntidad()->getEntId());

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
    public function mantRegVentaEdicionAction(Request $request) {
        $RegVentaTmp = new RegVenta();
        $RegVenta = new RegVenta();
        
        $form = $this->createForm(new RegVentaType($this->getDoctrine()), $RegVentaTmp);
        $form->bindRequest($request);
        
        $RegVentaDao = new RegVentaDao($this->getDoctrine());
        $alcoholDao = new AlcoholDao($this->getDoctrine());
        
        $user = $this->get('security.context')->getToken()->getUser();
        $errores = $RegVentaTmp->isValid();
        
        $eliminar = $request->get("eliminar");
        if($eliminar === 'true'){
            $RegVenta = $RegVentaDao->getRegVenta($RegVentaTmp->getRegVentaId());
            return $this->eliminarAction($RegVenta);
        }
        
        if(($form->isValid() && count($errores)==0)){
            if( $RegVentaTmp->getRegVentaId() ){
                $RegVenta = $RegVentaDao->getRegVenta($RegVentaTmp->getRegVentaId());

                //Primero es de revisar si ha cambiado la información de la tabla encabezado.
                if( $RegVentaTmp->getAlcId() != $RegVenta->getAlcId() ||
                    $RegVentaTmp->getRegVentaGrado() != $RegVenta->getRegVentaGrado() ||
                    $RegVentaTmp->getRegVentaNombreEsp() != $RegVenta->getRegVentaNombreEsp()
                        ){
                    //Si alguno de los campos es diferente, se debe actualizar los registros encabezados antiguos
                    $RegVentaOld = $RegVentaDao->findRegVenta(
                                        $user->getEntidad()->getEntId(), 
                                        $RegVenta->getAlcId(), 
                                        $RegVenta->getRegVentaGrado(), 
                                        $RegVenta->getRegVentaNombreEsp()
                                    );
                    $RegVentaLitros = $RegVentaOld->getRegVentaLitros();
                    $RegVentaOld->setRegVentaLitros($RegVentaLitros - $RegVenta->getRegVentaDetLitros());
                    
                    //$RegVentaDao->editRegVenta($RegVentaOld);

                    //Buscamos si existe el NUEVO encabezado en la tabla de "RegVenta"
                    $RegVenta = $RegVentaDao->findRegVenta(
                                        $user->getEntidad()->getEntId(), 
                                        $RegVentaTmp->getAlcId(), 
                                        $RegVentaTmp->getRegVentaGrado(), 
                                        $RegVentaTmp->getRegVentaNombreEsp()
                                    );

                    if($RegVenta != null){
                        $RegVentaLitros = $RegVenta->getRegVentaLitros();
                        $RegVenta->setRegVentaLitros( $RegVentaLitros + $RegVentaTmp->getRegVentaDetLitros() );
                        $RegVenta->setRegVenta($RegVenta);
                    }else{
                        //#### Encabezado de RegVenta
                        $RegVenta->setRegVenta(new RegVenta());
                        $RegVenta->getRegVenta()->setEntidad($user->getEntidad());
                        $RegVenta->getRegVenta()->setAlcohol($alcoholDao->getAlcohol($RegVentaTmp->getAlcId()));
                        $RegVenta->getRegVenta()->setRegVentaLitros($RegVentaTmp->getRegVentaDetLitros());                
                        $RegVenta->getRegVenta()->setRegVentaGrado($RegVentaTmp->getRegVentaGrado());
                        $RegVenta->getRegVenta()->setRegVentaNombreEsp($RegVentaTmp->getRegVentaNombreEsp());
                    }

                    //## Detalle de RegVenta
                    $RegVenta->getRegVenta()->addRegVenta($RegVenta);
                    $RegVenta->setRegVentaDetFecha(new \DateTime());
                }else{
                    //Si el encabezado no cambia
                    $RegVentaLitros = $RegVenta->getRegVenta()->getRegVentaLitros();
                    $RegVenta->getRegVenta()->setRegVentaLitros($RegVentaLitros + $RegVentaTmp->getRegVentaDetLitros() - $RegVenta->getRegVentaDetLitros());
                }
                
                //#### Auditoría 
                $RegVenta->setAuditUserUpd($user->getUsername());
                $RegVenta->setAuditDateUpd(new \DateTime());
            }else{
                //Buscamos si el encabezado en la tabla de "RegVenta" existe
                $RegVenta = $RegVentaDao->findRegVenta(
                                    $user->getEntidad()->getEntId(),
                                    $RegVentaTmp->getAlcId(),
                                    $RegVentaTmp->getRegVentaGrado(),
                                    $RegVentaTmp->getRegVentaNombreEsp()
                                );
                
                if($RegVenta != null){
                    $RegVentaLitros = $RegVenta->getRegVentaLitros();
                    $RegVenta->setRegVentaLitros( $RegVentaLitros + $RegVentaTmp->getRegVentaDetLitros());
                    $RegVenta->setRegVenta($RegVenta);
                }else{
                    //#### Encabezado de RegVenta
                    $RegVenta->setRegVenta(new RegVenta());
                    $RegVenta->getRegVenta()->setEntidad($user->getEntidad());
                    $RegVenta->getRegVenta()->setAlcohol($alcoholDao->getAlcohol($RegVentaTmp->getAlcId()));
                    $RegVenta->getRegVenta()->setRegVentaLitros($RegVentaTmp->getRegVentaDetLitros());
                    $RegVenta->getRegVenta()->setRegVentaGrado($RegVentaTmp->getRegVentaGrado());
                    $RegVenta->getRegVenta()->setRegVentaNombreEsp($RegVentaTmp->getRegVentaNombreEsp());
                }

                //## Detalle de RegVenta
                $RegVenta->getRegVenta()->addRegVenta($RegVenta);
                $RegVenta->setRegVentaFecha(new \DateTime());
            }

            //##################################################################################################
            $form = $this->createForm(new RegVentaType($this->getDoctrine()), $RegVenta);
        
            $form->bindRequest($request);
            
            $RegVentaDao->editRegVenta($RegVenta);
            $this->get('session')->setFlash('notice', 'Los datos se han guardado con éxito!!!');
            
            return $this->redirect($this->generateUrl('MinSalSCAProcesosBundle_mantRegVenta'));
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
            return $this->render('MinSalSCAProcesosBundle:RegVenta:showRegVenta.html.twig', array(
                    'opciones' => $opciones, 
                    'form' => $form->createView(), 
                    'RegVentaId'=>$RegVenta->getRegVentaId(),
                    'entNombComercial'=> $user->getEntidad()->getEntNombComercial()
                )
            );
        }
    }
    
    
    /*
     * Se encarga de cargar los datos de la RegVenta para que sean editados
     */
    public function mantCargarRegVentaAction($RegVentaId) {
        $opciones = $this->getRequest()->getSession()->get('opciones');
        $user = $this->get('security.context')->getToken()->getUser();
        
        $RegVentaDao = new RegVentaDao($this->getDoctrine());
        $RegVenta = $RegVentaDao->getRegVenta($RegVentaId);
        
        
//        if( !$RegVenta ){
//            $RegVenta = new RegVenta();
//        }else{
//        }
//        
        $form = $this->createForm(new RegVentaType($this->getDoctrine()), $RegVenta);

        return $this->render('MinSalSCAProcesosBundle:RegVenta:showRegVenta.html.twig', array(
            'form' => $form->createView(),
            'opciones' => $opciones,
            'RegVentaId' => $RegVentaId,
            'entNombComercial'=> $user->getEntidad()->getEntNombComercial()
        ));
    }
    
    /**
     * Eliminacion logica del registro en la tabla. Se encargada colocar el flag audit_deleted =true
     * 
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    private function eliminarAction(RegVenta $RegVenta){
        $auditUser = $this->container->get('security.context')->getToken()->getUser();
        
        $RegVentaDao = new RegVentaDao($this->getDoctrine());
        $RegVentaDao = new RegVentaDao($this->getDoctrine());
        
        //Buscamos el encabezado para quitarle la cantidad a eliminar
        $RegVentaOld = $RegVentaDao->findRegVenta(
                            $auditUser->getEntidad()->getEntId(), 
                            $RegVenta->getAlcId(), 
                            $RegVenta->getRegVentaGrado(), 
                            $RegVenta->getRegVentaNombreEsp()
                        );
        //$RegVentaOld = $RegVenta->getRegVenta();
        $RegVentaLitros = $RegVentaOld->getRegVentaLitros();
        $RegVentaOld->setRegVentaLitros($RegVentaLitros - $RegVenta->getRegVentaDetLitros());
        $RegVentaOld->setAuditUserUpd($auditUser->getUsername());
        $RegVentaOld->setAuditDateUpd(new \DateTime());
        
        $RegVentaDao->delRegVenta($RegVenta->getRegVentaId(), $auditUser->getUsername());
        
        $this->get('session')->setFlash('notice', '#### El registro ha sido eliminado ####');

        return $this->redirect($this->generateUrl('MinSalSCAProcesosBundle_mantRegVenta'));
    }
}
?>