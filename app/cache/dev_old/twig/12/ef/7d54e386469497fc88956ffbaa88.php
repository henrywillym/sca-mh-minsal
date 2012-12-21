<?php

/* MinSalSidPlaUnidadOrgBundle:Default:index.html.twig */
class __TwigTemplate_12ef7d54e386469497fc88956ffbaa88 extends Twig_Template
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
        echo "Unidades Organizativas
";
    }

    public function getTemplateName()
    {
        return "MinSalSidPlaUnidadOrgBundle:Default:index.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }
}
