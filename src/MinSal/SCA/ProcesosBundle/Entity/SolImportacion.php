<?php

namespace MinSal\SCA\ProcesosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\Common\Collections\ArrayCollection;
use MinSal\SCA\AdminBundle\Entity\Entidad;

/**
 * @ORM\Entity
 * @ORM\Table(name="sca_sol_imp")
 */
class SolImportacion {
    
    public function __construct() {
        $this->entidad = new Entidad();
        $this->solImportacionesDet = new ArrayCollection();
    }
    
    /**
     * @ORM\ManyToOne(targetEntity="MinSal\SCA\AdminBundle\Entity\Entidad", inversedBy="inventarios")
     * @ORM\JoinColumn(name="ent_id", referencedColumnName="ent_id")
     */
    protected $entidad;
    
    /**
     * @ORM\ManyToOne(targetEntity="MinSal\SCA\ProcesosBundle\Entity\Transiciones", inversedBy="solImportaciones")
     * @ORM\JoinColumn(name="tra_id", referencedColumnName="tra_id")
     */
    protected $transicion;
    
    /**
     * @ORM\OneToMany(targetEntity="MinSal\SCA\ProcesosBundle\Entity\SolImportacionDet", mappedBy="solImportacion", cascade={"persist"})
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
    public function addSolImportacionDet($solImportacionDet) {
        $this->solImportacionesDet[] = $solImportacionDet;
    }
}