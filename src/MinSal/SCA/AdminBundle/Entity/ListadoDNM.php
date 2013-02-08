<?php

namespace MinSal\SCA\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MinSal\SCA\AdminBundle\Entity\ListadoDNM 
 * 
 * @ORM\Entity
 * @ORM\Table(name="sca_lista_dnm")
 */
class ListadoDNM
{
    /**
     * @var integer $ldnm_id
     *
     * @ORM\Column(name="ldnm_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */ 

    private $ldnm_id;

    /**
     * @var integer $ldnm_year
     *
     * @ORM\Column(name="ldnm_year", type="integer", length=60)
     */
    private $ldnm_year;

    /**
     * @var string $ldnm_nit
     *
     * @ORM\Column(name="ldnm_nit", type="string", length=60)
     */
    private $ldnm_nit;

    /**
     * @var string $ldnm_nrc
     *
     * @ORM\Column(name="ldnm_nrc", type="string", length=150)
     */
    private $ldnm_nrc;

    /**
     * @var string $ldnm_tipo_persona
     *
     * @ORM\Column(name="ldnm_tipo_persona", type="string")
     */
    private $ldnm_tipo_persona;

  
   /**
     * @var string $ldnm_nombres
     *
     * @ORM\Column(name="ldnm_nombres", type="string", length=150)
     */
    private $ldnm_nombres;
  
   /**
     * @var string $ldnm_apellidos
     *
     * @ORM\Column(name="ldnm_apellidos", type="string", length=150)
     */
    private $ldnm_apellidos;
  
   /**
     * @var string $ldnm_razon
     *
     * @ORM\Column(name="ldnm_razon", type="string", length=150)
     */
    private $ldnm_razon;
  
  


    /**
     * Set ldnm_id
     *
     * @param integer $ldnm_id
     */
    public function setLdnm_id($ldnm_id)
    {
        $this->ldnm_id = $ldnm_id;
    }

    /**
     * Get ldnm_id
     *
     * @return integer 
     */
    public function getLdnm_id()
    {
        return $this->ldnm_id;
    }
	
	
    /**
     * Set ldnm_year
     *
     * @param integer $ldnm_year
     */
    public function setLdnm_year($ldnm_year)
    {
        $this->ldnm_year = $ldnm_year;
    }

    /**
     * Get ldnm_year
     *
     * @return integer 
     */
    public function getLdnm_year()
    {
        return $this->ldnm_year;
    }

 /**
     * Set ldnm_nit
     *
     * @param string $ldnm_nit
     */
    public function setLdnm_nit($ldnm_nit)
    {
        $this->ldnm_nit = $ldnm_nit;
    }

    /**
     * Get ldnm_nit
     *
     * @return string 
     */
    public function getLdnm_nit()
    {
        return $this->ldnm_nit;
    }

 
 /**
     * Set ldnm_nrc
     *
     * @param string $ldnm_nrc
     */
    public function setLdnm_nrc($ldnm_nrc)
    {
        $this->ldnm_nrc = $ldnm_nrc;
    }

    /**
     * Get ldnm_nrc
     *
     * @return string 
     */
    public function getLdnm_nrc()
    {
        return $this->ldnm_nrc;
    }
    
    
     /**
     * Set ldnm_tipo_persona
     *
     * @param string $ldnm_tipo_persona
     */
    public function setLdnm_tipo_persona($ldnm_tipo_persona)
    {if($ldnm_tipo_persona=="Natural") $this->ldnm_tipo_persona = "N";
     if($ldnm_tipo_persona=="Juridica")$this->ldnm_tipo_persona = "J";     
    }

    /**
     * Get ldnm_tipo_persona
     *
     * @return string 
     */
    public function getLdnm_tipo_persona()
    {
    	if($this->ldnm_tipo_persona=="N") return "Natural";
    	if($this->ldnm_tipo_persona=="J") return "Juridica";
    }
    
     /**
     * Set ldnm_nombres
     *
     * @param string $ldnm_nombres
     */
    public function setLdnm_nombres($ldnm_nombres)
    {
        $this->ldnm_nombres = $ldnm_nombres;
    }

    /**
     * Get ldnm_nombres
     *
     * @return string 
     */
    public function getLdnm_nombres()
    {
        return $this->ldnm_nombres;
    }
     
      /**
     * Set ldnm_apellidos
     *
     * @param string $ldnm_apellidos
     */
    public function setLdnm_apellidos($ldnm_apellidos)
    {
        $this->ldnm_apellidos = $ldnm_apellidos;
    }

    /**
     * Get ldnm_apellidos
     *
     * @return string 
     */
    public function getLdnm_apellidos()
    {
        return $this->ldnm_apellidos;
    }  

     /**
     * Set ldnm_razon
     *
     * @param string $ldnm_razon
     */
    public function setLdnm_razon($ldnm_razon)
    {
        $this->ldnm_razon = $ldnm_razon;
    }

    /**
     * Get ldnm_razon
     *
     * @return string 
     */
    public function getLdnm_razon()
    {
        return $this->ldnm_razon;
    }  


   
}