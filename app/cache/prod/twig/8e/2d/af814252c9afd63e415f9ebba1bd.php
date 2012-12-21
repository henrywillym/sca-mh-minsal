<?php

/* MinSalSidPlaAdminBundle:Default:index.html.twig */
class __TwigTemplate_8e2daf814252c9afd63e415f9ebba1bd extends Twig_Template
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
        echo "Administraci&oacute;n";
    }

    // line 5
    public function block_body($context, array $blocks = array())
    {
        echo " 
    Platilla de Administraci&oacute;n
    <br> 
";
    }

    public function getTemplateName()
    {
        return "MinSalSidPlaAdminBundle:Default:index.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }
}
