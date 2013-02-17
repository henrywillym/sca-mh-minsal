<?php

namespace MinSal\SCA\ProcesosBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="sca_etapas")
 */
class Etapa {
    
    public function __construct() {
        $this->auditDateIns = new \DateTime();
    }
    
    /**
     * @var integer $etpId
     *
     * @ORM\Id
     * @ORM\Column(name="etp_id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $etpId;
    
    /**
     * @var string $etpNombre
     *
     * @ORM\Column(name="etp_nombre", type="string", length=100, nullable=false)
     */
    private $etpNombre;
    
    /**
     * @var string $etpDesc
     *
     * @ORM\Column(name="etp_desc", type="text", nullable=false)
     */
    private $etpDesc;
    
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
    
    
    public function getEtpId() {
        return $this->etpId;
    }

    public function setEtpId($etpId) {
        $this->etpId = $etpId;
    }

    public function getEtpNombre() {
        return $this->etpNombre;
    }

    public function setEtpNombre($etpNombre) {
        $this->etpNombre = $etpNombre;
    }

    public function getEtpDesc() {
        return $this->etpDesc;
    }

    public function setEtpDesc($etpDesc) {
        $this->etpDesc = $etpDesc;
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
}
