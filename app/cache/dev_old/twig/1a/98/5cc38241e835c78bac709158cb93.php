<?php

/* MinSalSidPlaTemplateUnisalBundle:ObjetivoEspeUnisal:gestionObjetivoEspecificoUnisal.html.twig */
class __TwigTemplate_1a985cc38241e835c78bac709158cb93 extends Twig_Template
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
    \$('#guardarObj').button();
    \$('#limpiarObj').button();
    \$('#regresarObj').button();
    
    \$('#guardarObj').click(function(evento) {
          this.form.action='";
        // line 10
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("MinSalSidPlaTemplateUnisalBundle_manttObjetivoEspeUnisal"), "html");
        echo "';
    });
    
   \$(\"#regresarObj\").click(function(){
       window.location='mostrarObjEspeUnisal';
   });
    
  \$(\"#forObjEspTmp\").validate();   
   \$('#tabs').tabs();
    
});
</script>
<style type=\"text/css\">
form.cmxform label.error, label.error {
\t/* remove the next line when you have trouble in IE6 with labels in list */
\tcolor: red;
\tfont-style: italic
}
input.error { border: 1px dotted red; }
textarea.error { border: 1px dotted red; }
 </style>  

<form id=\"forObjEspTmp\" name=\"forObjEspTmp\" method=\"post\" >
";
        // line 33
        if (array_key_exists("idObj", $context)) {
            // line 34
            echo "        <h1 style=\" text-align: center\">Modifique el Objetivo Especifico para Unidades de salud</h1>
        <div id=\"tabs\">
                <ul><li><a href=\"#tabs-1\">Objetivo Especifico para Unidades de Salud</a></li></ul>
                <div id=\"tabs-1\" >
      <table colspan=\"4\"  align=\"center\">
         <tr>
            <td style=\" font-size: 12px\" >Objetivo(*):</td>
            <td><textarea class=\"required\" rows=\"4\" cols=\"83\" name= 'objEspTmp'  size=\"83%\" id=\"objEspTmp\" >";
            // line 41
            echo twig_escape_filter($this->env, $this->getContext($context, 'descObj'), "html");
            echo "</textarea></td>
        </tr>
        <tr>
            <td colspan=\"2\" align=\"center\">
                <button type=\"submmit\" id=\"guardarObj\"  >Guardar</button>
                <button type=\"reset\" id=\"limpiarObj\"  >Limpiar</button>
                <button type=\"button\" id=\"regresarObj\"  >Regresar</button>
            </td>
        </tr>

    </table>
                        </div>
                </div>
<input type='hidden' name='anio' id=\"anio\" value='";
            // line 54
            echo twig_escape_filter($this->env, $this->getContext($context, 'anio'), "html");
            echo "' />
<input type='hidden' name='idArea' id=\"idArea\" value='";
            // line 55
            echo twig_escape_filter($this->env, $this->getContext($context, 'idArea'), "html");
            echo "' /> 
<input type='hidden' name='idObj' id=\"idObj\" value='";
            // line 56
            echo twig_escape_filter($this->env, $this->getContext($context, 'idObj'), "html");
            echo "' /> 
<input type='hidden' name='oper' id=\"oper\" value='edit' /> 
";
        } else {
            // line 59
            echo "<h1 style=\" text-align: center\">Ingrese el Objetivo Especifico para Unidades de salud</h1>
        <div id=\"tabs\">
                <ul><li><a href=\"#tabs-1\">Objetivo Especifico para Unidades de Salud</a></li></ul>
                <div id=\"tabs-1\" >
    <table colspan=\"4\"  align=\"center\"><!-- id=\"datos\"  -->
        <tr>
            <td style=\" font-size: 12px\" >Objetivo(*):</td>
            <td><textarea class=\"required\" rows=\"4\" cols=\"83\" name= 'objEspTmp'  size=\"83%\" id=\"objEspTmp\" ></textarea></td>
        </tr>
        <tr>
            <td colspan=\"2\" align=\"center\">
                <button type=\"submmit\" id=\"guardarObj\"  >Guardar</button>
                <button type=\"reset\" id=\"limpiarObj\"  >Limpiar</button>
                <button type=\"button\" id=\"regresarObj\"  >Regresar</button>
            </td>
        </tr>

    </table>
<input type='hidden' name='anio' id=\"anio\" value='";
            // line 77
            echo twig_escape_filter($this->env, $this->getContext($context, 'anio'), "html");
            echo "' />
<input type='hidden' name='idArea' id=\"idArea\" value='";
            // line 78
            echo twig_escape_filter($this->env, $this->getContext($context, 'idArea'), "html");
            echo "' />  
<input type='hidden' name='oper' id=\"oper\" value='add' />
                    </div>
                </div>
";
        }
        // line 83
        echo "</form>
";
    }

    public function getTemplateName()
    {
        return "MinSalSidPlaTemplateUnisalBundle:ObjetivoEspeUnisal:gestionObjetivoEspecificoUnisal.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }
}
