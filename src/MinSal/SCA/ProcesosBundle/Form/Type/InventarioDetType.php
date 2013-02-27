<?php
namespace MinSal\SCA\ProcesosBundle\Form\Type;

use Doctrine\ORM\EntityRepository;
use MinSal\SCA\AdminBundle\EntityDao\AlcoholDao;
use MinSal\SCA\AdminBundle\Form\Type\AlcoholType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


/**
 * Estructura para formulario de Ingreso a Inventario de alcoholes
 *
 * @author Henry Willy Melara
 */
class InventarioDetType extends AbstractType {
    private $doctrine;
    
    public function __construct($doctrine){
        $this->doctrine = $doctrine;
    }
    
    
    /**
     * Utilizado en Symfony 2.1
     * 
     * @param \Symfony\Component\OptionsResolver\OptionsResolverInterface $resolver
     */
    public function setDefaultOptions1(OptionsResolverInterface $resolver){
        $resolver->setDefaults(array(
            'data_class' => 'MinSal\SCA\ProcesosBundle\Entity\InventarioDet'
        ));
    }
    
    /**
     * Utilizado en Symfony 2.0
     * @param array $options
     * @return type
     */
    public function getDefaultOptions(array $options){
        return array(
            'data_class' => 'MinSal\SCA\ProcesosBundle\Entity\InventarioDet'
        );
    }
    
    public function buildForm(FormBuilderInterface $builder, array $opciones){
        $builder->add('invDetId', 'hidden');
        
        /*$builder->add('alcohol', 'entity', array(
            'class'=>'MinSalSCAAdminBundle:Alcohol',
            'query_builder' => function(EntityRepository $er) {
                return $er->createQueryBuilder('u')
                        ->where('u.auditDeleted = false');
            },
            'property'=> 'alcNombre',
            'expanded'=>false,
            'multiple'=>false,
            //'em'=> 'doctrine.orm.entity_manager'
        ));/**/
        $builder->add('alcId', 'choice', array(
            'choices' => $this->getAlcoholes(),
            'required' => true,
            'expanded' => false,
            'multiple' => false,
            'empty_value' => 'Debe Seleccionar un Alcohol'
        ));
            
        $builder->add('invNombreEsp', null, array('label' => 'Nombre Específico'));
        $builder->add('invGrado', null, array('label' => 'Grado'));
        $builder->add('invDetLitros',  null, array('label' => 'Cuota (Lts)'));
        $builder->add('invDetComentario',  null, array('label' => 'Comentarios'));
    }

    public function getName(){
        return 'InventarioDet';
    }
    
    private function getAlcoholes(){
        $alcoholDao = new AlcoholDao($this->doctrine);
        $alcoholes = $alcoholDao->getAlcoholes();
        
        $lista = array();
        
        foreach($alcoholes as $alc){
            $lista[$alc['alcId']] = $alc['alcNombre'];
        }
        
        return $lista;
    }
}

?>
