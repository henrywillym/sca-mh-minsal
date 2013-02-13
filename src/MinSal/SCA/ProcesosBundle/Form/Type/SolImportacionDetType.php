<?php
namespace MinSal\SCA\ProcesosBundle\Form\Type;

use Doctrine\ORM\EntityRepository;
//use MinSal\SCA\AdminBundle\EntityDao\AlcoholDao;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use MinSal\SCA\AdminBundle\Entity\Cuota;
use MinSal\SCA\AdminBundle\Entity\Entidad;

/**
 * Estructura para formulario de Ingreso de Solicitud de Importaciones
 *
 * @author Henry Willy Melara
 */
class SolImportacionDetType extends AbstractType {
    private $doctrine;
    private $entId;
    
    public function __construct($doctrine){
        $this->doctrine = $doctrine;
    }
    
    
    /**
     * Utilizado en Symfony 2.1
     * 
     * @param \Symfony\Component\OptionsResolver\OptionsResolverInterface $resolver
     */
    public function setDefaultOptions1(OptionsResolverInterface $resolver){
        $resolver->setDefaults(array(
            'data_class' => 'MinSal\SCA\ProcesosBundle\Entity\SolImportacionDet'
        ));
    }
    
    /**
     * Utilizado en Symfony 2.0
     * @param array $options
     * @return type
     */
    public function getDefaultOptions(array $options){
        return array(
            'data_class' => 'MinSal\SCA\ProcesosBundle\Entity\SolImportacionDet'
        );
    }
    
    public function buildForm(FormBuilder $builder, array $opciones){
        $builder->add('impDetId', 'hidden');
        
        $builder->add('arancel', 'entity', array(
            'class'=>'MinSalSCAProcesosBundle:Arancel',
            'query_builder' => function(EntityRepository $er) {
                return $er->createQueryBuilder('u')
                        ->where('u.auditDeleted = false');
            },
            //'property'=> 'araDescripcion',
            'expanded'=>false,
            'multiple'=>false,
            'label'=> 'Inciso Arancelario'
        ));/**/
        
        /*##### OJO ===> 
         * No se utilizo un atributo en el formbuilder, debido a que el DropDownList debia pasarsele los Grados, Cuota Disponible
         * Y con el QUeryBuilder no se puede modificar como se genera el HTML.
        */
            
        /*
        $entId = $this->entId;
        $entidad = $this->entidad;
        $cuoTipoImportacion = Cuota::$cuoTipoImportacion;
        $year = new \DateTime();
        $year = $year->format('Y');
        
        $builder->add('cuota', 'entity', array(
            'class'=>'MinSalSCAAdminBundle:Cuota',
            'query_builder' => function(EntityRepository $er) use($entId, $cuoTipoImportacion, $year) {
                return $er->createQueryBuilder('a')
                            ->select('a')
                            ->join('a.entidad','B')
                            ->where('B.entId = :entId
                                    AND a.cuoTipo = :cuoTipo
                                    AND a.cuoYear = :cuoYear
                                    AND a.auditDeleted = false')
                            ->setParameter('entId', $entId)
                            ->setParameter('cuoTipo', $cuoTipoImportacion)
                            ->setParameter('cuoYear', $year);
            },
            'property'=> 'cuoNombreEsp',
            'expanded'=>false,
            'multiple'=>false,
            'label'=>'Nombre del Alcohol',
            //'em'=> 'doctrine.orm.entity_manager'
        ));/**/
        /*
        $builder->add('cuota', 'hidden', array(
            'label'=>'Nombre del Alcohol'
        ));/**/
            
        $builder->add('impDetFactCom', 'text', array('label' => 'No. Factura Comercial','required'=>true));
        $builder->add('impDetProvNom', 'text', array('label' => 'Nombre Empresa Proveedora','required'=>true));
        $builder->add('impDetPaisProc',  null, array('label' => 'País de Procedencia'));
        $builder->add('impDetPaisOri',  null, array('label' => 'País de Origen'));
        $builder->add('impDetProvDirec',  null, array('label' => 'Dirección Proveedor (Exterior)'));
        $builder->add('impDetLitros',  null, array('label' => 'Cantidad (Lts)'));
        $builder->add('impDetUso',  null, array('label' => 'Uso del Alcohol'));
        
        //$builder->add('solImpComentario',  null, array('label' => 'Comentarios'));
    }

    public function getName(){
        return 'SolImportacionDet';
    }
}

?>
