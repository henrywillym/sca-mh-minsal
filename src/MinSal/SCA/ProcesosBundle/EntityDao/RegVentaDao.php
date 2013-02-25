<?php
namespace MinSal\SCA\ProcesosBundle\EntityDao;

use MinSal\SCA\ProcesosBundle\Entity\RegVenta;
use MinSal\SCA\UsersBundle\Entity\User;

/**
 * RepositoryClass de RegVenta
 *
 * @author Daniel E. Diaz
 */
class RegVentaDao {
    var $doctrine;
    var $repositorio;
    var $em;
    

    function __construct($doctrine) {
        $this->doctrine = $doctrine;
        $this->em = $this->doctrine->getEntityManager();
        $this->repositorio = $this->doctrine->getRepository('MinSalSCAProcesosBundle:RegVenta');
    }

    /**
     * Obtiene todos las entidades.
     * 
     * @return Array
     */

    public function getRegVenta($id) {
     
         $registros = $this->em->createQuery("SELECT E
                                          FROM MinSalSCAProcesosBundle:RegVenta E
                                          WHERE E.RegVentaId = :RegVentaId")
                ->setParameter('RegVentaId',$id);
        $result= $registros->getResult();
        
        if($result !=null && count($result)>0){
            return $result[0];
        }else{
            return null;
        }
    }
    
    public function getJasonRegVenta($id) {
     
         $registros = $this->em->createQuery("SELECT E
                                          FROM MinSalSCAProcesosBundle:RegVenta E
                                          WHERE E.entidad = :entid")
                ->setParameter('entid',$id);
        return $registros->getArrayResult();
    }
    
    public function findRegVenta($entId, $alcId, $invGrado, $invNombreEsp) {
        $registros = $this->em->createQuery("SELECT E
                                          FROM MinSalSCAProcesosBundle:RegVenta E JOIN E.entidad A JOIN E.alcohol B
                                          WHERE A.entId = :entId
                                            AND B.alcId = :alcId
                                            AND E.invGrado = :invGrado
                                            AND E.invNombreEsp = :invNombreEsp")
                ->setParameter('entId', $entId)
                ->setParameter('alcId', $alcId)
                ->setParameter('invGrado', $invGrado)
                ->setParameter('invNombreEsp', $invNombreEsp);
        $result= $registros->getResult();
        
        if($result !=null && count($result)>0){
            return $result[0];
        }else{
            return null;
        }
    }

   	public function addRegVenta($fecha,$idEnt,$nit, $nombcliente, $reg_user, $n_res,$AlcId,$RegVentaLitros,$RegVentaGrado) {
            
            $RegVenta=new RegVenta(); 
           

            	//$RegVenta->setregveid($id);
                $RegVenta->setRegveNIT($nit);
                $RegVenta->setRegveNombre($nombcliente);
                $RegVenta->setRegveMinsal($reg_user);
                $RegVenta->setRegveFecha($fecha);
                $RegVenta->setRegvedgii($n_res);                
		$RegVenta->setAlcohol($AlcId);
		$RegVenta->setRegveLitros($RegVentaLitros);
                $RegVenta->setRegveGrado($RegVentaGrado);
                $RegVenta->setEntidad($idEnt);
                $RegVenta->setAuditDeleted("false");
  
            $this->em->persist($RegVenta);
	    $this->em->flush();	    
	    $matrizMensajes = array('El proceso de almacenar termino con exito', 'RegVenta '.$RegVenta->getRegVentaId());
      
            return $matrizMensajes;
	}
        
        
        /*
         * Actualizar RegVenta
         */
        public function editRegVenta($id,$idEnt, $fecha,$nit, $nombcliente, $reg_user, $n_res,$AlcId,$RegVentaLitros,$RegVentaGrado){
            
            $RegVenta= new RegVenta();            
            $RegVenta=$this->repositorio->find($id);
            
            $RegVenta= new RegVenta();
             
            if(!$RegVenta){
                throw $this->createNotFoundException('No se encontro Registro de Venta con ese id '.$id);
            }

            	$RegVenta->setregveid($id);
                $RegVenta->setregveNIT($nit);
                $RegVenta->setregveNombre($nombcliente);
                $RegVenta->setregveMinsal($reg_user);
                $RegVenta->setregveFecha($fecha);
                $RegVenta->setregvedgii($n_res);                
		$RegVenta->setAlcohol($AlcId);
		$RegVenta->setregveLitros($RegVentaLitros);
                $RegVenta->setregveGrado($RegVentaGrado);
                $RegVenta->setEntidad($idEnt);
                $RegVenta->setAuditDeleted("false");
            
            $this->em->persist($RegVenta);	
            $this->em->flush();
            
            $matrizMensajes = array('El proceso de Actualizar termino con exito', 'RegVenta '.$RegVenta->getRegVentaId());
            $this->get('session')->setFlash('notice', 'Los datos se han guardado con éxito!');
            return $matrizMensajes;
        }
        
        
        /*
         * eliminar RegVenta
         */
        public function delRegVenta($id){            
  
            $RegVenta= new RegVenta();            
            $RegVenta=$this->repositorio->find($id);
            
            $RegVenta= new RegVenta();
             
            if(!$RegVenta){
                throw $this->createNotFoundException('No se encontro Registro de Venta con ese id '.$id);
            }
				
            $auditUser = $this->container->get('security.context')->getToken()->getUser();
            $idEnt=$auditUser->getEntidad()->getEntId();

            $RegVenta->setAuditDeleted("true");
            
            $this->em->flush();
            
            $matrizMensajes = array('El proceso de eliminar termino con exito', 'RegVenta '.$RegVenta->getregveid());

            return $matrizMensajes;
        }
    
    /*
    public function existeRegVenta($entId) {
        $result = $this->em->createQuery("SELECT count(e) 
                                          FROM MinSalSCAProcesosBundle:RegVentae
                                          WHERE e.entId = :entId")
                 ->setParameter('entId',$entId);
        return $result->getSingleScalarResult();
    }/**/
}
?>