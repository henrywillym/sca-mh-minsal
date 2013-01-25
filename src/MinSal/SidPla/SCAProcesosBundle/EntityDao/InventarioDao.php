<?php
namespace MinSal\SidPla\SCAProcesosBundle\EntityDao;

use MinSal\SidPla\SCAProcesosBundle\Entity\InventarioDet;

/**
 * RepositoryClass de InventarioDet
 *
 * @author Henry Willy Melara
 */
class InventarioDao {
    var $doctrine;
    var $repositorio;
    var $em;

    function __construct($doctrine) {
        $this->doctrine = $doctrine;
        $this->em = $this->doctrine->getEntityManager();
        $this->repositorio = $this->doctrine->getRepository('MinSalSidPlaSCAProcesosBundle:Inventario');
    }

    /**
     * Obtiene todos las entidades.
     * 
     * @return Array
     */
    public function getInventarios($entId) {
        $registros = $this->em->createQuery("SELECT E
                                          FROM MinSalSidPlaSCAProcesosBundle:Inventario E JOIN E.entidad A
                                          WHERE A.entId = :entId
                                          order by E.auditDateUpd DESC, E.auditDateIns DESC")
                ->setParameter('entId',$entId);
        return $registros->getArrayResult();
    }

    public function getInventario($id) {
        //return $this->repositorio->find($id);
         $registros = $this->em->createQuery("SELECT E
                                          FROM MinSalSidPlaSCAProcesosBundle:Inventario E
                                          WHERE E.invId = :invId
                                          order by E.auditDateUpd DESC, E.auditDateIns DESC")
                //->setParameter('entId',$entId)
                ->setParameter('invId',$id);
        return $registros->getArrayResult();
    }
    
    public function findInventario($entId, $alcId, $invGrado, $invNombreEsp) {
        $registros = $this->em->createQuery("SELECT E
                                          FROM MinSalSidPlaSCAProcesosBundle:Inventario E JOIN E.entidad A JOIN E.alcohol B
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

    public function addInventario(Inventario $inventario) {
        $this->em->persist($inventario);
        $this->em->flush();
        $matrizMensajes = array('El proceso de almacenar el registro termino con éxito', 'Inventario ' . $inventario->getEntId());

        return $matrizMensajes;
    }

    public function editInventario(Inventario $inventario) {
        $this->em->persist($inventario);
        $this->em->flush();
        $matrizMensajes = array('Se actualizo con éxito', 'Inventario ' . $inventario->getEntId());

        return $matrizMensajes;
    }
    
    public function delInventario(Inventario $inventario) {
        if (!$inventario) {
            throw $this->createNotFoundException('No se encontro entidad con ese id ' . $inventario->getEntId());
        }
        //$this->em->remove($entidad);
        $this->em->flush();
        $matrizMensajes = array('El proceso de eliminar termino con exito', 'Inventario ' . $inventario->getEntId());
        
        return $matrizMensajes;
    }
    
    /*
    public function existeInventario($entId) {
        $result = $this->em->createQuery("SELECT count(e) 
                                          FROM MinSalSidPlaSCAProcesosBundle:Inventarioe
                                          WHERE e.entId = :entId")
                 ->setParameter('entId',$entId);
        return $result->getSingleScalarResult();
    }/**/
}
?>