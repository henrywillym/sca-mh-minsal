<?php

namespace MinSal\SCA\ProcesosBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use MinSal\SCA\AdminBundle\Entity\Entidad;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * RepositoryClass de RegVenta
 *
 * @author Daniel E. Diaz (dansel7@gmail.com)
 */

/**
 * @ORM\Entity
 * @ORM\Table(name="sca_det_registro_ventas")
 */
class RegVenta {
    
    public function __construct() {
        //$this->RegVenta = new RegVenta();
         //$this->alcohol = new Alcohol();
        $this->auditDeleted = false;
    }
    
    /**
     * Se encarga de validar que el valor de los grados se encuentre dentro del rango
     */
    
    public function isValid(){
        $msg = array();
        
        if($this->getRegveGrado() != null && $this->getRegveGrado() != ''){
          
            if($this->getRegveGrado()+0 <=0 || $this->getRegveGrado()+0 >100 ){
                $msg[]='- El grado ingresado "'.$this->getRegveGrado().'" debe ser mayor a 0 y menor a 100';
            }
        }else{
            $msg[]='- Debe especificar el grado del alcohol';
        }
        
        if($this->getRegveFecha() != null && $this->getRegveFecha()!= ''){
          
            if($this->getregveGrado()+0 <=0 || $this->getregveGrado()+0 >100 ){
                $msg[]='- El grado ingresado "'.$this->getregveGrado().'" debe ser mayor a 0 y menor a 100';
            }
        }else{
            $msg[]='- Debe especificar la fecha de la transacción';
        }
         
        return $msg;
    }
        
   /**
     * @var numeric $RegVentaId
     *
     * @ORM\Column(name="regve_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */ 

    protected $RegVentaId;
    
    /**
     * @var integer $entId
     * Es Many-To-One, Unidirectional
     * @ORM\ManyToOne(targetEntity="MinSal\SCA\AdminBundle\Entity\Entidad")
     * @ORM\JoinColumn(name="ent_id", referencedColumnName="ent_id")
     * @ORM\Column(name="ent_id", type="integer", nullable=false)
     */
    protected $entidad;
    
    /**
     * @var integer $alcohol
     * @ORM\ManyToOne(targetEntity="MinSal\SCA\AdminBundle\Entity\Cuota")
     * @ORM\JoinColumn(name="cuo_id", referencedColumnName="cuo_id")
     * * @ORM\Column(name="cuo_id", type="integer", nullable=false)
     */
    protected $alcohol;
    
    /**
     * @var string $regveFecha
     *
     *@ORM\Column(name="regve_fecha", type="string", nullable=false)
     */
    private $regveFecha;
       
    /**
     * @var numeric $regveNIT
     *
     * @ORM\Column(name="regve_nit", type="string", nullable=false)
     *  */
    private $regveNIT;
     
     /**
     * @var string $regveNombre
     *
     * @ORM\Column(name="regve_nombre", type="string", nullable=false)
     */
    private $regveNombre;    
      
    /**
     * @var string $regveMinsal
     *
     * @ORM\Column(name="regve_reg_minsal", type="string", nullable=false)
     */
    private $regveMinsal;
    
     /**
     * @var string $regvedgii
     *
     * @ORM\Column(name="regve_reg_dgii", type="string", nullable=false)
     */
    private $regvedgii;
     
   /**
     * @var numeric $regveLitros
     *
     * @ORM\Column(name="regve_litros", type="decimal", nullable=false)
    *  @Assert\Min(limit = "0", message = "Litros debe ser Mayor a Cero")
     */
    private $regveLitros;
    
      /**
     * @var numeric $regveGrado
     *
     * @ORM\Column(name="regve_grado", type="decimal", nullable=false)
     *  */
    private $regveGrado;
    
    /**
     * @var string $audit_user_ins
     *
     *@ORM\Column(name="audit_user_ins", type="string", nullable=false)
     */
    protected $audit_user_ins;
    
     
    /**
     * @var string $audit_date_ins
     *
     *@ORM\Column(name="audit_date_ins", type="datetime", nullable=false)
     */
    protected $audit_date_ins;
    
     
    /**
     * @var string $audit_user_upd
     *
     *@ORM\Column(name="audit_user_upd", type="string", nullable=false)
     */
    protected $audit_user_upd;
    
      /**
     * @var string $audit_date_upd
     *
     *@ORM\Column(name="audit_date_upd", type="datetime", nullable=false)
     */
    protected $audit_date_upd;
    
    
     /**
     * @var string $auditDeleted
     *
     * @ORM\Column(name="audit_deleted", type="boolean", nullable=false)
     */
    protected $auditDeleted;
    
    
    public function getRegVentaId() {
        return $this->RegVentaId;
    }

    public function setRegVentaId($RegVentaId) {
        $this->RegVentaId = $RegVentaId;
    }

    public function getEntidad() {
        return $this->entidad;
    }

    public function setEntidad($entidad) {
        $this->entidad = $entidad;
    }

    public function getAlcohol() {
        return $this->alcohol;
    }

    public function setAlcohol($alcohol) {
        $this->alcohol = $alcohol;
    }

    public function getRegveFecha() {
        return $this->regveFecha;
    }

    public function setRegveFecha($regveFecha) {
        $this->regveFecha = $regveFecha;
    }

    public function getRegveNIT() {
        return $this->regveNIT;
    }

    public function setRegveNIT($regveNIT) {
        $this->regveNIT = $regveNIT;
    }

    public function getRegveNombre() {
        return $this->regveNombre;
    }

    public function setRegveNombre($regveNombre) {
        $this->regveNombre = $regveNombre;
    }

    public function getRegveMinsal() {
        return $this->regveMinsal;
    }

    public function setRegveMinsal($regveMinsal) {
        $this->regveMinsal = $regveMinsal;
    }

    public function getRegvedgii() {
        return $this->regvedgii;
    }

    public function setRegvedgii($regvedgii) {
        $this->regvedgii = $regvedgii;
    }

    public function getRegveLitros() {
        return $this->regveLitros;
    }

    public function setRegveLitros($regveLitros) {
        $this->regveLitros = $regveLitros;
    }

    public function getRegveGrado() {
        return $this->regveGrado;
    }

    public function setRegveGrado($regveGrado) {
        $this->regveGrado = $regveGrado;
    }
    
    public function getAudituserins() {
        return $this->audit_user_ins;
    }

    public function setAudituserins($audit_user_ins) {
        $this->audit_user_ins = $audit_user_ins;
    }

    public function getAuditdateins() {
        return $this->audit_date_ins;
    }

    public function setAuditdateins($audit_date_ins) {
        $this->audit_date_ins = $audit_date_ins;
    }

    public function getAudituserupd() {
        return $this->audit_user_upd;
    }

    public function setAudituserupd($audit_user_upd) {
        $this->audit_user_upd = $audit_user_upd;
    }

    public function getAuditdateupd() {
        return $this->audit_date_upd;
    }

    public function setAuditdateupd($audit_date_upd) {
        $this->audit_date_upd = $audit_date_upd;
    }

    public function getAuditDeleted() {
        return $this->auditDeleted;
    }

    public function setAuditDeleted($auditDeleted) {
        $this->auditDeleted = $auditDeleted;
    }


    

}