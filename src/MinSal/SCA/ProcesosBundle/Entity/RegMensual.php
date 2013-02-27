<?php

namespace MinSal\SCA\ProcesosBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use MinSal\SCA\AdminBundle\Entity\Entidad;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * RepositoryClass de RegMensual
 *
 * @author Daniel E. Diaz
 */

/**
 * @ORM\Entity
 * @ORM\Table(name="sca_registro_mensual")
 */
class RegMensual {
    
    public function __construct() {
        //$this->RegMensual = new RegMensual();
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
     * @var numeric $RegMenId
     *
     * @ORM\Column(name="regmen_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */ 

    protected $RegMenId;
    
    /**
     * @var integer $entId
     * Es Many-To-One, Unidirectional
     * @ORM\ManyToOne(targetEntity="MinSal\SCA\AdminBundle\Entity\Entidad")
     * @ORM\JoinColumn(name="ent_id", referencedColumnName="ent_id")
     * @ORM\Column(name="ent_id", type="integer", nullable=false)
     */
    protected $entidad;

       
    /**
     * @var numeric $regmen_year
     *
     * @ORM\Column(name="regmen_year", type="decimal", nullable=false)
     *  */
    protected $regmen_year;
    
     /**
     * @var numeric $regmen_mes
     *
     * @ORM\Column(name="regmen_mes", type="decimal", nullable=false)
     *  */
    protected $regmen_mes;
      
    /**
     * @var string $regmen_excedente_ant
     *
     * @ORM\Column(name="regmen_excedente_ant", type="decimal", nullable=false)
     * @Assert\Type(type="real", message="Los litros ingresados ->{{value}} no es un número valido"),
     * @Assert\Min(limit="0", message="Los litros ingresados {{value}} deben ser mayor a 0")
     */
    protected $regmen_excedente_ant;
    
     /**
     * @var string $regmen_prod
    *
     * @ORM\Column(name="regmen_prod", type="decimal", nullable=false)
     * @Assert\Type(type="real", message="Los litros ingresados ->{{value}} no es un número valido"),
     * @Assert\Min(limit="0", message="Los litros ingresados {{value}} deben ser mayor a 0")
      */
    protected $regmen_prod;
     
   /**
     * @var numeric $regmen_imp
     *
     * @ORM\Column(name="regmen_imp", type="decimal", nullable=false)
     * @Assert\Type(type="real", message="Los litros ingresados ->{{value}} no es un número valido"),
     * @Assert\Min(limit="0", message="Los litros ingresados {{value}} deben ser mayor a 0")
     */
    protected $regmen_imp;

    
     /**
     * @var numeric $regmen_compra_local
     *
     * @ORM\Column(name="regmen_compra_local", type="decimal", nullable=false)
     * @Assert\Type(type="real", message="Los litros ingresados ->{{value}} no es un número valido"),
     * @Assert\Min(limit="0", message="Los litros ingresados {{value}} deben ser mayor a 0")
     */
      protected $regmen_compra_local;
    
     /**
     * @var numeric $regmen_venta_local
     *
     * @ORM\Column(name="regmen_venta_local", type="decimal", nullable=false)
     * @Assert\Type(type="real", message="Los litros ingresados ->{{value}} no es un número valido"),
     * @Assert\Min(limit="0", message="Los litros ingresados {{value}} deben ser mayor a 0")
     */
    protected $regmen_venta_local;
    
     /**
     * @var numeric $regmen_venta_inter
     *
     * @ORM\Column(name="regmen_venta_inter", type="decimal", nullable=false)
     * @Assert\Type(type="real", message="Los litros ingresados ->{{value}} no es un número valido"),
     * @Assert\Min(limit="0", message="Los litros ingresados {{value}} deben ser mayor a 0")
     */
    protected $regmen_venta_inter;    
    
     /**
     * @var numeric $regmen_utilizacion
     *
     * @ORM\Column(name="regmen_utilizacion", type="decimal", nullable=false)
     * @Assert\Type(type="real", message="Los litros ingresados ->{{value}} no es un número valido"),
     * @Assert\Min(limit="0", message="Los litros ingresados {{value}} deben ser mayor a 0")
     */
    protected $regmen_utilizacion;
    
     /**
     * @var numeric $regmen_perdida
     *
     * @ORM\Column(name="regmen_perdida", type="decimal", nullable=false)
     * @Assert\Type(type="real", message="Los litros ingresados ->{{value}} no es un número valido"),
     * @Assert\Min(limit="0", message="Los litros ingresados {{value}} deben ser mayor a 0")
     */
    protected $regmen_perdida;
    
     
    /**
     * @var string $audit_user_ins
     *
     *@ORM\Column(name="audit_user_ins", type="string", nullable=false)
     */
    protected $audit_user_ins;
    
     
    /**
     * @var string $audit_date_ins
     *
     *@ORM\Column(name="audit_date_ins", type="string", nullable=false)
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
     *@ORM\Column(name="audit_date_upd", type="string", nullable=false)
     */
    protected $audit_date_upd;
    
    
     /**
     * @var string $auditDeleted
     *
     * @ORM\Column(name="audit_deleted", type="boolean", nullable=false)
     */
    protected $auditDeleted;
    
    
    public function getRegMenId() {
        return $this->RegMenId;
    }

    public function setRegMenId($RegMenId) {
        $this->RegMenId = $RegMenId;
    }

    public function getEntidad() {
        return $this->entidad;
    }

    public function setEntidad($entidad) {
        $this->entidad = $entidad;
    }

    public function getRegmen_year() {
        return $this->regmen_year;
    }

    public function setRegmen_year($regmen_year) {
        $this->regmen_year = $regmen_year;
    }

    public function getRegmen_mes() {
        return $this->regmen_mes;
    }

    public function setRegmen_mes($regmen_mes) {
        $this->regmen_mes = $regmen_mes;
    }

    public function getRegmen_excedente_ant() {
        return $this->regmen_excedente_ant;
    }

    public function setRegmen_excedente_ant($regmen_excedente_ant) {
        $this->regmen_excedente_ant = $regmen_excedente_ant;
    }

    public function getRegmen_prod() {
        return $this->regmen_prod;
    }

    public function setRegmen_prod($regmen_prod) {
        $this->regmen_prod = $regmen_prod;
    }

    public function getRegmen_imp() {
        return $this->regmen_imp;
    }

    public function setRegmen_imp($regmen_imp) {
        $this->regmen_imp = $regmen_imp;
    }

    public function getRegmen_compra_local() {
        return $this->regmen_compra_local;
    }

    public function setRegmen_compra_local($regmen_compra_local) {
        $this->regmen_compra_local = $regmen_compra_local;
    }

    public function getRegmen_venta_local() {
        return $this->regmen_venta_local;
    }

    public function setRegmen_venta_local($regmen_venta_local) {
        $this->regmen_venta_local = $regmen_venta_local;
    }

    public function getRegmen_venta_inter() {
        return $this->regmen_venta_inter;
    }

    public function setRegmen_venta_inter($regmen_venta_inter) {
        $this->regmen_venta_inter = $regmen_venta_inter;
    }

    public function getRegmen_utilizacion() {
        return $this->regmen_utilizacion;
    }

    public function setRegmen_utilizacion($regmen_utilizacion) {
        $this->regmen_utilizacion = $regmen_utilizacion;
    }

    public function getRegmen_perdida() {
        return $this->regmen_perdida;
    }

    public function setRegmen_perdida($regmen_perdida) {
        $this->regmen_perdida = $regmen_perdida;
    }

    public function getAudit_user_ins() {
        return $this->audit_user_ins;
    }

    public function setAudit_user_ins($audit_user_ins) {
        $this->audit_user_ins = $audit_user_ins;
    }

    public function getAudit_date_ins() {
        return $this->audit_date_ins;
    }

    public function setAudit_date_ins($audit_date_ins) {
        $this->audit_date_ins = $audit_date_ins;
    }

    public function getAudit_user_upd() {
        return $this->audit_user_upd;
    }

    public function setAudit_user_upd($audit_user_upd) {
        $this->audit_user_upd = $audit_user_upd;
    }

    public function getAudit_date_upd() {
        return $this->audit_date_upd;
    }

    public function setAudit_date_upd($audit_date_upd) {
        $this->audit_date_upd = $audit_date_upd;
    }

    public function getAuditDeleted() {
        return $this->auditDeleted;
    }

    public function setAuditDeleted($auditDeleted) {
        $this->auditDeleted = $auditDeleted;
    }

    
    
}