<?php

/* MinSalSidPlaAdminBundle:Empleado:manttEmpleados.html.twig */
class __TwigTemplate_a0e78c2c58c4b9f7ced0d54794058822 extends Twig_Template
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
          \$('#agregarEmpleado').button();
          \$('#eliminarEmpleado').button();
          \$('#editarEmpleado').button();
          \$('#reporte').button();
          
          \$('#reporte').click(function() {
            this.form.action='";
        // line 11
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("MinSalSidPlaReportesBundle_reporteEmpleadosOrg"), "html");
        echo "'
        });
      });
    </script>
      
    <form action=\"\" method=\"post\">
        <table align=\"center\">
            <tr><td align=\"center\">
                    <h1>Mantenimiento de Empleados</h1>
                </td>
            </tr>
            <tr>
                <td align=\"center\">
                     ";
        // line 24
        $this->env->loadTemplate("MinSalSidPlaAdminBundle:Empleado:showAllEmpleados.html.twig")->display($context);
        // line 25
        echo "                </td>
            </tr>
            <tr>
                <td align=\"center\">
                    <input type=\"button\" value=\"Agregar\" id=\"agregarEmpleado\" />
                    <input type=\"button\" value=\"Editar\" id=\"editarEmpleado\" />
                    <input type=\"button\" value=\"Eliminar\" id=\"eliminarEmpleado\"/>
                    <input type=\"submit\" value=\"Reporte\" id=\"reporte\"></input>
                </td>
            </tr>
        </table>        
    </form>
    <br></br>
    <br></br>
    
";
    }

    public function getTemplateName()
    {
        return "MinSalSidPlaAdminBundle:Empleado:manttEmpleados.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }
}
