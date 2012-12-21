<?php

/* MinSalSidPlaCensoBundle:CategoriaCenso:ingresoCategoriaCenso.html.twig */
class __TwigTemplate_1e7a67e31df38230e608dea11a4cc155 extends Twig_Template
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
    \$('#ingresar').button();
    \$('#limpiar').button();
    \$('#regresar').button();
    \$(\"#regresar\").click(function(){
       window.location='";
        // line 9
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("MinSalSidPlaCensoBundle_manttCatCenso"), "html");
        echo "';
    });
    \$('#tabs').tabs();
    
});
    </script>

    <form action=\"";
        // line 16
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("MinSalSidPlaCensoBundle_addCategoria"), "html");
        echo "\" method=\"post\" ";
        echo $this->env->getExtension('form')->renderEnctype($this->getContext($context, 'form'));
        echo ">
        <h1 style=\" text-align: center\">Registro de Nuevas Categorias</h1>
        <div id=\"tabs\">
            <ul><li><a href=\"#tabs-1\">Categoria Censo</a></li></ul>
            <div id=\"tabs-1\" >
                <table align='center' >
                    <tr>
                        <td><label id=\"nombreCategoria\" >Nombre de Categoria:</label></td>
                        <td>";
        // line 24
        echo $this->env->getExtension('form')->renderWidget($this->getAttribute($this->getContext($context, 'form'), "descripcionCategoria", array(), "any", false));
        echo "</td>
                    </tr>
                    <tr>
                        <td><label id=\"tabla\" >Clasificacion:</label></td>
                        <td>";
        // line 28
        echo $this->env->getExtension('form')->renderWidget($this->getAttribute($this->getContext($context, 'form'), "divTabla", array(), "any", false));
        echo "</td>
                    </tr>

                    <tr>
                        <td><label id=\"activo\" >Activo:</label></td>
                        <td>";
        // line 33
        echo $this->env->getExtension('form')->renderWidget($this->getAttribute($this->getContext($context, 'form'), "activo", array(), "any", false));
        echo "</td>
                    </tr>
                    <tr>
                        <td><label id=\"bloque\" >Bloque:</label></td>
                        <td>";
        // line 37
        echo $this->env->getExtension('form')->renderWidget($this->getAttribute($this->getContext($context, 'form'), "bloque", array(), "any", false));
        echo "</td>
                    </tr>
                    <tr>

                        <td align='center' colspan=\"2\" ><br/>
                            <button type=\"reset\" id=\"limpiar\"  >Limpiar</button>
                            <input id='ingresar' value=\"Ingresar\" type=\"submit\" />
                            <button type=\"button\" id=\"regresar\"  >Regresar</button>
                        </td>

                    </tr>
                </table>
            </div>
        </div>
    ";
        // line 51
        echo $this->env->getExtension('form')->renderRest($this->getContext($context, 'form'));
        echo "

    </form>

";
    }

    public function getTemplateName()
    {
        return "MinSalSidPlaCensoBundle:CategoriaCenso:ingresoCategoriaCenso.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }
}
