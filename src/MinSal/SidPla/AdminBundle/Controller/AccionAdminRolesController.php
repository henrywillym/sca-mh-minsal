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
 * 
 * 
 */

/**
 * Description of AccionAdminRolesController
 *
 * @author Bruno González
 */

namespace MinSal\SidPla\AdminBundle\Controller;

use MinSal\SidPla\AdminBundle\Entity\OpcionSistema;
use MinSal\SidPla\AdminBundle\Entity\RolSistema;
use MinSal\SidPla\AdminBundle\EntityDao\RolDao;
use MinSal\SidPla\AdminBundle\Form\Type\RolSistemaType;
use MinSal\SidPla\UsersBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AccionAdminRolesController extends Controller {

    /**
     *  Esta es la opcion del Action que permitira obtener los valores de 
     *  un formulario, luego instancia una clase RolSistemaDao para
     *  manejar la persistencia de la entidad RolSistema, y retornara los
     *  mensajes de exito/fracaso del sistema.
     * 
     * @deprecated
     */
    public function addRolAction(Request $peticion) {
        $rol = new RolSistema();
        $form = $this->createForm(new RolSistemaType(), $rol);

        if ($peticion->getMethod() == 'POST') {
            $form->bindRequest($peticion);

            if ($form->isValid()) {
                $rolDao = new RolDao($this->getDoctrine());
                $mensajesSistema = $rolDao->addRol($rol);
                return new Response($mensajesSistema[0] . ' ' . $mensajesSistema[1]);
            }
        }
        return $this->redirect($this->generateUrl('MinSalSidPlaAdminBundle_homepage'));
    }

    /*
     * Crea un nuevo formulario, para ser utilizado, para crear un nuevo rol del sistema.
     */

    public function nuevoRolAction() {
        $opciones = $this->getRequest()->getSession()->get('opciones');

        $rol = new RolSistema();

        $form = $this->createForm(new RolSistemaType(), $rol);
        return $this->render('MinSalSidPlaAdminBundle:Default:rolFormTemplate.html.twig', array('form' => $form->createView(), 'opciones' => $opciones));
    }

    /*
     * Permite recuperar roles del sistema.
     * 
     */

    public function consultarRolesAction() {
        $rolDao = new RolDao($this->getDoctrine());
        $roles = $rolDao->getRoles();

        $numfilas = count($roles);

        if ($numfilas != 0) {
            //array_multisort($rows, SORT_ASC);
            $tmpRol = new RolSistema();
            $i = 0;

            foreach ($roles as $rol) {
                $tmpRol->setRolImportador($rol['rolImportador']);
                $tmpRol->setRolProductor($rol['rolProductor']);
                $tmpRol->setRolComprador($rol['rolComprador']);
                $tmpRol->setRolCompVend($rol['rolCompVend']);

                $tmpRol->setRolTipo($rol['rolTipo']);
                $tmpRol->setRolInterno($rol['rolInterno']);
                $tmpRol->setRolInternoTipo($rol['rolInternoTipo']);

                $roles[$i]['rolImportadorText'] = $tmpRol->getRolImportadorText();
                $roles[$i]['rolProductorText'] = $tmpRol->getRolProductorText();
                $roles[$i]['rolCompradorText'] = $tmpRol->getRolCompradorText();
                $roles[$i]['rolCompVendText'] = $tmpRol->getRolCompVendText();

                $roles[$i]['rolTipoText'] = $tmpRol->getRolTipoText();
                $roles[$i]['rolInternoText'] = $tmpRol->getRolInternoText();
                $roles[$i]['rolInternoTipoText'] = $tmpRol->getRolInternoTipoText();

                /*$roles[$i]['id'] = $rol->getIdRol();
                $roles[$i]['cell'] = array(
                    $rol->getIdRol(),
                    $rol->getNombreRol(),
                    $rol->getFuncionesRol()
                );*/

                $i++;
            }
        } else {
            /*$rows[0]['id'] = 0;
            $rows[0]['cell'] = array(' ', ' ', ' ', ' ', ' ');/**/
        }
        $datos = json_encode($roles);

        $pages = floor($numfilas / 10) + 1;

        $jsonresponse = '{
               "page":"1",
               "total":"' . $pages . '",
               "records":"' . $numfilas . '", 
               "rows":' . $datos . '}';


        $response = new Response($jsonresponse);
        return $response;


        /* return $this->render('MinSalSidPlaAdminBundle:Roles:showAllRoles.html.twig', 
          array('roles' => $roles, 'opciones' => $opciones,)); */
    }

    /*
     * Mantenimineto de roles.
     * 
     */

    public function mattRolesAction() {
        $opciones = $this->getRequest()->getSession()->get('opciones');

        $rolDao = new RolDao($this->getDoctrine());
        $roles = $rolDao->getRoles();
        return $this->render('MinSalSidPlaAdminBundle:Roles:manttRolesSystemForm.html.twig', array('roles' => $roles, 'opciones' => $opciones,));
    }

    /*
     * Opciones de mantenimiento de roles
     * Eliminar, agregar, editar
     * 
     */

    public function manttRolEdicionAction() {

        $request = $this->getRequest();

        $nombreRol = $request->get('nombreRol');
        $funciones = $request->get('funcionesRol');
        $rolImportador = $request->get('rolImportador');
        $rolProductor = $request->get('rolProductor');
        $rolComprador = $request->get('rolComprador');
        $rolCompVend = $request->get('rolCompVend');
        $rolInterno = $request->get('rolInterno');
        $rolTipo = $request->get('rolTipo');
        $rolInternoTipo = $request->get('rolInternoTipo');
        
        $id = $request->get('id');
        
        $operacion = $request->get('oper');

        $rolDao = new RolDao($this->getDoctrine());

        if ($operacion == 'edit') {
            $rolSistema = new RolSistema();
            $rolDao = new RolDao($this->getDoctrine());
            $rolSistema = $rolDao->repositorio->find($id);
            
            if(!$rolSistema){
                //throw $this->createNotFoundException('No se encontro rol con ese id '.$id);
                return new Response('{"status":false,"msg":"No se encontro rol con este id->'.$id.'"}');
            }
            
            $rolSistema->setNombreRol($nombreRol);
            $rolSistema->setFuncionesRol($funciones);
            $rolSistema->setRolImportador($rolImportador);
            $rolSistema->setRolProductor($rolProductor);
            
            $rolSistema->setRolComprador($rolComprador);
            $rolSistema->setRolCompVend($rolCompVend);
            $rolSistema->setRolInterno($rolInterno);
            $rolSistema->setRolTipo($rolTipo);
            $rolSistema->setRolInternoTipo($rolInternoTipo);
            
            $rolDao->editRol($rolSistema);
        }else if ($operacion == 'del') {
            $rolDao->delRol($id);
            
        }else if ($operacion == 'add') {
            $rolSistema=new RolSistema();
            
            $rolSistema->setNombreRol($nombreRol);
            $rolSistema->setFuncionesRol($funciones);
            $rolSistema->setRolImportador($rolImportador);
            $rolSistema->setRolProductor($rolProductor);
            
            $rolSistema->setRolComprador($rolComprador);
            $rolSistema->setRolCompVend($rolCompVend);
            $rolSistema->setRolInterno($rolInterno);
            $rolSistema->setRolTipo($rolTipo);
            $rolSistema->setRolInternoTipo($rolInternoTipo);
            
            $rolDao->addRol($rolSistema);
        }

        return new Response('{"status":true,"msg":""}');
    }

    public function asignarOpcRolesAction() {

        $opciones = $this->getRequest()->getSession()->get('opciones');

        return $this->render('MinSalSidPlaAdminBundle:Roles:asignarOpcionesARoles.html.twig', array('opciones' => $opciones,));
    }

    /*
     *  Obtiene las opciones seleccionadas de un rol
     */

    public function opcionesAsignadasAction() {
        $idRol = $this->getRequest()->get('reg');

        $rolDao = new RolDao($this->getDoctrine());
        $opciones = $rolDao->consultarOpcSeleccRol($idRol);

        $numfilas = count($opciones);
        $opc = new OpcionSistema();
        $i = 0;

        foreach ($opciones as $opc) {
            $rows[$i]['id'] = $opc->getIdOpcionSistema();
            $rows[$i]['cell'] = array($opc->getIdOpcionSistema(),
                $opc->getNombreOpcion()
            );
            $i++;
        }

        if ($numfilas != 0) {
            array_multisort($rows, SORT_ASC);
        } else {
            $rows[0]['id'] = 0;
            $rows[0]['cell'] = array(' ', ' ');
        }
        
        $datos = json_encode($rows);
        $pages = floor($numfilas / 25)+1;

        $jsonresponse = '{
               "page":"1",
               "total":"' . $pages . '",
               "records":"' . $numfilas . '", 
               "rows":' . $datos . '}';
        
        $response = new Response($jsonresponse);
        return $response;
    }

    /*
     * Obtiene las opciones del sistema no asignadas a un rol
     */

    public function opcionesSinAsignarAction() {
        $idRol = $this->getRequest()->get('reg');

        $rolDao = new RolDao($this->getDoctrine());
        $opciones = $rolDao->consultarOpcNoSeleccRol($idRol);

        $numfilas = count($opciones);
        $opc = new OpcionSistema();
        $i = 0;

        foreach ($opciones as $opc) {
            $rows[$i]['id'] = $opc->getIdOpcionSistema();
            $rows[$i]['cell'] = array($opc->getIdOpcionSistema(),
                $opc->getNombreOpcion()
            );
            $i++;
        }

        if ($numfilas != 0) {
            array_multisort($rows, SORT_ASC);
        } else {
            $rows[0]['id'] = 0;
            $rows[0]['cell'] = array(' ', ' ');
        }
        
        $datos = json_encode($rows);
        $pages = floor($numfilas / 25)+1;

        $jsonresponse = '{
               "page":"1",
               "total":"' . $pages . '",
               "records":"' . $numfilas . '", 
               "rows":' . $datos . '}';


        $response = new Response($jsonresponse);
        return $response;
    }

    /*
     *  Asigna una opcion a un rol seleccionado
     */

    public function insertOpcSeleccRolAction() {
        $idRol = $this->getRequest()->get('reg');
        $idOpc = $this->getRequest()->get('opc');

        $rolDao = new RolDao($this->getDoctrine());
        $rolDao->insertOpcSeleccRol($idRol, $idOpc);
        return $this->opcionesAsignadasAction();
    }

    /*
     *  Elimina un rol asignado a un rol
     */

    public function deleteOpcSeleccRolAction() {
        $idRol = $this->getRequest()->get('reg');
        $idOpc = $this->getRequest()->get('opc');

        $rolDao = new RolDao($this->getDoctrine());
        $rolDao->deleteOpcSeleccRol($idRol, $idOpc);
        return $this->opcionesAsignadasAction();
    }
    
    /**
     * Devuelve el Select a utilizar para seleccionar los tipos de acciones que tendra asignado el Rol
     * 
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function consultarTiposJSONSelectAction() {
        $select = "<select>";
        //$select = $select . "<option value='' >Seleccione una Acción</option>";
        $select = $select . "<option value=" . User::$VENDEDOR . " >" . User::$VENDEDOR_TEXT . "</option>";
        $select = $select . "<option value=" . User::$COMPRADOR . " >" . User::$COMPRADOR_TEXT . "</option>";
        $select = $select . "<option value=" . User::$APROBADOR . " >" . User::$APROBADOR_TEXT . "</option>";
        $select = $select . "<option value=" . User::$DIGITADOR . " >" . User::$DIGITADOR_TEXT . "</option>";
        $select = $select . "</select>";

        $response = new Response($select);
        return $response;
    }
    
    public function consultarInternoTiposJSONSelectAction() {
        $select = "<select>";
        $select = $select . "<option value='' >Seleccione un Ministerio</option>";
        $select = $select . "<option value=" . User::$MINSAL . " >" . User::$MINSAL_TEXT . "</option>";
        $select = $select . "<option value=" . User::$DGII . " >" . User::$DGII_TEXT . "</option>";
        $select = $select . "<option value=" . User::$DGA . " >" . User::$DGA_TEXT . "</option>";
        $select = $select . "<option value=" . User::$MH . " >" . User::$MH_TEXT . "</option>";
        $select = $select . "<option value=" . User::$DNM . " >" . User::$DNM_TEXT . "</option>";
        $select = $select . "</select>";

        $response = new Response($select);
        return $response;
    }

}

?>
