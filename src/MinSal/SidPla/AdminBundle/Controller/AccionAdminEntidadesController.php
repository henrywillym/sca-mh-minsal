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
use MinSal\SidPla\AdminBundle\EntityDao\ListadoDNMDao;
use MinSal\SidPla\AdminBundle\EntityDao\RolDao;
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
        
        //$emple = new Entidad();

        if ($numfilas != 0) {
            //array_multisort($entidades, SORT_ASC);
            $entidad = new Entidad();
            $i = 0;
            
            foreach ($entidades as $ent) {
                $entidad->setEntImportador($ent['entImportador']);
                $entidad->setEntProductor($ent['entProductor']);
                $entidad->setEntComprador($ent['entComprador']);
                $entidad->setEntCompVend($ent['entCompVend']);
                $entidad->setEntHabilitado($ent['entHabilitado']);
                $entidad->setEntTipoPersona($ent['entTipoPersona']);
                
                $entidades[$i]['entImportadorText']= $entidad->getEntImportadorText();
                $entidades[$i]['entProductorText']= $entidad->getEntProductorText();
                $entidades[$i]['entCompradorText']= $entidad->getEntCompradorText();
                $entidades[$i]['entCompVendText']= $entidad->getEntCompVendText();
                $entidades[$i]['entHabilitadoText']= $entidad->getEntHabilitadoText();
                $entidades[$i]['entTipoPersonaText']= $entidad->getEntTipoPersonaText();
                $i=$i+1;
            }
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
        $autorizadoDNM = null;
        $autorizadoDNMText = null;
        $entidadTmp = new Entidad();
        $form = $this->createForm(new EntidadType(), $entidadTmp);
        $form->bindRequest($request);
        
        $entidad = new Entidad();
        $entidadDao = new EntidadDao($this->getDoctrine());
        $listadoDNMDao = new ListadoDNMDao($this->getDoctrine());
        
        $user = $this->get('security.context')->getToken()->getUser();
        
        if( $entidadTmp->getEntId() ){
            $entidad = $entidadDao->getEntidad($entidadTmp->getEntId());
            //#### Auditoría 
            $entidad->setAuditUserUpd($user->getUsername());
            $entidad->setAuditDateUpd(new \DateTime());
            
            //## Mensaje de validacion de DNM
            $year = new \DateTime();
            $autorizadoDNM = $listadoDNMDao->estaAutorizado($year->format('Y')+0, $entidad->getEntNrc(), $entidad->getEntNit());
            
            if(!$autorizadoDNM){
                $autorizadoDNMText = ListadoDNMDao::$MSG_ERROR_DNM_NOAUTH;
            }
        }else{
            //#### Auditoría 
            $entidad->setAuditUserIns($user->getUsername());
            $entidad->setAuditDateIns(new \DateTime());
        }
        
        $form = $this->createForm(new EntidadType(),$entidad);
        
        $form->bindRequest($request);
        if($form->isValid()){
            $entidad->setEntYear($entidad->getEntVenc()->format("Y"));

            //Eliminar cuotas de importación y compras locales
            if(!$entidad->getEntImportador() || !$entidad->getEntComprador()){

                //Se realiza una busqueda de todas las cuotas que no cumplen con el nuevo perfil (Importador, Productor, Comprador Local)
                //Luego se dejan eliminadas logicamente en la BD
                foreach( $entidad->getCuotas() as $cuota){
                    if(($cuota->getCuoTipo()=='I' && !$entidad->getEntImportador() || 
                       $cuota->getCuoTipo()=='L' && !$entidad->getEntComprador()) && $cuota->getAuditDeleted()==false
                    ){
                        $cuota->setAuditDeleted(true);
                        $cuota->setAuditUserUpd($user->getUsername());
                        $cuota->setAuditDateUpd(new \DateTime());
                    }

                }
            }

            //Se verifican todos los usuarios asociados a la Entidad/Empresa para que se actualicen los roles 
            //de acuerdo a las actividades de la empresa y la de cada uno de los usuarios
            $i=0;
            $usuarios = array();
            foreach( $entidad->getUsers() as $usuario){
                $rolDao = new RolDao($this->getDoctrine());

                $usuario->setRols($rolDao->getRolesEspecificos(
                        $entidad->getEntImportador(),
                        $entidad->getEntProductor(),
                        $entidad->getEntComprador(),
                        $entidad->getEntCompVend(),
                        $usuario->getUserTipo(),
                        $usuario->getUserInterno(),
                        $usuario->getUserInternoTipo()
                ));

                $usuarios[$i] = $usuario;
                $i+=1;
            }
            $entidad->setUsers($usuarios);

            $entidadDao->editEntidad($entidad);
            $this->get('session')->setFlash('notice', 'Los datos se han guardado con éxito!!!');
            return $this->redirect(
                $this->generateUrl('MinSalSidPlaAdminBundle_mantCargarEntidad', 
                        array('entId'=>$entidad->getEntId()))
                );
        }else{
            $this->get('session')->setFlash('notice', '**** ERROR **** Existen errores con el formulario, por favor revise los valores ingresados');
            
            $opciones = $this->getRequest()->getSession()->get('opciones');
                return $this->render('MinSalSidPlaAdminBundle:Entidad:showEntidad.html.twig', array(
                        'opciones' => $opciones, 
                        'form' => $form->createView(), 
                        'entId'=>$entidad->getEntId(), 
                        'entHabilitado'=>$entidad->getEntHabilitado(),
                        'autorizadoDNM' => $autorizadoDNM,
                        'autorizadoDNMText' => $autorizadoDNMText
                    )
                );
        }
    }
    
    
    /*
     * Se encarga de cargar los datos de la entidad para que sean editados
     */
    public function mantCargarEntidadAction($entId) {
        $opciones = $this->getRequest()->getSession()->get('opciones');
        
        $entidadDao = new EntidadDao($this->getDoctrine());
        $listadoDNMDao = new ListadoDNMDao($this->getDoctrine());
        $entidad = $entidadDao->getEntidad($entId);
        $autorizadoDNM = null;
        $autorizadoDNMText = null;
        
        if( !$entidad ){
            $entidad = new Entidad();
        }else{
            $year = new \DateTime();
            $autorizadoDNM = $listadoDNMDao->estaAutorizado($year->format('Y')+0, $entidad->getEntNrc(), $entidad->getEntNit());
            
            if(!$autorizadoDNM){
                $autorizadoDNMText = ListadoDNMDao::$MSG_ERROR_DNM_NOAUTH;
            }
        }
        
        $form = $this->createForm(new EntidadType(), $entidad);

        return $this->render('MinSalSidPlaAdminBundle:Entidad:showEntidad.html.twig', 
                array('form' => $form->createView(),
                    'opciones' => $opciones,
                    'entId' => $entId,
                    'entHabilitado' => $entidad->getEntHabilitado(),
                    'autorizadoDNM' => $autorizadoDNM,
                    'autorizadoDNMText' => $autorizadoDNMText
                )
        );
    }
}
?>