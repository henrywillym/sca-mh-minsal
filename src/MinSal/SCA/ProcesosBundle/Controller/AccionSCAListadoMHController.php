<?php


namespace MinSal\SCA\ProcesosBundle\Controller;

use MinSal\SCA\ProcesosBundle\Entity\ListadoMH;
use MinSal\SCA\ProcesosBundle\EntityDao\ListadoMHDao;
use MinSal\SCA\UsersBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
* Mantenimineto de carga de NIT/NRC de MH
* @author Henry Willy Melara
*/
class AccionSCAListadoMHController extends Controller {

    /**
     * Retorna la página que muestra los datos de las empresas registradas en MH 
     * 
     * @return HTML.twig
     */
    public function mantListadoMHVerAction() {
        $opciones = $this->getRequest()->getSession()->get('opciones');
        $user = $this->get('security.context')->getToken()->getUser();
        $year = date("Y", strtotime("+1 month"));
        
        if($user->getEntidad()!=null){
            return $this->render('MinSalSCAProcesosBundle:Default:mantNoEntidad.html.twig', array(
                        'opciones' => $opciones
                    )
            );
        }else{
            return $this->render('MinSalSCAProcesosBundle:ListadoMH:verListadoMH.html.twig', array(
                        'opciones' => $opciones,
                        'year' => $year
                    )
            );
        }
    }
    

    /*
     * Se encarga la pagina web para subir el archivo de datos NIT/NRC
     * 
     */
    public function mantListadoMHIngresoAction() {
        $opciones = $this->getRequest()->getSession()->get('opciones');
        $user = $this->get('security.context')->getToken()->getUser();
        
        $listadoMH = new ListadoMH();
        $year = date("Y", strtotime("+1 month"));

        $form = $this->createFormBuilder($listadoMH)
            ->add('file')
            ->getForm();
        
        if($user->getEntidad()!=null){
            return $this->render('MinSalSCAProcesosBundle:Default:mantNoEntidad.html.twig', array(
                        'opciones' => $opciones
                    )
            );
        }else{
            return $this->render('MinSalSCAProcesosBundle:ListadoMH:ingresarListadoMH.html.twig', array(
                        'form' => $form->createView(),
                        'opciones' => $opciones,
                        'year' => $year
                    )
            );
        }
    }
    /**
     * Devuelve el listado solicitudes que se encuentran en una etapa especifica
     * @return Response
     */
    public function consultarListadoMHJSONAction() {
        $user = $this->get('security.context')->getToken()->getUser();
        $listadoMHDao = new ListadoMHDao($this->getDoctrine());
        
        $year = date("Y", strtotime("+1 month"));
        $registros = $listadoMHDao->getListadoMH($year);

        $numfilas = count($registros);
        $i = 0;
        
        foreach ($registros as $reg) {
            $listadoMH = new ListadoMH();
            $listadoMH->setMhTipoPersona($reg['mhTipoPersona']);
            $registros[$i]['mhTipoPersonaText'] = $listadoMH->getMhTipoPersonaText();
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
        return $response;
    }
    
    /*
     * Se encarga de ejecutar las acciones de ingresar las solicitudes de importacion
     * del mantenimiento
     */
    public function mantListadoMHEdicionAction(Request $request) {
        $listadoMHFile = new ListadoMH();
        $user = $this->get('security.context')->getToken()->getUser();
        
        $form = $this->createFormBuilder($listadoMHFile)
            ->add('file')
            ->getForm();
        
        $form->bind($request);
        
        $listadoMHDao = new ListadoMHDao($this->getDoctrine());
        
        $year = date("Y", strtotime("+1 month"));
        
        if($form->isValid()){
            $listadoMHFile->upload();
            
            $handle = fopen($listadoMHFile->getAbsolutePath(), "r");
            $listadoMHDao->deleteAll($year);
            
            try{
                $i =0;
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    $num = count($data);
                    //echo "<p> $num fields in line $i: <br /></p>\n";
                    
                    //Debemos saltar el registro de encabezado
                    if($i== 0){
                        $i++;
                        continue;
                    }
                    
                    $listadoMH = new ListadoMH();
                    
                    $listadoMH->setMhYear($year);
                    $listadoMH->setMhNIT($data[0]);
                    $listadoMH->setMhNRC(str_pad($data[1],8,"0",STR_PAD_LEFT));
                    $listadoMH->setMhTipoPersona($data[4]);
                    
                    if($data[4] =='J'){
                        $listadoMH->setMhRazon($data[2]);
                    }else if($data[4] =='N'){
                        $listadoMH->setMhNombres($data[2]);
                        $listadoMH->setMhApellidos($data[3]);
                    }
                    
                    $listadoMH->setAuditUserIns($user->getUsername());
                    $listadoMHDao->add($listadoMH);
                    $i++;
                }
            }catch (Exception $e){
                var_dump($e);
            }
            
            if($handle != null){
                fclose($handle);
                unlink($listadoMHFile->getAbsolutePath());
                
                $listadoMHDao->commit();
            }
            
            $this->get('session')->setFlash('notice', 'Los datos se han guardado con éxito!!!');
            
            /*
            $opciones = $this->getRequest()->getSession()->get('opciones');
            return $this->render('MinSalSCAProcesosBundle:SolImportacionDet:ingresarListadoMH.html.twig', array(
                    'opciones' => $opciones, 
                    'form' => $form->createView()
                )
            );/**/
            return $this->redirect($this->generateUrl('MinSalSCAProcesosBundle_mantListadoMHVer'));
        }else{
            
            $this->get('session')->setFlash('notice', '**** ERROR **** Existen errores con el formulario, por favor revise los valores ingresados');

            $opciones = $this->getRequest()->getSession()->get('opciones');
            return $this->render('MinSalSCAProcesosBundle:SolImportacionDet:ingresarListadoMH.html.twig', array(
                    'opciones' => $opciones, 
                    'form' => $form->createView()
                )
            );
        }
    }
    
    
    
