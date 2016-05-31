<?php

namespace MinSal\SCA\ProcesosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * MinSal\SCA\AdminBundle\Entity\ListadoMH
 * 
 * @ORM\Entity
 * @ORM\Table(name="sca_lista_mh")
 */
class ListadoMH{
    
    public function __construct() {
        $this->auditDateIns = new \DateTime();
    }
    
    /**
     * @var integer $mhId
     *
     * @ORM\Column(name="mh_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */ 
    private $mhId;

    /**
     * @var integer $mhYear
     *
     * @ORM\Column(name="mh_year", type="integer", length=60)
     */
    private $mhYear;

    /**
     * @var string $mhNIT
     *
     * @ORM\Column(name="mh_nit", type="string", length=60)
     */
    private $mhNIT;

    /**
     * @var string $mhNRC
     *
     * @ORM\Column(name="mh_nrc", type="string", length=150)
     */
    private $mhNRC;

    /**
     * @var string $mhTipoPersona
     *
     * @ORM\Column(name="mh_tipo_persona", type="string")
     */
    private $mhTipoPersona;

  
   /**
     * @var string $mhNombres
     *
     * @ORM\Column(name="mh_nombres", type="string", length=100)
     */
    private $mhNombres;
  
   /**
     * @var string $mhApellidos
     *
     * @ORM\Column(name="mh_apellidos", type="string", length=100)
     */
    private $mhApellidos;
  
   /**
     * @var string $mhRazon
     *
     * @ORM\Column(name="mh_razon", type="string", length=100)
     */
    private $mhRazon;
    
    
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
     * @Assert\File(maxSize="6000000")
     */
    public $file;
    
    public $path;

    public function getAbsolutePath() {
        return null === $this->path
            ? null
            : $this->getUploadRootDir().'/'.$this->path;
    }

    public function getWebPath(){
        return null === $this->path
            ? null
            : $this->getUploadDir().'/'.$this->path;
    }

    protected function getUploadRootDir(){
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__.'/../../../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir(){
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return 'uploads/documents';
    }
  
  

    public function getMhId() {
        return $this->mhId;
    }

    public function setMhId($mhId) {
        $this->mhId = $mhId;
    }

    public function getMhYear() {
        return $this->mhYear;
    }

    public function setMhYear($mhYear) {
        $this->mhYear = $mhYear;
    }

    public function getMhNIT() {
        return $this->mhNIT;
    }

    public function setMhNIT($mhNIT) {
        $this->mhNIT = $mhNIT;
    }

    public function getMhNRC() {
        return $this->mhNRC;
    }

    public function setMhNRC($mhNRC) {
        $this->mhNRC = $mhNRC;
    }

    public function getMhTipoPersona() {
        return $this->mhTipoPersona;
    }

    public function setMhTipoPersona($mhTipoPersona) {
        $this->mhTipoPersona = $mhTipoPersona;
    }

    public function getMhNombres() {
        return $this->mhNombres;
    }

    public function setMhNombres($mhNombres) {
        $this->mhNombres = $mhNombres;
    }

    public function getMhApellidos() {
        return $this->mhApellidos;
    }

    public function setMhApellidos($mhApellidos) {
        $this->mhApellidos = $mhApellidos;
    }

    public function getMhRazon() {
        return $this->mhRazon;
    }

    public function setMhRazon($mhRazon) {
        $this->mhRazon = $mhRazon;
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
    
    
    
    public function getMhTipoPersonaText(){
    	if($this->mhTipoPersona=="N") 
            return "Natural";
    	else if($this->mhTipoPersona=="J") 
            return "Jurídica";
    }
    
    public function upload(){
        // the file property can be empty if the field is not required
        if (null === $this->file) {
            return;
        }

        // use the original file name here but you should
        // sanitize it at least to avoid any security issues

        // move takes the target directory and then the
        // target filename to move to
        $this->file->move(
            $this->getUploadRootDir(),
            $this->file->getClientOriginalName()
        );

        // set the path property to the filename where you've saved the file
        $this->path = $this->file->getClientOriginalName();

        // clean up the file property as you won't need it anymore
        $this->file = null;
    }
  
}