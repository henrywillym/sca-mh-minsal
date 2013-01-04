<?php
namespace MinSal\SidPla\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Estructura para formulario de Entidades
 *
 * @author Henry Willy Melara
 */
class EntidadType extends AbstractType {
   
    public function setDefaultOptions(OptionsResolverInterface $resolver){
        $resolver->setDefaults(array(
            'data_class' => 'MinSal\SidPla\AdminBundle\Entity\Entidad',
        ));
    }
   public function buildForm(FormBuilder $builder, array $opciones)
    {
        $builder->add('entId', 'hidden');
        $builder->add('entVenc', 'date', array(
            'label' => 'Vencimiento del Permiso', 
            'widget'=>'choice',
            'input'=>'datetime',
            'format'=>'dd/MM/yyyy'
        ));
        $builder->add('entRegDgii', null, array('label' => 'Registro de Usuario (MINSAL)'));
        $builder->add('entRegMinsal',  null, array('label' => 'Número Resolución DGII'));
        $builder->add('entNrc', null, array('label' => 'NCR'));
        $builder->add('entTel',  null, array('label' => 'Teléfono'));
        $builder->add('entGiro', null, array('label' => 'Giro o Actividad Económica'));
        $builder->add('entEmail',  'email', array('label' => 'E-mail', 'max_length'=>'50'));
        
        $builder->add('entTipoPersona',  'choice', array(
            'label'=>'Tipo Persona',
            'expanded'=>true,
            'multiple'=>false,
            'choices'=> array(
                'N' => 'Natural', 
                'J'=>'Juridica'
            )
        ));
        
        $builder->add('entNit',null, array('label' => 'NIT Empresa o de Persona Natural'));
        $builder->add('entNombre',  null, array('label' => 'Nombre propietario, Denominación o Razón Social'));
        $builder->add('entNombComercial',  null, array('label' => 'Nombre Comercial'));
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
        $builder->add('entRepNombre',  null, array('label' => 'Nombre Completo de Representante Legal o Apoderado'));
        $builder->add('entDireccionMatriz',  null, array('label' => 'Dirección Casa Matriz'));
        $builder->add('entUsosAlcohol',  null, array('label' => 'Usos del Alcohol'));
        
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
                false =>'Deshabilitada'
            )
        ));
        
        $builder->add('entComentario',  null, array('label' => 'Explique. ¿Por qué se deshabilitara la empresa?'));
    }

    public function getName()
    {
        return 'Entidad';
    }
}

?>
