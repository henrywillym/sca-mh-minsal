<?php
namespace MinSal\SCA\AdminBundle\Form\Type;

use MinSal\SCA\AdminBundle\Form\Type\CuotaType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Estructura para formulario de Entidades
 *
 * @author Henry Willy Melara
 */
class EntidadType extends AbstractType {
   
    /*
     * Symfony 2.1
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver){
        $resolver->setDefaults(array(
            'data_class' => 'MinSal\SCA\AdminBundle\Entity\Entidad',
        ));
    }
    
    /*
     * Symfony 2.0
     */
    public function getDefaultOptions(array $options){
        return array(
            'data_class' => 'MinSal\SCA\AdminBundle\Entity\Entidad',
        );
    }
    
    public function buildForm(FormBuilderInterface $builder, array $opciones){
        $builder->add('entId', 'hidden');
        /*$builder->add('entVenc', 'date', array(
            'label' => 'Vencimiento del Permiso', 
            'widget'=>'choice',
            'input'=>'datetime',
            'format'=>'dd/MM/yyyy'
        ));/***/
        $builder->add('entRegMinsal', 'text', array('label' => 'Registro de Usuario (MINSAL)','required'=> false, 'attr'=> array('style'=>'text-transform:uppercase;')));
        $builder->add('entRegDgii',  'text', array('label' => 'Número Resolución DGII','required'=> true, 'attr'=> array('style'=>'text-transform:uppercase;')));
        $builder->add('entNrc', 'text', array('label' => 'NRC','required'=>false));
        $builder->add('entTel',  null, array('label' => 'Teléfono', 'required'=> true));
        $builder->add('entGiro', null, array('label' => 'Giro o Actividad Económica', 'required'=> true, 'attr'=> array('style'=>'text-transform:uppercase;')));
        $builder->add('entEmail',  'email', array('label' => 'E-mail', 'max_length'=>'50','required'=> true, 'attr'=> array('style'=>'text-transform:uppercase;')));
        
        $builder->add('entTipoPersona',  'choice', array(
            'label'=>'Tipo Persona',
            'required'=> true,
            'expanded'=>true,
            'multiple'=>false,
            'choices'=> array(
                'N' => 'Natural', 
                'J'=>'Jurídica'
            )
        ));
        
        $builder->add('entNit', null, array('label' => 'NIT Empresa o de Persona Natural','required'=> true));
        $builder->add('entNombre',  null, array('label' => 'Nombre propietario, Denominación o Razón Social','required'=> true, 'attr'=> array('style'=>'text-transform:uppercase;')));
        $builder->add('entNombComercial',  null, array('label' => 'Nombre Comercial','required'=> true, 'attr'=> array('style'=>'text-transform:uppercase;')));
        $builder->add('entTipoDoc', 'choice', array(
            'label' => 'Tipo de documento',
            'expanded'=>true,
            'multiple'=>false,
            'choices'=> array(
                'P' => 'Pasaporte', 
                'D'=>'DUI'
            )
        ));
        
        $builder->add('entActua',  'choice', array(
            'label' => 'Calidad en la que actua',
            'expanded'=>true,
            'multiple'=>false,
            'choices'=> array(
                'R' => 'Representante', 
                'A'=>'Apoderado'
            )
        ));
        
        $builder->add('entRepNit',  null, array('label' => 'NIT Representante Legal o Apoderado'));
        $builder->add('entRepDoc',  null, array('label' => 'Pasaporte o DUI de Rep. Legal o Apoderado'));
        $builder->add('entRepNombre',  null, array('label' => 'Nombre Completo de Representante Legal o Apoderado', 'attr'=> array('style'=>'text-transform:uppercase;')));
        $builder->add('entDireccionMatriz',  null, array('label' => 'Dirección Casa Matriz','required'=> true, 'attr'=> array('style'=>'text-transform:uppercase;')));
        $builder->add('entUsosAlcohol',  null, array('label' => 'Usos del Alcohol','required'=> true, 'attr'=> array('style'=>'text-transform:uppercase;')));
        
        $builder->add('entImportador',  'checkbox', array(
            'label'=>'Importador',
            'required'=> false,
        ));
        
        $builder->add('entProductor',  'checkbox', array(
            'label'=>'Productor',
            'required'=> false,
        ));
        
        $builder->add('entProdEstEtil',  null, array('label' => 'Producción estimada anual de alcohol etílico'));
        
        $builder->add('entComprador',  'checkbox', array(
            'label'=>'Comprador Local',
            'required'=> false,
        ));
        
        $builder->add('entCompVend',  'checkbox', array(
            'label'=>'Vendedor Local',
            'required'=> false,
        ));
        
        $builder->add('entHabilitado',  'choice', array(
            'label'=>'Estado de la empresa',
            'required'=> false,
            'expanded'=>true,
            'multiple'=>false,
            'choices'=> array(
                true => 'Habilitada', 
                false =>'Bloqueada'
            )
        ));
        
        $builder->add('entComentario',  null, array('label' => 'Explique. ¿Por qué se deshabilitara la empresa?'));
        
        //$builder->add('cuotas', 'collection', array('type' => new CuotaType(), 'label'=> 'collection'));
    }

    public function getName(){
        return 'Entidad';
    }
}

?>
