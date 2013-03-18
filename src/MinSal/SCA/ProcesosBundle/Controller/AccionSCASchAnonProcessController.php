<?php


namespace MinSal\SCA\ProcesosBundle\Controller;

use MinSal\SCA\AdminBundle\EntityDao\EntidadDao;
use MinSal\SCA\ProcesosBundle\Entity\Estado;
use MinSal\SCA\ProcesosBundle\Entity\InventarioDet;
use MinSal\SCA\ProcesosBundle\Entity\SolImportacionDet;
use MinSal\SCA\ProcesosBundle\Entity\SolLocalDet;
use MinSal\SCA\ProcesosBundle\Entity\Transicion;
use MinSal\SCA\ProcesosBundle\EntityDao\InventarioDetDao;
use MinSal\SCA\ProcesosBundle\EntityDao\SolImportacionDao;
use MinSal\SCA\ProcesosBundle\EntityDao\SolLocalDao;
use MinSal\SCA\ProcesosBundle\EntityDao\TransicionDao;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
* Mantenimineto de Ingreso de Solicitudes Locales
* @author Henry Willy Melara
*/
class AccionSCASchAnonProcessController extends Controller {

    /**
     * Proceso encargado de realizar la expiración de solicitudes de 
     * Importacion y Registro Local de Compras
     * 
     */
    public function expiracionSolicitudesAction() {
        /*###########################################
         ##* Expiración de Solicitudes Importación ##
         ###########################################*/
        $solImportacionDao = new SolImportacionDao($this->getDoctrine());
        $transicionDao = new TransicionDao($this->getDoctrine());
        
        $solicitudes = $solImportacionDao->getSolicitudesExpiradas();
        $contSolImp = 0;
        
        foreach($solicitudes as $sol){
            $transiciones = $transicionDao->getTransicionesSiguientes($sol->getTransicion()->getTraId());
            
            foreach($transiciones as $tran){
                $estId = $tran->getEstado()->getEstId();
                
                if($estId == Estado::$CANCELADO){
                    $sol->setTransicion($tran);
                    $sol->setSolImpComentario('Solicitud Expirada');
                    $sol->setAuditUserUpd('SCA');
                    $sol->setAuditDateUpd(new \DateTime());
                    
                    $solImportacionDet = $sol->getSolImportacionesDet();
                    $solImportacionDet = $solImportacionDet[0];

                    $solImportacionDao->editSolImportacion($sol);
                    
                    $this->generarEmailSolImpNotificacion($solImportacionDet,$tran);
                    $contSolImp = $contSolImp+1;
                }
            }
        }
        
        /*###############################################
         ##* Expiracion de Registros de compra local  ###
         ################################################*/
        $solLocalDao = new SolLocalDao($this->getDoctrine());
        $inventarioDetDao = new InventarioDetDao($this->getDoctrine());
        
        $solicitudes = $solLocalDao->getSolicitudesExpiradas();
        $contSolLocal = 0;
        
        foreach($solicitudes as $sol){
            $transiciones = $transicionDao->getTransicionesSiguientes($sol->getTransicion()->getTraId());
            
            foreach($transiciones as $tran){
                $estId = $tran->getEstado()->getEstId();
                
                if($estId == Estado::$CANCELADO){
                    //Buscamos el encabezado para realizar la transicion
                    $solLocalDet = $sol->getSolLocalesDet();
                    $solLocalDet = $solLocalDet[0];
                    $localDetId = $solLocalDet->getLocalDetId();

                    $invsDetTemp = $solLocalDet->getInventariosDet();
                    foreach($invsDetTemp as $tmp){
                        if( $solLocalDet->getSolLocal()->getEntidad()->getEntId() != $tmp->getInventario()->getEntidad()->getEntId()){
                            $inventarioProv = $tmp->getInventario();
                        }
                    }
                    
                    /*NOTA: Solo se busca el registro de inventario que esten en R (reserva) para eliminarse
                     * Los demás se asumen que si ya entraron a inventario no hay reversa 
                     */
                    $inventarioDetTmp = $inventarioDetDao->findInventarioDet($inventarioProv->getInvId(), $localDetId, 'R');
                    $inventarioDetTmp = $this->eliminarInventarioDetProveedorAction($inventarioDetTmp);
                    
                    $sol->setTransicion($tran);
                    $sol->setSolLocalComentario('Solicitud Expirada');
                    $sol->setAuditUserUpd('SCA');
                    $sol->setAuditDateUpd(new \DateTime());
                    
                    $solLocalDao->editSolLocal($sol);

                    $this->generarEmailSolLocalNotificacion($solLocalDet,$tran);
                    $contSolLocal = $contSolLocal+1;
                }
            }
        }
        
        return new Response('ok -> SolImportacion Expiradas ='.$contSolImp.'   SolLocal Expiradas = '.$contSolLocal);
    }
    
