<?php

/* MinSalSidPlaGesObjEspEntControlBundle:GestionObjetivosEspecificosTemplate:agregarObjEspTemplate.html.twig */
class __TwigTemplate_17958c0a91caff02957c83f016b5eb89 extends Twig_Template
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
        // line 9
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("MinSalSidPlaGesObjEspEntControlBundle_manttObjEspTemplate"), "html");
        echo "';
    });
    \$(\"#regresarObj\").click(function(){
       window.location='consultarObjetivosEspecificosTemplate';
    });
    \$('#tabs').tabs();
    \$(\"#forObjTmp\").validate();   
    
});
    </script>
    <style type=\"text/css\">
            form.cmxform label.error, label.error {
                /* remove the next line when you have trouble in IE6 with labels in list */
                color: red;
                font-style: italic
            }
            input.error { border: 1px dotted red; }
            textarea.error { border: 1px dotted red; }
        </style>  

        <form id=\"forObjTmp\" name=\"forObjTmp\" method=\"post\" >
            <h1 style=\" text-align: center\">Ingresar el Objetivo Especifico para los SIBASI y Regiones de Salud</h1>
            <div id=\"tabs\">
                <ul><li><a href=\"#tabs-1\">Objetivo Especifico SIBASI y Region de Salud</a></li></ul>
                <div id=\"tabs-1\" >
                    <table colspan=\"4\"  align=\"center\">
                        <tr>
                            <td style=\" font-size: 12px\" >Objetivo Especifico(*):</td>
                            <td  ><textarea class=\"required\" rows=\"4\" cols=\"83\" name= 'objEspTmp'  size=\"83%\" id=\"objEspTmp\" ></textarea></td>
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
                <input type='hidden' name='anio' id=\"anio\" value='";
        // line 49
        echo twig_escape_filter($this->env, $this->getContext($context, 'anio'), "html");
        echo "' />
                <input type='hidden' name='oper' id=\"oper\" value='add' />
            </div>
        </form>

";
    }

    public function getTemplateName()
    {
        return "MinSalSidPlaGesObjEspEntControlBundle:GestionObjetivosEspecificosTemplate:agregarObjEspTemplate.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }
}
