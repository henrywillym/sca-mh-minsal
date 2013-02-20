<?php
namespace MinSal\SCA\ProcesosBundle\EntityDao;

use MinSal\SCA\ProcesosBundle\Entity\RegVenta;

/**
 * RepositoryClass de RegVenta
 *
 * @author Daniel E. Diaz
 */
class RegVentaDao {
    var $doctrine;
    var $repositorio;
    var $em;

    function __construct($doctrine) {
        $this->doctrine = $doctrine;
        $this->em = $this->doctrine->getEntityManager();
        $this->repositorio = $this->doctrine->getRepository('MinSalSCAProcesosBundle:RegVenta');
    }

    /**
     * Obtiene todos las entidades.
     * 
     * @return Array
     */
    public function getRegVentas($entId) {
        $registros = $this->em->createQuery("SELECT E
                                          FROM MinSalSCAProcesosBundle:RegVenta E JOIN E.entidad A
                                          WHERE A.entId = :entId
                                          order by E.auditDateUpd DESC, E.auditDateIns DESC")
                ->setParameter('entId',$entId);
        return $registros->getArrayResult();
    }

    public function getRegVenta($id) {
        //return $this->repositorio->find($id);
         $registros = $this->em->createQuery("SELECT E
                                          FROM MinSalSCAProcesosBundle:RegVenta E
                                          WHERE E.invId = :invId
                                          order by E.auditDateUpd DESC, E.auditDateIns DESC")
                //->setParameter('entId',$entId)
                ->setParameter('invId',$id);
        return $registros->getArrayResult();
    }
    
    public function findRegVenta($entId, $alcId, $invGrado, $invNombreEsp) {
        $registros = $this->em->createQuery("SELECT E
                                          FROM MinSalSCAProcesosBundle:RegVenta E JOIN E.entidad A JOIN E.alcohol B
                                          WHERE A.entId = :entId
                                            AND B.alcId = :alcId
                                            AND E.invGrado = :invGrado
                                            AND E.invNombreEsp = :invNombreEsp")
                ->setParameter('entId', $entId)
                ->setParameter('alcId', $alcId)
                ->setParameter('invGrado', $invGrado)
                ->setParameter('invNombreEsp', $invNombreEsp);
        $result= $registros->getResult();
        
        if($result !=null && count($result)>0){
            return $result[0];
        }else{
            return null;
        }
    }

    public function addRegVenta(RegVenta $RegVenta) {
        $this->em->persist($RegVenta);
        $this->em->flush();
        $matrizMensajes = array('El proceso de almacenar el registro termino con éxito', 'RegVenta ' . $RegVenta->getEntId());

        return $matrizMensajes;
    }

    public function editRegVenta(RegVenta $RegVenta) {
        $this->em->persist($RegVenta);
        $this->em->flush();
        $matrizMensajes = array('Se actualizo con éxito', 'RegVenta ' . $RegVenta->getEntId());

        return $matrizMensajes;
    }
    
    public function delRegVenta(RegVenta $RegVenta) {
        if (!$RegVenta) {
            throw $this->createNotFoundException('No se encontro entidad con ese id ' . $RegVenta->getEntId());
        }
        //$this->em->remove($entidad);
        $this->em->flush();
        $matrizMensajes = array('El proceso de eliminar termino con exito', 'RegVenta ' . $RegVenta->getEntId());
        
        return $matrizMensajes;
    }
    
    /*
    public function existeRegVenta($entId) {
        $result = $this->em->createQuery("SELECT count(e) 
                                          FROM MinSalSCAProcesosBundle:RegVentae
                                          WHERE e.entId = :entId")
                 ->setParameter('entId',$entId);
        return $result->getSingleScalarResult();
    }/**/
}
?>