<?php

namespace MinSal\SCA\AdminBundle\EntityDao;

use MinSal\SCA\UsersBundle\Entity\User;
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
        $this->repositorio = $this->doctrine->getRepository('MinSalSCAAdminBundle:Alcohol');
    }

    /*
     *  Obtiene todos los registros de alcoholes activos
     */
    public function getAlcoholes($userInternoTipo) {
        //$alcoholes = $this->repositorio->findAll();
        if($userInternoTipo == User::$MH){
            $alcoholes = $this->em->createQuery("SELECT A
                                                FROM MinSalSCAAdminBundle:Alcohol A
                                                WHERE A.auditDeleted = false
                                                  AND A.alcId = 1
                                                order by A.alcNombre ASC");
        }else{
            $alcoholes = $this->em->createQuery("SELECT A
                                                FROM MinSalSCAAdminBundle:Alcohol A
                                                WHERE A.auditDeleted = false
                                                  AND A.alcId <> 1
                                                order by A.alcNombre ASC");
        }
        return $alcoholes->getArrayResult();
    }
    
    public function getAlcohol($id) {
        //return $this->repositorio->find($id);
        $registros = $this->em->createQuery("SELECT E, A
                                          FROM MinSalSCAAdminBundle:Alcohol E JOIN E.grupo A
                                          WHERE E.alcId= :alcId")
                ->setParameter('alcId',$id);
        return $registros->getSingleResult();
    }
}
?>
