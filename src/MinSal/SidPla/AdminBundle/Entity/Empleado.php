<?php

namespace MinSal\SidPla\AdminBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * MinSal\SidPla\AdminBundle\Entity\Empleado
 *
 * @ORM\Table(name="sca_usuario")
 * @ORM\Entity
 */
class Empleado  {
 /**
     * @ORM\Id
     * @ORM\Column(name="usuario_codigo", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $idUsuario;
	
/**
     * 
     * @ORM\Column(name="username", type="string")
    
     */
    protected $username;
	
    /**
     * @ORM\ManyToOne(targetEntity="MinSal\SidPla\AdminBundle\Entity\Entidad", inversedBy="users")
     * @ORM\JoinColumn(name="ent_id", referencedColumnName="ent_id")
     */
    protected $entidad;

    /**
     * ORM\ManyToOne(targetEntity="MinSal\SidPla\AdminBundle\Entity\RolSistema", inversedBy="usuarios")
     * ORM\JoinColumn(name="rol_codigo", referencedColumnName="rol_codigo")
     */
    //protected $rol;
    
    /**
     * @ORM\ManyToMany(targetEntity="MinSal\SidPla\AdminBundle\Entity\RolSistema")
     * @ORM\JoinTable(name="sca_usuario_rol", 
     *              joinColumns={@ORM\JoinColumn(name="usuario_codigo", referencedColumnName="usuario_codigo")},
     *              inverseJoinColumns={@ORM\JoinColumn(name="rol_codigo", referencedColumnName="rol_codigo")})
     */
    protected $rols;
        
    /**
     * @var string $userDui
     *
     * @ORM\Column(name="user_primer_nombre", type="string", length=20)
     */
    private $userPrimerNombre;
    
    /**
     * @var string $userNit
     *
     * @ORM\Column(name="user_segundo_nombre", type="string", length=30)
     */
    private $userSegundoNombre;
    
    /**
     * @var string $userNit
     *
     * @ORM\Column(name="user_apellidos", type="string", length=30)
     */
    private $userApellidos;
    
    /**
     * @var string $userDui
     *
     * @ORM\Column(name="user_dui", type="string", length=20)
     */
    private $userDui;
    
    /**
     * @var string $userNit
     *
     * @ORM\Column(name="user_nit", type="string", length=30)
     */
    private $userNit;
    
    /**
     * @var string $userCargo
     *
     * @ORM\Column(name="user_cargo", type="string", length=255, nullable=true)
     */
    private $userCargo;
    
    /**
     * @var string $userTelefono
     *
     * @ORM\Column(name="user_telefono", type="text")
     */
    private $userTelefono;
    
	 /**
     * @var string $email
     *
     * @ORM\Column(name="email", type="text")
     */
    private $email;
    
	 /**
     * @var string $password
     *
     * @ORM\Column(name="password", type="text")
     */
    private $password;
	
    /**
     * @var string $userInterno
     *
     * @ORM\Column(name="user_interno", type="boolean")
     */
    private $userInterno;
    
    /**
     * @var string $userInternoTipo
     *
     * @ORM\Column(name="user_interno_tipo", type="string", length=20, nullable=true)
     */
    private $userInternoTipo;
    
    

    /**
     * @var integer $idEmpleado
     *
     * ORM\Column(name="empleado_codigo", type="integer")
     */
    //private $idEmpleado;

    

    /**
     * Get id
     *
     * @return integer 
     */
    public function getIdUsuario() {
        return $this->idUsuario;
    }
	public function setIdUsuario($idUsuario) {
        $this->idUsuario=$idUsuario;
    }
	   public function getEntidad() {
        return $this->entidad;
    }

    public function setEntidad($entidad) {
        $this->entidad = $entidad;
    }
	
    /**
     * Set idEmpleado
     *
     * @param integer $idEmpleado
     */
    /*public function setIdEmpleado($idEmpleado) {
        $this->idEmpleado = $idEmpleado;
    }*/

    /**
     * Get idEmpleado
     *
     * @return integer
     */
    /*public function getidEmpleado() {
        return $this->idEmpleado;
    }*/

    /**
     * Set empleado
     *
     * @param MinSal\SidPla\UsersBundle\Entity\Empleado $empleado
     */
    /*public function setEmpleado(\MinSal\SidPla\AdminBundle\Entity\Empleado $empleado) {
        $this->empleado = $empleado;
    }/**/

    /**
     * Get empleado
     *
     * @return MinSal\SidPla\UsersBundle\Entity\Empleado 
     */
    /*public function getEmpleado() {
        return $this->empleado;
    }*/


    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername() {
        return $this->username;
    }
	public function setUsername($username) {
       $this->username=$username;
    }
	
 
    public function getUserDui() {
        return $this->userDui;
    }

    public function setUserDui($userDui) {
        $this->userDui = $userDui;
    }

    public function getUserNit() {
        return $this->userNit;
    }

    public function setUserNit($userNit) {
        $this->userNit = $userNit;
    }

    public function getUserCargo() {
        return $this->userCargo;
    }

    public function setUserCargo($userCargo) {
        $this->userCargo = $userCargo;
    }

    public function getUserTelefono() {
        return $this->userTelefono;
    }

    public function setUserTelefono($userTelefono) {
        $this->userTelefono = $userTelefono;
    }

    public function getUserInterno() {
        return $this->userInterno;
    }

    public function setUserInterno($userInterno) {
        $this->userInterno = $userInterno;
    }

    public function getUserInternoTipo() {
    	//ACA SE FILTRA CUAL ES EL TIPO DE MINISTERIO AL QUE PERTENECE
    if($this->userInternoTipo=="MINSAL"){return "Ministerio de Salud";}
	if($this->userInternoTipo=="DGII"){return "Dirección General de Impuestos Internos";}
	if($this->userInternoTipo=="DGA"){return "Dirección General de Aduanas";}
	if($this->userInternoTipo=="MH"){return "Ministerio de Hacienda";}
	if($this->userInternoTipo=="DNM"){return "Dirección Nacional de Medicamentos";}
    }

    public function setUserInternoTipo($userInternoTipo) {
        $this->userInternoTipo = $userInternoTipo;
    }

    public function getUserPrimerNombre() {
        return $this->userPrimerNombre;
    }

    public function setUserPrimerNombre($userPrimerNombre) {
        $this->userPrimerNombre = $userPrimerNombre;
    }

    public function getUserSegundoNombre() {
        return $this->userSegundoNombre;
    }

    public function setUserSegundoNombre($userSegundoNombre) {
        $this->userSegundoNombre = $userSegundoNombre;
    }

    public function getUserApellidos() {
        return $this->userApellidos;
    }

    public function setUserApellidos($userApellidos) {
        $this->userApellidos = $userApellidos;
    }
	 public function getEmail() {
        return $this->email;
    }
	public function setEmail($email) {
       $this->email=$email;
    }
	 public function getPassword() {
        return $this->password;
    }
	public function setPassword($password) {
       $this->password=$password;
    }

    public function getRols() {
        return $this->rols;
    }

    public function setRols($rols) {
        $this->rols = $rols;
    }

}