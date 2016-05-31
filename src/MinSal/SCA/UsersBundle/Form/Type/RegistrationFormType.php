<?php
namespace  MinSal\SCA\UsersBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;
use Doctrine\ORM\EntityRepository;
use MinSal\SCA\UsersBundle\Entity\User;

/**
 * Description of RegistrationFormType
 *
 * @author Henry Willy Melara
 */

class RegistrationFormType  extends BaseType{
    
    /**
     * Utilizado en Symfony 2.1
     * 
     * @param \Symfony\Component\OptionsResolver\OptionsResolverInterface $resolver
     */
    public function setDefaultOptions1(OptionsResolverInterface $resolver){
        $resolver->setDefaults(array(
            'data_class' => 'MinSal\SCA\UsersBundle\Entity\User',
            'csrf_protection' => false,
            'cascade_validation' => false,
        ));
    }
    
    /**
     * Utilizado en Symfony 2.0
     * @param array $options
     * @return type
     */
    public function setDefaultOption1(array $options){
        return array(
            'data_class' => 'MinSal\SCA\UsersBundle\Entity\User',
            'csrf_protection' => false,
            'cascade_validation' => false,
        );
    }
    public function buildForm(FormBuilderInterface $builder, array $options){
        
        parent::buildForm($builder, $options);
        
        $builder->add('id',  'hidden');
        $builder->add('userPrimerNombre',  null, array('label' => 'Primer Nombre'));
        $builder->add('userSegundoNombre',  null, array('label' => 'Segundo Nombre'));
        $builder->add('userApellidos',  null, array('label' => 'Apellidos'));
        $builder->add('userDui',  null, array('label' => 'DUI'));
        $builder->add('userNit',  null, array('label' => 'NIT'));
        $builder->add('userCargo',  null, array('label' => 'Cargo que desempeña'));
        $builder->add('userTelefono',  'text', array('label' => 'Teléfono', 'required'=>true));
        $builder->add('userInterno',  'hidden', array('label' => 'Usuario Interno?'));
        $builder->add('userInternoTipo',  'choice', array(
            'label'=>'Ministerio al que pertenece',
            'empty_value' => 'Seleccione un Ministerio',
            'required'=>false,
            'expanded'=>false,
            'multiple'=>false,
            'choices'=> array(
                User::$MINSAL => User::$MINSAL_TEXT, 
                User::$DGII => User::$DGII_TEXT,
                User::$DGA => User::$DGA_TEXT, 
                User::$MH => User::$MH_TEXT,
                User::$DNM => User::$DNM_TEXT, 
            )
        ));
        
        $builder->add('userTipo',  'choice', array(
            'label'=>'Acciones que Realizará',
            'empty_value' => 'Seleccione una Acción',
            'required'=>true,
            'expanded'=>false,
            'multiple'=>false,
            'choices'=> array(
                User::$COMPRADOR_VENDEDOR => User::$COMPRADOR_VENDEDOR_TEXT,
                User::$VENDEDOR => User::$VENDEDOR_TEXT, 
                User::$COMPRADOR => User::$COMPRADOR_TEXT,
                User::$DIGITADOR => User::$DIGITADOR_TEXT, 
                User::$APROBADOR => User::$APROBADOR_TEXT
            )
        ));
        
    }

    public function getName(){
        return 'sca_user_registration';
    }
}


?>
