<?php
namespace MinSal\SCA\ProcesosBundle\EntityDao;

/**
 * RepositoryClass de SolImportacion
 *
 * @author Henry Willy Melara
 */
class SolImportacionDao {
    var $doctrine;
    var $repositorio;
    var $em;

    function __construct($doctrine) {
        $this->doctrine = $doctrine;
        $this->em = $this->doctrine->getEntityManager();
        $this->repositorio = $this->doctrine->getRepository('MinSalSCAProcesosBundle:SolImportacion');
    }

    /**
     * Obtiene todas las solicitudes de Importacion sin importar el estado o etapa que se encuentren
     * 
     * @return Array
     */
    public function getSolImportaciones($entId) {
        $registros = $this->em->createQuery("SELECT E, A, D, C, F
                                          FROM MinSalSCAProcesosBundle:SolImportacion E 
                                            JOIN E.entidad A
                                            JOIN E.transicion B
                                            JOIN B.estado C
                                            JOIN B.etapa D
                                            JOIN E.solImportacionesDet F
                                          WHERE A.entId = :entId
                                          order by E.auditDateUpd DESC, E.auditDateIns DESC")
                ->setParameter('entId',$entId);
        return $registros->getArrayResult();
    }
    
    public function getSolImportacionesByTransicion($entId, $traId) {
        $registros = $this->em->createQuery("SELECT E, A, D, C, F
                                          FROM MinSalSCAProcesosBundle:SolImportacion E 
                                            JOIN E.entidad A
                                            JOIN E.transicion B
                                            JOIN B.estado C
                                            JOIN B.etapa D
                                            JOIN E.solImportacionesDet F
                                          WHERE A.entId = :entId
                                            AND B.traId = :traId
                                          order by E.auditDateUpd DESC, E.auditDateIns DESC")
                ->setParameter('entId',$entId)
                ->setParameter('traId',$traId);
        return $registros->getArrayResult();
    }

    public function getSolImportacion($id) {
        return $this->repositorio->find($id);
        /*$registros = $this->em->createQuery("SELECT E
                                          FROM MinSalSCAProcesosBundle:SolImportacion E
                                          WHERE E.solImpId = :solImpId")
                ->setParameter('solImpId',$id);
        return $registros->getResult();/**/
    }
    
    public function addSolImportacion(SolImportacion $solImportacion) {
        $this->em->persist($solImportacion);
        $this->em->flush();
        $matrizMensajes = array('El proceso de almacenar el registro termino con éxito', 'SolImportacion ' . $solImportacion->getEntId());

        return $matrizMensajes;
    }

    public function editSolImportacion(SolImportacion $solImportacion) {
        $this->em->persist($solImportacion);
        $this->em->flush();
        $matrizMensajes = array('Se actualizo con éxito', 'SolImportacion ' . $solImportacion->getEntId());

        return $matrizMensajes;
    }
    
    public function delSolImportacion(SolImportacion $solImportacion) {
        if (!$solImportacion) {
            throw $this->createNotFoundException('No se encontro entidad con ese id ' . $solImportacion->getEntId());
        }
        //$this->em->remove($entidad);
        $this->em->flush();
        $matrizMensajes = array('El proceso de eliminar termino con exito', 'SolImportacion ' . $solImportacion->getEntId());
        
        return $matrizMensajes;
    }
}
?>