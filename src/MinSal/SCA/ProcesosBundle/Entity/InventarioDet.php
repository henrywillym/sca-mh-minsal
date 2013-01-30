<?php

namespace MinSal\SCA\ProcesosBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use MinSal\SCA\AdminBundle\Entity\Entidad;
use MinSal\SCA\ProcesosBundle\Entity\Inventario;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="sca_inventarios_det")
 */
class InventarioDet {
    
    public function __construct() {
        //$this->alcohol = new ArrayCollection();
        //$this->entidad = new ArrayCollection();
        $this->inventario = new Inventario();
        $this->invDetAccion = '+';
        $this->invDetComentario = 'Inventario Inicial';
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
     * Es Many-To-One, Unidirectional
     * @ORM\ManyToOne(targetEntity="MinSal\SCA\AdminBundle\Entity\Cuota")
     * @ORM\JoinColumn(name="cuo_id", referencedColumnName="cuo_id")
     */
    protected $cuota;
    
    /**
     * @ORM\ManyToOne(targetEntity="MinSal\SCA\ProcesosBundle\Entity\Inventario", inversedBy="inventariosDet", cascade={"persist"})
     * @ORM\JoinColumn(name="inv_id", referencedColumnName="inv_id")
     */
    protected $inventario;
    
    /**
     * Es One-to-One Self-Referencing
     * @ORM\OneToOne(targetEntity="MinSal\SCA\ProcesosBundle\Entity\InventarioDet")
     * @ORM\JoinColumn(name="invdet_id_origen", referencedColumnName="invdet_id")
     **/
    protected $inventarioOrigen;
    
    /**
     * Es Many-To-One, Unidirectional
     * @ORM\ManyToOne(targetEntity="MinSal\SCA\AdminBundle\Entity\Entidad")
     * @ORM\JoinColumn(name="ent_id", referencedColumnName="ent_id")
     */
    protected $entidad;
    
    /**
     * ORM\ManyToOne(targetEntity="MinSal\SCA\ProcesosBundle\Entity\SolicitudImportacion", inversedBy="inventariosDet")
     * ORM\JoinColumn(name="alc_id", referencedColumnName="alc_id")
     */
    protected $solImportacion;
    
    /**
     * ORM\ManyToOne(targetEntity="MinSal\SCA\ProcesosBundle\Entity\SolicitudLocal", inversedBy="inventariosDet")
     * ORM\JoinColumn(name="alc_id", referencedColumnName="alc_id")
     */
    protected $solLocal;
    
    
    /**
     * @var integer $invDetId
     *
     * @ORM\Id
     * @ORM\Column(name="invdet_id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $invDetId;
    
    
    /**
     * @var string $invDetAccion
     *
     * @ORM\Column(name="invdet_accion", type="string", length=1, nullable=false)
     * @Assert\Choice(choices= {"+","-","R"}, message="Tipo de Acción no valida --> {{value}}")
     */
    private $invDetAccion;
    
    
    /**
     * @var string $invDetFecha
     *
     * @ORM\Column(name="invdet_fecha", type="date", nullable=false)
     */
    private $invDetFecha;
    
    
    /**
     * @var numeric $invDetLitros
     *
     * @ORM\Column(name="invdet_litros", type="decimal", nullable=false)
     * @Assert\Type(type="real", message="Los litros ingresados ->{{value}} no es un número valido"),
     * @Assert\Min(limit="0", message="Los litros ingresados {{value}} deben ser mayor a 0")
     */
    private $invDetLitros;
    
    
    /**
     * @var string $invDetComentario
     *
     * @ORM\Column(name="invdet_comentario", type="text", nullable=true)
     */
    private $invDetComentario;
    
    
    /**
     * @var DateTime $auditDateIns
     *
     * @ORM\Column(name="audit_date_ins", type="datetime")
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
    
    
    
    public function getCuota() {
        return $this->cuota;
    }

    public function setCuota($cuota) {
        $this->cuota = $cuota;
    }

    public function getInventario() {
        return $this->inventario;
    }

    public function setInventario($inventario) {
        $this->inventario = $inventario;
    }

    public function getInventarioOrigen() {
        return $this->inventarioOrigen;
    }

    public function setInventarioOrigen($inventarioOrigen) {
        $this->inventarioOrigen = $inventarioOrigen;
    }

    public function getEntidad() {
        return $this->entidad;
    }

    public function setEntidad($entidad) {
        $this->entidad = $entidad;
    }

    public function getSolImportacion() {
        return $this->solImportacion;
    }

    public function setSolImportacion($solImportacion) {
        $this->solImportacion = $solImportacion;
    }

    public function getSolLocal() {
        return $this->solLocal;
    }

    public function setSolLocal($solLocal) {
        $this->solLocal = $solLocal;
    }

    public function getInvDetId() {
        return $this->invDetId;
    }

    public function setInvDetId($invDetId) {
        $this->invDetId = $invDetId;
    }

    public function getInvDetAccion() {
        return $this->invDetAccion;
    }

    public function setInvDetAccion($invDetAccion) {
        $this->invDetAccion = $invDetAccion;
    }

    public function getInvDetFecha() {
        return $this->invDetFecha;
    }

    public function setInvDetFecha($invDetFecha) {
        $this->invDetFecha = $invDetFecha;
    }

    public function getInvDetLitros() {
        return $this->invDetLitros;
    }

    public function setInvDetLitros($invDetLitros) {
        $this->invDetLitros = $invDetLitros;
    }

    public function getInvDetComentario() {
        return $this->invDetComentario;
    }

    public function setInvDetComentario($invDetComentario) {
        $this->invDetComentario = $invDetComentario;
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
    
    /******  CUSTOM SET/GET *******/
    /*public function getAlcohol() {
        if($this->inventario != null){
            return $this->inventario->getAlcohol();
        }else{
            return null;
        }
    }
    
    public function setAlcohol($alcohol) {
        if($this->inventario == null){
            $this->inventario = new Inventario();
        }
        $this->inventario->setAlcohol($alcohol);
    }/**/
    
    public function getAlcId() {
        if($this->inventario != null){
            return $this->inventario->getAlcohol()->getAlcId();
        }else{
            return null;
        }
    }
    
    public function setAlcId($alcId) {
        if($this->inventario == null){
            $this->inventario = new Inventario();
        }
        $this->inventario->getAlcohol()->setAlcId($alcId);
    }
    
    public function getInvNombreEsp() {
        if($this->inventario != null){
            return $this->inventario->getInvNombreEsp();
        }else{
            return null;
        }
    }
    
    public function setInvNombreEsp($invNombreEsp) {
        $this->inventario->setInvNombreEsp($invNombreEsp);
    }
    
    public function getInvGrado() {
        if($this->inventario != null){
            return $this->inventario->getInvGrado();
        }else{
            return 0;
        }
    }
    
    public function setInvGrado($invGrado) {
        if($this->inventario == null){
            $this->inventario = new Inventario();
        }
        
        $this->inventario->setInvGrado($invGrado);
    }
}