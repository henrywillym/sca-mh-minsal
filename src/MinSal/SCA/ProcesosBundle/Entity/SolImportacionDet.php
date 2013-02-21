<?php

namespace MinSal\SCA\ProcesosBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use MinSal\SCA\AdminBundle\Entity\Cuota;
use MinSal\SCA\ProcesosBundle\Entity\Arancel;
use MinSal\SCA\ProcesosBundle\Entity\SolImportacion;
use MinSal\SCA\ProcesosBundle\EntityDao\InventarioDetDao;
use MinSal\SCA\ProcesosBundle\EntityDao\SolImportacionDao;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="sca_sol_imp_det")
 * UniqueEntity(fields="solImportacion", message="Ya existe otro item con esta ID de solicitud")
 */
class SolImportacionDet {
    
    public function __construct() {
        //$this->auditDateIns = new \DateTime();
        $this->impDetLitrosLib = 0;
        $this->solImportacion = new SolImportacion();
        $this->cuota = new Cuota();
        $this->inventariosDet = new ArrayCollection();
    }
    
    /**
     * Se encarga de validar que el valor de los grados se encuentre dentro del rango
     */
    public function isValid($doctrine, $entidad){
        $msg = array();
        if($this->getImpDetLitros()){
            if($this->getImpDetLitros()+0 <=0 ){
                $msg[]='- La cantidad en litros ingresados "'.$this->getImpDetLitros().'" debe ser mayor a 0';
            }else{
                $solImportacionDao = new SolImportacionDao($doctrine);
                $inventarioDetDao = new InventarioDetDao($doctrine);

                $litrosInventario = $inventarioDetDao->getLitrosInventarioXCuota($entidad->getEntId(), $this->getCuota()->getCuoId());
                $litrosSolicitudesPendientes = $solImportacionDao->getLitrosSolicitudXCuota($entidad->getEntId(), $this->getCuota()->getCuoId());
                
                $disponible = $this->getCuota()->getCuoLitros() - $litrosInventario - $litrosSolicitudesPendientes;
                
                if( $this->getImpDetLitros() > $disponible ){
                    $msg[]='- La cantidad en litros ingresados "'.$this->getImpDetLitros().'" es mayor al saldo disponible de la cuota "'.$disponible.'"';
                }
            }
        }else{
            $msg[]='- El campo "Cantidad" se encuentra vacio';
        }
        
        return $msg;
    }
    
    /**
     * Es Many-To-One, Unidirectional
     * @ORM\ManyToOne(targetEntity="MinSal\SCA\AdminBundle\Entity\Cuota")
     * @ORM\JoinColumn(name="cuo_id", referencedColumnName="cuo_id")
     */
    protected $cuota;
    
    /**
     * Es Many-To-One, Unidirectional
     * @ORM\ManyToOne(targetEntity="MinSal\SCA\ProcesosBundle\Entity\Arancel")
     * @ORM\JoinColumn(name="ara_id", referencedColumnName="ara_id")
     **/
    protected $arancel;
    
    /**
     * @ORM\ManyToOne(targetEntity="MinSal\SCA\ProcesosBundle\Entity\SolImportacion", inversedBy="solImportacionesDet")
     * @ORM\JoinColumn(name="solimp_id", referencedColumnName="solimp_id")
     */
    protected $solImportacion;
    
    /**
     * @ORM\OneToMany(targetEntity="MinSal\SCA\ProcesosBundle\Entity\InventarioDet", mappedBy="solImportacionDet", cascade={"persist"})
     */
    protected $inventariosDet;
    
    /**
     * @var integer $impDetId
     *
     * @ORM\Id
     * @ORM\Column(name="impdet_id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $impDetId;
    
    
    /**
     * @var string $impDetFactCom
     *
     * @ORM\Column(name="impdet_fact_com", type="text", nullable=false)
     */
    private $impDetFactCom;
    
    
    /**
     * @var string $impDetProvNom
     *
     * @ORM\Column(name="impdet_prov_nom", type="text", nullable=false)
     */
    private $impDetProvNom;
    
