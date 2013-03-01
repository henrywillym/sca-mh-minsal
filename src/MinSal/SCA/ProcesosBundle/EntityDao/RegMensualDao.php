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
     
 $registros = $this->em->createQuery("
                        SELECT E.RegMenId, E.regmen_mes,E.regmen_year,E.regmen_excedente_ant,
                        (E.regmen_prod + E.regmen_imp + E.regmen_compra_local) t_ent,
                 (E.regmen_venta_local + E.regmen_venta_inter + E.regmen_utilizacion + E.regmen_perdida) t_sal, 
 (E.regmen_excedente_ant + (E.regmen_prod + E.regmen_imp + E.regmen_compra_local) - (E.regmen_venta_local + E.regmen_venta_inter + E.regmen_utilizacion + E.regmen_perdida)) inv_fin
                                      FROM MinSalSCAProcesosBundle:RegMensual E  
                                      WHERE E.entidad = :entid
                                      AND E.auditDeleted = false")
                ->setParameter('entid',$id);
        return $registros->getArrayResult();
    }
    
   	public function addRegMensual($year,$idEnt,$regmen_mes, $regmen_exc, $regmen_prod, $regmen_imp,$regmen_c_l,$regmen_v_l,$regmen_v_i,$regmen_util,$regmen_perd,$user) {
            
            $RegMensual=new RegMensual(); 
           

          $RegMensual->setEntidad($idEnt);
          $RegMensual->setRegmenyear($year);
          $RegMensual->setRegmenmes($regmen_mes);
          $RegMensual->setRegmenexcedenteant($regmen_exc);
          $RegMensual->setRegmenprod($regmen_prod);
          $RegMensual->setRegmenimp($regmen_imp);
          $RegMensual->setRegmencompralocal($regmen_c_l);
          $RegMensual->setRegmenventalocal($regmen_v_l);
          $RegMensual->setRegmenutilizacion($regmen_util);
          $RegMensual->setRegmenventainter($regmen_v_i);
          $RegMensual->setRegmenperdida($regmen_perd);
                $RegMensual->setAudituserins($user->getUsername());
                $RegMensual->setAuditdateins(new \DateTime());
                $RegMensual->setAudituserupd($user->getUsername());
                $RegMensual->setAuditdateupd(new \DateTime());
                $RegMensual->setAuditDeleted("false");
                
                
  
            $this->em->persist($RegMensual);
	    $this->em->flush();	    
	    $matrizMensajes = array('El proceso de almacenar termino con exito', 'RegMensual '.$RegMensual->getRegMenId());
      
            return $matrizMensajes;
	}
        
        
        /*
         * Actualizar RegMensual
         */
        public function editRegMensual($id,$idEnt,$year,$regmen_mes, $regmen_exc, $regmen_prod, $regmen_imp,$regmen_c_l,$regmen_v_l,$regmen_v_i,$regmen_util,$regmen_perd,$user){
            
            //$RegMensual= new RegMensual();            
            $RegMensual=$this->repositorio->find($id);
             
//            if(!$RegMensual){
//                throw $this->createNotFoundException('No se encontro Registro de Venta con ese id '.$id);
//            }
          
        $RegMensual->setEntidad($idEnt);
          $RegMensual->setRegmenyear($year);
          $RegMensual->setRegmenmes($regmen_mes);
          $RegMensual->setRegmenexcedenteant($regmen_exc);
          $RegMensual->setRegmenprod($regmen_prod);
          $RegMensual->setRegmenimp($regmen_imp);
          $RegMensual->setRegmencompralocal($regmen_c_l);
          $RegMensual->setRegmenventalocal($regmen_v_l);
          $RegMensual->setRegmenutilizacion($regmen_util);
          $RegMensual->setRegmenventainter($regmen_v_i);
          $RegMensual->setRegmenperdida($regmen_perd);
                $RegMensual->setAudituserupd($user->getUsername());
                $RegMensual->setAuditdateupd(new \DateTime());
                $RegMensual->setAuditDeleted("false");
            
            $this->em->persist($RegMensual);	
            $this->em->flush();
            
            $matrizMensajes = array('El proceso de Actualizar termino con exito', 'RegMensual '.$RegMensual->getRegMenId());

            return $matrizMensajes;
        }
        
        
        /*
         * eliminar RegMensual
         */
        public function delRegMensual($id,$user){            
  
            //$RegMensual= new RegMensual();            
            $RegMensual=$this->repositorio->find($id);
                      
            if(!$RegMensual){
                throw $this->createNotFoundException('No se encontro Registro de Venta con ese id '.$id);
            }
            
            $RegMensual->setAudituserupd($user->getUsername());
            $RegMensual->setAuditdateupd(new \DateTime());
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