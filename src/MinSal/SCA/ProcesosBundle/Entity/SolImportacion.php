<?php

namespace MinSal\SCA\ProcesosBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

use MinSal\SCA\AdminBundle\Entity\Entidad;
use MinSal\SCA\ProcesosBundle\Entity\SolImportacionDet;
use MinSal\SCA\ProcesosBundle\Entity\Transicion;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="sca_sol_imp")
 */
class SolImportacion {
    public static $BLOQUEADA = '** BLOQUEADA **';
    
    public function __construct() {
        $this->entidad = new Entidad();
        $this->solImportacionesDet = new ArrayCollection();
        $this->transicion = new Transicion();
        $this->solImpFecha = new \DateTime();
        $this->auditDateIns = new \DateTime();
    }
    
    /**
     * @ORM\ManyToOne(targetEntity="MinSal\SCA\AdminBundle\Entity\Entidad")
     * @ORM\JoinColumn(name="ent_id", referencedColumnName="ent_id")
     */
    protected $entidad;
    
    /**
     * @ORM\ManyToOne(targetEntity="MinSal\SCA\ProcesosBundle\Entity\Transicion", inversedBy="solImportaciones")
     * @ORM\JoinColumn(name="tra_id", referencedColumnName="tra_id")
     */
    protected $transicion;
    
    /**
     * @ORM\OneToMany(targetEntity="MinSal\SCA\ProcesosBundle\Entity\SolImportacionDet", mappedBy="solImportacion")
     */
    protected $solImportacionesDet;
    
    
    /**
     * @var integer $solImpId
     *
     * @ORM\Id
     * @ORM\Column(name="solimp_id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $solImpId;
    
    
    /**
     * @var string $solImpComentario
     *
     * @ORM\Column(name="solimp_comentario", type="text", nullable=true)
     */
    private $solImpComentario;
    
    
    /**
     * @var \DateTime $solImpFecha
     *
     * @ORM\Column(name="solimp_fecha", type="date", nullable=false)
     */
    private $solImpFecha;
    
    
    /**
     * @var \DateTime $auditDateIns
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
     * @var \DateTime $auditDateUpd
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
    
    public function getEntidad() {
        return $this->entidad;
    }

    public function setEntidad($entidad) {
        $this->entidad = $entidad;
    }

    public function getTransicion() {
        return $this->transicion;
    }

    public function setTransicion($transicion) {
        $this->transicion = $transicion;
    }

    public function getSolImportacionesDet() {
        return $this->solImportacionesDet;
    }

    public function setSolImportacionesDet($solImportacionesDet) {
        $this->solImportacionesDet = $solImportacionesDet;
    }

    public function getSolImpId() {
        return $this->solImpId;
    }

    public function setSolImpId($solImpId) {
        $this->solImpId = $solImpId;
    }

    public function getSolImpComentario() {
        return $this->solImpComentario;
    }

    public function setSolImpComentario($solImpComentario) {
        $this->solImpComentario = $solImpComentario;
    }

    public function getSolImpFecha() {
        return $this->solImpFecha;
    }

    public function setSolImpFecha($solImpFecha) {
        $this->solImpFecha = $solImpFecha;
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

    
    //*********** CUSTOM SET/GET ******************
    public function addSolImportacionDet(SolImportacionDet $solImportacionDet) {
        $this->solImportacionesDet[] = $solImportacionDet;
    }
    
    public function getAuditDateUpdText() {
        if($this->auditDateUpd){
            return $this->auditDateUpd->format('Y-m-d H:i:s');
        }else{
            return '';
        }
    }
    
    public function getAuditDateInsText() {
        return $this->auditDateIns->format('Y-m-d H:i:s');
    }
    
    public function getSolImpFechaText() {
        return $this->solImpFecha->format('Y-m-d');
    }
}
