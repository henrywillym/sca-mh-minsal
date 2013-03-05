<?php
namespace MinSal\SCA\ProcesosBundle\EntityDao;

use MinSal\SCA\ProcesosBundle\Entity\RegVenta;


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
     
         $registros = $this->em->createQuery("SELECT E.RegVentaId,E.regveNIT,E.regveNombre,E.regveLitros,
                                              A.alcNombre,E.regveFecha,E.regveMinsal,E.regvedgii
                                              FROM MinSalSCAProcesosBundle:RegVenta E , MinSalSCAAdminBundle:Alcohol A 
                                              WHERE E.entidad = :entid
                                              AND E.alcohol=A.alcId
                                              AND E.auditDeleted = false")
                ->setParameter('entid',$id);
        return $registros->getArrayResult();
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
            
            //$RegVenta= new RegVenta();            
            $RegVenta=$this->repositorio->find($id);
             
//            if(!$RegVenta){
//                throw $this->createNotFoundException('No se encontro Registro de Venta con ese id '.$id);
//            }
            	$RegVenta->setRegVentaId($id);
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

            return $matrizMensajes;
        }
        
        
        /*
         * eliminar RegVenta
         */
        public function delRegVenta($id){            
  
            //$RegVenta= new RegVenta();            
            $RegVenta=$this->repositorio->find($id);
                      
            if(!$RegVenta){
                throw $this->createNotFoundException('No se encontro Registro de Venta con ese id '.$id);
            }
            
            $RegVenta->setAuditDeleted("true");
            
            $this->em->persist($RegVenta);
            $this->em->flush();
            
            $matrizMensajes = array('El proceso de eliminar termino con exito', 'RegVenta '.$RegVenta->getRegVentaId());

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
        
        public function getGrado($id) {
            //OBTIENE EL GRADO DESDE LA TABLA CUOTA PARA MOSTRARLO EN EL CAMPO GRADO DEEL FORMULARIO REGVENTA
     $registros = $this->em->createQuery("SELECT E.cuoGrado
                                          FROM MinSalSCAAdminBundle:Cuota E
                                          WHERE E.cuoId = :cuoid ")
                ->setParameter('cuoid',$id);
        $result= $registros->getArrayResult();
       $grado=0;
         foreach($result as $gr){
            $grado=$gr['cuoGrado'];
        }
        
            return $grado ;
    }
}
?>