<?php
namespace MinSal\SCA\ProcesosBundle\EntityDao;

use Doctrine\ORM\Query;
use MinSal\SCA\ProcesosBundle\Entity\Flujo;
use MinSal\SCA\ProcesosBundle\Entity\SolImportacion;
use MinSal\SCA\ProcesosBundle\Entity\SolImportacionDet;

/**
 * RepositoryClass de Transicion
 *
 * @author Henry Willy Melara
 */
class TransicionDao {
    var $doctrine;
    var $repositorio;
    var $em;

    function __construct($doctrine) {
        $this->doctrine = $doctrine;
        $this->em = $this->doctrine->getEntityManager();
        $this->repositorio = $this->doctrine->getRepository('MinSalSCAProcesosBundle:Transicion');
    }
    
    /**
     * Devuelve la transicion inicial de un flujo determinado
     * 
     * @param integer $fluId
     * @return Object Transicion
     */
    public function getTransicionInicial($fluId) {
        $registros = $this->em->createQuery("SELECT E
                                          FROM MinSalSCAProcesosBundle:Transicion E 
                                            left JOIN E.etpInicio A
                                            left JOIN E.etpFin B
                                            JOIN E.flujo G
                                          WHERE A.etpId is null
                                            AND B.etpId is not null
                                            AND G.fluId = :fluId
                                            AND E.auditDeleted = false")
                ->setParameter('fluId',$fluId);
        return $registros->getSingleResult();
    }
    
    /**
     * Devuelve las transicion posibles a realizar, a partir de una transicion dada.
     * 
     * @param integer $traId
     * @return Object[] Transicion
     */
    public function getTransicionesSiguientes($traId) {
        $registros = $this->em->createQuery("SELECT E, A
                                          FROM MinSalSCAProcesosBundle:Transicion E 
                                            JOIN E.parentsTransicion B
                                            LEFT JOIN E.childrenTransicion A
                                            LEFT JOIN A.estado C
                                          WHERE B.traId = :traId
                                          ORDER BY C.estId ASC") //No se utiliza "AND E.auditDeleted = false" porque si se cambia el flujo, las solicitudes en proceso finalizan con el flujo que ya habian iniciado. Y las nuevas siguen con el que se configuro.
                ->setParameter('traId',$traId);
        return $registros->getResult();
    }
    
    
    
    public function getEmailsXTransicion($entId, $traId){
        $registros = $this->em->createQuery("SELECT distinct C.email
                                          FROM MinSalSCAProcesosBundle:Transicion E 
                                            LEFT JOIN E.childrenTransicion A
                                            LEFT JOIN A.parentsTransicion AA
                                            LEFT JOIN A.rols B
                                            LEFT JOIN B.usuarios C
                                            LEFT JOIN C.entidad D
                                          WHERE AA.traId = :traId
                                            AND (D.entId = :entId OR C.userInterno = true)
                                            AND C.auditDeleted = false")
                ->setParameter('traId',$traId)
                ->setParameter('entId',$entId);
        $result = array();
        foreach($registros->getResult() as $reg){
            $result[] = $reg['email'];
        }
        return $result;
    }
}
?>