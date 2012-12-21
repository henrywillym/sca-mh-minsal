<?php

/* MinSalSidPlaAdminBundle:Roles:manttRolesSystemForm.html.twig */
class __TwigTemplate_fcc3c46d4fad3e8ca5044ca0fcad9c4a extends Twig_Template
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

    // line 3
    public function block_body($context, array $blocks = array())
    {
        // line 4
        echo "    <script type=\"text/javascript\">
      \$(document).ready(function(){
          \$('#asignar').button();
          \$('#agregarRoles').button();
          \$('#eliminarRoles').button();
          \$('#editarRoles').button();
          \$('#asignar').click(function() {
              document.location.href='";
        // line 11
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("MinSalSidPlaAdminBundle_asignarOpcRoles"), "html");
        echo "'
          });
      });
    </script>
   <form>
        <table align=\"center\">
            <tr><td align=\"center\">
                    <h1>Mantenimiento de Roles del Sistema</h1>
                </td>
            </tr>
            <tr>
                <td align=\"center\">
                    <input type=\"button\" value=\"Asignar/Desasignar Opciones\" id=\"asignar\" ></input>                    
                </td>
            </tr>
            <tr>
                <td align=\"center\">
                <br></br>                
                ";
        // line 29
        $this->env->loadTemplate("MinSalSidPlaAdminBundle:Roles:showAllRoles.html.twig")->display($context);
        // line 30
        echo "                </td>
            </tr>
            <tr>
                <td align=\"center\">
                    <input type=\"button\" value=\"Agregar\" id=\"agregarRoles\" />
                    <input type=\"button\" value=\"Editar\" id=\"editarRoles\" />
                    <input type=\"button\" value=\"Eliminar\" id=\"eliminarRoles\"/>
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
        return "MinSalSidPlaAdminBundle:Roles:manttRolesSystemForm.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }
}
