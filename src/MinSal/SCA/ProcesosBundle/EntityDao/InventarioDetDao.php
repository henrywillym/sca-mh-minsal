<?php
namespace MinSal\SCA\ProcesosBundle\EntityDao;

use MinSal\SCA\ProcesosBundle\Entity\InventarioDet;

/**
 * RepositoryClass de InventarioDet
 *
 * @author Henry Willy Melara
 */
class InventarioDetDao {
    var $doctrine;
    var $repositorio;
    var $em;

    function __construct($doctrine) {
        $this->doctrine = $doctrine;
        $this->em = $this->doctrine->getEntityManager();
        $this->repositorio = $this->doctrine->getRepository('MinSalSCAProcesosBundle:InventarioDet');
    }

    /**
     * Obtiene todos los movimientos del Inventario que pertenecen a la entidad <b>$entId</b>.
     * 
     * @return Array
     */
    public function getInventariosDet($entId) {
        $registros = $this->em->createQuery("SELECT E, A, C
                                          FROM MinSalSCAProcesosBundle:InventarioDet E 
                                                JOIN E.inventario A 
                                                JOIN A.entidad B
                                                JOIN A.alcohol C
                                          WHERE B.entId = :entId
                                            AND E.auditDeleted = false")
                ->setParameter('entId', $entId);
        return $registros->getArrayResult();
    }

    public function getInventarioDet($id) {
        return $this->repositorio->find($id);/*
        $registros = $this->em->createQuery("SELECT E
                                          FROM MinSalSCAProcesosBundle:InventarioDet E
                                          WHERE E.invDetId = :invDetId
                                            AND E.audit_deleted = false
                                          order by E.auditDateUpd DESC, E.auditDateIns DESC")
                ->setParameter('invDetId',$id);
        return $registros->getSingleResult();/**/
    }
    
    public function findInventarioDet($invId, $localDetId, $invDetAccion) {
        $registros = $this->em->createQuery("SELECT E
                                          FROM MinSalSCAProcesosBundle:InventarioDet E 
                                                JOIN E.inventario A
                                                JOIN E.solLocalDet B
                                          WHERE A.invId = :invId
                                            AND B.localDetId = :localDetId
                                            AND E.invDetAccion = :invDetAccion
                                            AND E.auditDeleted = false")
                ->setParameter('invId', $invId)
                ->setParameter('localDetId', $localDetId)
                ->setParameter('invDetAccion', $invDetAccion);
        
        $result= $registros->getResult();
        if($result !=null && count($result)>0 && $result[0] != null){
            return $result[0];
        }else{
            return null;
        }
        
    }

    public function addInventarioDet(InventarioDet $inventarioDet) {
        $this->em->persist($inventarioDet);
        $this->em->flush();
        $matrizMensajes = array('El proceso de almacenar el registro termino con éxito', 'InventarioDet ' . $inventarioDet->getInvDetId());

        return $matrizMensajes;
    }

    public function editInventarioDet(InventarioDet $inventarioDet) {
        $this->em->persist($inventarioDet);
        $this->em->flush();
        $matrizMensajes = array('Se actualizo con éxito', 'InventarioDet ' . $inventarioDet->getInvDetId());

        return $matrizMensajes;
    }
    
    public function delInventarioDet($invDetId, $auditUser) {
        $reg = $this->getInventarioDet($invDetId);
        
        $reg->setAuditUserUpd($auditUser);
        $reg->setAuditDateUpd(new \DateTime());
        $reg->setAuditDeleted(true);
        
        $this->em->persist($reg);
        $this->em->flush();
        $matrizMensajes = array('El proceso de eliminar termino con exito', 'InventarioDet ' . $invDetId);
        
        return $matrizMensajes;
    }
    
    /**
     * Devuelve la cantidad en litros de alcohol descargados o en reserva en el inventario del proveedor, a partir de una cuota dada.
     * Esta funcion es utilizada para obtener los litros disponibles de una cuota
     * 
     * @param int $entId ID del proveedor de alcohol
     * @param int $invId ID del inventario del proveedor de alcohol
     * @return int
     */
    public function getLitrosVendidosYReservaXInventario($entId, $invId) {
        $registros = $this->em->createQuery("SELECT sum(E.invDetLitros)
                                          FROM MinSalSCAProcesosBundle:InventarioDet E 
                                                JOIN E.inventario C
                                                JOIN C.entidad D
                                          WHERE D.entId = :entId
                                            AND C.invId = :invId
                                            AND E.invDetAccion in ('-','R')
                                            AND E.auditDeleted = false")
                ->setParameter('entId', $entId)
                ->setParameter('invId', $invId);
        
        $result= $registros->getSingleResult();
        
        if($result !=null && count($result)>0 && $result[1] != null){
            return $result[1];
        }else{
            return 0;
        }
    }
}
?>
