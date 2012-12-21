<?php

/* MinSalSidPlaGesObjEspBundle:GestionObjetivosEspecificos:manttObjetivosEspecificos.html.twig */
class __TwigTemplate_120b2d08356b9f2240966a4b5a1023c3 extends Twig_Template
{
    protected $parent;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->blocks = array(
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
    public function block_body($context, array $blocks = array())
    {
        // line 3
        echo "<script type=\"text/javascript\">
\$(document).ready(function(){
    
    \$('#agregar').click(function(evento) {
          this.form.action='";
        // line 7
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("MinSalSidPlaGesObjEspBundle_ingresarObjetivoEspecifico"), "html");
        echo "';
    });
    
      
    \$('#reporteProgramon').click(function(evento) {
          this.form.action='";
        // line 12
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("MinSalSidPlaReportesBundle_reporteDependenciaInvidual"), "html");
        echo "';
    });
    
});
</script>
    <form action=\"\" method=\"post\">
        <input type=\"hidden\" name=\"anioConsultar\" value=\"";
        // line 18
        echo twig_escape_filter($this->env, (twig_date_format_filter("now", "Y") + 1), "html");
        echo " \" />
        <input type=\"hidden\" name=\"idDepen\" value=\"";
        // line 19
        echo twig_escape_filter($this->env, $this->getContext($context, 'idDepen'), "html");
        echo " \" />
        
        <table align=\"center\">
            <tr>
                <td align=\"center\"><h1>Gestion de Objetivos Especificos</h1>
                    <h1>PAO: ";
        // line 24
        echo twig_escape_filter($this->env, (twig_date_format_filter("now", "Y") + 1), "html");
        echo "</h1>
                </td>
            </tr>
            <tr>
                <td align=\"center\" class=\"tdBotonIconoAgregar\" >
                    <input width=\"60\" height=\"60\" type=\"image\" src=\"";
        // line 29
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("/images/iconos/agregar.png"), "html");
        echo "\" id=\"agregar\"/>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <input width=\"60\" height=\"60\" type=\"image\" src=\"";
        // line 31
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("/images/iconos/documento.png"), "html");
        echo "\" id=\"reporteProgramon\"/>
                    <br/>Agregar Objetivo &nbsp;&nbsp;&nbsp; Reporte
                </td>
                               
            </tr>
            <tr>
                <td align=\"center\">               
                ";
        // line 38
        $this->env->loadTemplate("MinSalSidPlaGesObjEspBundle:GestionObjetivosEspecificos:showAllObjetivosEspecificos.html.twig")->display(array_merge($context, array("idCaractOrg" => $this->getContext($context, 'idCaractOrg'))));
        echo " 
                </td>
            </tr>        
        </table>
         <input type='hidden' name='idfila' id=\"idfila\" value='' />
         <input type='hidden' name='id' id=\"id\" value='' />  
         <input type='hidden' name='idCaractOrg' id=\"idCaractOrg\" value='";
        // line 44
        echo twig_escape_filter($this->env, $this->getContext($context, 'idCaractOrg'), "html");
        echo "' />
    </form>
    <br/><br/>
  
";
    }

    public function getTemplateName()
    {
        return "MinSalSidPlaGesObjEspBundle:GestionObjetivosEspecificos:manttObjetivosEspecificos.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }
}