    /**
     * @var string $impDetProvDirec
     *
     * @ORM\Column(name="impdet_prov_direc", type="text", nullable=false)
     */
    private $impDetProvDirec;
    
    
    /**
     * @var string $impDetPaisProc
     *
     * @ORM\Column(name="impdet_pais_proc", type="string", length=100, nullable=false)
     */
    private $impDetPaisProc;
    
    
    /**
     * @var string $impDetPaisOri
     *
     * @ORM\Column(name="impdet_pais_ori", type="string", length=100, nullable=false)
     */
    private $impDetPaisOri;
    
    
    /**
     * @var numeric $impDetLitros
     *
     * @ORM\Column(name="impdet_litros", type="decimal", nullable=false)
     * @Assert\Type(type="real", message="Los litros ingresados ->{{value}} no es un número valido"),
     * @Assert\Min(limit="0", message="Los litros ingresados {{value}} deben ser mayor a 0")
     */
    private $impDetLitros;
    
    
    /**
     * @var string $impDetUso
     *
     * @ORM\Column(name="impdet_uso", type="text", nullable=false)
     */
    private $impDetUso;
    
    /**
     * @var numeric $impDetLitrosLib
     *
     * @ORM\Column(name="impdet_litros_lib", type="decimal", nullable=true)
     * @Assert\Min(limit="0", message="Los litros liberados ingresados {{value}} deben ser mayor a 0")
     */
    private $impDetLitrosLib;
    
    
    
    public function getCuota() {
        return $this->cuota;
    }

    public function setCuota($cuota) {
        $this->cuota = $cuota;
    }

    public function getArancel() {
        return $this->arancel;
    }

    public function setArancel($arancel) {
        $this->arancel = $arancel;
    }

    public function getSolImportacion() {
        return $this->solImportacion;
    }

    public function setSolImportacion($solImportacion) {
        $this->solImportacion = $solImportacion;
    }

    public function getInventariosDet() {
        return $this->inventariosDet;
    }

    public function setInventariosDet($inventariosDet) {
        $this->inventariosDet = $inventariosDet;
    }

    public function getImpDetId() {
        return $this->impDetId;
    }

    public function setImpDetId($impDetId) {
        $this->impDetId = $impDetId;
    }

    public function getImpDetFactCom() {
        return $this->impDetFactCom;
    }

    public function setImpDetFactCom($impDetFactCom) {
        $this->impDetFactCom = $impDetFactCom;
    }

    public function getImpDetProvNom() {
        return $this->impDetProvNom;
    }

    public function setImpDetProvNom($impDetProvNom) {
        $this->impDetProvNom = $impDetProvNom;
    }

    public function getImpDetProvDirec() {
        return $this->impDetProvDirec;
    }

    public function setImpDetProvDirec($impDetProvDirec) {
        $this->impDetProvDirec = $impDetProvDirec;
    }

    public function getImpDetPaisProc() {
        return $this->impDetPaisProc;
    }

    public function setImpDetPaisProc($impDetPaisProc) {
        $this->impDetPaisProc = $impDetPaisProc;
    }

    public function getImpDetPaisOri() {
        return $this->impDetPaisOri;
    }

    public function setImpDetPaisOri($impDetPaisOri) {
        $this->impDetPaisOri = $impDetPaisOri;
    }

    public function getImpDetLitros() {
        return $this->impDetLitros;
    }

    public function setImpDetLitros($impDetLitros) {
        $this->impDetLitros = $impDetLitros;
    }

    public function getImpDetUso() {
        return $this->impDetUso;
    }

    public function setImpDetUso($impDetUso) {
        $this->impDetUso = $impDetUso;
    }

    public function getImpDetLitrosLib() {
        return $this->impDetLitrosLib;
    }

    public function setImpDetLitrosLib($impDetLitrosLib) {
        $this->impDetLitrosLib = $impDetLitrosLib;
    }

    
    
    //*********** CUSTOM SET/GET ******************
    public function addInventarioDet($inventarioDet) {
        $this->inventariosDet[] = $inventarioDet;
    }
}