<?php

namespace MinSal\SCA\ProcesosBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use MinSal\SCA\AdminBundle\Entity\Cuota;
use MinSal\SCA\AdminBundle\Entity\Entidad;
use MinSal\SCA\ProcesosBundle\Entity\Inventario;
use MinSal\SCA\ProcesosBundle\EntityDao\InventarioDetDao;
use MinSal\SCA\ProcesosBundle\EntityDao\SolLocalDao;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="sca_sol_local_det")
 */
class SolLocalDet {
    
    public function __construct() {
        $this->localDetLitrosLib = 0;
        $this->solLocal = new SolLocal();
        $this->cuota = new Cuota();
        $this->inventariosDet = new ArrayCollection();
    }
    
    /**
     * Se encarga de validar que el valor de los grados se encuentre dentro del rango
     */
    public function isValid($doctrine, $entidad){
        $msg = array();
        if($this->getLocalDetLitros()){
            if($this->getLocalDetLitros()+0 <=0 ){
                $msg[]='- La cantidad en litros ingresados "'.$this->getLocalDetLitros().'" debe ser mayor a 0';
            }else{
                $solLocalDao = new SolLocalDao($doctrine);
                $inventarioDetDao = new InventarioDetDao($doctrine);

                $litrosInventario = $inventarioDetDao->getLitrosInventarioXCuota($entidad->getEntId(), $this->getCuota()->getCuoId());
                $litrosSolicitudesPendientes = $solLocalDao->getLitrosSolicitudXCuota($entidad->getEntId(), $this->getCuota()->getCuoId());
                
                $disponible = $this->getCuota()->getCuoLitros() - $litrosInventario - $litrosSolicitudesPendientes;
                
                if( $this->getLocalDetLitros() > $disponible ){
                    $msg[]='- La cantidad en litros ingresados "'.$this->getLocalDetLitros().'" es mayor al saldo disponible de la cuota "'.$disponible.'"';
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
     * @ORM\ManyToOne(targetEntity="MinSal\SCA\ProcesosBundle\Entity\SolLocal", inversedBy="solLocalesDet", cascade={"persist"})
     * @ORM\JoinColumn(name="sollocal_id", referencedColumnName="sollocal_id")
     */
    protected $solLocal;
    
    /**
     * @ORM\OneToMany(targetEntity="MinSal\SCA\ProcesosBundle\Entity\InventarioDet", mappedBy="solLocalDet", cascade={"persist"})
     */
    protected $inventariosDet;
    
        
    /**
     * @var integer $localDetId
     *
     * @ORM\Id
     * @ORM\Column(name="localdet_id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $localDetId;
    
    /**
     * @var numeric $localDetLitros
     *
     * @ORM\Column(name="localdet_litros", type="decimal", nullable=false)
     * @Assert\Type(type="real", message="Los litros ingresados ->{{value}} no es un número valido"),
     * @Assert\Min(limit="0", message="Los litros ingresados {{value}} deben ser mayor a 0")
     */
    private $localDetLitros;
    
    
    /**
     * @var string $localDetUso
     *
     * @ORM\Column(name="localdet_uso", type="text", nullable=false)
     */
    private $localDetUso;
    
    /**
     * @var numeric $impDetLitrosLib
     *
     * @ORM\Column(name="localdet_litros_lib", type="decimal", nullable=true)
     * @Assert\Min(limit="0", message="Los litros liberados ingresados {{value}} deben ser mayor a 0")
     */
    private $localDetLitrosLib;
    
    
    
    public function getCuota() {
        return $this->cuota;
    }

    public function setCuota($cuota) {
        $this->cuota = $cuota;
    }

    public function getSolLocal() {
        return $this->solLocal;
    }

    public function setSolLocal($solLocal) {
        $this->solLocal = $solLocal;
    }

    public function getLocalDetId() {
        return $this->localDetId;
    }

    public function setLocalDetId($localDetId) {
        $this->localDetId = $localDetId;
    }

    public function getLocalDetLitros() {
        return $this->localDetLitros;
    }

    public function setLocalDetLitros($localDetLitros) {
        $this->localDetLitros = $localDetLitros;
    }

    public function getLocalDetUso() {
        return $this->localDetUso;
    }

    public function setLocalDetUso($localDetUso) {
        $this->localDetUso = $localDetUso;
    }

    public function getInventariosDet() {
        return $this->inventariosDet;
    }

    public function setInventariosDet($inventariosDet) {
        $this->inventariosDet = $inventariosDet;
    }
    
    public function getLocalDetLitrosLib() {
        return $this->localDetLitrosLib;
    }

    public function setLocalDetLitrosLib($localDetLitrosLib) {
        $this->localDetLitrosLib = $localDetLitrosLib;
    }
        
    /******  CUSTOM SET/GET *******/
    public function addInventarioDet($inventarioDet) {
        $this->inventariosDet[] = $inventarioDet;
    }
}