<?php

namespace MinSal\SCA\ProcesosBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="sca_estados")
 */
class Estado {
    public static $RECHAZADO = 2;
    public static $CANCELADO = 4;
    
    public function __construct() {
        $this->auditDateIns = new \DateTime();
    }
    
    /**
     * @var integer $estId
     *
     * @ORM\Id
     * @ORM\Column(name="est_id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $estId;
    
    /**
     * @var string $estNombre
     *
     * @ORM\Column(name="est_nombre", type="string", length=100, nullable=false)
     */
    private $estNombre;
    
    /**
     * @var string $estDesc
     *
     * @ORM\Column(name="est_desc", type="text", nullable=false)
     */
    private $estDesc;
    
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
    
    
    public function getEstId() {
        return $this->estId;
    }

    public function setEstId($estId) {
        $this->estId = $estId;
    }

    public function getEstNombre() {
        return $this->estNombre;
    }

    public function setEstNombre($estNombre) {
        $this->estNombre = $estNombre;
    }

    public function getEstDesc() {
        return $this->estDesc;
    }

    public function setEstDesc($estDesc) {
        $this->estDesc = $estDesc;
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
