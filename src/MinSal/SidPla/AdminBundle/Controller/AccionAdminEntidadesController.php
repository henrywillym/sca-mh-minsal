<?php

/**
 * Description of AccionAdminEntidadController
 *
 * @author Henry Willy Melara
 */

namespace MinSal\SidPla\AdminBundle\Controller;

use MinSal\SidPla\AdminBundle\Entity\Entidad;
use MinSal\SidPla\AdminBundle\EntityDao\CuotaDao;
use MinSal\SidPla\AdminBundle\EntityDao\EntidadDao;
use MinSal\SidPla\AdminBundle\Form\Type\EntidadType;
use MinSal\SidPla\UsersBundle\Entity\User;
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
        return $this->render('MinSalSidPlaAdminBundle:Entidad:mantEntidades.html.twig', 
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
        
        $emple = new Entidad();

        if ($numfilas != 0) {
            //array_multisort($entidades, SORT_ASC);
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
        //$request = $this->getRequest();
        //$user = new User();
        
        $entidadTmp = new Entidad();
        $form = $this->createForm(new EntidadType(),$entidadTmp);
        $form->bindRequest($request);
        
        $entidad = new Entidad();
        $entidadDao = new EntidadDao($this->getDoctrine());
        $user = $this->get('security.context')->getToken()->getUser();
        
        if( $entidadTmp->getEntId() ){
            $entidad = $entidadDao->getEntidad($entidadTmp->getEntId());
            //#### Auditoría 
            $entidad->setAuditUserUpd($user->getUsername());
            $entidad->setAuditDateUpd(new \DateTime());
        }else{
            //#### Auditoría 
            $entidad->setAuditUserIns($user->getUsername());
            $entidad->setAuditDateIns(new \DateTime());
        }
        
        $form = $this->createForm(new EntidadType(),$entidad);
        
        $form->bindRequest($request);
        if($form->isValid()){
            //$operacion = $request->get('oper');
            //$entidad = $form->getData();
            $entidad->setEntYear($entidad->getEntVenc()->format("Y"));
            
            //Eliminar cuotas de importación
            if(!$entidad->getEntImportador() || !$entidad->getEntComprador()){
                
                //$cuotaDao = new CuotaDao($this->getDoctrine());
                foreach( $entidad->getCuotas() as $cuota){
                    //$cuota = $cuotaDao->getCuota($cuota->getCuoId());
                    if(($cuota->getCuoTipo()=='I' && !$entidad->getEntImportador() || 
                       $cuota->getCuoTipo()=='L' && !$entidad->getEntComprador()) && $cuota->getAuditDeleted()==false
                    ){
                        $cuota->setAuditDeleted(true);
                        $cuota->setAuditUserUpd($user->getUsername());
                        $cuota->setAuditDateUpd(new \DateTime());
                    }
                    
                }
            }
            $entidadDao->editEntidad($entidad);
            $this->get('session')->setFlash('notice', 'Los datos se han guardado con éxito!!!');
            return $this->redirect(
                $this->generateUrl('MinSalSidPlaAdminBundle_mantCargarEntidad', 
                        array('entId'=>$entidad->getEntId()))
                );
        }else{
            $this->get('session')->setFlash('notice', '**** ERROR **** Existen errores con el formulario, por favor revise los valores ingresados');
            
            $opciones = $this->getRequest()->getSession()->get('opciones');
            return $this->render('MinSalSidPlaAdminBundle:Entidad:showEntidad.html.twig', 
                array('opciones' => $opciones, 'form' => $form->createView(), 'entId'=>$entidad->getEntId(), 'entHabilitado'=>$entidad->getEntHabilitado()));
        }
        //return $this->mantCargarEntidadAction($entidadTmp->getEntId());
    }
    
    
    /*
     * Se encarga de cargar los datos de la entidad para que sean editados
     */
    public function mantCargarEntidadAction($entId) {
        $opciones = $this->getRequest()->getSession()->get('opciones');
        //$entidad = new Entidad();
        //$form->bindRequest($this->getRequest());//Capturar datos de Request a Form
        
        $entidadDao = new EntidadDao($this->getDoctrine());
        $entidad = $entidadDao->getEntidad($entId);
        
        if( !$entidad ){
            $entidad = new Entidad();
        }
        
        $form = $this->createForm(new EntidadType(), $entidad);

        return $this->render('MinSalSidPlaAdminBundle:Entidad:showEntidad.html.twig', 
                array('form' => $form->createView(),'opciones'=>$opciones, 'entId'=>$entId, 'entHabilitado'=>$entidad->getEntHabilitado())
        );
    }
}
?>