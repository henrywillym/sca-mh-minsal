<?php

/* MinSalSidPlaRRMedicoBundle:ResulPrograRRMed:manttResultPrograRRMed.html.twig */
class __TwigTemplate_02c8bbbbde90310a05282643f2db3bc9 extends Twig_Template
{
    protected $parent;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->blocks = array(
            'titulo' => array($this, 'block_titulo'),
            'body' => array($this, 'block_body'),
        );
    }

    public function getParent(array $context)
    {
        if (null === $this->parent) {
            $this->parent = $this->env->loadTemplate("MinSalSidPlaBundle:Default:index.html.twig");
        }

        return $this->parent;
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $context = array_merge($this->env->getGlobals(), $context);

        $this->getParent($context)->display($context, array_merge($this->blocks, $blocks));
    }

    // line 2
    public function block_titulo($context, array $blocks = array())
    {
        echo " Resultado de Programacion de recurso Medico";
    }

    // line 4
    public function block_body($context, array $blocks = array())
    {
        // line 5
        echo "<script type=\"text/javascript\">
\$(document).ready(function(){
  \$('#selHorario').change(cargarPrograRRMedico);
  
 function cargarPrograRRMedico(){
            \$('#tabPrograRHHH').setGridParam({
               url:'consultarResulPrograRRMedJSON?turno='+\$('#selHorario').val(),
               datatype:'json'
           }).trigger(\"reloadGrid\"); 
        }

 
 });
 
    </script>
<h1 style='text-align: center;'>Resultado de Programacion de recurso Medico</h1>
<table align=\"center\">
      
    <tr>
        <td align=\"center\">
              <select id='selHorario'>
                <option value='1'>Horario Normal</option>
                <option value='2'>Horario Ampliado</option>
            </select>
        </td>
    </tr>
    <tr>
     <td align=\"center\">
         <br></br>
       ";
        // line 34
        $this->env->loadTemplate("MinSalSidPlaRRMedicoBundle:ResulPrograRRMed:showResultPrograRRMed.html.twig")->display($context);
        // line 35
        echo "     </td>
   </tr>
   <tr>
       <td>
        ";
        // line 39
        $this->env->loadTemplate("MinSalSidPlaRRMedicoBundle:ResulPrograRRMed:showProgRRMed.html.twig")->display($context);
        // line 40
        echo "       </td>
   </tr>
</table>   

";
    }

    public function getTemplateName()
    {
        return "MinSalSidPlaRRMedicoBundle:ResulPrograRRMed:manttResultPrograRRMed.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }
}
