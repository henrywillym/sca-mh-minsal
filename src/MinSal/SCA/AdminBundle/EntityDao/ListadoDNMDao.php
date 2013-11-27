<?php

/**
 * Description of ListadoDNMDao
 *
 * @author Daniel Diaz
 */
namespace MinSal\SCA\AdminBundle\EntityDao;

use MinSal\SCA\AdminBundle\Entity\ListadoDNM;

/*
 *  ListadoDNMDao: Parte de la capa de Acceso a Datos, para separar la logica de
 *  Acceso a Datos 
 */
class ListadoDNMDao {
        public static $MSG_ERROR_DNM_NOAUTH = '**** ERROR **** La empresa no se encuentra registrada en el Listado de Personas Autorizadas por la Dirección General de Medicamentos';
        
	var $doctrine;
        var $repositorio;
        var $em;    

        function __construct($doctrine){ 
            $this->doctrine=$doctrine;      	
            $this->em=$this->doctrine->getEntityManager();
            $this->repositorio=$this->doctrine->getRepository('MinSalSCAAdminBundle:ListadoDNM');
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
         *  Obtiene todos los registros de DNM del sistema.
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
        
        /**
         * Funcion que verifica si la persona natural o juridica se encuentra registrada en el listado de autorizados por DNM
         * para permitirle la inscripción y actualización de cuotas.
         * @param int $year Año para el cual se verificará si se encuentra registrado
         * @param string $NRC Numero de Registro de Contribuyente con el cual se realizara la busqueda.
         * @return boolean true= Se encuentra autorizado , False= No tiene permisos.
         */
        public function estaAutorizado($year, $NRC, $NIT){
            $result = $this->em->createQuery("SELECT count(e) 
                                          FROM MinSalSCAAdminBundle:ListadoDNM e
                                          WHERE e.ldnm_year = :ldnm_year
                                            AND e.ldnm_nrc = :ldnm_nrc
                                            AND e.ldnm_nit = :ldnm_nit")
                ->setParameter('ldnm_year',$year)
                ->setParameter('ldnm_nrc',$NRC)
                ->setParameter('ldnm_nit',$NIT);
            
            $cant = $result->getSingleScalarResult();
            
            if($cant == 0){
                return false;
            }else{
                return true;
            }
        }
}
