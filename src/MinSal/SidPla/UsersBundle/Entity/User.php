<?php

namespace MinSal\SidPla\UsersBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="sca_usuario")
 */
class User extends BaseUser {
    
    public function __construct() {
        parent::__construct();
        // your own logic
        //$this->entidad = new ArrayCollection();
        $this->rols = new ArrayCollection();
        $this->auditDeleted = false;
        $this->userInternoTipo = null;
    }
    
    /**
     * @ORM\Id
     * @ORM\Column(name="usuario_codigo", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $idUsuario;

    /**
     * @ORM\ManyToOne(targetEntity="MinSal\SidPla\AdminBundle\Entity\Entidad", inversedBy="users", cascade={"persist"})
     * @ORM\JoinColumn(name="ent_id", referencedColumnName="ent_id", nullable=true)
     */
    protected $entidad;

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
     * 
     * @Assert\NotNull(message="Debe especificar el Primer Nombre", groups={"Registration", "Profile"})
     * @Assert\MinLength(
     *     limit=2,
     *     message="Nombre no valido, es muy corto", 
     *     groups={"Registration", "Profile"}
     * )
     */
    private $userPrimerNombre;
    
    /**
     * @var string $userNit
     *
     * @ORM\Column(name="user_segundo_nombre", type="string", length=30)
     * @Assert\MaxLength(
     *     limit=30,
     *     message="Segundo Nombre no valido, es muy largo. Debe ser inferior a {{limit}} caracteres", 
     *     groups={"Registration", "Profile"}
     * )
     */
    private $userSegundoNombre;
    
    /**
     * @var string $userNit
     *
     * @ORM\Column(name="user_apellidos", type="string", length=30)
     * 
     * @Assert\NotNull(message="Debe especificar los Apellidos", groups={"Registration", "Profile"})
     * @Assert\MinLength(
     *     limit=2,
     *     message="Apellidos no validos, es muy corto", 
     *     groups={"Registration", "Profile"}
     * )
     * @Assert\MaxLength(
     *     limit=30,
     *     message="Apellidos no validos, es muy largo. Debe ser inferior a {{limit}} caracteres"
     * )
     */
    private $userApellidos;
    
    /**
     * @var string $userDui
     *
     * @ORM\Column(name="user_dui", type="string", length=20)
     * 
     * @Assert\NotNull(message="Debe especificar el número de DUI", groups={"Registration", "Profile"})
     * @Assert\MinLength(
     *     limit=10,
     *     message="DUI no valido , es muy corto", 
     *      groups={"Registration", "Profile"}
     * )
     * @Assert\MaxLength(
     *     limit=20,
     *     message="DUI es muy largo. Debe ser inferior a {{limit}} caracteres", 
     *      groups={"Registration", "Profile"}
     * )
     */
    private $userDui;
    
    /**
     * @var string $userNit
     *
     * @ORM\Column(name="user_nit", type="string", length=30)
     * 
     * @Assert\NotNull(message="Debe especificar el número de NIT", groups={"Registration", "Profile"})
     * @Assert\MinLength(
     *     limit=17,
     *     message="NIT no valido , es muy corto", 
     *      groups={"Registration", "Profile"}
     * )
     * @Assert\MaxLength(
     *     limit=30,
     *     message="NIT es muy largo. Debe ser inferior a {{limit}} caracteres", 
     *      groups={"Registration", "Profile"}
     * )
     */
    private $userNit;
    
    /**
     * @var string $userCargo
     *
     * @ORM\Column(name="user_cargo", type="string", length=255, nullable=true)
     * 
     * @Assert\NotNull(message="Debe especificar el cargo", groups={"Registration", "Profile"})
     * @Assert\MaxLength(
     *     limit=255,
     *     message="El nombre del Cargo es muy largo. Debe ser inferior a {{limit}} caracteres", 
     *      groups={"Registration", "Profile"}
     * )
     * @Assert\MinLength(
     *     limit=5,
     *     message="Cargo no valido, es muy corto. Debe ser mayor a 5 caracteres", 
     *      groups={"Registration", "Profile"}
     * )
     */
    private $userCargo;
    
