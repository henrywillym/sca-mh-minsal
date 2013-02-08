<?php

namespace MinSal\SCA\ProcesosBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="sca_aranceles")
 */
class Arancel {
    
    public function __construct() {
        
    }
    
    /**
     * @var integer $araId
     *
     * @ORM\Id
     * @ORM\Column(name="ara_id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $araId;
    
    /**
     * @var string $araCodigo
     *
     * @ORM\Column(name="ara_codigo", type="string", length=50, nullable=false)
     */
    private $araCodigo;
    
    /**
     * @var string $araDescripcion
     *
     * @ORM\Column(name="ara_descripcion", type="text", nullable=false)
     */
    private $araDescripcion;

    /**
     * @var string $araIVA
     *
     * @ORM\Column(name="ara_iva", type="decimal", nullable=true)
     */
    private $araIVA;
    
    /**
     * @var string $araDAI
     *
     * @ORM\Column(name="ara_dai", type="decimal", nullable=true)
     */
    private $araDAI;
    
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
    
    
    
    public function getAraId() {
        return $this->araId;
    }

    public function setAraId($araId) {
        $this->araId = $araId;
    }

    public function getAraCodigo() {
        return $this->araCodigo;
    }

    public function setAraCodigo($araCodigo) {
        $this->araCodigo = $araCodigo;
    }

    public function getAraDescripcion() {
        return $this->araDescripcion;
    }

    public function setAraDescripcion($araDescripcion) {
        $this->araDescripcion = $araDescripcion;
    }

    public function getAraIVA() {
        return $this->araIVA;
    }

    public function setAraIVA($araIVA) {
        $this->araIVA = $araIVA;
    }

    public function getAraDAI() {
        return $this->araDAI;
    }

    public function setAraDAI($araDAI) {
        $this->araDAI = $araDAI;
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
