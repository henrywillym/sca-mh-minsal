<?php
namespace MinSal\SCA\AdminBundle\Form\Type;

use MinSal\SCA\AdminBundle\Form\Type\EntidadType;
use MinSal\SCA\AdminBundle\Form\Type\AlcoholType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Estructura para formulario de Alcoholes
 *
 * @author Henry Willy Melara
 */
class AlcoholType extends AbstractType {
   
    /**
     * Utilizado en Symfony 2.1
     * 
     * @param \Symfony\Component\OptionsResolver\OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver){
        $resolver->setDefaults(array(
            'data_class' => 'MinSal\SCA\AdminBundle\Entity\Alcohol',
            'csrf_protection' => false,
        ));
    }
    
    /**
     * Utilizado en Symfony 2.0
     * @param array $options
     * @return type
     */
    public function getDefaultOptions(array $options){
        return array(
            'data_class' => 'MinSal\SCA\AdminBundle\Entity\Alcohol',
            'csrf_protection' => false,
        );
    }
    
    public function buildForm(FormBuilderInterface $builder, array $opciones){
        $builder->add('alcId', 'hidden');
        $builder->add('alcNombre', 'hidden');
        $builder->add('alcGrado', 'hidden');
    }

    public function getName(){
        return 'Alcohol';
    }
}

?>
