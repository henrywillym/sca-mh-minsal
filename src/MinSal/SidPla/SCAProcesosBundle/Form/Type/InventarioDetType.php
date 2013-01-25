<?php
namespace MinSal\SidPla\SCAProcesosBundle\Form\Type;

use MinSal\SidPla\AdminBundle\Form\Type\AlcoholType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;


/**
 * Estructura para formulario de Ingreso a Inventario de alcoholes
 *
 * @author Henry Willy Melara
 */
class InventarioDetType extends AbstractType {
   
    /**
     * Utilizado en Symfony 2.1
     * 
     * @param \Symfony\Component\OptionsResolver\OptionsResolverInterface $resolver
     */
    public function setDefaultOptions1(OptionsResolverInterface $resolver){
        $resolver->setDefaults(array(
            'data_class' => 'MinSal\SidPla\SCAProcesosBundle\Entity\InventarioDet'
        ));
    }
    
    /**
     * Utilizado en Symfony 2.0
     * @param array $options
     * @return type
     */
    public function getDefaultOption(array $options){
        return array(
            'data_class' => 'MinSal\SidPla\SCAProcesosBundle\Entity\InventarioDet'
        );
    }
    
    public function buildForm(FormBuilder $builder, array $opciones){
        $builder->add('invDetId', 'hidden');
        //$builder->add('alcohol.alcId', null, array('label' => 'Nombre del Alcohol', 'property_path' => false));
        //$builder->add('entidad.entId', null, array('label' => 'Nombre del Alcohol', 'property_path' => false));
        
        $builder->add('alcohol', 'entity', array(
            'class'=>'MinSalSidPlaAdminBundle:Alcohol',
            'query_builder' => function(EntityRepository $er) {
                return $er->createQueryBuilder('u')
                        ->where('u.auditDeleted = false');
            },/**/
            'property'=> 'alcNombre',
            'expanded'=>false,
            'multiple'=>false
        ));/**/
        
        $builder->add('invNombreEsp', null, array('label' => 'Nombre Específico'));
        $builder->add('invGrado', null, array('label' => 'Grado'));
        $builder->add('invDetLitros',  null, array('label' => 'Cuota (Lts)'));
        $builder->add('invDetComentario',  null, array('label' => 'Comentarios'));
    }

    public function getName(){
        return 'InventarioDet';
    }
}

?>
