<?php

namespace MinSal\SCA\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use MinSal\SCA\AdminBundle\Entity\Alcohol; 
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="sca_grupos_alcohol")
 */
class GrupoAlcohol {
    
    public function __construct() {
        $this->alcoholes = new ArrayCollection();
    }
    
    /**
     * @ORM\OneToMany(targetEntity="MinSal\SCA\AdminBundle\Entity\Alcohol", mappedBy="grupo")
     */
    protected $alcoholes;
    
    
    /**
     * @var integer $grpId
     *
     * @ORM\Id
     * @ORM\Column(name="grp_id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $grpId;

    /**
     * @var string $grpNombre
     *
     * @ORM\Column(name="grp_nombre", type="string", length=100, nullable=false)
     */
    private $grpNombre;

    /**
     * @var boolean $grpImpuesto
     *
     * @ORM\Column(name="grp_impuesto", type="boolean", nullable=false)
     */
    private $grpImpuesto;
    
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
     * var string $auditDeleted
     *
     * ORM\Column(name="audit_deleted", type="boolean", nullable=false)
     */
    //private $auditDeleted;

    
    public function getAlcoholes() {
        return $this->alcoholes;
    }

    public function setAlcoholes($alcoholes) {
        $this->alcoholes = $alcoholes;
    }

    public function getGrpId() {
        return $this->grpId;
    }

    public function setGrpId($grpId) {
        $this->grpId = $grpId;
    }

    public function getGrpNombre() {
        return $this->grpNombre;
    }

    public function setGrpNombre($grpNombre) {
        $this->grpNombre = $grpNombre;
    }

    public function getGrpImpuesto() {
        return $this->grpImpuesto;
    }

    public function setGrpImpuesto($grpImpuesto) {
        $this->grpImpuesto = $grpImpuesto;
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
}