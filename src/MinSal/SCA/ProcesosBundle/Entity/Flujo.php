<?php

namespace MinSal\SCA\ProcesosBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="sca_flujos")
 */
class Flujo {
    
    public function __construct() {
        $this->auditDateIns = new \DateTime();
    }
    
    /**
     * @var integer $fluId
     *
     * @ORM\Id
     * @ORM\Column(name="flu_id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $fluId;
    
    /**
     * @var string $fluNombre
     *
     * @ORM\Column(name="flu_nombre", type="string", length=100, nullable=false)
     */
    private $fluNombre;
    
    /**
     * @var string $fluDesc
     *
     * @ORM\Column(name="flu_desc", type="text", nullable=false)
     */
    private $fluDesc;
    
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
    
    
    public function getFluId() {
        return $this->fluId;
    }

    public function setFluId($fluId) {
        $this->fluId = $fluId;
    }

    public function getFluNombre() {
        return $this->fluNombre;
    }

    public function setFluNombre($fluNombre) {
        $this->fluNombre = $fluNombre;
    }

    public function getFluDesc() {
        return $this->fluDesc;
    }

    public function setFluDesc($fluDesc) {
        $this->fluDesc = $fluDesc;
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
