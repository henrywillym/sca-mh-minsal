<?php
namespace MinSal\SCA\ProcesosBundle\EntityDao;

use MinSal\SCA\ProcesosBundle\Entity\Flujo;
use MinSal\SCA\ProcesosBundle\Entity\SolLocalDet;

/**
 * RepositoryClass de SolLocalDet
 *
 * @author Henry Willy Melara
 */
class SolLocalDetDao {
    var $doctrine;
    var $repositorio;
    var $em;
    
    var $fluId;
    
    private $sqlSelect = " E.localDetId, E.localDetProvNom, E.localDetPaisProc, E.localDetPaisOri, E.localDetLitros, E.localDetLitrosLib, E.localDetFactCom, F.auditUserIns, F.auditDateIns,
                        C.estId, C.estNombre, 
                        D.etpId, D.etpNombre,
                        F.solImpFecha,
                        H.cuoNombreEsp, H.cuoGrado ";

    function __construct($doctrine) {
        $this->doctrine = $doctrine;
        $this->em = $this->doctrine->getEntityManager();
        $this->repositorio = $this->doctrine->getRepository('MinSalSCAProcesosBundle:SolLocalDet');
        
        $this->fluId = Flujo::$LOCAL;
    }

    /**
     * Obtiene todas las solicitudes de Local sin importar el estado o etapa que se encuentren
     * 
     * @return Array
     */
    public function getSolLocalesDet($solImpId) {
        $registros = $this->em->createQuery("SELECT E, A, B, C
                                          FROM MinSalSCAProcesosBundle:SolLocalDet E 
                                            JOIN E.arancel A
                                            JOIN E.cuota B
                                            JOIN E.solLocal C
                                          WHERE C.solImpId = :solImpId
                                          order by E.auditDateUpd DESC, E.auditDateIns DESC")
                ->setParameter('solImpId',$solImpId);
        return $registros->getArrayResult();
    }
    
    public function getSolLocalesDetByEntidad($entId) {
        $registros = $this->em->createQuery("SELECT ".$this->sqlSelect."
                                          FROM MinSalSCAProcesosBundle:SolLocalDet E 
                                            JOIN E.cuota H
                                            JOIN E.solLocal F
                                            JOIN F.entidad A
                                            JOIN F.transicion B
                                            JOIN B.estado C
                                            JOIN B.etpFin D
                                            JOIN B.flujo G
                                          WHERE A.entId = :entId
                                            AND G.fluId = :fluId
                                            ORDER BY F.solImpId DESC")
                ->setParameter('entId',$entId)
                ->setParameter('fluId',$this->fluId);
        return $registros->getArrayResult();
    }
    
    /**
     * Obtiene todas las solicitudes de Local de acuerdo a la etapa y flujo que se encuentren
     * 
     * @param integer $entId
     * @param integer $etpId
     * @param integer $fluId
     * @return Array
     */
    public function getSolLocalesDetByEtapa($etpId, $entId = null) {
        $sql = "SELECT  ".$this->sqlSelect."
                FROM MinSalSCAProcesosBundle:SolLocalDet E 
                    JOIN E.cuota H
                    JOIN E.solLocal F
                    JOIN F.entidad A
                    JOIN F.transicion B
                    JOIN B.estado C
                    JOIN B.etpFin D
                    JOIN B.flujo G
                WHERE D.etpId = :etpId ";
        
        if($entId != null){
            $sql = $sql." AND A.entId = :entId ";
        }
        
        $sql = $sql." AND G.fluId = :fluId
                order by F.solImpFecha Desc";
        
        $registros = $this->em->createQuery($sql);
        
        if($entId != null){
            $registros->setParameter('entId',$entId);
        }
        
        $registros->setParameter('etpId',$etpId)
                ->setParameter('fluId',$this->fluId);
        return $registros->getArrayResult();
    }
    
    
    public function getSolLocalDet($id) {
        return $this->repositorio->find($id);
        /*$registros = $this->em->createQuery("SELECT E
                                          FROM MinSalSCAProcesosBundle:SolLocalDet E
                                          WHERE E.localDetId = :localDetId")
                ->setParameter('localDetId',$id);
        return $registros->getResult();/**/
    }
    
    public function addSolLocalDet(SolLocalDet $solLocalDet) {
        $this->em->persist($solLocalDet);
        $this->em->flush();
        $matrizMensajes = array('El proceso de almacenar el registro termino con éxito', 'SolLocalDet ' . $solLocalDet->getLocalDetId());

        return $matrizMensajes;
    }

    public function editSolLocalDet(SolLocalDet $solLocalDet) {
        $this->em->persist($solLocalDet);
        $this->em->flush();
        $matrizMensajes = array('Se actualizo con éxito', 'SolLocalDet ' . $solLocalDet->getLocalDetId());

        return $matrizMensajes;
    }
    
    public function delSolLocalDet(SolLocalDet $solLocalDet) {
        if (!$solLocalDet) {
            throw $this->createNotFoundException('No se encontro entidad con ese id ' . $solLocalDet->getLocalDetId());
        }
        //$this->em->remove($entidad);
        $this->em->flush();
        $matrizMensajes = array('El proceso de eliminar termino con exito', 'SolLocalDet ' . $solLocalDet->getLocalDetId());
        
        return $matrizMensajes;
    }
    
    public function getProveedores(){
        
    }
}
?>