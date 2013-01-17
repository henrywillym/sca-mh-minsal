<?php
namespace  MinSal\SidPla\UsersBundle\Form\Type;

use Symfony\Component\Form\FormBuilder;
use FOS\UserBundle\Form\Type\ChangePasswordFormType as BaseType;

/**
 * Formulario para Cambiar Password
 *
 * @author Henry Willy Melara
 */
class ChangePasswordFormType extends BaseType{
    
    public function getDefaultOptions(array $options){
        return parent::getDefaultOptions($options);
    }

    public function buildForm(FormBuilder $builder, array $options){
        parent::buildForm($builder, $options);
    }

    public function getName(){
        return 'sidpla_change_password';
    }
}
