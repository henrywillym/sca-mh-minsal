<?php

namespace MinSal\SidPla\AdminBundle\EntityDao;

use MinSal\SidPla\AdminBundle\Entity\UnidadOrganizativa;
use MinSal\SidPla\AdminBundle\Entity\InformacionGeneral;
use MinSal\SidPla\AdminBundle\EntityDao\MunicipioDao;
use MinSal\SidPla\AdminBundle\EntityDao\InformacionGeneralDao;
use MinSal\SidPla\AdminBundle\EntityDao\EmpleadoDao;
use MinSal\SidPla\AdminBundle\Entity\Empleado;
use Doctrine\ORM\Query\ResultSetMapping;

/**
 * @author Henry Willy Melara <henrywillym@gmail.com>
 */
class AlcoholDao {

    var $doctrine;
    var $repositorio;
    var $em;

    function __construct($doctrine) {
        $this->doctrine = $doctrine;
        $this->em = $this->doctrine->getEntityManager();
        $this->repositorio = $this->doctrine->getRepository('MinSalSidPlaAdminBundle:Alcohol');
    }

    /*
     *  Obtiene todos los registros de alcoholes
     */

    public function getAlcoholes() {
        $alcoholes = $this->repositorio->findAll();
        return $alcoholes;
    }
    
    public function getAlcohol($id) {
        return $this->repositorio->find($id);
    }
    /*
     * Insertar nueva unidad organizativa
     */

    public function ingresarUnidadOrg($nombreUnidad, $direccion, $responsable, $telefono, $fax, $tipoUnidad, $unidadPadre, $departameto, $municipio, $descripcion) {




        $municipioDao = new MunicipioDao($this->doctrine);
        $muncipioObj = $municipioDao->getMunicipio($municipio);


        $informacionGeneral = new InformacionGeneral();
        $informacionGeneral->setDireccion($direccion);
        $informacionGeneral->setTelefono($telefono);
        $informacionGeneral->setFax($fax);


        $unidadOrg = new UnidadOrganizativa();
        $unidadOrg->setNombreUnidad($nombreUnidad);
        $unidadOrg->setTipoUnidad($tipoUnidad);



        if ($responsable != 0) {
            $unidadOrg->setResponsable($responsable);
        }

        if ($unidadPadre != 0) {
            $unidadParent = $this->repositorio->find($unidadPadre);
            $unidadOrg->setParent($unidadParent);
        }

        $unidadOrg->setIdMunicipio($municipio);
        $unidadOrg->setInformacionGeneral($informacionGeneral);
        $unidadOrg->setDescripcionUnidad($descripcion);

        $informacionGeneral->setUnidadOrganizativa($unidadOrg);

        $this->em->persist($unidadOrg);
        $this->em->persist($informacionGeneral);
        $this->em->flush();
        $matrizMensajes = array('El proceso de almacenar Unidad Organizativa termino con exito', 'Unidad ' . $unidadOrg->getIdUnidadOrg());

        return $matrizMensajes;
    }

    public function getUnidadOrg($id) {
        $unidadOrg = $this->repositorio->find($id);
        return $unidadOrg;
    }



    public function editarUnidadOrg($nombreUnidad, $direccion, $responsable, $telefono, $fax, $tipoUnidad, $unidadPadre, $departameto, $municipio, $descripcion, $id, $idinfogeneral, $respon) {




        // $municipioDao = new MunicipioDao($this->doctrine);
        //$muncipioObj = $municipioDao->getMunicipio($municipio);
        // $infogenDao= new InformacionGeneralDao($this->doctrine);
        // $informacionGeneral = new InformacionGeneral();
        //$informacionGeneral=$infogenDao->getInfoGeneral($idinfogeneral);
        //$informacionGeneral->setDireccion($direccion);
        //$informacionGeneral->setTelefono($telefono);
        // $informacionGeneral->setFax($fax);



        $unidadDao = new UnidadOrganizativaDao($this->doctrine);
        $unidadOrg = new UnidadOrganizativa();
        $unidadOrg = $unidadDao->getUnidadOrg($id);
        $unidadOrg->setNombreUnidad($nombreUnidad);
        $unidadOrg->setTipoUnidad($tipoUnidad);

        if ($responsable != 0 && $respon != NULL) {
            $unidadOrg->setResponsable($responsable);
        } else {
            $unidadOrg->setResponsable(null);
        }



        if ($unidadPadre != 0) {
            $unidadParent = $this->repositorio->find($unidadPadre);
            $unidadOrg->setParent($unidadParent);
        }

        $unidadOrg->setIdMunicipio($municipio);
        //  $unidadOrg->setInformacionGeneral($informacionGeneral);
        $unidadOrg->setDescripcionUnidad($descripcion);

        //$informacionGeneral->setUnidadOrganizativa($unidadOrg);
        //  $this->em->persist($informacionGeneral);
        $this->em->persist($unidadOrg);

        $this->em->flush();
        $matrizMensajes = array('El proceso de almacenar Unidad Organizativa termino con exito', 'Unidad ' . $unidadOrg->getIdUnidadOrg());

        return $matrizMensajes;
    }

    public function guardarInfogeneralOrg($infoGeneralcod, $unidadorgcod, $responsable, $mail, $telefono, $fax, $direccion) {





        $infogenDao = new InformacionGeneralDao($this->doctrine);
        $informacionGeneral = new InformacionGeneral();
        $informacionGeneral = $infogenDao->getInfoGeneral($infoGeneralcod);


        $informacionGeneral->setDireccion($direccion);
        $informacionGeneral->setTelefono($telefono);
        $informacionGeneral->setFax($fax);
        $informacionGeneral->setEmail($mail);

        $informacionGeneral->setFechaActualizacion(date("Y-m-d"));

        $this->em->persist($informacionGeneral);

        $this->em->flush();
        $matrizMensajes = array('El proceso de almacenar Unidad Organizativa termino con exito');

        return $matrizMensajes;
    }

    public function obtenerUniSalSibasiRegion() {
        $obtenerUnidad = $this->em->createQuery("SELECT UO
                                                FROM MinSalSidPlaAdminBundle:UnidadOrganizativa UO
                                                WHERE UO.tipoUnidad IN ('3')
                                                ORDER BY UO.tipoUnidad ASC");
        return $obtenerUnidad->getResult();
    }
    
     public function obtenerUniSal() {
        $obtenerUnidad = $this->em->createQuery("SELECT UO
                                                FROM MinSalSidPlaAdminBundle:UnidadOrganizativa UO
                                                WHERE UO.tipoUnidad IN ('2')
                                                ORDER BY UO.nombreUnidad ASC");
        return $obtenerUnidad->getResult();
    }
    
     public function obtenerDepen() {
        $obtenerUnidad = $this->em->createQuery("SELECT UO
                                                FROM MinSalSidPlaAdminBundle:UnidadOrganizativa UO
                                                WHERE UO.tipoUnidad IN ('1')
                                                ORDER BY UO.nombreUnidad ASC");
        return $obtenerUnidad->getResult();
    }

}

?>
