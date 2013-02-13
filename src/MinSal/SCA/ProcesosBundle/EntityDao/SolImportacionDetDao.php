<?php
namespace MinSal\SCA\ProcesosBundle\EntityDao;

use MinSal\SCA\ProcesosBundle\Entity\SolImportacionDet;

/**
 * RepositoryClass de SolImportacionDet
 *
 * @author Henry Willy Melara
 */
class SolImportacionDetDao {
    var $doctrine;
    var $repositorio;
    var $em;

    function __construct($doctrine) {
        $this->doctrine = $doctrine;
        $this->em = $this->doctrine->getEntityManager();
        $this->repositorio = $this->doctrine->getRepository('MinSalSCAProcesosBundle:SolImportacionDet');
    }

    /**
     * Obtiene todas las solicitudes de Importacion sin importar el estado o etapa que se encuentren
     * 
     * @return Array
     */
    public function getSolImportacionesDet($solImpId) {
        $registros = $this->em->createQuery("SELECT E, A, B, C
                                          FROM MinSalSCAProcesosBundle:SolImportacionDet E 
                                            JOIN E.arancel A
                                            JOIN E.cuota B
                                            JOIN E.solImportacion C
                                          WHERE C.solImpId = :solImpId
                                          order by E.auditDateUpd DESC, E.auditDateIns DESC")
                ->setParameter('solImpId',$solImpId);
        return $registros->getArrayResult();
    }
    
    public function getSolImportacionDet($id) {
        return $this->repositorio->find($id);
        /*$registros = $this->em->createQuery("SELECT E
                                          FROM MinSalSCAProcesosBundle:SolImportacionDet E
                                          WHERE E.impDetId = :impDetId")
                ->setParameter('impDetId',$id);
        return $registros->getResult();/**/
    }
    
    public function addSolImportacionDet(SolImportacionDet $solImportacionDet) {
        $this->em->persist($solImportacionDet);
        $this->em->flush();
        $matrizMensajes = array('El proceso de almacenar el registro termino con éxito', 'SolImportacionDet ' . $solImportacionDet->getImpDetId());

        return $matrizMensajes;
    }

    public function editSolImportacionDet(SolImportacionDet $solImportacionDet) {
        $this->em->persist($solImportacionDet);
        $this->em->flush();
        $matrizMensajes = array('Se actualizo con éxito', 'SolImportacionDet ' . $solImportacionDet->getImpDetId());

        return $matrizMensajes;
    }
    
    public function delSolImportacionDet(SolImportacionDet $solImportacionDet) {
        if (!$solImportacionDet) {
            throw $this->createNotFoundException('No se encontro entidad con ese id ' . $solImportacionDet->getImpDetId());
        }
        //$this->em->remove($entidad);
        $this->em->flush();
        $matrizMensajes = array('El proceso de eliminar termino con exito', 'SolImportacionDet ' . $solImportacionDet->getImpDetId());
        
        return $matrizMensajes;
    }
}
?>