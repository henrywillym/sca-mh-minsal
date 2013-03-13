<?php
namespace MinSal\SCA\ProcesosBundle\EntityDao;

use MinSal\SCA\ProcesosBundle\Entity\Flujo;
use MinSal\SCA\ProcesosBundle\Entity\SolLocalDet;
use MinSal\SCA\AdminBundle\Entity\Cuota;

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
    
    private $sqlSelect = " distinct E.localDetId, E.localDetLitros, E.localDetLitrosLib, F.auditUserIns, F.auditDateIns,
                        C.estId, C.estNombre, 
                        D.etpId, D.etpNombre,
                        F.solLocalFecha,
                        H.cuoNombreEsp, H.cuoGrado,
                        AA.entNombComercial,
                        A.entHabilitado, A.entComentario";

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
    public function getSolLocalesDet($solLocalId) {
        $registros = $this->em->createQuery("SELECT E, B, C
                                          FROM MinSalSCAProcesosBundle:SolLocalDet E 
                                            JOIN E.cuota B
                                            JOIN E.solLocal C
                                          WHERE C.solLocalId = :solLocalId
                                          order by E.auditDateUpd DESC, E.auditDateIns DESC")
                ->setParameter('solLocalId',$solLocalId);
        return $registros->getArrayResult();
    }
    
    public function getSolLocalesDetByEntidad($entId) {
        $registros = $this->em->createQuery("SELECT ".$this->sqlSelect.", 
                                                    (SELECT count(K) 
                                                       FROM MinSalSCAAdminBundle:ListadoDNM K 
                                                      WHERE H.cuoYear = K.ldnm_year
                                                        AND A.entNit = K.ldnm_nit
                                                        AND A.entNrc = K.ldnm_nrc) AS HAB
                                          FROM MinSalSCAProcesosBundle:SolLocalDet E 
                                            JOIN E.cuota H
                                            JOIN E.solLocal F
                                            JOIN F.entidad A
                                            JOIN E.inventariosDet BB
                                            JOIN BB.inventario HH
                                            JOIN HH.entidad AA
                                            JOIN F.transicion B
                                            JOIN B.estado C
                                            JOIN B.etpFin D
                                            JOIN B.flujo G
                                          WHERE A.entId = :entId
                                            AND G.fluId = :fluId
                                            ORDER BY F.solLocalId DESC")
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
        $sql = "SELECT  ".$this->sqlSelect.", 
                    (SELECT count(K) 
                       FROM MinSalSCAAdminBundle:ListadoDNM K 
                      WHERE H.cuoYear = K.ldnm_year
                        AND A.entNit = K.ldnm_nit
                        AND A.entNrc = K.ldnm_nrc) AS HAB
                FROM MinSalSCAProcesosBundle:SolLocalDet E 
                    JOIN E.cuota H
                    JOIN E.solLocal F
                    JOIN E.inventariosDet BB
                    JOIN BB.inventario HH
                    JOIN HH.entidad AA
                    JOIN F.entidad A
                    JOIN F.transicion B
                    JOIN B.estado C
                    JOIN B.etpFin D
                    JOIN B.flujo G
                WHERE D.etpId = :etpId ";
        
        if($entId != null){
            $sql = $sql." AND (A.entId = :entId or AA.entId = :entId) ";
        }
        
        $sql = $sql." AND G.fluId = :fluId
                order by F.solLocalFecha Desc";
        
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
    
    public function getProveedores($entId, $cuoId){
        $cuotas = $this->em->createQuery("SELECT ProvBB.entId, ProvBB.entNombComercial,ProvBB.entDireccionMatriz,ProvBB.entHabilitado,
                                                ProvEE.invId, ProvEE.invLitros - ProvEE.invReservado as invLitros, ProvEE.invGrado, ProvEE.invNombreEsp, 
                                                (SELECT count(K) 
                                                   FROM MinSalSCAAdminBundle:ListadoDNM K 
                                                  WHERE E.cuoYear = K.ldnm_year
                                                    AND ProvBB.entNit = K.ldnm_nit
                                                    AND ProvBB.entNrc = K.ldnm_nrc) AS HAB
                                          FROM MinSalSCAAdminBundle:Cuota E
                                            JOIN E.alcohol A
                                            JOIN E.entidad B
                                            , MinSalSCAProcesosBundle:Inventario ProvEE
                                            JOIN ProvEE.alcohol ProvAA
                                            JOIN ProvEE.entidad ProvBB
                                          WHERE B.entId = :entId
                                            AND E.cuoId = :cuoId
                                            AND E.auditDeleted = false
                                            
                                            AND ProvBB.entId <> B.entId
                                            AND ProvAA.alcId = A.alcId
                                            AND (ProvBB.entImportador = TRUE 
                                                OR ProvBB.entProductor = TRUE 
                                                OR ProvBB.entCompVend = TRUE)
                                            AND ProvEE.invGrado >= E.cuoGrado
                                            
                                            AND B.entComprador = TRUE
                                          ORDER by ProvEE.invNombreEsp ASC")
                ->setParameter('entId',$entId)
                ->setParameter('cuoId',$cuoId);
        
        return $cuotas->getArrayResult();
    }
    
    public function getProveedorSolicitud($localDetId, $entId, $cuoId){
        $cuotas = $this->em->createQuery("SELECT ProvBB.entId, ProvBB.entNombComercial,ProvBB.entDireccionMatriz,ProvBB.entHabilitado,
                                                ProvEE.invId, ProvEE.invLitros - ProvEE.invReservado as invLitros, ProvEE.invGrado, ProvEE.invNombreEsp,
                                                -1 as HAB
                                          FROM MinSalSCAAdminBundle:Cuota E
                                            JOIN E.alcohol A
                                            JOIN E.entidad B
                                            , MinSalSCAProcesosBundle:Inventario ProvEE
                                            JOIN ProvEE.alcohol ProvAA
                                            JOIN ProvEE.entidad ProvBB
                                            JOIN ProvEE.inventariosDet ProvCC
                                            JOIN ProvCC.solLocalDet ProvDD
                                          WHERE B.entId = :entId
                                            AND E.cuoId = :cuoId
                                            AND E.auditDeleted = false
                                            
                                            AND ProvBB.entId <> B.entId
                                            AND ProvAA.alcId = A.alcId
                                            AND (ProvBB.entImportador = TRUE 
                                                OR ProvBB.entProductor = TRUE 
                                                OR ProvBB.entCompVend = TRUE)
                                            AND ProvEE.invGrado >= E.cuoGrado
                                            
                                            AND B.entComprador = TRUE
                                            AND ProvDD.localDetId = :localDetId
                                          ORDER by ProvEE.invNombreEsp ASC")
                ->setParameter('entId',$entId)
                ->setParameter('localDetId',$localDetId)
                ->setParameter('cuoId',$cuoId);
        
        return $cuotas->getArrayResult();
    }
    
    /**
     * Esta funcion, realiza un conteo de los litros asociados a una cuota  de un proveedor que se encuentran en solicitudes en proceso.
     * Se excluyen aquellas solicitudes que han sido rechazadas o Canceladas, pues significa que se ha restablecido 
     * lo reservado para su cuota. Ademas se restan los valores de LItros LIberados por aduana, ya que esos se tomaran 
     * en cuenta al momento de obtener los litros del inventario por cuota.
     * 
     * @param int $entId ID de la entidad proveedora del alcohol
     * @param int $invId ID de la cuota del proveedor del alcohol
     * @return int
     * @deprecated
     */
    public function getLitrosSolicitudXCuotaProveedor($entId, $invId){
        $registros = $this->em->createQuery("SELECT sum(E.localDetLitros - E.localDetLitrosLib)
                                          FROM MinSalSCAProcesosBundle:SolLocalDet E 
                                                JOIN E.inventariosDet B
                                                JOIN B.inventario C
                                                JOIN C.entidad D
                                                JOIN E.SolLocal A
                                                JOIN A.transicion F
                                                JOIN F.etpFin G
                                          WHERE D.entId = :entId
                                            AND C.invId = :invId
                                            AND G.etpId not in (".Etapa::$FINALIZADA_OBS.",".Etapa::$RECEPCION_TOTAL_INV.")")
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