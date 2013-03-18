<?php
namespace MinSal\SCA\ProcesosBundle\Form\Type;

use Doctrine\ORM\EntityRepository;
use MinSal\SCA\AdminBundle\EntityDao\AlcoholDao;
use MinSal\SCA\AdminBundle\Form\Type\AlcoholType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


/**
 * Estructura para formulario de Ingreso a detalle mensual de litros de alcoholes
 *
 * @author Daniel E. Diaz
 */
class RegMensualType extends AbstractType {
    private $doctrine;
    
    public function __construct($doctrine){
        $this->doctrine = $doctrine;
    }
    
    
    /**
     * Utilizado en Symfony 2.1
     * 
     * @param \Symfony\Component\OptionsResolver\OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver){
        $resolver->setDefaults(array(
            'data_class' => 'MinSal\SCA\ProcesosBundle\Entity\RegMensual'
        ));
    }
    
    /**
     * Utilizado en Symfony 2.0
     * @param array $options
     * @return type
     */
    public function getDefaultOptions(array $options){
        return array(
            'data_class' => 'MinSal\SCA\ProcesosBundle\Entity\RegMensual'
        );
    }
    
    public function buildForm(FormBuilderInterface $builder, array $opciones){
        $builder->add('RegMenId', 'hidden');
        
        
        $builder->add('regmen_mes', 'choice', array(
            'choices' => $this->getMeses(),
            'required' => true,
            'expanded' => false,
            'multiple' => false,
            'empty_value' => 'Debe Seleccionar un Mes'
        ));
        $builder->add('regmen_year', null, array('attr' => array('readonly' => 'readonly'),'label' => 'A&ntilde;o'));
        $builder->add('regmen_excedente_ant', null, array('label' => 'Excedente'));
        $builder->add('regmen_prod', null, array('label' => 'Produccion'));
        $builder->add('regmen_imp', null, array('label' => 'Importacion'));
        $builder->add('regmen_compra_local', null, array('label' => 'Compra local'));
        $builder->add('regmen_venta_local', null, array('label' => 'Venta Local'));
        $builder->add('regmen_venta_inter',  null, array('label' => 'Venta Internacional'));
        $builder->add('regmen_utilizacion',  null, array('label' => 'Utilizacion'));
        $builder->add('regmen_perdida',  null, array('label' => 'Perdida , Merma'));
    }

    public function getName(){
        return 'RegMensual';
    }
    
    private function getMeses(){
    
    $meses=array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
        
        $lista = array();
        $i=1;
        
        foreach($meses as $m){
            $lista[$i] = $m;
            $i++;
        }
        
        return $lista;
    }
}

?>
