<?php

namespace MinSal\SidPla\UsersBundle\EntityDao;

use Doctrine\ORM\Query\ResultSetMapping;
use MinSal\SidPla\UsersBundle\Entity\User;
use MinSal\SidPla\AdminBundle\EntityDao\RolDao;
use MinSal\SidPla\AdminBundle\Entity\RolSistema;
use Doctrine\Common\Collections\ArrayCollection;

class UserDao {

    var $doctrine;
    var $repositorio;
    var $em;

//Este es el constructor
    function __construct($doctrine) {
        $this->doctrine = $doctrine;
        $this->em = $this->doctrine->getEntityManager();
        $this->repositorio = $this->doctrine->getRepository('MinSalSidPlaUsersBundle:User');
    }
    
    public function getUsersInternos() {
        $User = $this->em->createQuery("SELECT U
                                        FROM MinSalSidPlaUsersBundle:User U
                                        WHERE U.userInterno = true
                                        AND U.auditDeleted = false");
        return $User->getResult();
    }
    
    public function getUsersExternos($entId) {
        $User = $this->em->createQuery("SELECT U
                                        FROM MinSalSidPlaUsersBundle:User U JOIN U.entidad B
                                        WHERE U.userInterno = false
                                        AND B.entId = :entId
                                        AND U.auditDeleted = false")
                ->setParameter('entId',$entId); 
        return $User->getResult();
    }
    
    public function getUserSinRol() {
        $User = $this->em->createQuery("SELECT U
                                        FROM MinSalSidPlaUsersBundle:User U
                                        WHERE U.auditDeleted = false");//WHERE U.rol IS NULL
        return $User->getResult();
    }

    public function getUserEspecifico($codigo) {
        $usuario = $this->repositorio->find($codigo);
        ;
        return $usuario;
    }

    public function editUserSinRol($codigoUser, $idRol) {
        $user = new User();
        $user = $this->getUserEspecifico($codigoUser);

        $rolDao = new RolDao($this->doctrine);
        $rol[0] = $rolDao->getRolEspecifico($idRol);
        
        $user->setRols($rol);
        $this->em->persist($user);
        $this->em->flush();
        $matrizMensajes = $codigoUser;

        return $matrizMensajes;
    }
    
    /**
     * @deprecated
     * @param type $idUsuario
     * @return type
     */
    public function tieneOtroUsuario($idUsuario) {
        $rsm = new ResultSetMapping;
        $rsm->addScalarResult('resp', 'resp');
        $query = $this->em->createNativeQuery('SELECT count (* )resp 
                                               FROM sca_usuario
                                               WHERE sca_usuario.username = ?
                                               AND audit_deleted = false', $rsm);
        $query->setParameter(1, $idUsuario);

        $x = $query->getResult();

        return $x[0]['resp'];
    }

    public function usernameDisponible($username, $idUsuario='') {
        $rsm = new ResultSetMapping;
        $rsm->addScalarResult('resp', 'resp');
        $sql = "SELECT count (*)resp 
                FROM sca_usuario
                WHERE username =?
                AND audit_deleted = false";
        
        if($idUsuario !='' && $idUsuario != null){
            $sql= $sql.' AND usuario_codigo <> '.$idUsuario;
        }
        
        $query = $this->em->createNativeQuery($sql, $rsm);
        $query->setParameter(1, $username);

        $x = $query->getResult();

        return $x[0]['resp'];
    }
    
     public function emailDisponible($email, $idUsuario='') {
        $rsm = new ResultSetMapping;
        $rsm->addScalarResult('resp', 'resp');
        $sql = "SELECT count (*) resp
                FROM sca_usuario
                WHERE sca_usuario.email = ?
                AND audit_deleted = false";
        
        if($idUsuario!='' && $idUsuario!=null){
            $sql= $sql.' AND usuario_codigo <> '.$idUsuario;
        }
        
        $query = $this->em->createNativeQuery($sql, $rsm);
        $query->setParameter(1, trim($email));

        $x = $query->getResult();

        return $x[0]['resp'];
    }

}

?>
