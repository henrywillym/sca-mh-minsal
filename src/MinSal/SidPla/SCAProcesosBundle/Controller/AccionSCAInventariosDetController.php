<?php

/**
 * @author Henry Willy Melara
 */

namespace MinSal\SidPla\SCAProcesosBundle\Controller;

use MinSal\SidPla\AdminBundle\EntityDao\AlcoholDao;
use MinSal\SidPla\SCAProcesosBundle\Entity\Inventario;
use MinSal\SidPla\SCAProcesosBundle\Entity\InventarioDet;
use MinSal\SidPla\SCAProcesosBundle\EntityDao\InventarioDao;
use MinSal\SidPla\SCAProcesosBundle\EntityDao\InventarioDetDao;
use MinSal\SidPla\SCAProcesosBundle\Form\Type\InventarioDetType;
use MinSal\SidPla\UsersBundle\Entity\User;
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
        //var_dump($user->getEntidad());die;
        return $this->render('MinSalSidPlaSCAProcesosBundle:InventarioDet:mantInventariosDet.html.twig', array(
                    'opciones' => $opciones,
                    'entNombComercial'=> $user->getEntidad()->getEntNombComercial()
                )
        );
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
        $alcoholDao = new AlcoholDao($this->getDoctrine());
        var_dump($alcoholDao->getAlcohol(1));die;
        //$this->getDoctrine()->getEntityManager()->persist($inventarioDetTmp->getAlcohol());
        $form = $this->createForm(new InventarioDetType(), $inventarioDetTmp);
        $form->bindRequest($request);
        
        $inventarioDet = new InventarioDet();
        $inventarioDao = new InventarioDao($this->getDoctrine());
        $inventarioDetDao = new InventarioDetDao($this->getDoctrine());
        $alcoholDao = new AlcoholDao($this->getDoctrine());
        
        $user = $this->get('security.context')->getToken()->getUser();
        //$this->getDoctrine()->getEntityManager()->persist($inventarioDet->getAlcohol());
        $form = $this->createForm(new InventarioDetType(),$inventarioDet);
        
        $form->bindRequest($request);
        
        if($form->isValid()){
            $inventarioDet->setAlcohol($alcoholDao->getAlcohol($inventarioDetTmp->getAlcohol()->getAlcId()));
            $inventarioDetTmp->setAlcohol($alcoholDao->getAlcohol($inventarioDetTmp->getAlcohol()->getAlcId()));
            
            if( $inventarioDet->getInvDetId() ){
                $inventarioDetOld = $inventarioDetDao->getInventarioDet($inventarioDetTmp->getInvDetId());

                //Primero es de revisar si ha cambiado la información de la tabla encabezado.
                if( $inventarioDetTmp->getAlcohol()->getAlcId() != $inventarioDetOld->getAlcohol()->getAlcId() ||
                    $inventarioDetTmp->getInvGrado() != $inventarioDetOld->getInvGrado() ||
                    $inventarioDetTmp->getInvNombreEsp() != $inventarioDetOld->getInvNombreEsp()
                        ){
                    //Si alguno de los campos es diferente, se debe actualizar los registros encabezados antiguos
                    $inventarioOld = $inventarioDao->findInventario(
                                        $user->getEntidad()->getEntId(), 
                                        $inventarioDetOld->getAlcohol()->getAlcId(), 
                                        $inventarioDetOld->getInvGrado(), 
                                        $inventarioDetOld->getInvNombreEsp()
                                    );
                    $invLitros = $inventarioOld->getInvLitros();
                    $inventarioOld->setInvLitros($invLitros - $inventarioDetOld->getInvDetLitros());
                    $inventarioOld->setAuditUserUpd($user->getUsername());
                    $inventarioOld->setAuditDateUpd(new \DateTime());
                    //$inventarioDao->editInventario($inventarioOld);
                    
                    //Buscamos si existe el NUEVO encabezado en la tabla de "Inventario"
                    $inventario = $inventarioDao->findInventario(
                                        $user->getEntidad()->getEntId(), 
                                        $inventarioDetTmp->getAlcohol()->getAlcId(), 
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
                        $inventarioDet->getInventario()->setEntidad($user->getEntidad());
                        $inventarioDet->getInventario()->setAlcohol($alcoholDao->getAlcohol($inventarioDetTmp->getAlcohol()->getAlcId()));
                        $inventarioDet->getInventario()->setInvLitros($inventarioDetTmp->getInvDetLitros());
                        $inventarioDet->getInventario()->setAuditUserIns($user->getUsername());
                        $inventarioDet->getInventario()->setAuditDateIns(new \DateTime());
                        //$inventarioDet->getInventario()->setInvGrado($inventarioDetTmp->getInvGrado());
                        //$inventarioDet->getInventario()->setInvNombreEsp($inventarioDetTmp->getInvNombreEsp());
                    }

                    //## Detalle de inventario
                    $inventarioDet->getInventario()->addInventarioDet($inventarioDet);
                    $inventarioDet->setInvDetFecha(new \DateTime());
                }else{
                    //Si el encabezado no cambia
                    $invLitros = $inventarioDet->getInventario()->getInvLitros();
                    $inventarioDet->getInventario()->setInvLitros($invLitros + $inventarioDetTmp->getInvDetLitros());
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
                                    $inventarioDetTmp->getAlcohol()->getAlcId(),
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
                    $inventarioDet->getInventario()->setEntidad($user->getEntidad());
                    $inventarioDet->getInventario()->setAlcohol($alcoholDao->getAlcohol($inventarioDetTmp->getAlcohol()->getAlcId()));
                    $inventarioDet->getInventario()->setInvLitros($inventarioDetTmp->getInvDetLitros());
                    $inventarioDet->getInventario()->setAuditUserIns($user->getUsername());
                    $inventarioDet->getInventario()->setAuditDateIns(new \DateTime());
                    //$inventarioDet->getInventario()->setInvGrado($inventarioDetTmp->getInvGrado());
                    //$inventarioDet->getInventario()->setInvNombreEsp($inventarioDetTmp->getInvNombreEsp());
                }

                //## Detalle de inventario
                $inventarioDet->getInventario()->addInventarioDet($inventarioDet);
                $inventarioDet->setInvDetFecha(new \DateTime());

                //#### Auditoría 
                $inventarioDet->setAuditUserIns($user->getUsername());
                $inventarioDet->setAuditDateIns(new \DateTime());
            }

            //##################################################################################################
            var_dump($inventarioDet->getInventario()->getAlcohol());die;
            $inventarioDetDao->editInventarioDet($inventarioDet);
            $this->get('session')->setFlash('notice', 'Los datos se han guardado con éxito!!!');
            return $this->redirect(
                $this->generateUrl('MinSalSidPlaSCAProcesosBundle_mantCargarInventarioDet', 
                        array('invDetId'=>$inventarioDet->getInvDetId()))
                );
        }else{
            $this->get('session')->setFlash('notice', '**** ERROR **** Existen errores con el formulario, por favor revise los valores ingresados');
            
            $opciones = $this->getRequest()->getSession()->get('opciones');
                return $this->render('MinSalSidPlaSCAProcesosBundle:InventarioDet:showInventarioDet.html.twig', array(
                        'opciones' => $opciones, 
                        'form' => $form->createView(), 
                        'invDetId'=>$inventarioDet->getInvDetId()
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
        
        $form = $this->createForm(new InventarioDetType(), $inventarioDet);

        return $this->render('MinSalSidPlaSCAProcesosBundle:InventarioDet:showInventarioDet.html.twig', array(
            'form' => $form->createView(),
            'opciones' => $opciones,
            'invDetId' => $invDetId,
            'entNombComercial'=> $user->getEntidad()->getEntNombComercial()
        ));
    }
}
?>