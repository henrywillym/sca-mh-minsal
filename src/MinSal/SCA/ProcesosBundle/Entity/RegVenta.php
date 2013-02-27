<?php

namespace MinSal\SCA\ProcesosBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use MinSal\SCA\AdminBundle\Entity\Entidad;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * RepositoryClass de RegVenta
 *
 * @author Daniel E. Diaz
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
        if($this->getInvGrado()){
            if($this->getInvGrado()+0 <=0 || $this->getInvGrado()+0 >100 ){
                $msg[]='- El grado ingresado "'.$this->getInvGrado().'" debe ser mayor a 0 y menor a 100';
            }
        }else{
            $msg[]='- El campo "Grados" se encuentra vacio';
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
     * @ORM\ManyToOne(targetEntity="MinSal\SCA\AdminBundle\Entity\Alcohol")
     * @ORM\JoinColumn(name="alc_id", referencedColumnName="alc_id")
     * * @ORM\Column(name="alc_id", type="integer", nullable=false)
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
     * @ORM\Column(name="regve_reg_minsal", type="decimal", nullable=false)
     */
    private $regveMinsal;
    
     /**
     * @var string $regvedgii
     *
     * @ORM\Column(name="regve_reg_dgii", type="decimal", nullable=false)
     */
    private $regvedgii;
     
   /**
     * @var numeric $regveLitros
     *
     * @ORM\Column(name="regve_litros", type="decimal", nullable=false)
     * @Assert\Type(type="real", message="Los litros ingresados ->{{value}} no es un número valido"),
     * @Assert\Min(limit="0", message="Los litros ingresados {{value}} deben ser mayor a 0")
     */
    private $regveLitros;
    
      /**
     * @var numeric $regveGrado
     *
     * @ORM\Column(name="regve_grado", type="decimal", nullable=false)
     *  */
    private $regveGrado;
    
     /**
     * @var string $auditDeleted
     *
     * @ORM\Column(name="audit_deleted", type="boolean", nullable=false)
     */
    private $auditDeleted;
    
    
    
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

    public function getAuditDeleted() {
        return $this->auditDeleted;
    }

    public function setAuditDeleted($auditDeleted) {
        $this->auditDeleted = $auditDeleted;
    }


    

}