<?php

/**
 * @author Henry Willy Melara
 */

namespace MinSal\SCA\ProcesosBundle\Controller;

use MinSal\SCA\AdminBundle\EntityDao\AlcoholDao;
use MinSal\SCA\ProcesosBundle\Entity\Inventario;
use MinSal\SCA\ProcesosBundle\Entity\InventarioDet;
use MinSal\SCA\ProcesosBundle\EntityDao\InventarioDao;
use MinSal\SCA\ProcesosBundle\EntityDao\InventarioDetDao;
use MinSal\SCA\ProcesosBundle\Form\Type\InventarioDetType;
use MinSal\SCA\UsersBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
* Mantenimineto de Ingreso inicial a inventario de alcohol...
* 
*/
class AccionSCAInventariosDetController extends Controller {

    /**
     * Retorna la página principal del mantenimiento
     * @return type HTML.twig
     */
    public function mantInventariosDetAction() {
        $opciones = $this->getRequest()->getSession()->get('opciones');
        $user = $this->get('security.context')->getToken()->getUser();
        
        if($user->getEntidad()==null){
            return $this->render('MinSalSCAProcesosBundle:InventarioDet:mantInventariosDetNoEntidad.html.twig', array(
                        'opciones' => $opciones
                    )
            );
        }else{
            return $this->render('MinSalSCAProcesosBundle:InventarioDet:mantInventariosDet.html.twig', array(
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
    public function consultarInventariosDetJSONAction() {
        $user = $this->get('security.context')->getToken()->getUser();
        
        $inventarioDetDao = new InventarioDetDao($this->getDoctrine());
        $registros = $inventarioDetDao->getInventariosDet($user->getEntidad()->getEntId());

        $numfilas = count($registros);
        
        //$emple = new InventarioDet();

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

    /*
     * Se encarga de ejecutar las acciones de Eliminar, agregar y editar
     * del mantenimiento
     */
    public function mantInventarioDetEdicionAction(Request $request) {
        $inventarioDetTmp = new InventarioDet();
        $inventarioDet = new InventarioDet();
        
        $form = $this->createForm(new InventarioDetType($this->getDoctrine()), $inventarioDetTmp);
        $form->bindRequest($request);
        
        $inventarioDao = new InventarioDao($this->getDoctrine());
        $inventarioDetDao = new InventarioDetDao($this->getDoctrine());
        $alcoholDao = new AlcoholDao($this->getDoctrine());
        
        $user = $this->get('security.context')->getToken()->getUser();
        $errores = $inventarioDetTmp->isValid();
        
        $eliminar = $request->get("eliminar");
        if($eliminar === 'true'){
            $inventarioDet = $inventarioDetDao->getInventarioDet($inventarioDetTmp->getInvDetId());
            return $this->eliminarAction($inventarioDet);
        }
        
        if(($form->isValid() && count($errores)==0)){
            if( $inventarioDetTmp->getInvDetId() ){
                $inventarioDet = $inventarioDetDao->getInventarioDet($inventarioDetTmp->getInvDetId());

                //Primero es de revisar si ha cambiado la información de la tabla encabezado.
                if( $inventarioDetTmp->getAlcId() != $inventarioDet->getAlcId() ||
                    $inventarioDetTmp->getInvGrado() != $inventarioDet->getInvGrado() ||
                    $inventarioDetTmp->getInvNombreEsp() != $inventarioDet->getInvNombreEsp()
                        ){
                    //Si alguno de los campos es diferente, se debe actualizar los registros encabezados antiguos
                    $inventarioOld = $inventarioDao->findInventario(
                                        $user->getEntidad()->getEntId(), 
                                        $inventarioDet->getAlcId(), 
                                        $inventarioDet->getInvGrado(), 
                                        $inventarioDet->getInvNombreEsp()
                                    );
                    $invLitros = $inventarioOld->getInvLitros();
                    $inventarioOld->setInvLitros($invLitros - $inventarioDet->getInvDetLitros());
                    $inventarioOld->setAuditUserUpd($user->getUsername());
                    $inventarioOld->setAuditDateUpd(new \DateTime());
                    //$inventarioDao->editInventario($inventarioOld);

                    //Buscamos si existe el NUEVO encabezado en la tabla de "Inventario"
                    $inventario = $inventarioDao->findInventario(
                                        $user->getEntidad()->getEntId(), 
                                        $inventarioDetTmp->getAlcId(), 
                                        $inventarioDetTmp->getInvGrado(), 
                                        $inventarioDetTmp->getInvNombreEsp()
                                    );

                    if($inventario != null){
                        $invLitros = $inventario->getInvLitros();
                        $inventario->setInvLitros( $invLitros + $inventarioDetTmp->getInvDetLitros() );
                        $inventario->setAuditUserUpd($user->getUsername());
                        $inventario->setAuditDateUpd(new \DateTime());
                        $inventarioDet->setInventario($inventario);
                    }else{
                        //#### Encabezado de Inventario
                        $inventarioDet->setInventario(new Inventario());
                        $inventarioDet->getInventario()->setEntidad($user->getEntidad());
                        $inventarioDet->getInventario()->setAlcohol($alcoholDao->getAlcohol($inventarioDetTmp->getAlcId()));
                        $inventarioDet->getInventario()->setInvLitros($inventarioDetTmp->getInvDetLitros());
                        $inventarioDet->getInventario()->setAuditUserIns($user->getUsername());
                        $inventarioDet->getInventario()->setAuditDateIns(new \DateTime());
                        $inventarioDet->getInventario()->setInvGrado($inventarioDetTmp->getInvGrado());
                        $inventarioDet->getInventario()->setInvNombreEsp($inventarioDetTmp->getInvNombreEsp());
                    }

                    //## Detalle de inventario
                    $inventarioDet->getInventario()->addInventarioDet($inventarioDet);
                    $inventarioDet->setInvDetFecha(new \DateTime());
                }else{
                    //Si el encabezado no cambia
                    $invLitros = $inventarioDet->getInventario()->getInvLitros();
                    $inventarioDet->getInventario()->setInvLitros($invLitros + $inventarioDetTmp->getInvDetLitros() - $inventarioDet->getInvDetLitros());
                    $inventarioDet->getInventario()->setAuditUserUpd($user->getUsername());
                    $inventarioDet->getInventario()->setAuditDateUpd(new \DateTime());
                }
                
                //#### Auditoría 
                $inventarioDet->setAuditUserUpd($user->getUsername());
                $inventarioDet->setAuditDateUpd(new \DateTime());
            }else{
                //Buscamos si el encabezado en la tabla de "Inventario" existe
                $inventario = $inventarioDao->findInventario(
                                    $user->getEntidad()->getEntId(),
                                    $inventarioDetTmp->getAlcId(),
                                    $inventarioDetTmp->getInvGrado(),
                                    $inventarioDetTmp->getInvNombreEsp()
                                );
                
                if($inventario != null){
                    $invLitros = $inventario->getInvLitros();
                    $inventario->setInvLitros( $invLitros + $inventarioDetTmp->getInvDetLitros());
                    $inventario->setAuditUserUpd($user->getUsername());
                    $inventario->setAuditDateUpd(new \DateTime());
                    $inventarioDet->setInventario($inventario);
                }else{
                    //#### Encabezado de Inventario
                    $inventarioDet->setInventario(new Inventario());
                    $inventarioDet->getInventario()->setEntidad($user->getEntidad());
                    $inventarioDet->getInventario()->setAlcohol($alcoholDao->getAlcohol($inventarioDetTmp->getAlcId()));
                    $inventarioDet->getInventario()->setInvLitros($inventarioDetTmp->getInvDetLitros());
                    $inventarioDet->getInventario()->setAuditUserIns($user->getUsername());
                    $inventarioDet->getInventario()->setAuditDateIns(new \DateTime());
                    $inventarioDet->getInventario()->setInvGrado($inventarioDetTmp->getInvGrado());
                    $inventarioDet->getInventario()->setInvNombreEsp($inventarioDetTmp->getInvNombreEsp());
                }

                //## Detalle de inventario
                $inventarioDet->getInventario()->addInventarioDet($inventarioDet);
                $inventarioDet->setInvDetFecha(new \DateTime());

                //#### Auditoría 
                $inventarioDet->setAuditUserIns($user->getUsername());
                $inventarioDet->setAuditDateIns(new \DateTime());
            }

            //##################################################################################################
            $form = $this->createForm(new InventarioDetType($this->getDoctrine()), $inventarioDet);
        
            $form->bindRequest($request);
            
            $inventarioDetDao->editInventarioDet($inventarioDet);
            $this->get('session')->setFlash('notice', 'Los datos se han guardado con éxito!!!');
            
            return $this->redirect($this->generateUrl('MinSalSCAProcesosBundle_mantInventariosDet'));
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
            return $this->render('MinSalSCAProcesosBundle:InventarioDet:showInventarioDet.html.twig', array(
                    'opciones' => $opciones, 
                    'form' => $form->createView(), 
                    'invDetId'=>$inventarioDet->getInvDetId(),
                    'entNombComercial'=> $user->getEntidad()->getEntNombComercial()
                )
            );
        }
    }
    
    
    /*
     * Se encarga de cargar los datos de la inventarioDet para que sean editados
     */
    public function mantCargarInventarioDetAction($invDetId) {
        $opciones = $this->getRequest()->getSession()->get('opciones');
        $user = $this->get('security.context')->getToken()->getUser();
        
        $inventarioDetDao = new InventarioDetDao($this->getDoctrine());
        $inventarioDet = $inventarioDetDao->getInventarioDet($invDetId);
        
        if( !$inventarioDet ){
            $inventarioDet = new InventarioDet();
        }else{
        }
        
        $form = $this->createForm(new InventarioDetType($this->getDoctrine()), $inventarioDet);

        return $this->render('MinSalSCAProcesosBundle:InventarioDet:showInventarioDet.html.twig', array(
            'form' => $form->createView(),
            'opciones' => $opciones,
            'invDetId' => $invDetId,
            'entNombComercial'=> $user->getEntidad()->getEntNombComercial()
        ));
    }
    
    /**
     * Eliminacion logica del registro en la tabla. Se encargada colocar el flag audit_deleted =true
     * 
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    private function eliminarAction(InventarioDet $inventarioDet){
        $auditUser = $this->container->get('security.context')->getToken()->getUser();
        
        $inventarioDetDao = new InventarioDetDao($this->getDoctrine());
        $inventarioDao = new InventarioDao($this->getDoctrine());
        
        //Buscamos el encabezado para quitarle la cantidad a eliminar
        $inventarioOld = $inventarioDao->findInventario(
                            $auditUser->getEntidad()->getEntId(), 
                            $inventarioDet->getAlcId(), 
                            $inventarioDet->getInvGrado(), 
                            $inventarioDet->getInvNombreEsp()
                        );
        //$inventarioOld = $inventarioDet->getInventario();
        $invLitros = $inventarioOld->getInvLitros();
        $inventarioOld->setInvLitros($invLitros - $inventarioDet->getInvDetLitros());
        $inventarioOld->setAuditUserUpd($auditUser->getUsername());
        $inventarioOld->setAuditDateUpd(new \DateTime());
        
        $inventarioDetDao->delInventarioDet($inventarioDet->getInvDetId(), $auditUser->getUsername());
        
        $this->get('session')->setFlash('notice', '#### El registro ha sido eliminado ####');

        return $this->redirect($this->generateUrl('MinSalSCAProcesosBundle_mantInventariosDet'));
    }
}
?>