    /**
     * Eliminacion logica del registro en la tabla. Se encargada colocar el flag audit_deleted =true
     * 
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    private function eliminarInventarioDetProveedorAction(InventarioDet $inventarioDet){
        
        //Buscamos el encabezado para quitarle la cantidad a eliminar
        $inventarioOld = $inventarioDet->getInventario();
        
        $invLitros = $inventarioOld->getInvLitros();
        $invReservado = $inventarioOld->getInvReservado();
        
        if($inventarioDet->getInvDetAccion() == '+'){
            $inventarioOld->setInvLitros($invLitros - $inventarioDet->getInvDetLitros());
        
        }else if($inventarioDet->getInvDetAccion() == 'R'){
            //$inventarioOld->setInvLitros($invLitros - $inventarioDet->getInvDetLitros());
            $inventarioOld->setInvReservado($invReservado - $inventarioDet->getInvDetLitros());
            
        }else if($inventarioDet->getInvDetAccion() == '-'){
            $inventarioOld->setInvLitros($invLitros + $inventarioDet->getInvDetLitros());
        }
        
        $inventarioOld->setAuditUserUpd('SCA');
        $inventarioOld->setAuditDateUpd(new \DateTime());
        
        $inventarioDet->setAuditUserUpd('SCA');
        $inventarioDet->setAuditDateUpd(new \DateTime());
        $inventarioDet->setAuditDeleted(true);
        $inventarioDet->setInvDetComentario("Solicitud #".$inventarioDet->getSolLocalDet()->getLocalDetId()." Cancelada x Vencimiento");
        
        return $inventarioDet;
    }
    
    
    private function generarEmailSolImpNotificacion(SolImportacionDet $solImportacionDet, Transicion $transicion){
        $transicionDao = new TransicionDao($this->getDoctrine());
        $entidadDao = new EntidadDao($this->getDoctrine());
        
        $impDetId = $solImportacionDet->getImpDetId();
        $etpNombre = $transicion->getEtpFin()->getEtpNombre();
        $entNombComercial = $solImportacionDet->getSolImportacion()->getEntidad()->getEntNombComercial();
        $traId = $transicion->getTraId();
        $entId = $solImportacionDet->getSolImportacion()->getEntidad()->getEntId();
        
                            
        $url = urlencode($this->generateUrl('MinSalSCAProcesosBundle_mantCargarSolImportacion', array('impDetId' => $impDetId), true));
        $url = $this->generateUrl('MinSalSCABundle_homepage', array(), true). '?url='.$url;
        
        $subject = 'Cancelación automática de Solicitud #'.$impDetId;
        $emails = $transicionDao->getEmailsXTransicion($entId, $traId);
        
        if($transicion->getTraNotificaEmpresa()){
            $emailsXEmpresa = $entidadDao->getEmailsXEmpresa($entId);
            
            foreach($emailsXEmpresa as $reg){
                if(!in_array($reg, $emails)){
                    $emails[] = $reg;
                }
            }
        }
        
        foreach($emails as $email){
            $message = \Swift_Message::newInstance($subject)
                ->setFrom(array($this->container->getParameter('contact_email') => 'SCA'))
                ->setTo($email) 
                ->setBody($this->renderView('MinSalSCAProcesosBundle:SolImportacionDet\Email:SolicitudExpirada.html.twig', array(
                            'solImpId' => $impDetId,
                            'entNombComercial' => $entNombComercial,
                            'etpNombre' => $etpNombre,
                            'url' => $url
                        )
                    ), 'text/html'
                )->addPart($this->renderView('MinSalSCAProcesosBundle:SolImportacionDet\Email:SolicitudExpirada.txt.twig', array(
                            'solImpId' => $impDetId,
                            'entNombComercial' => $entNombComercial,
                            'etpNombre' => $etpNombre,
                            'url' => $url
                        )
                    ), 'text/plain'
                );

            $this->get('mailer')->send($message);
        }
    }
    
    
    private function generarEmailSolLocalNotificacion(SolLocalDet $solLocalDet, Transicion $transicion){
        $transicionDao = new TransicionDao($this->getDoctrine());
        $entidadDao = new EntidadDao($this->getDoctrine());
        
        $localDetId = $solLocalDet->getLocalDetId();
        $etpNombre = $transicion->getEtpFin()->getEtpNombre();
        $entNombComercial = $solLocalDet->getSolLocal()->getEntidad()->getEntNombComercial();
        $traId = $transicion->getTraId();
        $entId = $solLocalDet->getSolLocal()->getEntidad()->getEntId();
        
                            
        $url = urlencode($this->generateUrl('MinSalSCAProcesosBundle_mantCargarSolLocal', array('localDetId' => $localDetId), true));
        $url = $this->generateUrl('MinSalSCABundle_homepage', array(), true). '?url='.$url;
        
        $subject = 'Cancelación automática de Registro Compra Local #'.$localDetId;
        $emails = $transicionDao->getEmailsXTransicion($entId, $traId);
        
        if($transicion->getTraNotificaEmpresa()){
            $emailsXEmpresa = $entidadDao->getEmailsXEmpresa($entId);
            
            foreach($emailsXEmpresa as $reg){
                if(!in_array($reg, $emails)){
                    $emails[] = $reg;
                }
            }
        }
        
        foreach($emails as $email){
            $message = \Swift_Message::newInstance($subject)
                ->setFrom(array($this->container->getParameter('contact_email') => 'SCA'))
                ->setTo($email) 
                ->setBody($this->renderView('MinSalSCAProcesosBundle:SolLocalDet\Email:SolicitudExpirada.html.twig', array(
                            'solLocalId' => $localDetId,
                            'entNombComercial' => $entNombComercial,
                            'etpNombre' => $etpNombre,
                            'url' => $url
                        )
                    ), 'text/html'
                )->addPart($this->renderView('MinSalSCAProcesosBundle:SolLocalDet\Email:SolicitudExpirada.txt.twig', array(
                            'solLocalId' => $localDetId,
                            'entNombComercial' => $entNombComercial,
                            'etpNombre' => $etpNombre,
                            'url' => $url
                        )
                    ), 'text/plain'
                );

            $this->get('mailer')->send($message);
        }
    }
}
?>