    public function mantListadoMHEdicionRowAction() {
        $request = $this->getRequest();
		
 	$mhId = $request->get('id');//aunque tenga ldnm_id siempre tomara lo que retornara del jqgrid id
        $mhYear = $request->get('mhYear');
	$mhNIT = $request->get('mhNIT');
        $mhNRC = $request->get('mhNRC');
        $mhTipoPersona = $request->get('mhTipoPersona');       
        $mhNombres = $request->get('mhNombres');
        $mhApellidos = $request->get('mhApellidos');
	$mhRazon = $request->get('mhRazon');
	$operacion = $request->get('oper');
        
        $listadoMH = new ListadoMH();
        $listadoMHDao = new ListadoMHDao($this->getDoctrine());
        
        $user = $this->get('security.context')->getToken()->getUser();

        if ($operacion == 'edit' || $operacion == 'del') {
            $listadoMH = $listadoMHDao->getRegMH($mhId);
        }else{
            $mhId = null;
            $mhYear = date("Y", strtotime("+1 month"));
        }
        
        if ($operacion != 'del') {
            
            $listadoMH->setMhNIT($mhNIT);
            $listadoMH->setMhNRC($mhNRC);
            $listadoMH->setMhYear($mhYear);
            $listadoMH->setMhTipoPersona($mhTipoPersona);
            $listadoMH->setMhNombres($mhNombres);
            $listadoMH->setMhApellidos($mhApellidos);
            $listadoMH->setMhRazon($mhRazon);
            
            $cantidad = $listadoMHDao->existeReg($mhId, $mhYear, $mhNIT, $mhNRC);
            if( $cantidad>0 ){
                $resp = new Response('{"status":false,"msg":"Registro duplicado, ya existe(n) '.$cantidad.' registro(s) con estos datos de NIT o NRC."}');
                return $resp;
            }
        }
        
        if ($operacion == 'edit') {
            //#### Auditoría 
            $listadoMH->setAuditUserUpd($user->getUsername());
            $listadoMH->setAuditDateUpd(new \DateTime());
            $listadoMHDao->editRegMH($listadoMH);

        }else if ($operacion == 'del') {
            //#### Auditoría 
            $listadoMH->setAuditUserUpd($user->getUsername());
            $listadoMH->setAuditDateUpd(new \DateTime());

            $listadoMHDao->deleteRegMH($listadoMH);
            
        }else if ($operacion == 'add') {
            $listadoMH->setAuditUserIns($user->getUsername());
            $listadoMH->setAuditDateIns(new \DateTime());
            $listadoMHDao->editRegMH($listadoMH);
        }

        return new Response('{"status":true,"msg":""}');
    }
    
}
?>