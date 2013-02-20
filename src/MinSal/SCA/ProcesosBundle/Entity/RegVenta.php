<?php

namespace MinSal\SCA\ProcesosBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use MinSal\SCA\AdminBundle\Entity\Entidad;
use MinSal\SCA\ProcesosBundle\Entity\RegVenta;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * RepositoryClass de RegVenta
 *
 * @author Daniel E. Diaz
 */

/**
 * @ORM\Entity
 * @ORM\Table(name="sca_det_registro_ventas")
 */
class RegVenta {
    
    public function __construct() {
        $this->RegVenta = new RegVenta();
        $this->regveAccion = '+';
        $this->regveComentario = 'RegVenta Inicial';
        $this->auditDeleted = false;
    }
    
    /**
     * Se encarga de validar que el valor de los grados se encuentre dentro del rango
     */
    
    public function isValid(){
        $msg = array();
        if($this->getInvGrado()){
            if($this->getInvGrado()+0 <=0 || $this->getInvGrado()+0 >100 ){
                $msg[]='- El grado ingresado "'.$this->getInvGrado().'" debe ser mayor a 0 y menor a 100';
            }
        }else{
            $msg[]='- El campo "Grados" se encuentra vacio';
        }
        
        return $msg;
    }
        
   /**
     * @var integer $RegVentaId
     *
     * @ORM\Column(name="regve_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */ 

    protected $RegVentaId;
    
    /**
     * Es Many-To-One, Unidirectional
     * @ORM\ManyToOne(targetEntity="MinSal\SCA\AdminBundle\Entity\Entidad")
     * @ORM\JoinColumn(name="ent_id", referencedColumnName="ent_id")
     */
    protected $entidad;
    
    /**
     * @ORM\ManyToOne(targetEntity="MinSal\SCA\ProcesosBundle\Entity\Alcohol")
     * @ORM\JoinColumn(name="alc_id", referencedColumnName="alc_id")
     */
    protected $alcohol;
    
    /**
     * @var string $regveFecha
     *
     * @ORM\Column(name="regve_fecha", type="date", nullable=false)
     */
    private $regveFecha;
       
    /**
     * @var numeric $regveNIT
     *
     * @ORM\Column(name="regve_nit", type="integer", nullable=false)
     *  */
    private $regveNIT;
     
     /**
     * @var string $regveNombre
     *
     * @ORM\Column(name="regve_nombre", type="text", nullable=true)
     */
    private $regveNombre;    
      
    /**
     * @var string $regveMinsal
     *
     * @ORM\Column(name="regve_reg_minsal", type="text", nullable=true)
     */
    private $regveMinsal;
    
     /**
     * @var string $regvedgii
     *
     * @ORM\Column(name="regve_reg_dgii", type="text", nullable=true)
     */
    private $regvedgii;
     
   /**
     * @var numeric $regveLitros
     *
     * @ORM\Column(name="regve_litros", type="decimal", nullable=false)
     * @Assert\Type(type="real", message="Los litros ingresados ->{{value}} no es un número valido"),
     * @Assert\Min(limit="0", message="Los litros ingresados {{value}} deben ser mayor a 0")
     */
    private $regveLitros;
    
      /**
     * @var numeric $regveGrado
     *
     * @ORM\Column(name="regve_grado", type="integer", nullable=false)
     *  */
    private $regveGrado;
    
     /**
     * @var string $auditDeleted
     *
     * @ORM\Column(name="audit_deleted", type="boolean", nullable=false)
     */
    private $auditDeleted;
    
    
    

}