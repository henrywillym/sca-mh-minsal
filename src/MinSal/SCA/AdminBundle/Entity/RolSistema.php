<?php

namespace MinSal\SCA\AdminBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use MinSal\SCA\AdminBundle\Entity\Entidad;
use MinSal\SCA\UsersBundle\Entity\User;

/**
 * MinSal\SCA\AdminBundle\Entity\RolSistema
 *
 * @ORM\Table(name="sca_rol")
 * @ORM\Entity
 */
class RolSistema{

     /**
     * @var integer $idRol
     *
     * @ORM\Column(name="rol_codigo", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idRol;

    /**
     * @var string $nombreRol
     *
     * @ORM\Column(name="rol_nombre", type="string", length=10)
     */
    private $nombreRol;

    /**
     * @var string $funcionesRol
     *
     * @ORM\Column(name="rol_funciones", type="string", length=300)
     */
    private $funcionesRol; 
    
    
     /**
     * ORM\OneToMany(targetEntity="MinSal\SCA\UsersBundle\Entity\User", mappedBy="rol")
     */
    //protected $usuarios;
    
    /**
     * @ORM\ManyToMany(targetEntity="OpcionSistema")
     * @ORM\JoinTable(name="sca_rol_opcion",
     *      joinColumns={@ORM\JoinColumn(name="rol_codigo", referencedColumnName="rol_codigo")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="opcionsistema_codigo", referencedColumnName="opcionsistema_codigo")}
     *      )
     * @ORM\OrderBy({"idOpcionSistema" = "ASC"})
     */
    private $opcionesSistema;
    
    /**
     * @var boolean $rolImportador
     *
     * @ORM\Column(name="rol_compra_inter", type="boolean")
     */
    private $rolImportador;
    
    /**
     * @var boolean $rolProductor
     *
     * @ORM\Column(name="rol_productor", type="boolean")
     */
    private $rolProductor;
    
    /**
     * @var boolean $rolComprador
     *
     * @ORM\Column(name="rol_compra_local", type="boolean")
     */
    private $rolComprador;
    
    /**
     * @var boolean $rolCompVend
     *
     * @ORM\Column(name="rol_venta_local", type="boolean")
     */
    private $rolCompVend;
    
    /**
     * @var string $rolTipo
     *
     * @ORM\Column(name="rol_tipo", type="string", length=20)
     */
    private $rolTipo;
    
    /**
     * @var boolean $rolInterno
     *
     * @ORM\Column(name="rol_interno", type="boolean")
     */
    private $rolInterno;
    
    /**
     * @var string $rolInternoTipo
     *
     * @ORM\Column(name="rol_interno_tipo", type="string", length=20)
     */
    private $rolInternoTipo;
    
    
    /**
     * ORM\ManyToMany(targetEntity="MinSal\SCA\UserBundle\Entity\User", mappedBy="rols")\
     * ORM\JoinTable(name="sca_usuario_rol",joinColumns={@ORM\JoinColumn(name="rol_codigo", referencedColumnName="rol_codigo")})
     *
    private $usuarios;*/
    
    /**
     * @ORM\ManyToMany(targetEntity="MinSal\SCA\ProcesosBundle\Entity\Transicion")
     * @ORM\JoinTable(name="sca_rol_transicion",
     *              joinColumns={@ORM\JoinColumn(name="rol_codigo", referencedColumnName="rol_codigo")},
     *              inverseJoinColumns={@ORM\JoinColumn(name="tra_id", referencedColumnName="tra_id")})
     */
    protected $transiciones;
    
    public function __construct()
    {
        $this->usuarios = new ArrayCollection();
        $this->opcionesSistema = new ArrayCollection();
        $this->rolImportador = false;
        $this->rolProductor = false;
        $this->rolComprador = false;
        $this->rolCompVend = false;
        $this->rolInterno = true; //No hay razon especial por la cual se le puso true, es solo por dejar un valor por defecto
        $this->rolInternoTipo = null;
        $this->transiciones = new ArrayCollection();
    }

    

    /**
     * Get idRol
     *
     * @return integer 
     */
    public function getIdRol()
    {
        return $this->idRol;
    }

    /**
     * Set nombreRol
     *
     * @param string $nombreRol
     */
    public function setNombreRol($nombreRol)
    {
        $this->nombreRol = $nombreRol;
    }
    
    
     public function setIdRol($idRol)
    {
        $this->idRol=$idRol;
    }

    /**
     * Get nombreRol
     *
     * @return string 
     */
    public function getNombreRol()
    {
        return $this->nombreRol;
    }

    /**
     * Set funcionesRol
     *
     * @param string $funcionesRol
     */
    public function setFuncionesRol($funcionesRol)
    {
        $this->funcionesRol = $funcionesRol;
    }

    /**
     * Get funcionesRol
     *
     * @return string 
     */
    public function getFuncionesRol()
    {
        return $this->funcionesRol;
    }

    /**
     * Add usuarios
     *
     * @param MinSal\SCA\UsersBundle\Entity\User $usuarios
     */
    /*public function addUsuarios(\MinSal\SCA\UsersBundle\Entity\User $usuarios)
    {
        $this->usuarios[] = $usuarios;
    }*/

