<?php
namespace MinSal\SidPla\SCAProcesosBundle\EntityDao;

use MinSal\SidPla\SCAProcesosBundle\Entity\InventarioDet;

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
        $this->repositorio = $this->doctrine->getRepository('MinSalSidPlaSCAProcesosBundle:InventarioDet');
    }

    /**
     * Obtiene todos los movimientos del Inventario que pertenecen a la entidad <b>$entId</b>.
     * 
     * @return Array
     */
    public function getInventariosDet($entId) {
        $registros = $this->em->createQuery("SELECT E, A, C
                                          FROM MinSalSidPlaSCAProcesosBundle:InventarioDet E 
                                                JOIN E.inventario A 
                                                JOIN A.entidad B
                                                JOIN A.alcohol C
                                          WHERE B.entId = :entId")
                ->setParameter('entId', $entId);
        return $registros->getArrayResult();
    }

    public function getInventarioDet($id) {
        //return $this->repositorio->find($id);
         $registros = $this->em->createQuery("SELECT E
                                          FROM MinSalSidPlaSCAProcesosBundle:InventarioDet E
                                          WHERE E.invDetId = :invDetId
                                          order by E.auditDateUpd DESC, E.auditDateIns DESC")
                //->setParameter('entId',$entId)
                ->setParameter('invDetId',$id);
        return $registros->getSingleResult();
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
    
    public function delInventarioDet(InventarioDet $inventarioDet) {
        if (!$inventarioDet) {
            throw $this->createNotFoundException('No se encontro entidad con ese id ' . $inventarioDet->getInvDetId());
        }
        //$this->em->remove($entidad);
        $this->em->flush();
        $matrizMensajes = array('El proceso de eliminar termino con exito', 'InventarioDet ' . $inventarioDet->getInvDetId());
        
        return $matrizMensajes;
    }
    
    /*
    public function existeInventarioDet($entId) {
        $result = $this->em->createQuery("SELECT count(e) 
                                          FROM MinSalSidPlaSCAProcesosBundle:InventarioDet e
                                          WHERE e.entId = :entId")
                 ->setParameter('entId',$entId);
        return $result->getSingleScalarResult();
    }/**/
}
?>