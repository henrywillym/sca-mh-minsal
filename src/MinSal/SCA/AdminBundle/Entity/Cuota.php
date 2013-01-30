<?php
// src/MinSal/SCA/AdminBundle/Entity/Cuota.php

namespace MinSal\SCA\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\Common\Collections\ArrayCollection;
use MinSal\SCA\AdminBundle\Entity\Alcohol;
use MinSal\SCA\AdminBundle\Entity\Entidad;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity
 * @ORM\Table(name="sca_cuotas")
 * @UniqueEntity(fields={"entidad","alcohol","cuoYear","cuoTipo", "cuoGrado","cuoNombreEsp"},message="Ya existe un registro similar")
 */
class Cuota {
    
    public function __construct() {
        //$this->alcohol = new ArrayCollection();
        //$this->entidad = new ArrayCollection();
        $this->auditDeleted = false;
    }
    
    /**
     * @ORM\ManyToOne(targetEntity="MinSal\SCA\AdminBundle\Entity\Alcohol", inversedBy="cuotas")
     * @ORM\JoinColumn(name="alc_id", referencedColumnName="alc_id")
     */
    protected $alcohol;
    
    /**
     * @ORM\ManyToOne(targetEntity="MinSal\SCA\AdminBundle\Entity\Entidad", inversedBy="cuotas")
     * @ORM\JoinColumn(name="ent_id", referencedColumnName="ent_id")
     */
    protected $entidad;
    
    
    /**
     * @var integer $cuoId
     *
     * @ORM\Id
     * @ORM\Column(name="cuo_id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $cuoId;
    
    /**
     * @var string $cuoYear
     * 
     * @ORM\Column(name="cuo_year", type="integer", nullable=false)
     * @Assert\Type(type="integer", message="El año {{value}} no es un valor entero valido")
     */
    private $cuoYear;
    
    /**
     * @var string $cuoTipo
     *
     * @ORM\Column(name="cuo_tipo", type="string", length=1, nullable=false)
     * @Assert\Choice(choices= {"I","L"}, message="Tipo de Cuota no valido --> {{value}}")
     */
    private $cuoTipo;
    
    /**
     * @var string $cuoNombreEsp
     *
     * @ORM\Column(name="cuo_nombre_esp", type="string", length=255, nullable=false)
     * @Assert\NotNull(message="Debe especificar el nombre especifico")
     */
    private $cuoNombreEsp;
    
    /**
     * @var string $cuoGrado
     *
     * @ORM\Column(name="cuo_grado", type="decimal", nullable=false)
     * @Assert\Type(type="real", message="El grado ingresado ->{{value}} no es un número valido"),
     * @Assert\Min(limit="0", message="El grado ingresado {{value}}debe ser mayor a 0"),
     * @Assert\Max(limit="100", message="El grado ingresado {{value}} debe menor mayor a 100")
     */
    private $cuoGrado;
    
    /**
     * @var string $cuoLitros
     *
     * @ORM\Column(name="cuo_litros", type="decimal", nullable=false)
     * @Assert\Type(type="real", message="Los litros ingresados ->{{value}} no es un número valido"),
     * @Assert\Min(limit="0", message="Los Litros ingresados {{value}} debe ser mayor a 0")
     */
    private $cuoLitros;
    
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
    
    
    
    public function getAlcohol() {
        return $this->alcohol;
    }

    public function setAlcohol($alcohol) {
        $this->alcohol = $alcohol;
    }

    public function getCuoId() {
        return $this->cuoId;
    }

    public function setCuoId($cuoId) {
        $this->cuoId = $cuoId;
    }

    public function getCuoYear() {
        return $this->cuoYear;
    }

    public function setCuoYear($cuoYear) {
        $this->cuoYear = $cuoYear;
    }

    public function getCuoTipo() {
        return $this->cuoTipo;
    }

    public function setCuoTipo($cuoTipo) {
        $this->cuoTipo = $cuoTipo;
    }

    public function getCuoGrado() {
        return $this->cuoGrado;
    }

    public function setCuoGrado($cuoGrado) {
        $this->cuoGrado = $cuoGrado;
    }

    public function getCuoLitros() {
        return $this->cuoLitros;
    }

    public function setCuoLitros($cuoLitros) {
        $this->cuoLitros = $cuoLitros;
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
    
    public function getEntidad() {
        return $this->entidad;
    }

    public function setEntidad($entidad) {
        $this->entidad = $entidad;
    }

    public function getCuoNombreEsp() {
        return $this->cuoNombreEsp;
    }

    public function setCuoNombreEsp($cuoNombreEsp) {
        $this->cuoNombreEsp = $cuoNombreEsp;
    }


}