    /**
     * @var string $userTelefono
     *
     * @ORM\Column(name="user_telefono", type="text")
     * @Assert\NotNull(message="Debe especificar el número de teléfono", groups={"Registration", "Profile"})
     * @Assert\MinLength(
     *     limit=8,
     *     message="Número telefónico no valido, es muy corto", 
     *      groups={"Registration", "Profile"}
     * )
     */
    private $userTelefono;
    
    /**
     * @var string $userInterno
     *
     * @ORM\Column(name="user_interno", type="boolean")
     * @Assert\NotNull(message="Debe especificar si es usuario interno")
     */
    private $userInterno;
    
    /**
     * @var string $userInternoTipo
     *
     * @ORM\Column(name="user_interno_tipo", type="string", length=20, nullable=true)
     */
    private $userInternoTipo;
    
    /**
     * @var string $userTipo
     * 
     * es nullable=true porque los super-usuarios no tendran ningun tipo de accion a realizar dentro del proceso
     * por eso se utiliza la condicion assert\notnull para que el formulario se valide que no venga vacio, pues desde ahi se crearan usuarios
     * que pertenezcan al proceso
     * 
     * @ORM\Column(name="user_tipo", type="string", length=20, nullable=true)
     * @Assert\NotNull(message="Debe especificar que acciones realizara")
     */
    private $userTipo;
    
    /**
     * @var DateTime $auditDateIns
     *
     * @ORM\Column(name="audit_date_ins", type="datetime", nullable=true)
     */
    private $auditDateIns;
    
    
    /**
     * @var string $auditUserIns
     *
     * @ORM\Column(name="audit_user_ins", type="string", length=50)
     */
    private $auditUserIns;
    
    /**
     * @var DateTime $auditDateUpd
     *
     * @ORM\Column(name="audit_date_upd", type="datetime", nullable=true)
     */
    private $auditDateUpd;
    
    /**
     * @var string $auditUserUpd
     *
     * @ORM\Column(name="audit_user_upd", type="string", length=50, nullable=true)
     */
    private $auditUserUpd;
    
    /**
     * @var string $auditDeleted
     *
     * @ORM\Column(name="audit_deleted", type="boolean", nullable=false)
     */
    private $auditDeleted;
    
   

    /**
     * Get idUsuario
     *
     * @return integer 
     */
    public function getIdUsuario() {
        return $this->idUsuario;
    }

    /**
     * Set idUsuario
     *
     * @param integer $idUsuario
     */
    public function setIdUsuario($idUsuario) {
        $this->idUsuario= $idUsuario;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername() {
        return $this->username;
    }

    
    public function getEntidad() {
        return $this->entidad;
    }

    public function setEntidad($entidad) {
        $this->entidad = $entidad;
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
        return $this->userInternoTipo;
    }

    public function setUserInternoTipo($userInternoTipo) {
        if($userInternoTipo ==''){
            $userInternoTipo = null;
        }else{
            $userInternoTipo = trim($userInternoTipo);
        }
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

    public function getRols() {
        return $this->rols;
    }

    public function setRols($rols) {
        $this->rols = $rols;
    }

    public function getUserTipo() {
        return $this->userTipo;
    }

    public function setUserTipo($userTipo) {
        $this->userTipo = $userTipo;
    }
    
    public function getAuditDateIns() {
        return $this->auditDateIns;
    }

    public function setAuditDateIns($auditDateIns) {
        $this->auditDateIns = $auditDateIns;
    }

    public function getAuditUserIns() {
        return $this->auditUserIns;
    }

    public function setAuditUserIns($auditUserIns) {
        $this->auditUserIns = $auditUserIns;
    }

    public function getAuditDateUpd() {
        return $this->auditDateUpd;
    }

    public function setAuditDateUpd($auditDateUpd) {
        $this->auditDateUpd = $auditDateUpd;
    }

    public function getAuditUserUpd() {
        return $this->auditUserUpd;
    }

    public function setAuditUserUpd($auditUserUpd) {
        $this->auditUserUpd = $auditUserUpd;
    }

    public function getAuditDeleted() {
        return $this->auditDeleted;
    }

    public function setAuditDeleted($auditDeleted) {
        $this->auditDeleted = $auditDeleted;
    }
}