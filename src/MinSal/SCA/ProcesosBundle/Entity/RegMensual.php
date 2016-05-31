<?php

namespace MinSal\SCA\ProcesosBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use MinSal\SCA\AdminBundle\Entity\Entidad;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * RepositoryClass de RegMensual
 * @author Daniel E. Diaz (dansel7@gmail.com)
 * 
 * @ORM\Entity
 * @ORM\Table(name="sca_registro_mensual")
 */
class RegMensual {
    
    public function __construct() {
        $year = date("Y");
        $month = date("m");
        $this->regmen_year = $year;
        $this->regmen_mes = $month+0;
        $this->auditDeleted = false;
    }
    
    /**
     * Se encarga de validar que el valor de los grados se encuentre dentro del rango
     */
    
    public function isValid(){
        $msg = array();
        if($this->getInvGrado() != null && $this->getInvGrado()!=''){
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
     * @var integer $alcohol
     * @ORM\ManyToOne(targetEntity="MinSal\SCA\AdminBundle\Entity\Cuota")
     * @ORM\JoinColumn(name="cuo_id", referencedColumnName="cuo_id")
     * * @ORM\Column(name="cuo_id", type="integer", nullable=false)
     */
    protected $alcohol;
       
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
     * @ORM\Column(name="regmen_prod", type="decimal", nullable=true)
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

    
    public function getAlcohol() {
        return $this->alcohol;
    }

    public function setAlcohol($alcohol) {
        $this->alcohol = $alcohol;
    }
    
    public function getRegmenyear() {
        return $this->regmen_year;
    }

    public function setRegmenyear($regmen_year) {
        $this->regmen_year = $regmen_year;
    }

 public function getRegmenmes() {
 
        return $this->regmen_mes;
    }

    public function setRegmenmes($regmen_mes) {
        $this->regmen_mes = $regmen_mes;
    }

    public function getRegmenexcedenteant() {
        return $this->regmen_excedente_ant;
    }

    public function setRegmenexcedenteant($regmen_excedente_ant) {
        $this->regmen_excedente_ant = $regmen_excedente_ant;
    }

    public function getRegmenprod() {
        return $this->regmen_prod;
    }

    public function setRegmenprod($regmen_prod) {
        $this->regmen_prod = $regmen_prod;
    }

    public function getRegmenimp() {
        return $this->regmen_imp;
    }

    public function setRegmenimp($regmen_imp) {
        $this->regmen_imp = $regmen_imp;
    }

    public function getRegmencompralocal() {
        return $this->regmen_compra_local;
    }

    public function setRegmencompralocal($regmen_compra_local) {
        $this->regmen_compra_local = $regmen_compra_local;
    }

    public function getRegmenventalocal() {
        return $this->regmen_venta_local;
    }

    public function setRegmenventalocal($regmen_venta_local) {
        $this->regmen_venta_local = $regmen_venta_local;
    }

    public function getRegmenventainter() {
        return $this->regmen_venta_inter;
    }

    public function setRegmenventainter($regmen_venta_inter) {
        $this->regmen_venta_inter = $regmen_venta_inter;
    }

    public function getRegmenutilizacion() {
        return $this->regmen_utilizacion;
    }

    public function setRegmenutilizacion($regmen_utilizacion) {
        $this->regmen_utilizacion = $regmen_utilizacion;
    }

    public function getRegmenperdida() {
        return $this->regmen_perdida;
    }

    public function setRegmenperdida($regmen_perdida) {
        $this->regmen_perdida = $regmen_perdida;
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