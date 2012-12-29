<?php
namespace MinSal\SidPla\AdminBundle\Form\Type;

use MinSal\SidPla\AdminBundle\Form\Type\EntidadType;
use MinSal\SidPla\AdminBundle\Form\Type\AlcoholType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Estructura para formulario de Cuotas
 *
 * @author Henry Willy Melara
 * SE CREO INICIALMENTE PARA INTENTAR COLOCAR LAS CUOTAS EN LA MISMA PAGINA DEL FORMULARIO DE EMPRESA.
 * PERO YA NO SE UTILIZO
 */
class CuotaType extends AbstractType {
   
    /**
     * Utilizado en Symfony 2.1
     * 
     * @param \Symfony\Component\OptionsResolver\OptionsResolverInterface $resolver
     */
    public function setDefaultOptions1(OptionsResolverInterface $resolver){
        $resolver->setDefaults(array(
            'data_class' => 'MinSal\SidPla\AdminBundle\Entity\Cuota',
            'csrf_protection' => false,
        ));
    }
    
    /**
     * Utilizado en Symfony 2.0
     * @param array $options
     * @return type
     */
    public function getDefaultOption1(array $options){
        return array(
            'data_class' => 'MinSal\SidPla\AdminBundle\Entity\Cuota',
            'csrf_protection' => false,
        );
    }
    
    public function buildForm(FormBuilder $builder, array $opciones){
        $builder->add('cuoId', 'hidden');
        $builder->add('cuoYear', 'hidden');
        $builder->add('cuoTipo', 'hidden');
        //$builder->add('alcohol.alcId', null, array('label' => 'Nombre del Alcohol', 'property_path' => false));
        //$builder->add('entidad.entId', null, array('label' => 'Nombre del Alcohol', 'property_path' => false));
        
        $builder->add('alcohol', new AlcoholType());
        $builder->add('entidad', new EntidadType());
        
        $builder->add('cuoNombreEsp', null, array('label' => 'Nombre Específico'));
        $builder->add('cuoGrado', null, array('label' => 'Grado'));
        $builder->add('cuoLitros',  null, array('label' => 'Cuota (Lts)'));
    }

    public function getName(){
        return 'Cuota';
    }
}

?>
