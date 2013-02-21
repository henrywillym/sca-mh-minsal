<?php
namespace MinSal\SCA\ProcesosBundle\EntityDao;

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
    
}
?>