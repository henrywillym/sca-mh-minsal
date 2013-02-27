<?php
namespace MinSal\SCA\ProcesosBundle\EntityDao;

use MinSal\SCA\ProcesosBundle\Entity\RegMensual;


/**
 * RepositoryClass de RegMensual
 *
 * @author Daniel E. Diaz
 */
class RegMensualDao {
    var $doctrine;
    var $repositorio;
    var $em;
    

    function __construct($doctrine) {
        $this->doctrine = $doctrine;
        $this->em = $this->doctrine->getEntityManager();
        $this->repositorio = $this->doctrine->getRepository('MinSalSCAProcesosBundle:RegMensual');
    }

    /**
     * Obtiene todos las entidades.
     * 
     * @return Array
     */

    public function getRegMensual($id) {
     
         $registros = $this->em->createQuery("SELECT E
                                          FROM MinSalSCAProcesosBundle:RegMensual E
                                          WHERE E.RegMenId = :RegMenId")
                ->setParameter('RegMenId',$id);
        $result= $registros->getResult();
        
        if($result !=null && count($result)>0){
            return $result[0];
        }else{
            return null;
        }
    }
    
    public function getJasonRegMensual($id) {
     
         $registros = $this->em->createQuery("SELECT E.RegMenId,E.regveNIT,E.regveNombre,E.regveLitros,
                                              A.alcNombre,E.regveFecha,E.regveMinsal,E.regvedgii
                                              FROM MinSalSCAProcesosBundle:RegMensual E , MinSalSCAAdminBundle:Alcohol A 
                                              WHERE E.entidad = :entid
                                              AND E.alcohol=A.alcId
                                              AND E.auditDeleted = false")
                ->setParameter('entid',$id);
        return $registros->getArrayResult();
    }
    
   	public function addRegMensual($fecha,$idEnt,$nit, $nombcliente, $reg_user, $n_res,$AlcId,$RegMensualLitros,$RegMensualGrado) {
            
            $RegMensual=new RegMensual(); 
           

            	//$RegMensual->setregveid($id);
                $RegMensual->setRegveNIT($nit);
                $RegMensual->setRegveNombre($nombcliente);
                $RegMensual->setRegveMinsal($reg_user);
                $RegMensual->setRegveFecha($fecha);
                $RegMensual->setRegvedgii($n_res);                
		$RegMensual->setAlcohol($AlcId);
		$RegMensual->setRegveLitros($RegMensualLitros);
                $RegMensual->setRegveGrado($RegMensualGrado);
                $RegMensual->setEntidad($idEnt);
                $RegMensual->setAuditDeleted("false");
  
            $this->em->persist($RegMensual);
	    $this->em->flush();	    
	    $matrizMensajes = array('El proceso de almacenar termino con exito', 'RegMensual '.$RegMensual->getRegMenId());
      
            return $matrizMensajes;
	}
        
        
        /*
         * Actualizar RegMensual
         */
        public function editRegMensual($id,$idEnt, $fecha,$nit, $nombcliente, $reg_user, $n_res,$AlcId,$RegMensualLitros,$RegMensualGrado){
            
            //$RegMensual= new RegMensual();            
            $RegMensual=$this->repositorio->find($id);
             
//            if(!$RegMensual){
//                throw $this->createNotFoundException('No se encontro Registro de Venta con ese id '.$id);
//            }
            	$RegMensual->setRegMenId($id);
                $RegMensual->setregveNIT($nit);
                $RegMensual->setregveNombre($nombcliente);
                $RegMensual->setregveMinsal($reg_user);
                $RegMensual->setregveFecha($fecha);
                $RegMensual->setregvedgii($n_res);                
		$RegMensual->setAlcohol($AlcId);
		$RegMensual->setregveLitros($RegMensualLitros);
                $RegMensual->setregveGrado($RegMensualGrado);
                $RegMensual->setEntidad($idEnt);
                $RegMensual->setAuditDeleted("false");
            
            $this->em->persist($RegMensual);	
            $this->em->flush();
            
            $matrizMensajes = array('El proceso de Actualizar termino con exito', 'RegMensual '.$RegMensual->getRegMenId());

            return $matrizMensajes;
        }
        
        
        /*
         * eliminar RegMensual
         */
        public function delRegMensual($id){            
  
            //$RegMensual= new RegMensual();            
            $RegMensual=$this->repositorio->find($id);
                      
            if(!$RegMensual){
                throw $this->createNotFoundException('No se encontro Registro de Venta con ese id '.$id);
            }
            
            $RegMensual->setAuditDeleted("true");
            
            $this->em->persist($RegMensual);
            $this->em->flush();
            
            $matrizMensajes = array('El proceso de eliminar termino con exito', 'RegMensual '.$RegMensual->getRegMenId());

            return $matrizMensajes;
        }
    
    /*
    public function existeRegMensual($entId) {
        $result = $this->em->createQuery("SELECT count(e) 
                                          FROM MinSalSCAProcesosBundle:RegMensuale
                                          WHERE e.entId = :entId")
                 ->setParameter('entId',$entId);
        return $result->getSingleScalarResult();
    }/**/
}
?>