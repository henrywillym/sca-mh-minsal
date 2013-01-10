<?php

/*
  SCA - MINSAL MH 
  
/**
 * Description of AccionAdminListadoDNMController
 *
 * @author Daniel Diaz
 */

namespace MinSal\SidPla\AdminBundle\Controller;

use MinSal\SidPla\AdminBundle\EntityDao\ListadoDNMDao;
use MinSal\SidPla\AdminBundle\Entity\ListadoDNM;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AccionAdminListadoDNMController extends Controller {

    /**
     *  Esta es la ListadoDNM del Action que permitira obtener los valores de 
     *  un formulario, luego instancia una clase ListadoDNMDao para
     *  manejar la persistencia de la entidad ListadoDNMDao, y retornara los
     *  mensajes de exito/fracaso del sistema.
     */
    
    /*
    public function addOcpAction(Request $peticion) {
        $opc = new ListadoDNMSistema();
        $form = $this->createForm(new ListadoDNMSistemaType(), $opc);

        if ($peticion->getMethod() == 'POST') {
            $form->bindRequest($peticion);

            if ($form->isValid()) {
                $dnmDao = new ListadoDNMDao($this->getDoctrine());
                $mensajesSistema = $dnmDao->addListadoDNM($opc);
                return new Response($mensajesSistema[0] . ' ' . $mensajesSistema[1]);
            }
        }
        return $this->redirect($this->generateUrl('MinSalSidPlaAdminBundle_homepage'));
    }*/

    /*
     * Crea un nuevo formulario, para ser utilizado, para crear una Nueva ListadoDNM del sistema.
     */

 
 /*   public function nuevaOpcAction() {
        $ListadoDNMes = $this->getRequest()->getSession()->get('ListadoDNMes');

        $opc = new ListadoDNMSistema();

        $form = $this->createForm(new ListadoDNMSistemaType(), $opc);
        return $this->render('MinSalSidPlaAdminBundle:Default:ListadoDNMFormTemplate.html.twig', array('form' => $form->createView(), 'ListadoDNMes' => $ListadoDNMes));
    }
	*/

    /*
     * Permite recuperar roles del sistema.
     * 
     */

    public function ConsultarListadoDNMAction() {
        $dnmDao = new ListadoDNMDao($this->getDoctrine());
        $ListadoDNMes = $dnmDao->getListado();

        $numfilas = count($ListadoDNMes);

        $opc = new ListadoDNM();
        $i = 0;

        foreach ($ListadoDNMes as $listDNM) {
			
            $rows[$i]['id'] = $listDNM->getLdnm_id();
            $rows[$i]['cell'] = array($listDNM->getLdnm_id(),
                $listDNM->getLdnm_year(),
                $listDNM->getLdnm_nit(),
                $listDNM->getLdnm_nrc(),
				$listDNM->getLdnm_tipo_persona(),
                $listDNM->getLdnm_nombres(),
				$listDNM->getLdnm_apellidos(),
				 $listDNM->getLdnm_razon());
            $i++;
        }

        if ($numfilas != 0) {
            array_multisort($rows, SORT_ASC);
        } else {
            $rows[0]['id'] = 0;
            $rows[0]['cell'] = array(' ', ' ', ' ', ' ', ' ');
        }

        $datos = json_encode($rows);
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
     * Mantenimineto de ListadoDNMes.
     * 
     */

    public function LoadListadoDNMAction() {
        $opciones = $this->getRequest()->getSession()->get('opciones');
        
        return $this->render('MinSalSidPlaAdminBundle:ListadoDNM:manttListadoDNMForm.html.twig', array(
            'opciones' => $opciones
        ));
    }

    public function manttListadoDNMedicionAction() {
        $request = $this->getRequest();
		
 		$id = $request->get('id');//aunque tenga ldnm_id siempre tomara lo que retornara del jqgrid id
        $nombres = $request->get('ldnm_nombres');
		$apellidos = $request->get('ldnm_apellidos');
        $year = $request->get('ldnm_year');
        $nit= $request->get('ldnm_nit');       
        $nrc = $request->get('ldnm_nrc');
        $tipo_persona = $request->get('ldnm_tipo_persona');
		$razon = $request->get('ldnm_razon');
		$operacion = $request->get('oper');

        $dnmDao = new ListadoDNMDao($this->getDoctrine());

        if ($operacion == 'edit') {
            $dnmDao->editListadoDNM($id, $nombres, $apellidos, $year, $nit,$nrc,$tipo_persona,$razon);
        }

        if ($operacion == 'del') {
           $dnmDao->delListadoDNM($id);
        }

        if ($operacion == 'add') {
            $dnmDao->addListadoDNM($id, $nombres, $apellidos, $year, $nit,$nrc,$tipo_persona,$razon);
        }

        return new Response("{sc:true,msg:''}");
    }

}
