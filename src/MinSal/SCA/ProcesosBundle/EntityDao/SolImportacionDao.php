<?php
namespace MinSal\SCA\ProcesosBundle\EntityDao;

use MinSal\SCA\ProcesosBundle\Entity\Estado;
use MinSal\SCA\ProcesosBundle\Entity\Flujo;
use MinSal\SCA\ProcesosBundle\Entity\SolImportacion;
use MinSal\SCA\ProcesosBundle\Entity\SolImportacionDet;

/**
 * RepositoryClass de SolImportacion
 *
 * @author Henry Willy Melara
 */
class SolImportacionDao {
    var $doctrine;
    var $repositorio;
    var $em;
    
    var $fluId;

    function __construct($doctrine) {
        $this->doctrine = $doctrine;
        $this->em = $this->doctrine->getEntityManager();
        $this->repositorio = $this->doctrine->getRepository('MinSalSCAProcesosBundle:SolImportacion');
        
        $this->fluId = Flujo::$IMPORTACION;
    }

    
    /**
     * Devuelve las solicitudes de acuerdo al estado, etapa y flujo en el que se encuentren
     * @param integer $entId
     * @param integer $estId
     * @param integer $etpId
     * @param integer $fluId
     * @return Array
     */
    public function getSolImportacionesByCriteria($entId, $estId, $etpId) {
        $registros = $this->em->createQuery("SELECT E, A, D, C, F
                                          FROM MinSalSCAProcesosBundle:SolImportacion E 
                                            JOIN E.entidad A
                                            JOIN E.transicion B
                                            JOIN B.estado C
                                            JOIN B.etapa D
                                            JOIN E.solImportacionesDet F
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
    
    /*public function getSolImportacionesByEntidad($entId) {
        
        $registros = $this->em->createQuery("SELECT E, C, D, F, H
                                          FROM MinSalSCAProcesosBundle:SolImportacion E 
                                            JOIN E.entidad A
                                            JOIN E.transicion B
                                            JOIN B.estado C
                                            JOIN B.etpFin D
                                            JOIN E.solImportacionesDet F
                                            JOIN B.flujo G
                                            JOIN F.cuota H
                                          WHERE A.entId = :entId
                                            AND G.fluId = :fluId")
                ->setParameter('entId',$entId)
                ->setParameter('fluId',$this->fluId);
        return $registros->getArrayResult();
    }*/

    public function getSolImportacionDet($id) {
        //return $this->repositorio->find($id);
        $registros = $this->em->createQuery("SELECT E, A
                                          FROM MinSalSCAProcesosBundle:SolImportacionDet E
                                          JOIN E.solImportacion A
                                          WHERE E.impDetId = :impDetId
                                          ")
                ->setParameter('impDetId',$id); //WHERE E.solImpId = :solImpId
        return $registros->getSingleResult();/**/
    }
    
    public function addSolImportacion(SolImportacion $solImportacion) {
        $this->em->persist($solImportacion);
        $this->em->flush();
        $matrizMensajes = array('El proceso de almacenar el registro termino con éxito', 'SolImportacion ' . $solImportacion->getSolImpId());

        return $matrizMensajes;
    }
    
    /**
     * Esta funcion se utiliza para persistir tanto objetos de tipo SolImportacion y SolImportacionDet
     * @param type $solImportacion
     * @return string
     */
    public function editSolImportacion(SolImportacion $solImportacion) {
        $this->em->persist($solImportacion);
        $this->em->flush();
        $matrizMensajes = array('Se actualizo con éxito', 'SolImportacionDet ' . $solImportacion->getSolImpId());

        return $matrizMensajes;
    }
    
    public function delSolImportacion(SolImportacion $solImportacion) {
        if (!$solImportacion) {
            throw $this->createNotFoundException('No se encontro entidad con ese id ' . $solImportacion->getSolImpId());
        }
        //$this->em->remove($entidad);
        $this->em->flush();
        $matrizMensajes = array('El proceso de eliminar termino con exito', 'SolImportacion ' . $solImportacion->getSolImpId());
        
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
        $registros = $this->em->createQuery("SELECT sum(B.impDetLitros - B.impDetLitrosLib)
                                          FROM MinSalSCAProcesosBundle:SolImportacion E 
                                                JOIN E.solImportacionesDet B
                                                JOIN B.cuota C
                                                JOIN C.entidad D
                                                JOIN E.transicion F
                                                JOIN F.estado G
                                          WHERE D.entId = :entId
                                            AND C.cuoId = :cuoId
                                            AND G.estId not in (".Estado::$CANCELADO.",".Estado::$RECHAZADO.")")
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
                                          FROM MinSalSCAProcesosBundle:SolImportacion E 
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
                                          FROM MinSalSCAProcesosBundle:SolImportacion E 
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
    public function getCantidadSolicitudesXEtapa($etpId){
        $registros = $this->em->createQuery("SELECT count(E.solImpId)
                                          FROM MinSalSCAProcesosBundle:SolImportacion E 
                                                JOIN E.transicion F
                                                JOIN F.etpFin G
                                          WHERE G.etpId = :etpId")
                ->setParameter('etpId', $etpId);
        
        $result= $registros->getSingleResult();
        
        if($result !=null && count($result)>0 && $result[1] != null){
            return $result[1];
        }else{
            return 0;
        }
    }
}
?>