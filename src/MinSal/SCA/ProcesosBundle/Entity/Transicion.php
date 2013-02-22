<?php

namespace MinSal\SCA\ProcesosBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="sca_transiciones")
 */
class Transicion {
    
    public function __construct() {
        $this->auditDateIns = new \DateTime();
        $this->traComentario = false;
        $this->traLitrosLibera = false;
        
        $this->solImportaciones = new ArrayCollection();
        //$this->solLocales = new ArrayCollection();
        $this->parentsTransicion = new ArrayCollection();
        $this->childrenTransicion = new ArrayCollection();
    }
    
    /**
     * Es Many-To-One, Unidirectional
     * @ORM\ManyToOne(targetEntity="MinSal\SCA\ProcesosBundle\Entity\Etapa")
     * @ORM\JoinColumn(name="etpInicio_id", referencedColumnName="etp_id")
     */
    protected $etpInicio;
    
    /**
     * Es Many-To-One, Unidirectional
     * @ORM\ManyToOne(targetEntity="MinSal\SCA\ProcesosBundle\Entity\Etapa")
     * @ORM\JoinColumn(name="etpFin_id", referencedColumnName="etp_id")
     */
    protected $etpFin;
    
    /**
     * Es Many-To-One, Unidirectional
     * @ORM\ManyToOne(targetEntity="MinSal\SCA\ProcesosBundle\Entity\Flujo")
     * @ORM\JoinColumn(name="flu_id", referencedColumnName="flu_id")
     */
    protected $flujo;
    
    /**
     * Es Many-To-One, Unidirectional
     * @ORM\ManyToOne(targetEntity="MinSal\SCA\ProcesosBundle\Entity\Estado")
     * @ORM\JoinColumn(name="est_id", referencedColumnName="est_id")
     */
    protected $estado;
    
    
    /**
     * @ORM\OneToMany(targetEntity="MinSal\SCA\ProcesosBundle\Entity\SolImportacion", mappedBy="transicion")
     */
    protected $solImportaciones;
    
    /**
     * ORM\OneToMany(targetEntity="MinSal\SCA\ProcesosBundle\Entity\SolLocal", mappedBy="transicion")
     */
    //protected $solLocales;
    
    /**
     * Many to Many Self-Reference
     * @ORM\ManyToMany(targetEntity="Transicion", mappedBy="childrenTransicion")
     **/
    protected $parentsTransicion;

    /**
     * @ORM\ManyToMany(targetEntity="Transicion", inversedBy="parentsTransicion")
     * @ORM\JoinTable(name="sca_transiciones_mov",
     *      joinColumns={@ORM\JoinColumn(name="traparent_id", referencedColumnName="tra_id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="trachild_id", referencedColumnName="tra_id")}
     * )
     **/
    protected $childrenTransicion;
    
    /**
     * @ORM\ManyToMany(targetEntity="MinSal\SCA\AdminBundle\Entity\RolSistema", mappedBy="transiciones")
     */
    protected $rols;

    
    
    /**
     * @var integer $traId
     *
     * @ORM\Id
     * @ORM\Column(name="tra_id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $traId;
    
    /**
     * @var boolean $traComentario
     *
     * @ORM\Column(name="tra_comentario", type="boolean", nullable=false)
     */
    private $traComentario;
    
    /**
     * @var boolean $traLitrosLibera
     *
     * @ORM\Column(name="tra_litros_libera", type="boolean", nullable=false)
     */
    private $traLitrosLibera;
    
    /**
     * @var boolean $traLiberaTotal
     *
     * @ORM\Column(name="tra_libera_total", type="boolean", nullable=false)
     */
    private $traLiberaTotal;
    
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
    
    
    public function getTraId() {
        return $this->traId;
    }

    public function setTraId($traId) {
        $this->traId = $traId;
    }

    public function getTraNombre() {
        return $this->traNombre;
    }

    public function setTraNombre($traNombre) {
        $this->traNombre = $traNombre;
    }

    public function getTraDesc() {
        return $this->traDesc;
    }

    public function setTraDesc($traDesc) {
        $this->traDesc = $traDesc;
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
    
    public function getEtpInicio() {
        return $this->etpInicio;
    }

    public function setEtpInicio($etpInicio) {
        $this->etpInicio = $etpInicio;
    }

    public function getEtpFin() {
        return $this->etpFin;
    }

    public function setEtpFin($etpFin) {
        $this->etpFin = $etpFin;
    }

    public function getFlujo() {
        return $this->flujo;
    }

    public function setFlujo($flujo) {
        $this->flujo = $flujo;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }
    
    public function getSolImportaciones() {
        return $this->solImportaciones;
    }

    public function setSolImportaciones($solImportaciones) {
        $this->solImportaciones = $solImportaciones;
    }

    public function getParentsTransicion() {
        return $this->parentsTransicion;
    }

    public function setParentsTransicion($parentsTransicion) {
        $this->parentsTransicion = $parentsTransicion;
    }

    public function getChildrenTransicion() {
        return $this->childrenTransicion;
    }

    public function setChildrenTransicion($childrenTransicion) {
        $this->childrenTransicion = $childrenTransicion;
    }
    
    public function getTraComentario() {
        return $this->traComentario === 'true' || $this->traComentario === true;
    }

    public function setTraComentario($traComentario) {
        $this->traComentario = $traComentario;
    }
    
    public function getTraLitrosLibera() {
        return $this->traLitrosLibera === 'true' || $this->traLitrosLibera === true;
    }

    public function setTraLitrosLibera($traLitrosLibera) {
        $this->traLitrosLibera = $traLitrosLibera;
    }
    
    public function getTraLiberaTotal() {
        return $this->traLiberaTotal=== 'true' || $this->traLiberaTotal === true;
    }

    public function setTraLiberaTotal($traLiberaTotal) {
        $this->traLiberaTotal = $traLiberaTotal;
    }
    
    public function getRoles() {
        return $this->roles;
    }

    public function setRoles($roles) {
        $this->roles = $roles;
    }

    
                
    //*********** CUSTOM SET/GET ******************
    public function addSolImportacion($solImportacion) {
        $this->solImportaciones[] = $solImportacion;
    }
    
    public function addParentTransicion($transicion) {
        $this->parentsTransicion[] = $transicion;
    }
    
    public function addChildTransicion($transicion) {
        $this->childrenTransicion[] = $transicion;
    }
    
    public function addRol(\MinSal\SCA\AdminBundle\Entity\RolSistema $rol)
    {
        $this->rols[] = $rol;
    }
}