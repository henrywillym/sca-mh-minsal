<?php
namespace  MinSal\SidPla\UsersBundle\Form\Type;

use Symfony\Component\Form\FormBuilder;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;
use Doctrine\ORM\EntityRepository;


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
            'data_class' => 'MinSal\SidPla\UsersBundle\Entity\User',
            'csrf_protection' => false,
            'cascade_validation' => false,
        ));
    }
    
    /**
     * Utilizado en Symfony 2.0
     * @param array $options
     * @return type
     */
    public function getDefaultOption1(array $options){
        return array(
            'data_class' => 'MinSal\SidPla\UsersBundle\Entity\User',
            'csrf_protection' => false,
            'cascade_validation' => false,
        );
    }
    public function buildForm(FormBuilder $builder, array $options){
        
        parent::buildForm($builder, $options);
        
        $builder->add('idUsuario',  'hidden');
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
                'MINSAL' => 'MINSAL - Ministerio de Salud', 
                'DGII'=>'DGII - Dirección General de Impuestos Internos',
                'DGA' => 'DGA - Dirección General de Aduanas', 
                'MH'=>'MH - Ministerio de Hacienda',
                'DNM' => 'DNM - Dirección Nacional de Medicamentos', 
            )
        ));
        
        $builder->add('userTipo',  'choice', array(
            'label'=>'Acciones que Realizará',
            'empty_value' => 'Seleccione una Acción',
            'required'=>true,
            'expanded'=>false,
            'multiple'=>false,
            'choices'=> array(
                'VENDEDOR' => 'Vendedor', 
                'COMPRADOR'=>'Comprador',
                'DIGITADOR' => 'Digitador de Empresas y Cuotas', 
                'APROBADOR'=>'Autorizador en Proceso Solicitud de Import.'
            )
        ));
        
    }

    public function getName(){
        return 'sidpla_user_registration';
    }
}


?>
