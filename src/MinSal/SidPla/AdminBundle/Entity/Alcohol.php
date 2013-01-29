<?php
// src/MinSal/SidPla/AdminBundle/Entity/Alcohol.php

namespace MinSal\SidPla\AdminBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use MinSal\SidPla\AdminBundle\Entity\Cuota;
use MinSal\SidPla\AdminBundle\Entity\GrupoAlcohol;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="sca_alcohol")
 */
class Alcohol {
    
    public function __construct() {
        $this->cuotas = new ArrayCollection();
        //$this->grupo = new GrupoAlcohol();
    }
    
    /**
     * @ORM\OneToMany(targetEntity="MinSal\SidPla\AdminBundle\Entity\Cuota", mappedBy="alcohol")
     */
    protected $cuotas;
    
    /**
     * @ORM\ManyToOne(targetEntity="MinSal\SidPla\AdminBundle\Entity\GrupoAlcohol", inversedBy="alcoholes")
     * @ORM\JoinColumn(name="grp_id", referencedColumnName="grp_id")
     */
    protected $grupo;
    
    
    /**
     * @var integer $alcId
     *
     * @ORM\Id
     * @ORM\Column(name="alc_id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $alcId;

    /**
     * @var string $alcNombre
     *
     * @ORM\Column(name="alc_nombre", type="text", nullable=false)
     */
    private $alcNombre;

    /**
     * @var string $alcGrado
     *
     * @ORM\Column(name="alc_grado", type="decimal", nullable=false)
     */
    private $alcGrado;
    
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
    
    
    
    public function getCuotas() {
        return $this->cuotas;
    }

    public function setCuotas($cuotas) {
        $this->cuotas = $cuotas;
    }

    public function getAlcId() {
        return $this->alcId;
    }

    public function setAlcId($alcId) {
        $this->alcId = $alcId;
    }

    public function getAlcNombre() {
        return $this->alcNombre;
    }

    public function setAlcNombre($alcNombre) {
        $this->alcNombre = $alcNombre;
    }

    public function getAlcGrado() {
        return $this->alcGrado;
    }

    public function setAlcGrado($alcGrado) {
        $this->alcGrado = $alcGrado;
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

    public function getGrupo() {
        return $this->grupo;
    }

    public function setGrupo($grupo) {
        $this->grupo = $grupo;
    }
}
