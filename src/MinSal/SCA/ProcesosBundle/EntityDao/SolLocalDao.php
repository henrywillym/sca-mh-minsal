<?php
namespace MinSal\SCA\ProcesosBundle\EntityDao;

use MinSal\SCA\ProcesosBundle\Entity\Estado;
use MinSal\SCA\ProcesosBundle\Entity\Etapa;
use MinSal\SCA\ProcesosBundle\Entity\Flujo;
use MinSal\SCA\ProcesosBundle\Entity\SolLocal;
use MinSal\SCA\ProcesosBundle\Entity\SolLocalDet;

/**
 * RepositoryClass de SolLocal
 *
 * @author Henry Willy Melara
 */
class SolLocalDao {
    var $doctrine;
    var $repositorio;
    var $em;
    
    var $fluId;

    function __construct($doctrine) {
        $this->doctrine = $doctrine;
        $this->em = $this->doctrine->getEntityManager();
        $this->repositorio = $this->doctrine->getRepository('MinSalSCAProcesosBundle:SolLocal');
        
        $this->fluId = Flujo::$LOCAL;
    }

    
    /**
     * Devuelve las solicitudes de acuerdo al estado, etapa y flujo en el que se encuentren
     * @param integer $entId
     * @param integer $estId
     * @param integer $etpId
     * @param integer $fluId
     * @return Array
     */
    public function getSolLocalesByCriteria($entId, $estId, $etpId) {
        $registros = $this->em->createQuery("SELECT E, A, D, C, F
                                          FROM MinSalSCAProcesosBundle:SolLocal E 
                                            JOIN E.entidad A
                                            JOIN E.transicion B
                                            JOIN B.estado C
                                            JOIN B.etapa D
                                            JOIN E.solLocalesDet F
                                            JOIN B.flujo G
                                          WHERE A.entId = :entId
                                            AND C.estId = :estId
                                            AND B.etpId = :etpId
                                            AND G.fluId = :fluId
                                          order by E.auditDateUpd DESC, E.auditDateIns DESC")
                ->setParameter('entId',$entId)
                ->setParameter('estId',$estId)
                ->setParameter('etpId',$etpId)
                ->setParameter('fluId',$this->fluId);
        return $registros->getArrayResult();
    }
    
    /*public function getSolLocalesByEntidad($entId) {
        
        $registros = $this->em->createQuery("SELECT E, C, D, F, H
                                          FROM MinSalSCAProcesosBundle:SolLocal E 
                                            JOIN E.entidad A
                                            JOIN E.transicion B
                                            JOIN B.estado C
                                            JOIN B.etpFin D
                                            JOIN E.solLocalesDet F
                                            JOIN B.flujo G
                                            JOIN F.cuota H
                                          WHERE A.entId = :entId
                                            AND G.fluId = :fluId")
                ->setParameter('entId',$entId)
                ->setParameter('fluId',$this->fluId);
        return $registros->getArrayResult();
    }*/

    public function getSolLocalDet($id) {
        //return $this->repositorio->find($id);
        $registros = $this->em->createQuery("SELECT E, A
                                          FROM MinSalSCAProcesosBundle:SolLocalDet E
                                          JOIN E.solLocal A
                                          WHERE E.localDetId = :localDetId
                                          ")
                ->setParameter('localDetId',$id); //WHERE E.solLocalId = :solLocalId
        $result = $registros->getResult();/**/
        
        if($result !=null && count($result)>0 && $result[0] != null){
            return $result[0];
        }else{
            return 0;
        }
    }
    
    public function addSolLocal(SolLocal $solLocal) {
        $this->em->persist($solLocal);
        $this->em->flush();
        $matrizMensajes = array('El proceso de almacenar el registro termino con éxito', 'SolLocal ' . $solLocal->getSolLocalId());

        return $matrizMensajes;
    }
    
    /**
     * Esta funcion se utiliza para persistir tanto objetos de tipo SolLocal y SolLocalDet
     * @param type $solLocal
     * @return string
     */
    public function editSolLocal(SolLocal $solLocal) {
        $this->em->persist($solLocal);
        $this->em->flush();
        $matrizMensajes = array('Se actualizo con éxito', 'SolLocalDet ' . $solLocal->getSolLocalId());

        return $matrizMensajes;
    }
    
    public function delSolLocal(SolLocal $solLocal) {
        if (!$solLocal) {
            throw $this->createNotFoundException('No se encontro entidad con ese id ' . $solLocal->getSolLocalId());
        }
        //$this->em->remove($entidad);
        $this->em->flush();
        $matrizMensajes = array('El proceso de eliminar termino con exito', 'SolLocal ' . $solLocal->getSolLocalId());
        
        return $matrizMensajes;
    }
    
    /**
     * Esta funcion, realiza un conteo de los litros asociados a una cuota que se encuentran en solicitudes en proceso.
     * Se excluyen aquellas solicitudes que han sido rechazadas o Canceladas, pues significa que se ha restablecido 
     * lo reservado para su cuota. Ademas se restan los valores de LItros LIberados por aduana, ya que esos se tomaran 
     * en cuenta al momento de obtener los litros del inventario por cuota.
     * 
     * @param type $entId
     * @param type $cuoId
     * @return int
     */
    public function getLitrosSolicitudXCuota($entId, $cuoId){
        $registros = $this->em->createQuery("SELECT sum(B.localDetLitros - B.localDetLitrosLib)
                                          FROM MinSalSCAProcesosBundle:SolLocal E 
                                                JOIN E.solLocalesDet B
                                                JOIN B.cuota C
                                                JOIN C.entidad D
                                                JOIN E.transicion F
                                                JOIN F.etpFin G
                                          WHERE D.entId = :entId
                                            AND C.cuoId = :cuoId
                                            AND G.etpId not in (".Etapa::$FINALIZADA_OBS.",".Etapa::$RECEPCION_TOTAL_INV.")")
                ->setParameter('entId', $entId)
                ->setParameter('cuoId', $cuoId);
        
        $result= $registros->getSingleResult();
        
        if($result !=null && count($result)>0 && $result[1] != null){
            return $result[1];
        }else{
            return 0;
        }
    }
    
    public function getSearchEstados($entId) {
        $registros = $this->em->createQuery("SELECT DISTINCT C.estId, C.estNombre
                                          FROM MinSalSCAProcesosBundle:SolLocal E 
                                            JOIN E.entidad A
                                            JOIN E.transicion B
                                            JOIN B.estado C
                                            JOIN B.flujo G
                                          WHERE A.entId = :entId
                                            AND G.fluId = :fluId
                                          order by C.estNombre ASC")
                ->setParameter('entId',$entId)
                ->setParameter('fluId',$this->fluId);
        return $registros->getArrayResult();
    }
    
    public function getSearchEtapas($entId) {
        $registros = $this->em->createQuery("SELECT DISTINCT C.etpId, C.etpNombre
                                          FROM MinSalSCAProcesosBundle:SolLocal E 
                                            JOIN E.entidad A
                                            JOIN E.transicion B
                                            JOIN B.etpFin C
                                            JOIN B.flujo G
                                          WHERE A.entId = :entId
                                            AND G.fluId = :fluId
                                          order by C.etpNombre ASC")
                ->setParameter('entId',$entId)
                ->setParameter('fluId',$this->fluId);
        return $registros->getArrayResult();
    }
    
    /**
     * Devuelve la cantidad de solicitudes que se encuentran en cierta Etapa. Este dato 
     * es utilizado para presentarlo en el grid como resumen de cuantas solicitudes se encuentran en cada etapa
     * 
     * @param int $etpId
     * @return int
     */
    public function getCantidadSolicitudesXEtapa($entId, $etpId){
        $registros = $this->em->createQuery("SELECT count( E.solLocalId)
                                          FROM MinSalSCAProcesosBundle:SolLocal E 
                                                JOIN E.entidad A
                                                JOIN E.transicion F
                                                JOIN F.etpFin G
                                          WHERE G.etpId = :etpId
                                            AND (A.entId = :entId or :entId =0)")
                ->setParameter('etpId', $etpId)
                ->setParameter('entId', $entId);
        
        $result= $registros->getSingleResult();
        
        if($result !=null && count($result)>0 && $result[1] != null){
            return $result[1];
        }else{
            return 0;
        }
    }
}
?>