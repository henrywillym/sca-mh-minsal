<?php

namespace MinSal\SCA\ProcesosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\Common\Collections\ArrayCollection;
use MinSal\SCA\AdminBundle\Entity\Entidad;
use MinSal\SCA\ProcesosBundle\Entity\SolLocalDet;
use MinSal\SCA\ProcesosBundle\Entity\Transicion;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="sca_sol_local")
 */
class SolLocal {
    
    public function __construct() {
        $this->entidad = new Entidad();
        $this->solLocalesDet = new ArrayCollection();
        $this->transicion = new Transicion();
        $this->solLocalFecha = new \DateTime();
        $this->auditDateIns = new \DateTime();
    }
    
    /**
     * @ORM\ManyToOne(targetEntity="MinSal\SCA\AdminBundle\Entity\Entidad")
     * @ORM\JoinColumn(name="ent_id", referencedColumnName="ent_id")
     */
    protected $entidad;
    
    /**
     * @ORM\ManyToOne(targetEntity="MinSal\SCA\ProcesosBundle\Entity\Transicion", inversedBy="solLocales")
     * @ORM\JoinColumn(name="tra_id", referencedColumnName="tra_id")
     */
    protected $transicion;
    
    /**
     * @ORM\OneToMany(targetEntity="MinSal\SCA\ProcesosBundle\Entity\SolLocalDet", mappedBy="solLocal")
     */
    protected $solLocalesDet;
    
    
    /**
     * @var integer $solLocalId
     *
     * @ORM\Id
     * @ORM\Column(name="sollocal_id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $solLocalId;
    
    
    /**
     * @var string $solLocalComentario
     *
     * @ORM\Column(name="sollocal_comentario", type="text", nullable=true)
     */
    private $solLocalComentario;
    
    
    /**
     * @var \DateTime $solLocalFecha
     *
     * @ORM\Column(name="sollocal_fecha", type="datetime", nullable=false)
     */
    private $solLocalFecha;
    
    
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

    public function getSolLocalesDet() {
        return $this->solLocalesDet;
    }

    public function setSolLocalesDet($solLocalesDet) {
        $this->solLocalesDet = $solLocalesDet;
    }

    public function getSolLocalId() {
        return $this->solLocalId;
    }

    public function setSolLocalId($solLocalId) {
        $this->solLocalId = $solLocalId;
    }

    public function getSolLocalComentario() {
        return $this->solLocalComentario;
    }

    public function setSolLocalComentario($solLocalComentario) {
        $this->solLocalComentario = $solLocalComentario;
    }

    public function getSolLocalFecha() {
        return $this->solLocalFecha;
    }

    public function setSolLocalFecha($solLocalFecha) {
        $this->solLocalFecha = $solLocalFecha;
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
    public function addSolLocalDet(SolLocalDet $solLocalDet) {
        $this->solLocalesDet[] = $solLocalDet;
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
    
    public function getSolLocalFechaText() {
        return $this->solLocalFecha->format('Y-m-d');
    }
}