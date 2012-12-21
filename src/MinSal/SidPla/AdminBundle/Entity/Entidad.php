<?php
// src/MinSal/SidPla/AdminBundle/Entity/Entidad.php

namespace MinSal\SidPla\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * (repositoryClass="MinSal\SidPla\AdminBundle\Entity\EntidadRepository")
 * @ORM\Entity
 * @ORM\Table(name="sca_entidades_ctg")
 */
class Entidad {
    
    /**
     * @var integer $entId
     *
     * @ORM\Column(name="ent_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $entId;

    /**
     * @var string $entRegDgii
     *
     * @ORM\Column(name="ent_reg_dgii", type="text", nullable=false)
     */
    private $entRegDgii;

    /**
     * @var string $entRegMinsal
     *
     * @ORM\Column(name="ent_reg_minsal", type="text", nullable=false)
     */
    private $entRegMinsal;

    /**
     * @var string $entNrc
     *
     * @ORM\Column(name="ent_nrc", type="text", nullable=true)
     */
    private $entNrc;

    /**
     * @var string $entTel
     *
     * @ORM\Column(name="ent_tel", type="string", length=20)
     */
    private $entTel;

    /**
     * @var string $entGiro
     *
     * @ORM\Column(name="ent_giro", type="text")
     */
    private $entGiro;

    
    /**
     * @var string $entTipoPersona
     *
     * @ORM\Column(name="ent_tipo_persona", type="string", length=1)
     */
    private $entTipoPersona;
    
    /**
     * @var string $entEmail
     *
     * @ORM\Column(name="ent_email", type="string", length=50)
     */
    private $entEmail;
    
    /**
     * @var string $entEmail
     *
     * @ORM\Column(name="ent_nit", type="string", length=50, unique=true)
     */
    private $entNit;
    
    /**
     * @var string $entNombre
     *
     * @ORM\Column(name="ent_nombre", type="string", length=100)
     */
    private $entNombre;
    
    /**
     * @var string $entNombComercial
     *
     * @ORM\Column(name="ent_nomb_comercial", type="string", length=100)
     */
    private $entNombComercial;
    
    /**
     * @var string $entTipoDoc
     *
     * @ORM\Column(name="ent_tipo_doc", type="string", length=1, nullable=true)
     */
    private $entTipoDoc;
    
    /**
     * @var string $entActua
     *
     * @ORM\Column(name="ent_actua", type="string", length=1, nullable=true)
     */
    private $entActua;
    
    /**
     * @var string $entRepNit
     *
     * @ORM\Column(name="ent_rep_nit", type="string", length=20, nullable=true)
     */
    private $entRepNit;
    
    /**
     * @var string $entRepDoc
     *
     * @ORM\Column(name="ent_rep_doc", type="string", length=50, nullable=true)
     */
    private $entRepDoc;
    
    /**
     * @var string $ent+ RepNombre
     *
     * @ORM\Column(name="ent_rep_nombre", type="string", length=100, nullable=true)
     */
    private $entRepNombre;
    
    /**
     * @var string $entDireccionMatriz
     *
     * @ORM\Column(name="ent_direccion_matriz", type="text")
     */
    private $entDireccionMatriz;
    
    /**
     * @var string $entUsosAlcohol
     *
     * @ORM\Column(name="ent_usos_alcohol", type="text")
     */
    private $entUsosAlcohol;
    
    /**
     * @var integer $entYear
     *
     * @ORM\Column(name="ent_year", type="integer")
     */
    private $entYear;
    
    /**
     * @var datetime $entVenc
     *
     * @ORM\Column(name="ent_venc", type="datetime")
     */
    private $entVenc;
    
    /**
     * @var boolean $entDistribuidor
     *
     * @ORM\Column(name="ent_distribuidor", type="boolean")
     */
    private $entDistribuidor;
    
    /**
     * @var boolean $entProductor
     *
     * @ORM\Column(name="ent_productor", type="boolean")
     */
    private $entProductor;
    
    /**
     * @var boolean $entComprador
     *
     * @ORM\Column(name="ent_comprador", type="boolean")
     */
    private $entComprador;
    
    /**
     * @var boolean $entCompVend
     *
     * @ORM\Column(name="ent_comp_vend", type="boolean")
     */
    private $entCompVend;
    
    /**
     * @var decimal $entProdEstEtil
     *
     * @ORM\Column(name="ent_prod_est_etil", type="decimal", nullable=true)
     */
    private $entProdEstEtil;
    
    /**
     * @var decimal $entHabilitado
     *
     * @ORM\Column(name="ent_habilitado", type="boolean")
     */
    private $entHabilitado;
    
    /**
     * @var string $entComentario
     *
     * @ORM\Column(name="ent_comentario", type="text", nullable=true)
     */
    private $entComentario;
    
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
     * @ORM\OneToMany(targetEntity="MinSal\SidPla\UsersBundle\Entity\User", mappedBy="entidad")
     */
    protected $users;
    


    /**
     * Set usuario
     *
     * @param MinSal\SidPla\AdminBundle\Entity\User $usuario
     */
    public function setUsuario(\MinSal\SidPla\UsersBundle\Entity\User $usuario) {
        $this->usuario = $usuario;
    }

