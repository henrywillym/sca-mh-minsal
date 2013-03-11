<?php
namespace  MinSal\SCA\UsersBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\ChangePasswordFormType as BaseType;

/**
 * Formulario para Cambiar Password
 *
 * @author Henry Willy Melara
 */
class ChangePasswordFormType extends BaseType{
    /*
    public function getDefaultOptions(array $options){
        return parent::getDefaultOptions($options);
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver){
        parent::setDefaultOptions($resolver);
    }/**/

    public function buildForm(FormBuilderInterface $builder, array $options){
        parent::buildForm($builder, $options);
    }

    public function getName(){
        return 'sca_change_password';
    }
}
