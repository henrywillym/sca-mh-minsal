<?php

/* MinSalSidPlaAdminBundle:UnidadOrganizativa:manttUnidadesOrganizativas.html.twig */
class __TwigTemplate_0d48f248524d47845bc3ed7425e1bdb0 extends Twig_Template
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
        echo "    <script type=\"text/javascript\">
      \$(document).ready(function(){
          \$('#ingresar').button();
          \$('#reporte').button();
          \$('#ingresar').click(function() {
              this.form.action='";
        // line 8
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("MinSalSidPlaAdminBundle_ingresoNuevaUnidadesOrg"), "html");
        echo "'
          });
        
          \$('#reporte').click(function() {
            this.form.action='";
        // line 12
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("MinSalSidPlaReportesBundle_reporteInfoGeneral"), "html");
        echo "'
         });
      });
    </script>
    
    <form action=\"\" method=\"post\">
        <table align=\"center\">
            <tr><td align=\"center\">
                    <h1>Mantenimiento de Unidades del Sistema</h1>
                </td>
            </tr>
            <tr>
                <td align=\"center\">
                    <input type=\"submit\" value=\"Ingresar Nuevas Unidades\" id=\"ingresar\" ></input>  
                    <input type=\"submit\" value=\"Reporte\" id=\"reporte\"></input>
                </td>
            </tr>
            <tr>
                <td align=\"center\">
                <br></br>                
                ";
        // line 32
        $this->env->loadTemplate("MinSalSidPlaAdminBundle:UnidadOrganizativa:showAllUnidadesOrganizativas.html.twig")->display($context);
        // line 33
        echo "                </td>
            </tr>        
        </table>        
    </form>
    <br></br>
    <br></br>
    
    
";
    }

    public function getTemplateName()
    {
        return "MinSalSidPlaAdminBundle:UnidadOrganizativa:manttUnidadesOrganizativas.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }
}
