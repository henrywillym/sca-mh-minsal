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
    
    /*
    public function existeInventarioDet($entId) {
        $result = $this->em->createQuery("SELECT count(e) 
                                          FROM MinSalSCAProcesosBundle:InventarioDet e
                                          WHERE e.entId = :entId")
                 ->setParameter('entId',$entId);
        return $result->getSingleScalarResult();
    }/**/
}
?>