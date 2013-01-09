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
 * Description of ListadoDNMDao
 *
 * @author Bruno González
 */


namespace MinSal\SidPla\AdminBundle\EntityDao;

use MinSal\SidPla\AdminBundle\Entity\ListadoDNM;

/*
 *  ListadoDNMDao: Parte de la capa de Acceso a Datos, para separar la logica de
 *  Acceso a Datos 
 */

class ListadoDNMDao 
{
	var $doctrine;
        var $repositorio;
        var $em;    

        function __construct($doctrine){ 
            $this->doctrine=$doctrine;      	
            $this->em=$this->doctrine->getEntityManager();
            $this->repositorio=$this->doctrine->getRepository('MinSalSidPlaAdminBundle:ListadoDNM');
        } 
   	
   	/*
   	 *  Agrega una nueva ListadoDNM a la base de datos, recibe como parametros
   	 *  los datos para el nuevo registro. 
   	 *  
   	 *  Retorna mensajes del sistema que indican si es exito o fracaso.
   	 */	

	public function addListadoDNM($id, $nombres, $apellidos, $year, $nit,$nrc,$tipo_persona,$razon) {
            
            $ListadoDNM=new ListadoDNM();            

            	//$ListadoDNM->setLdnm_id($id);
                $ListadoDNM->setLdnm_year($year);
                $ListadoDNM->setLdnm_nit($nit);
                $ListadoDNM->setLdnm_nrc($nrc);
                $ListadoDNM->setLdnm_tipo_persona($tipo_persona);
                $ListadoDNM->setLdnm_nombres($nombres);
				$ListadoDNM->setLdnm_apellidos($apellidos);
				$ListadoDNM->setLdnm_razon($razon);
  
            $this->em->persist($ListadoDNM);
	    $this->em->flush();	    
	    $matrizMensajes = array('El proceso de almacenar termino con exito', 'ListadoDNM '.$ListadoDNM->getIdListadoDNM());
 
            return $matrizMensajes;
	}
        
         /*
         *  Obtiene todos los roles del sistema.
         */    

        public function getListado() {	    
            $listadoDNM=$this->repositorio->findAll();
            return $listadoDNM;
        }
        
        /*
         * Actualizar ListadoDNM
         */
        
        
        public function editListadoDNM($id, $nombres, $apellidos, $year, $nit,$nrc,$tipo_persona,$razon){
            
            $ListadoDNM= new ListadoDNM();            
            $ListadoDNM=$this->repositorio->find($id);
            
            if(!$ListadoDNM){
                throw $this->createNotFoundException('No se encontro ListadoDNM con ese id '.$id);
            }
				
                $ListadoDNM->setLdnm_year($year);
                $ListadoDNM->setLdnm_nit($nit);
                $ListadoDNM->setLdnm_nrc($nrc);
                $ListadoDNM->setLdnm_tipo_persona($tipo_persona);
                $ListadoDNM->setLdnm_nombres($nombres);
				$ListadoDNM->setLdnm_apellidos($apellidos);
				$ListadoDNM->setLdnm_razon($razon);
			
			
            $this->em->flush();
            
            $matrizMensajes = array('El proceso de almacenar termino con exito', 'ListadoDNM '.$ListadoDNM->getLdnm_id());
 
            return $matrizMensajes;
        }
        
        
        /*
         * eliminar ListadoDNM
         */
        
        
        public function delListadoDNM($id){            
  
            $ListadoDNM=$this->repositorio->find($id);
            
            if(!$ListadoDNM){
                throw $this->createNotFoundException('No se encontro ListadoDNM con ese id '.$id);
            }
            
            $this->em->remove($ListadoDNM);
            $this->em->flush();
            
            $matrizMensajes = array('El proceso de eliminar termino con exito', 'ListadoDNM '.$ListadoDNM->getLdnm_id());

            return $matrizMensajes;
        }
       
}