    /**
     * Get usuarios
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getUsuarios()
    {
        return $this->usuarios;
    }
    
    
     public function __toString()
    {
       return $this->getNombreRol();
    }
    

    /**
     * Add opcionesSistema
     *
     * @param \MinSal\SCA\AdminBundle\Entity\OpcionSistema $opcionesSistema
     */
    public function addOpcionesSistema(\MinSal\SCA\AdminBundle\Entity\OpcionSistema $opcionesSistema)
    {
        $this->opcionesSistema[] = $opcionesSistema;
    }

    /**
     * Get opcionesSistema
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getOpcionesSistema()
    {
        return $this->opcionesSistema;
    }

    /**
     * Add usuarios
     *
     * @param MinSal\SCA\UsersBundle\Entity\User $usuarios
     */
    /*public function addUser(\MinSal\SCA\UsersBundle\Entity\User $usuarios)
    {
        $this->usuarios[] = $usuarios;
    }*/

    /**
     * Add opcionesSistema
     *
     * @param \MinSal\SCA\AdminBundle\Entity\OpcionSistema $opcionesSistema
     */
    public function addOpcionSistema(\MinSal\SCA\AdminBundle\Entity\OpcionSistema $opcionesSistema)
    {
        $this->opcionesSistema[] = $opcionesSistema;
    }
    
    
    
    public function getRolImportador() {
        return $this->rolImportador;
    }

    public function setRolImportador($rolImportador) {
        $this->rolImportador = $rolImportador;
    }

    public function getRolProductor() {
        return $this->rolProductor;
    }

    public function setRolProductor($rolProductor) {
        $this->rolProductor = $rolProductor;
    }

    public function getRolComprador() {
        return $this->rolComprador;
    }

    public function setRolComprador($rolComprador) {
        $this->rolComprador = $rolComprador;
    }
    
    public function getRolCompVend() {
        return $this->rolCompVend;
    }

    public function setRolCompVend($rolCompVend) {
        $this->rolCompVend = $rolCompVend;
    }

    public function getRolTipo() {
        return $this->rolTipo;
    }

    public function setRolTipo($rolTipo) {
        $this->rolTipo = $rolTipo;
    }

    public function getRolInterno() {
        return $this->rolInterno;
    }

    public function setRolInterno($rolInterno) {
        $this->rolInterno = $rolInterno;
    }

    public function getRolInternoTipo() {
        return $this->rolInternoTipo;
    }

    public function setRolInternoTipo($rolInternoTipo) {
        if($rolInternoTipo == ''){
            $rolInternoTipo = null;
        }
        $this->rolInternoTipo = $rolInternoTipo;
    }
    
    /**
     * Aca se determina el texto que se presenta en el grid
     */
    public function getRolInternoText() {
        if($this->getRolInterno()){
            return Entidad::$SI;
        }else {
            return Entidad::$NO;
        }
    }
    
    /**
     * Aca se determina el texto que se presenta en el grid
     */
    public function getRolImportadorText() {
        if($this->getRolImportador()){
            return Entidad::$SI;
        }else {
            return Entidad::$NO;
        }
    }
    
    /**
     * Aca se determina el texto que se presenta en el grid
     */
    public function getRolProductorText() {
        if($this->getRolProductor()){
            return Entidad::$SI;
        }else {
            return Entidad::$NO;
        }
    }
    
    /**
     * Aca se determina el texto que se presenta en el grid
     */
    public function getRolCompVendText() {
        if($this->getRolCompVend()){
            return Entidad::$SI;
        }else {
            return Entidad::$NO;
        }
    }
    
    /**
     * Aca se determina el texto que se presenta en el grid
     */
    public function getRolCompradorText() {
        if($this->getRolComprador()){
            return Entidad::$SI;
        }else {
            return Entidad::$NO;
        }
    }
    
    public function getRolInternoTipoText() {
    	//ACA SE FILTRA CUAL ES EL TIPO DE MINISTERIO AL QUE PERTENECE
        if($this->getRolInternoTipo() == User::$MINSAL){
            return User::$MINSAL_TEXT;
        }else if($this->getRolInternoTipo() == User::$DGII){
            return User::$DGII_TEXT;
        }else if($this->getRolInternoTipo() == User::$DGA){
            return User::$DGA_TEXT;
        }else if($this->getRolInternoTipo() == User::$MH){
            return User::$MH_TEXT;
        }else if($this->getRolInternoTipo() == User::$DNM){
            return User::$DNM_TEXT;
        }
    }
    
    public function getRolTipoText() {
        //Aca se determina el texto de que tipo de usuario es y las acciones que puede realizar.
        if($this->getRolTipo() == User::$VENDEDOR){
            return User::$VENDEDOR_TEXT;
        }else if($this->getRolTipo() == User::$COMPRADOR){
            return User::$COMPRADOR_TEXT;
        }else if($this->getRolTipo() == User::$APROBADOR){
            return User::$APROBADOR_TEXT;
        }else if($this->getRolTipo() == User::$DIGITADOR){
            return User::$DIGITADOR_TEXT;
        }
    }
}
