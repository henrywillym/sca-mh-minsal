<?php
// src/MinSal/SidPla/AdminBundle/Entity/Cuota.php

namespace MinSal\SidPla\SCAProcesosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\Common\Collections\ArrayCollection;
use MinSal\SidPla\AdminBundle\Entity\Alcohol;
use MinSal\SidPla\AdminBundle\Entity\Entidad;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity
 * @ORM\Table(name="sca_inventarios")
 * @UniqueEntity(fields={"entidad","alcohol","invGrado","invNombreEsp"},message="Ya existe un registro similar")
 */
class Inventario {
    
    public function __construct() {
        $this->alcohol = new Alcohol();
        $this->entidad = new Entidad();
        $this->inventariosDet = new ArrayCollection();
        $this->invLitros = 0;
        $this->invGrados = 0;
        $this->invReservado = 0;
    }
    
    /**
     * Es Many-To-One, Unidirectional
     * @ORM\ManyToOne(targetEntity="MinSal\SidPla\AdminBundle\Entity\Alcohol")
     * @ORM\JoinColumn(name="alc_id", referencedColumnName="alc_id")
     */
    protected $alcohol;
    
    /**
     * @ORM\ManyToOne(targetEntity="MinSal\SidPla\AdminBundle\Entity\Entidad", inversedBy="inventarios")
     * @ORM\JoinColumn(name="ent_id", referencedColumnName="ent_id")
     */
    protected $entidad;
    
    /**
     * @ORM\OneToMany(targetEntity="MinSal\SidPla\SCAProcesosBundle\Entity\InventarioDet", mappedBy="inventario", cascade={"persist"})
     */
    protected $inventariosDet;
    
    /**
     * @var integer $invId
     *
     * @ORM\Id
     * @ORM\Column(name="inv_id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $invId;
    
    
    /**
     * @var string $invLitros
     *
     * @ORM\Column(name="inv_litros", type="decimal", nullable=false)
     * @Assert\Type(type="real", message="Los litros ingresados ->{{value}} no es un número valido"),
     * @Assert\Min(limit="0", message="Los litros ingresados {{value}} deben ser mayor a 0")
     */
    private $invLitros;
    
    
    /**
     * @var string $invGrado
     *
     * @ORM\Column(name="inv_grado", type="decimal", nullable=false)
     * @Assert\Type(type="real", message="El grado ingresado ->{{value}} no es un número valido"),
     * @Assert\Min(limit="0", message="El grado ingresado {{value}} debe ser mayor a 0"),
     * @Assert\Max(limit="100", message="El grado ingresado {{value}} debe menor mayor a 100")
     */
    private $invGrado;
    
    
    /**
     * @var string $invNombreEsp
     *
     * @ORM\Column(name="inv_nombre_esp", type="string", length=255, nullable=false)
     * @Assert\NotNull(message="Debe especificar el nombre especifico")
     */
    private $invNombreEsp;
    
    
    /**
     * @var string $invReservado
     *
     * @ORM\Column(name="inv_reservado", type="decimal", nullable=true)
     * @Assert\Min(limit="0", message="El grado ingresado {{value}} debe ser mayor a 0")
     */
    private $invReservado;
    
    
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
    
    

    public function getAlcohol() {
        return $this->alcohol;
    }

    public function setAlcohol($alcohol) {
        $this->alcohol = $alcohol;
    }

    public function getEntidad() {
        return $this->entidad;
    }

    public function setEntidad($entidad) {
        $this->entidad = $entidad;
    }

    public function getInvId() {
        return $this->invId;
    }

    public function setInvId($invId) {
        $this->invId = $invId;
    }

    public function getInvLitros() {
        return $this->invLitros;
    }

    public function setInvLitros($invLitros) {
        $this->invLitros = $invLitros;
    }

    public function getInvGrado() {
        return $this->invGrado;
    }

    public function setInvGrado($invGrado) {
        $this->invGrado = $invGrado;
    }

    public function getInvNombreEsp() {
        return $this->invNombreEsp;
    }

    public function setInvNombreEsp($invNombreEsp) {
        $this->invNombreEsp = $invNombreEsp;
    }

    public function getInvReservado() {
        return $this->invReservado;
    }

    public function setInvReservado($invReservado) {
        $this->invReservado = $invReservado;
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

    public function getInventariosDet() {
        return $this->inventariosDet;
    }

    public function setInventariosDet($inventariosDet) {
        $this->inventariosDet = $inventariosDet;
    }
    
    //*********** CUSTOM SET/GET ******************
    public function addInventarioDet($inventarioDet) {
        $this->inventariosDet[] = $inventarioDet;
    }
}