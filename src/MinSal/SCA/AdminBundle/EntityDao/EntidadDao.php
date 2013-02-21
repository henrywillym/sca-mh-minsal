<?php
namespace MinSal\SCA\AdminBundle\EntityDao;

use MinSal\SCA\AdminBundle\Entity\Entidad;

/**
 * RepositoryClass de Entidad
 *
 * @author Henry Willy Melara
 */
class EntidadDao {
    var $doctrine;
    var $repositorio;
    var $em;

    function __construct($doctrine) {
        $this->doctrine = $doctrine;
        $this->em = $this->doctrine->getEntityManager();
        $this->repositorio = $this->doctrine->getRepository('MinSalSCAAdminBundle:Entidad');
    }

    /**
     * Obtiene todos las entidades.
     * 
     * @return Array
     */
    public function getEntidades() {
        $entidades = $this->em->createQuery("SELECT E
                                          FROM MinSalSCAAdminBundle:Entidad E
                                          order by E.auditDateUpd DESC, E.auditDateIns DESC");
        return $entidades->getArrayResult();
    }

    public function getEntidad($id) {
        return $this->repositorio->find($id);
    }

    public function addEntidad(Entidad $entidad) {
        $this->em->persist($entidad);
        $this->em->flush();
        $matrizMensajes = array('El proceso de almacenar rol termino con exito', 'Entidad ' . $entidad->getEntId());

        return $matrizMensajes;
    }

    public function editEntidad(Entidad $entidad) {
        $this->em->persist($entidad);
        $this->em->flush();
        $matrizMensajes = array('Se actualizo la empresa con éxito', 'Empresa ' . $entidad->getEntId());

        return $matrizMensajes;
    }
    
    public function delEntidad(Entidad $entidad) {
        if (!$entidad) {
            throw $this->createNotFoundException('No se encontro entidad con ese id ' . $entidad->getEntId());
        }
        //$this->em->remove($entidad);
        $this->em->flush();
        $matrizMensajes = array('El proceso de eliminar termino con exito', 'Entidad ' . $entidad->getEntId());
        
        return $matrizMensajes;
    }

    public function existeEntidad($idEntidad) {
        $result = $this->em->createQuery("SELECT count(e) 
                                          FROM MinSalSCAAdminBundle:Entidad e
                                          WHERE e.entId = :entId")
                 ->setParameter('entId',$idEntidad);
        return $result->getSingleScalarResult();
    }
}
?>