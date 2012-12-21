<?php

/* MinSalSidPlaCensoBundle:Default:index.html.twig */
class __TwigTemplate_0e0fd701760856b904ace6bda07da742 extends Twig_Template
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

    // line 3
    public function block_titulo($context, array $blocks = array())
    {
        echo "Censo Poblaci&oacute;n";
    }

    // line 5
    public function block_body($context, array $blocks = array())
    {
        echo " 
    Platilla de Censo Poblaci&oacute;n    
    <br> 
";
    }

    public function getTemplateName()
    {
        return "MinSalSidPlaCensoBundle:Default:index.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }
}
