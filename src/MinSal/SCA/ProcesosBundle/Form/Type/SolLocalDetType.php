<?php
namespace MinSal\SCA\ProcesosBundle\Form\Type;

use Doctrine\ORM\EntityRepository;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use MinSal\SCA\AdminBundle\Entity\Cuota;
use MinSal\SCA\AdminBundle\Entity\Entidad;

/**
 * Estructura para formulario de Ingreso de Solicitudes Locales
 *
 * @author Henry Willy Melara
 */
class SolLocalDetType extends AbstractType {
    private $doctrine;
    //private $entId;
    
    public function __construct($doctrine){
        $this->doctrine = $doctrine;
    }
    
    
    /**
     * Utilizado en Symfony 2.1
     * 
     * @param \Symfony\Component\OptionsResolver\OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver){
        $resolver->setDefaults(array(
            'data_class' => 'MinSal\SCA\ProcesosBundle\Entity\SolLocalDet'
        ));
    }
    
    /**
     * Utilizado en Symfony 2.0
     * @param array $options
     * @return type
     */
    public function getDefaultOptions(array $options){
        return array(
            'data_class' => 'MinSal\SCA\ProcesosBundle\Entity\SolLocalDet'
        );
    }
    
    public function buildForm(FormBuilderInterface $builder, array $opciones){
        $builder->add('localDetId', 'hidden');
        
        
        /*##### OJO ===> 
         * No se utilizo un atributo en el formbuilder, debido a que el DropDownList debia pasarsele los Grados, Cuota Disponible
         * Y con el QUeryBuilder no se puede modificar como se genera el HTML.
        */
            
        /*
        $entId = $this->entId;
        $entidad = $this->entidad;
        $cuoTipoLocal = Cuota::$cuoTipoLocal;
        $year = new \DateTime();
        $year = $year->format('Y');
        
        $builder->add('cuota', 'entity', array(
            'class'=>'MinSalSCAAdminBundle:Cuota',
            'query_builder' => function(EntityRepository $er) use($entId, $cuoTipoLocal, $year) {
                return $er->createQueryBuilder('a')
                            ->select('a')
                            ->join('a.entidad','B')
                            ->where('B.entId = :entId
                                    AND a.cuoTipo = :cuoTipo
                                    AND a.cuoYear = :cuoYear
                                    AND a.auditDeleted = false')
                            ->setParameter('entId', $entId)
                            ->setParameter('cuoTipo', $cuoTipoLocal)
                            ->setParameter('cuoYear', $year);
            },
            'property'=> 'cuoNombreEsp',
            'expanded'=>false,
            'multiple'=>false,
            'label'=>'Nombre del Alcohol',
            //'em'=> 'doctrine.orm.entity_manager'
        ));/**/
        
        $builder->add('cuoId', 'hidden', array(
            'label'=>'Nombre del Alcohol',
            'property_path'=> 'cuota.cuoId'
        ));/**/
        
        $builder->add('entId', 'hidden', array(
            'label'=>'Nombre del Proveedor',
            'property_path'=> 'proveedor.entId'
        ));/**/
            
        $builder->add('localDetLitros',  null, array('label' => 'Cantidad (Lts)', 'attr' => array('autocomplete' => 'off'),));
        $builder->add('localDetUso',  null, array('label' => 'Uso del Alcohol'));
        
        $builder->add('localDetLitrosLib',  null, array(
            'label' => 'Litros Liberados',
            'attr' => array('readonly' => 'readonly'),
        ));
    }

    public function getName(){
        return 'SolLocalDet';
    }
}
?>