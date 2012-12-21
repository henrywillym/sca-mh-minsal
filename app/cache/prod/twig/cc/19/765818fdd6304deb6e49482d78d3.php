<?php

/* MinSalSidPlaUsersBundle:Usuarios:manttUsuariosSinRol.html.twig */
class __TwigTemplate_cc19765818fdd6304deb6e49482d78d3 extends Twig_Template
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
        echo "Usuarios sin Rol ";
    }

    // line 4
    public function block_body($context, array $blocks = array())
    {
        // line 5
        echo "    <h1 style='text-align: center;'>Usuarios sin Rol</h1>
    <table align=\"center\">
        <tr>
            <td align=\"center\">
               ";
        // line 9
        $this->env->loadTemplate("MinSalSidPlaUsersBundle:Usuarios:showUsuariosSinRol.html.twig")->display($context);
        // line 10
        echo "            </td>
        </tr>
        <tr>
            <td align=\"center\">
                <input type=\"button\" id=\"editarUsuarioButton\" value=\"   Editar   \" />
            </td>
        </tr>        
    </table>    
";
    }

    public function getTemplateName()
    {
        return "MinSalSidPlaUsersBundle:Usuarios:manttUsuariosSinRol.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }
}
