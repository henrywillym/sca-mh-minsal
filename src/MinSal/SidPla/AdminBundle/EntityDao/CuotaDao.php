<?php
namespace MinSal\SidPla\AdminBundle\EntityDao;

use MinSal\SidPla\AdminBundle\Entity\Cuota;

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
        $this->repositorio = $this->doctrine->getRepository('MinSalSidPlaAdminBundle:Cuota');
    }

    /**
     *  Obtiene todos las cuotas activas
     */
    public function getCuotas($entId, $cuoTipo, $cuoYear) {
        $cuotas = $this->em->createQuery("SELECT E, A, B
                                          FROM MinSalSidPlaAdminBundle:Cuota E JOIN E.alcohol A JOIN E.entidad B
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

    public function existeCuota($idCuota) {
        $result = $this->em->createQuery("SELECT count(e) 
                                          FROM MinSalSidPlaAdminBundle:Cuota e
                                          WHERE e.cuoId = " . $idCuota);
        return $result->getSingleScalarResult();
    }
}
?>