<?php

/*
  SIDPLA - MINSAL
  Copyright (C) 2011  Bruno González   e-mail: bagonzalez.sv EN gmail.com
  Copyright (C) 2011  Universidad de El Salvador

  This program is free software: you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation, either version 3 of the License, or
  (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program.  If not, see <http://www.gnu.org/licenses/>.


 */

namespace MinSal\SCA\AdminBundle\EntityDao;

use MinSal\SCA\AdminBundle\Entity\UnidadOrganizativa;
use MinSal\SCA\AdminBundle\Entity\InformacionGeneral;
use MinSal\SCA\AdminBundle\EntityDao\MunicipioDao;
use MinSal\SCA\AdminBundle\EntityDao\InformacionGeneralDao;
use MinSal\SCA\AdminBundle\EntityDao\EmpleadoDao;
use MinSal\SCA\AdminBundle\Entity\Empleado;
use Doctrine\ORM\Query\ResultSetMapping;
/**
 * Description of UnidadOrganizativaDao
 *
 * @author bagonzalez
 */
class UnidadOrganizativaDao {

    var $doctrine;
    var $repositorio;
    var $em;

    function __construct($doctrine) {
        $this->doctrine = $doctrine;
        $this->em = $this->doctrine->getEntityManager();
        $this->repositorio = $this->doctrine->getRepository('MinSalSCAAdminBundle:UnidadOrganizativa');
    }

    /*
     *  Obtiene todos las unidades organizativadel sistema.
     */

    public function getUnidadesOrg() {
        $unidadesOrg = $this->repositorio->findAll();
        return $unidadesOrg;
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
                                                FROM MinSalSCAAdminBundle:UnidadOrganizativa UO
                                                WHERE UO.tipoUnidad IN ('3')
                                                ORDER BY UO.tipoUnidad ASC");
        return $obtenerUnidad->getResult();
    }
    
     public function obtenerUniSal() {
        $obtenerUnidad = $this->em->createQuery("SELECT UO
                                                FROM MinSalSCAAdminBundle:UnidadOrganizativa UO
                                                WHERE UO.tipoUnidad IN ('2')
                                                ORDER BY UO.nombreUnidad ASC");
        return $obtenerUnidad->getResult();
    }
    
     public function obtenerDepen() {
        $obtenerUnidad = $this->em->createQuery("SELECT UO
                                                FROM MinSalSCAAdminBundle:UnidadOrganizativa UO
                                                WHERE UO.tipoUnidad IN ('1')
                                                ORDER BY UO.nombreUnidad ASC");
        return $obtenerUnidad->getResult();
    }

}

?>
