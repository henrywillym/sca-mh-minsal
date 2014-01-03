<?php

/**
 * Description of ListadoDNMDao
 *
 * @author Daniel Diaz
 */
namespace MinSal\SCA\ProcesosBundle\EntityDao;

use MinSal\SCA\ProcesosBundle\Entity\ListadoMH;

/*
 *  ListadoDNMDao: Parte de la capa de Acceso a Datos, para separar la logica de
 *  Acceso a Datos 
 */
class ListadoMHDao {
    public static $MSG_ERROR_MH_NOAUTH = '**** ERROR **** La empresa no se encuentra registrada en Ministerio de Hacienda';

    var $doctrine;
    var $repositorio;
    var $em;    

    function __construct($doctrine){ 
        $this->doctrine = $doctrine;      	
        $this->em = $this->doctrine->getEntityManager();
        $this->repositorio = $this->doctrine->getRepository('MinSalSCAProcesosBundle:ListadoMH');
    }
    
    /**
     *  Obtiene todos las cuotas activas
     */
    public function getListadoMH($mhYear) {
        $registros = $this->em->createQuery("SELECT E
                                          FROM MinSalSCAProcesosBundle:ListadoMH E
                                          WHERE E.mhYear = :mhYear
                                          order by E.auditDateIns DESC")
                ->setParameter('mhYear',$mhYear);
        
        return $registros->getArrayResult();
    }
    
    public function getRegMH($id) {
        return $this->repositorio->find($id);
    }
    
    public function commit(){
        $this->em->flush();
    }
    
    public function add(ListadoMH $registro) {
        $this->em->persist($registro);
    }

    public function deleteAll($mhYear) {
        if (!$mhYear) {
            throw $this->createNotFoundException('Se debe especificar el año ' . $mhYear);
        }
        
        $registros = $this->em->createQuery("SELECT E
                                          FROM MinSalSCAProcesosBundle:ListadoMH E
                                          WHERE E.mhYear = :mhYear
                                          order by E.auditDateIns DESC")
                ->setParameter('mhYear',$mhYear);
        
        $listado = $registros->getResult();
        
        $i = 0;
        foreach($listado as $reg){
            $this->em->remove($reg);
            $i=$i+1;
        }
        
        $this->em->flush();
        
        return $i;
    }
    
    public function deleteRegMH(ListadoMH $reg) {
        $this->em->remove($reg);
        $this->em->flush();
        
        return ;
    }

    public function editRegMH(ListadoMH $reg) {
        $this->em->persist($reg);
        $this->em->flush();
        
        return ;
    }
    
    public function existenRegistros($mhYear) {
        $sql = "SELECT count(E) 
                FROM MinSalSCAProcesosBundle:ListadoMH E
                WHERE E.mhYear = :mhYear";
        
        $result = $this->em->createQuery($sql)
                ->setParameter('mhYear',$mhYear);
        
        $valor = $result->getSingleScalarResult();
        
        if($valor == 0){
            return false;
        }else{
            return true;
        }
    }
    
    public function getEntidadByNITNRC($mhNIT, $mhNRC, $mhTipoPersona){
        $year = new \DateTime();
        $year = $year->format('Y')+0;
                
        $sql = "SELECT count(E) 
                FROM MinSalSCAProcesosBundle:ListadoMH E
                WHERE E.mhYear = :mhYear
                  AND E.mhNIT = :mhNIT
                  AND E.mhNRC = :mhNRC
                  AND E.mhTipoPersona = :mhTipoPersona ";
        
        $result = $this->em->createQuery($sql)
                ->setParameter('mhYear',$year)
                ->setParameter('mhNIT',$mhNIT)
                ->setParameter('mhNRC',$mhNRC)
                ->setParameter('mhTipoPersona',$mhTipoPersona);
        
        $valor = $result->getSingleScalarResult();
        
        if($valor == 0){
            return false;
        }else{
            return true;
        }
    }
    
    public function existeReg($mhId, $mhYear, $mhNIT, $mhNRC) {
        $sql = "SELECT count(e) 
                FROM MinSalSCAProcesosBundle:ListadoMH e
                WHERE e.mhYear= :mhYear
                  AND (e.mhNIT= :mhNIT
                  OR e.mhNRC= :mhNRC)";
        
        if($mhId){
            $sql = $sql." AND e.mhId <> :mhId";
        }
        
        $result = $this->em->createQuery($sql)
                ->setParameter("mhYear",$mhYear)
                ->setParameter("mhNIT",$mhNIT)
                ->setParameter("mhNRC",$mhNRC);
        
        if($mhId){
            $result->setParameter("mhId",$mhId);
        }
        
        return $result->getSingleScalarResult();
    }
}
