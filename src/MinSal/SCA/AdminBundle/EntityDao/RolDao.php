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

/**
 * Description of RolDao
 *
 * @author Bruno González
 */


namespace MinSal\SCA\AdminBundle\EntityDao;

use Doctrine\ORM\Query\ResultSetMapping;
use MinSal\SCA\AdminBundle\Entity\OpcionSistema;
use MinSal\SCA\AdminBundle\Entity\RolSistema;
use Symfony\Bundle\DoctrineBundle\Registry;

class RolDao {
    
    var $doctrine;
    var $repositorio;
    var $em;    
	
    function __construct($doctrine){ 
        $this->doctrine=$doctrine;      	
        $this->em=$this->doctrine->getEntityManager();
        $this->repositorio=$this->doctrine->getRepository('MinSalSCAAdminBundle:RolSistema');
    } 
    
    /*
     *  Almacena un rol ingresado en el sistema
     */
    
    public function addRol($rolSistema) {
        $this->em->persist($rolSistema);
        $this->em->flush();	    
        $matrizMensajes = array('El proceso de almacenar rol termino con exito', 'Rol '.$rolSistema->getIdRol());

        return $matrizMensajes;
    }
    
    /*
     *  Obtiene todos los roles del sistema.
     */    
    
    public function getRoles() {	    
        $roles = $this->em->createQuery("SELECT R
                                          FROM MinSalSCAAdminBundle:RolSistema R
                                          order by R.nombreRol DESC");
        
        return $roles->getArrayResult();
        
        //$roles=$this->repositorio->findAll();
        //return $roles;
    }
    
     public function getRolEspecifico($id) {	    
        $rol=$this->repositorio->find($id);
        return $rol;
    }
    
    
        /*
         * Actualizar rol
         */
        
        
        public function editRol($rol){
            $this->em->flush();            
            $matrizMensajes = array('El proceso de almacenar termino con exito', 'Rol '.$rol->getIdRol());
 
            return $matrizMensajes;
        }
        
         /*
         * eliminar rol
         */
        
        
        public function delRol($id){            
            
            $rol=$this->repositorio->find($id);
            
            if(!$rol){
                throw $this->createNotFoundException('No se encontro rol con ese id '.$id);
            }
            
            $this->em->remove($rol);
            $this->em->flush();
            
            $matrizMensajes = array('El proceso de eliminar termino con exito', 'Rol '.$rol->getIdRol());
 
            return $matrizMensajes;
        }
        
        /*
         * Consulta las opciones asignadas a un rol
         * 
         */
        
         public function consultarOpcSeleccRol($id){ 
             
             
             $rsm=new ResultSetMapping;             
             $rsm->addEntityResult('MinSalSCAAdminBundle:OpcionSistema', 'o');
             $rsm->addFieldResult('o', 'opcionsistema_codigo', 'idOpcionSistema');
             $rsm->addFieldResult('o', 'opcionsistema_nombre', 'nombreOpcion');
             $query = $this->em->createNativeQuery('SELECT opc.opcionsistema_codigo, opc.opcionsistema_nombre 
                                                    FROM sca_rol_opcion rolopc, sca_opcionsistema opc, sca_rol rol  
                                                    WHERE rol.rol_codigo=rolopc.rol_codigo AND opc.opcionsistema_codigo=rolopc.opcionsistema_codigo
                                                    AND rol.rol_codigo = ?' , $rsm);   
             $query->setParameter(1, $id);
             $opciones = $query->getResult();             
             
             return $opciones;
         }
         
         /*
          * Asigna una opcion seleccionada a un rol
          * 
          */
         
         public function insertOpcSeleccRol($idRol, $idOpc){ 
             
             $query = $this->em->getConnection()
                     ->executeUpdate('INSERT INTO sca_rol_opcion(
                                opcionsistema_codigo, rol_codigo)
                                VALUES ('.$idOpc.','.$idRol.' );');
         }
         
         /*
          * Elimina una opcion asignada a un rol
          */
         
         public function deleteOpcSeleccRol($idRol, $idOpc){ 
             
             $query = $this->em->getConnection()
                     ->executeUpdate('DELETE FROM sca_rol_opcion
                                      WHERE opcionsistema_codigo='.$idOpc.'  
                                      AND rol_codigo='.$idRol);  
         }
         
         /*
          *  Consulta las opciones no asignadas a un rol
          */
         
          public function consultarOpcNoSeleccRol($idRol){ 
             
             
             $rsm=new ResultSetMapping;             
             $rsm->addEntityResult('MinSalSCAAdminBundle:OpcionSistema', 'o');
             $rsm->addFieldResult('o', 'opcionsistema_codigo', 'idOpcionSistema');
             $rsm->addFieldResult('o', 'opcionsistema_nombre', 'nombreOpcion');
             $query = $this->em
                     ->createNativeQuery('SELECT opc.opcionsistema_codigo, opc.opcionsistema_nombre 
                                          FROM sca_opcionsistema opc
                                          WHERE opc.opcionsistema_codigo 
                                          NOT IN (SELECT opc.opcionsistema_codigo 
                                            FROM sca_rol_opcion rolopc, sca_rol rol 
                                            WHERE rol.rol_codigo=rolopc.rol_codigo AND opc.opcionsistema_codigo=rolopc.opcionsistema_codigo
                                            AND rol.rol_codigo=?)' , $rsm);   
             $query->setParameter(1, $idRol);
             $opciones = $query->getResult();             
             
             return $opciones;
         }
    
    /**
     * Retorna todos los roles que cumplan con las condiciones acorde a los valores de los parametros
     * 
     * @param bool $entImportador 
     * @param bool $entProductor
     * @param bool $entComprador
     * @param bool $entVendedorLocal
     * @param string $userTipo VENDEDOR, COMPRADOR, APROBADOR, DIGITADOR
     * @param bool $userInterno true=Usuario interno (Ministerio); false=Usuario externo (Empresas)
     * @param sting $userInternoTipo MH, MINSAL, DGII, DGA, DNM
     * @return array Array Doctrine Object
     */
    public function getRolesEspecificos($entImportador, $entProductor, $entComprador, $entVendedorLocal, $userTipo, $userInterno, $userInternoTipo) {
        $query = $this->repositorio->createQueryBuilder('R');
        
        $where = '     R.rolTipo = :rolTipo
                         AND R.rolInterno = :rolInterno ';
        $query = $query->setParameters(array(
            'rolTipo' => $userTipo,
            'rolInterno' => $userInterno === true?1:0
        ));
        
        if($entImportador || $entProductor || $entComprador){
            $where = $where.' AND (';

            if($entImportador){
                $where = $where.' R.rolImportador = :rolImportador ';
                $query = $query->setParameter('rolImportador',$entImportador === true?1:0 );
            }

            if($entProductor){
                if($entImportador){
                    $where = $where.' OR ';
                }

                $where = $where.'    R.rolProductor = :rolProductor ';
                $query = $query->setParameter('rolProductor',$entProductor === true?1:0 );
            }

            if($entComprador ){
                if($entImportador || $entProductor){
                    $where = $where.' OR ';
                }

                $where = $where.'    (R.rolComprador = :rolComprador OR R.rolCompVend = :rolCompVend )';
                $query = $query->setParameter('rolComprador',$entComprador === true?1:0 );
                $query = $query->setParameter('rolCompVend',$entVendedorLocal === true?1:0 );
            }
            $where = $where.'     ) ';
        }
                        
        if($userInterno == true){
            $where = $where.' AND R.rolInternoTipo = :rolInternoTipo';
            $query = $query->setParameter('rolInternoTipo',$userInternoTipo);
        }
                
        $query = $query->where($where);
        
        return $query->getQuery()->getResult();
    }
 
}

?>
