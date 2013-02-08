<?php
namespace MinSal\SCA\AdminBundle\EntityDao;

use MinSal\SCA\AdminBundle\Entity\Cuota;

/**
 * RepositoryClass de Cuota
 *
 * @author Henry Willy Melara
 */
class CuotaDao {
    var $doctrine;
    var $repositorio;
    var $em;

    function __construct($doctrine) {
        $this->doctrine = $doctrine;
        $this->em = $this->doctrine->getEntityManager();
        $this->repositorio = $this->doctrine->getRepository('MinSalSCAAdminBundle:Cuota');
    }

    /**
     *  Obtiene todos las cuotas activas
     */
    public function getCuotas($entId, $cuoTipo, $cuoYear) {
        $cuotas = $this->em->createQuery("SELECT E, A, B
                                          FROM MinSalSCAAdminBundle:Cuota E JOIN E.alcohol A JOIN E.entidad B
                                          WHERE B.entId = :entId
                                            AND E.cuoTipo = :cuoTipo
                                            AND E.cuoYear = :cuoYear
                                            AND E.auditDeleted = false
                                          order by E.auditDateUpd DESC, E.auditDateIns DESC")
                ->setParameter('entId',$entId)
                ->setParameter('cuoTipo',$cuoTipo)
                ->setParameter('cuoYear',$cuoYear);
        
        return $cuotas->getArrayResult();
    }

    public function getCuota($id) {
        return $this->repositorio->find($id);
    }

    public function addCuota(Cuota $cuota) {
        $this->em->persist($cuota);
        $this->em->flush();
        $matrizMensajes = array('Se agrego con exito', 'Cuota ' . $cuota->getCuoId());

        return $matrizMensajes;
    }

    public function editCuota(Cuota $cuota) {
        $this->em->persist($cuota);
        $this->em->flush();
        $matrizMensajes = array('Se actualizo con éxito', 'Cuota ' . $cuota->getCuoId());

        return $matrizMensajes;
    }
    
    public function delCuota(Cuota $cuota) {
        if (!$cuota) {
            throw $this->createNotFoundException('No se encontro cuota con ese id ' . $cuota->getCuoId());
        }
        //$this->em->remove($cuota);
        $this->em->flush();
        $matrizMensajes = array('El proceso de eliminar termino con exito', 'Cuota ' . $cuota->getCuoId());
        
        return $matrizMensajes;
    }

    public function existeCuota($cuoId, $entId, $alcId, $cuoYear, $cuoTipo, $cuoGrado, $cuoNombreEsp) {
        $sql = "SELECT count(e) 
                                          FROM MinSalSCAAdminBundle:Cuota e JOIN e.entidad A JOIN e.alcohol B
                                          WHERE A.entId= :entId
                                            AND B.alcId= :alcId
                                            AND e.cuoYear= :cuoYear
                                            AND e.cuoTipo= :cuoTipo
                                            AND e.cuoGrado= :cuoGrado
                                            AND e.cuoNombreEsp = :cuoNombreEsp
                                            AND e.auditDeleted = false";
        
        if($cuoId){
            $sql = $sql." AND e.cuoId <> :cuoId";
        }
        
        $result = $this->em->createQuery($sql)
                ->setParameter("entId",$entId)
                ->setParameter("alcId",$alcId)
                ->setParameter("cuoYear",$cuoYear)
                ->setParameter("cuoTipo",$cuoTipo)
                ->setParameter("cuoGrado",$cuoGrado)
                ->setParameter("cuoNombreEsp",trim($cuoNombreEsp));
        
        if($cuoId){
            $result->setParameter("cuoId",$cuoId);
        }
        
        return $result->getSingleScalarResult();
    }
}
?>