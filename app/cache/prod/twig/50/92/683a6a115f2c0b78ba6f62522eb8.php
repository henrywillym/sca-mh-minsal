<?php

/* MinSalSidPlaAdminBundle:Opciones:manttOpcionesSystemForm.html.twig */
class __TwigTemplate_5092683a6a115f2c0b78ba6f62522eb8 extends Twig_Template
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
        echo "  
    <form>
        <table align=\"center\">
            <tr><td align=\"center\">
                    <h1>Mantenimiento de Opciones del Sistema</h1>
                </td>
            </tr>
            <tr>
                <td align=\"center\">
                <br></br>                
                ";
        // line 13
        $this->env->loadTemplate("MinSalSidPlaAdminBundle:Opciones:showAllOpciones.html.twig")->display($context);
        // line 14
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
        return "MinSalSidPlaAdminBundle:Opciones:manttOpcionesSystemForm.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }
}
