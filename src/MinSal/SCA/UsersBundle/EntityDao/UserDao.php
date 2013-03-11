<?php

namespace MinSal\SCA\UsersBundle\EntityDao;

use Doctrine\ORM\Query\ResultSetMapping;
use MinSal\SCA\UsersBundle\Entity\User;
use MinSal\SCA\AdminBundle\EntityDao\RolDao;
use MinSal\SCA\AdminBundle\Entity\RolSistema;
use Doctrine\Common\Collections\ArrayCollection;

class UserDao {

    var $doctrine;
    var $repositorio;
    var $em;

//Este es el constructor
    function __construct($doctrine) {
        $this->doctrine = $doctrine;
        $this->em = $this->doctrine->getEntityManager();
        $this->repositorio = $this->doctrine->getRepository('MinSalSCAUsersBundle:User');
    }
    
    public function getUsersInternos() {
        $User = $this->em->createQuery("SELECT U
                                        FROM MinSalSCAUsersBundle:User U
                                        WHERE U.userInterno = true
                                         AND U.auditDeleted = false");
        return $User->getArrayResult();
    }
    
    public function getUsersExternos($entId) {
        $User = $this->em->createQuery("SELECT U
                                        FROM MinSalSCAUsersBundle:User U JOIN U.entidad B
                                        WHERE U.userInterno = false
                                         AND B.entId = :entId
                                         AND U.auditDeleted = false")
                ->setParameter('entId',$entId); 
        return $User->getArrayResult();
    }
    
    public function getUserSinRol() {
        $User = $this->em->createQuery("SELECT U
                                        FROM MinSalSCAUsersBundle:User U
                                        WHERE U.auditDeleted = false");//WHERE U.rol IS NULL
        return $User->getResult();
    }

    public function getUserEspecifico($id) {
        $usuario = $this->repositorio->find($id);
        return $usuario;
    }

    public function updateUsuario($user, $auditUser) {
        $user->setAuditUserUpd($auditUser);
        $user->setAuditDateUpd(new \DateTime());
        
        $this->em->persist($user);
        $this->em->flush();
        $matrizMensajes = $user;

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
    
    public function eliminarUsuario($idUsuario, $auditUser){
        $user = new User();
        $user = $this->getUserEspecifico($idUsuario);
        
        $user->setAuditUserUpd($auditUser);
        $user->setAuditDateUpd(new \DateTime());
        $user->setAuditDeleted(true);
        
        $this->em->persist($user);
        $this->em->flush();
        return $user;
    }
}
?>
