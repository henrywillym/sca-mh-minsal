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
    
    public static $NO_HABILITADA ='**** NOTA **** La empresa se encuentra deshabilitada por MH/MINSAL y bloqueada para realizar transacciones';

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
    
    /**
     * Esta funcion se encarga buscar el registro de la empresa a partir del NIT del representante asociado. Solo aplica si la empresa es un persona Juridica.
     * 
     * @param string $entRepNit
     * @return Object<Entidad>
     */
    public function getRepresentanteByNIT($entRepNit, $entId=0) {
        $result = $this->em->createQuery("SELECT e
                                          FROM MinSalSCAAdminBundle:Entidad e
                                          WHERE e.entTipoPersona = 'J' 
                                            AND e.entRepNit = :entRepNit
                                            AND e.entId <> :entId")
                ->setParameter('entRepNit',$entRepNit)
                ->setParameter('entId',$entId);
        $result = $result->getResult();
        if(count($result)>0){
            $result = $result[0];
        }
        return $result;
    }
    
    /**
     * Esta funcion se encarga de buscar el registro d ela empresa a partir del NIT de la empresa. 
     * 
     * @param string $entNit
     * @return Object<Entidad>
     */
    public function getEntidadByNIT($entNit, $entId=0) {
        $result = $this->em->createQuery("SELECT e
                                          FROM MinSalSCAAdminBundle:Entidad e
                                          WHERE e.entNit = :entNit
                                            AND e.entId <> :entId")
                ->setParameter('entNit', $entNit)
                ->setParameter('entId',$entId);
        $result = $result->getResult();
        if(count($result)>0){
            $result = $result[0];
        }
        return $result;
    }
    
    public function getEmailsXEmpresa($entId){
        $registros = $this->em->createQuery("SELECT distinct C.email
                                          FROM MinSalSCAAdminBundle:Entidad E 
                                            JOIN E.users C
                                          WHERE E.entId = :entId
                                            AND C.auditDeleted = false")
                ->setParameter('entId',$entId);
        $result = array();
        foreach($registros->getResult() as $reg){
            $result[] = $reg['email'];
        }
        return $result;
    }
}
?>