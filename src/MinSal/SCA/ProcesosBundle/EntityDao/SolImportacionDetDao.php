<?php
namespace MinSal\SCA\ProcesosBundle\EntityDao;

use MinSal\SCA\ProcesosBundle\Entity\Flujo;
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
    
    var $fluId;
    
    private $sqlSelect = " E.impDetId, E.impDetProvNom, E.impDetPaisProc, E.impDetPaisOri, E.impDetLitros, E.impDetLitrosLib, E.impDetFactCom, 
                        F.auditUserIns, F.auditDateIns,
                        C.estId, C.estNombre, 
                        D.etpId, D.etpNombre,
                        F.solImpFecha,
                        H.cuoNombreEsp, H.cuoGrado,
                        A.entHabilitado, A.entComentario ";

    function __construct($doctrine) {
        $this->doctrine = $doctrine;
        $this->em = $this->doctrine->getEntityManager();
        $this->repositorio = $this->doctrine->getRepository('MinSalSCAProcesosBundle:SolImportacionDet');
        
        $this->fluId = Flujo::$IMPORTACION;
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
    
    public function getSolImportacionesDetByEntidad($entId) {
        $registros = $this->em->createQuery("SELECT ".$this->sqlSelect.", 
                                                    (SELECT count(K) 
                                                       FROM MinSalSCAAdminBundle:ListadoDNM K 
                                                      WHERE H.cuoYear = K.ldnm_year
                                                        AND A.entNit = K.ldnm_nit
                                                        AND A.entNrc = K.ldnm_nrc) AS HAB
                                          FROM MinSalSCAProcesosBundle:SolImportacionDet E 
                                            JOIN E.cuota H
                                            JOIN E.solImportacion F
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
     * Obtiene todas las solicitudes de Importacion de acuerdo a la etapa y flujo que se encuentren
     * 
     * @param integer $entId
     * @param integer $etpId
     * @param integer $fluId
     * @return Array
     */
    public function getSolImportacionesDetByEtapa($etpId, $entId = null) {
        $sql = "SELECT  ".$this->sqlSelect.", 
                    (SELECT count(K) 
                       FROM MinSalSCAAdminBundle:ListadoDNM K 
                      WHERE H.cuoYear = K.ldnm_year
                        AND A.entNit = K.ldnm_nit
                        AND A.entNrc = K.ldnm_nrc) AS HAB
                FROM MinSalSCAProcesosBundle:SolImportacionDet E 
                    JOIN E.cuota H
                    JOIN E.solImportacion F
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
    
    /**
     * Devuelve la cantidad en litros de alcohol ingresados a inventario, a partir de una cuota dada.
     * Esta funcion es utilizada para obtener los litros disponibles de una cuota
     * 
     * @param type $entId
     * @param type $cuoId
     * @return type
     */
    public function getLitrosInventarioXCuota($entId, $cuoId) {
        $registros = $this->em->createQuery("SELECT sum(E.invDetLitros)
                                          FROM MinSalSCAProcesosBundle:InventarioDet E 
                                                JOIN E.solImportacionDet B
                                                JOIN B.cuota C
                                                JOIN C.entidad D
                                          WHERE D.entId = :entId
                                            AND C.cuoId = :cuoId
                                            AND E.invDetAccion = '+'
                                            AND E.auditDeleted = false")
                ->setParameter('entId', $entId)
                ->setParameter('cuoId', $cuoId);
        
        $result= $registros->getSingleResult();
        
        if($result !=null && count($result)>0 && $result[1] != null){
            return $result[1];
        }else{
            return 0;
        }
    }
}
?>