    /**
     * Get usuario
     *
     * @return MinSal\SidPla\AdminBundle\Entity\User 
     */
    public function getUsuario() {
        return $this->usuario;
    }
    
    public function getEntId() {
        return $this->entId;
    }

    public function setEntId($entId) {
        $this->entId = $entId;
    }

    public function getEntRegDgii() {
        return $this->entRegDgii;
    }

    public function setEntRegDgii($entRegDgii) {
        $this->entRegDgii = $entRegDgii;
    }

    public function getEntRegMinsal() {
        return $this->entRegMinsal;
    }

    public function setEntRegMinsal($entRegMinsal) {
        $this->entRegMinsal = $entRegMinsal;
    }

    public function getEntNrc() {
        return $this->entNrc;
    }

    public function setEntNrc($entNrc) {
        $this->entNrc = $entNrc;
    }

    public function getEntTel() {
        return $this->entTel;
    }

    public function setEntTel($entTel) {
        $this->entTel = $entTel;
    }

    public function getEntGiro() {
        return $this->entGiro;
    }

    public function setEntGiro($entGiro) {
        $this->entGiro = $entGiro;
    }

    public function getEntTipoPersona() {
        return $this->entTipoPersona;
    }

    public function setEntTipoPersona($entTipoPersona) {
        $this->entTipoPersona = $entTipoPersona;
    }

    public function getEntEmail() {
        return $this->entEmail;
    }

    public function setEntEmail($entEmail) {
        $this->entEmail = $entEmail;
    }

    public function getEntNit() {
        return $this->entNit;
    }

    public function setEntNit($entNit) {
        $this->entNit = $entNit;
    }

    public function getEntNombre() {
        return $this->entNombre;
    }

    public function setEntNombre($entNombre) {
        $this->entNombre = $entNombre;
    }

    public function getEntNombComercial() {
        return $this->entNombComercial;
    }

    public function setEntNombComercial($entNombComercial) {
        $this->entNombComercial = $entNombComercial;
    }

    public function getEntTipoDoc() {
        return $this->entTipoDoc;
    }

    public function setEntTipoDoc($entTipoDoc) {
        $this->entTipoDoc = $entTipoDoc;
    }

    public function getEntActua() {
        return $this->entActua;
    }

    public function setEntActua($entActua) {
        $this->entActua = $entActua;
    }

    public function getEntRepNit() {
        return $this->entRepNit;
    }

    public function setEntRepNit($entRepNit) {
        $this->entRepNit = $entRepNit;
    }

    public function getEntRepDoc() {
        return $this->entRepDoc;
    }

    public function setEntRepDoc($entRepDoc) {
        $this->entRepDoc = $entRepDoc;
    }

    public function getEntRepNombre() {
        return $this->entRepNombre;
    }

    public function setEntRepNombre($entRepNombre) {
        $this->entRepNombre = $entRepNombre;
    }

    public function getEntDireccionMatriz() {
        return $this->entDireccionMatriz;
    }

    public function setEntDireccionMatriz($entDireccionMatriz) {
        $this->entDireccionMatriz = $entDireccionMatriz;
    }

    public function getEntUsosAlcohol() {
        return $this->entUsosAlcohol;
    }

    public function setEntUsosAlcohol($entUsosAlcohol) {
        $this->entUsosAlcohol = $entUsosAlcohol;
    }

    public function getEntYear() {
        return $this->entYear;
    }

    public function setEntYear($entYear) {
        $this->entYear = $entYear;
    }

    public function getEntVenc() {
        return $this->entVenc;
    }

    public function setEntVenc($entVenc) {
        $this->entVenc = $entVenc;
    }

    public function getEntDistribuidor() {
        return $this->entDistribuidor;
    }

    public function setEntDistribuidor($entDistribuidor) {
        $this->entDistribuidor = $entDistribuidor;
    }

    public function getEntProductor() {
        return $this->entProductor;
    }

    public function setEntProductor($entProductor) {
        $this->entProductor = $entProductor;
    }

    public function getEntComprador() {
        return $this->entComprador;
    }

    public function setEntComprador($entComprador) {
        $this->entComprador = $entComprador;
    }

    public function getEntCompVend() {
        return $this->entCompVend;
    }

    public function setEntCompVend($entCompVend) {
        $this->entCompVend = $entCompVend;
    }

    public function getEntProdEstEtil() {
        return $this->entProdEstEtil;
    }

    public function setEntProdEstEtil($entProdEstEtil) {
        $this->entProdEstEtil = $entProdEstEtil;
    }

    public function getEntHabilitado() {
        return $this->entHabilitado;
    }

    public function setEntHabilitado($entHabilitado) {
        $this->entHabilitado = $entHabilitado;
    }

    public function getEntComentario() {
        return $this->entComentario;
    }

    public function setEntComentario($entComentario) {
        $this->entComentario = $entComentario;
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

    
    public function __toString() {
        return 'ID ' . $this->getIdEmpleado() . ' ' . $this->getPrimerNombre() . ' ' . $this->getPrimerApellido();
    }
}