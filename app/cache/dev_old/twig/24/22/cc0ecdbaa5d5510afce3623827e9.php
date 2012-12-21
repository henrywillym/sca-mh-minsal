<?php

/* MinSalSidPlaTemplateUnisalBundle:ResultadoEspeUnisal:manttResultadoEspeUnisal.html.twig */
class __TwigTemplate_2422cc0ecdbaa5d5510afce3623827e9 extends Twig_Template
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
   \$('#agregar').click(function() {
        \$('#anio').attr('value', \$('#selanio').val());
        \$('#idArea').attr('value', \$('#selarea').val());
        this.form.action='";
        // line 8
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("MinSalSidPlaTemplateUnisalBundle_ingresarResEspeUnisal"), "html");
        echo "';
     });

});
    </script>
    <form action=\"\" method=\"post\">
        <table align=\"center\">
            <tr>
                <td align=\"center\"><h1>Gestion de Plantilla de Actividades Trazadoras para Unidad de Salud</h1>
                </td>
            </tr>
             <tr>
                 <td align=\"center\">
                     <a href=\"mostrarObjEspeUnisal\" style=\"font-size: 12px\" ><strong>Objetivos >></strong></a>
                     <br></br>
                 </td>
            </tr>
           <tr>
                <td align=\"center\" style=\" font-size: 12px\">
                   <textarea readonly=\"readonly\"  rows=\"4\" cols=\"100\" name= 'objEspTmp'  size=\"83%\" id=\"objEspTmp\" >";
        // line 27
        echo twig_escape_filter($this->env, $this->getContext($context, 'descObj'), "html");
        echo "</textarea>
                </td>
            </tr>
            <tr colspan=\"2\">
                <td align=\"center\" class=\"tdBotonIconoAgregar\"  >
                   <input width=\"60\" height=\"60\" type=\"image\" src=\"";
        // line 32
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("/images/iconos/agregar.png"), "html");
        echo "\" name=\"agregar\" id=\"agregar\"/>
                   <br/>Agregar Resultado Esperado
                </td>
            </tr>
            <tr>
                <td align=\"center\">
                    <br></br>                
                ";
        // line 39
        $this->env->loadTemplate("MinSalSidPlaTemplateUnisalBundle:ResultadoEspeUnisal:showResultadoEspeUnisal.html.twig")->display($context);
        echo " 
                </td>
            </tr>        
        </table>
        <input type='hidden' name='idResEsp' id=\"idResEsp\" value='' />
        <input type='hidden' name='idObj' id=\"idObj\" value='";
        // line 44
        echo twig_escape_filter($this->env, $this->getContext($context, 'idObj'), "html");
        echo "' /> 
    </form>
    <br></br>
    <br></br>


";
    }

    public function getTemplateName()
    {
        return "MinSalSidPlaTemplateUnisalBundle:ResultadoEspeUnisal:manttResultadoEspeUnisal.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }
}
