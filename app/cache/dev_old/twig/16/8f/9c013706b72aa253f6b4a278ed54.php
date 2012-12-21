<?php

/* MinSalSidPlaTemplateUnisalBundle:Default:index.html.twig */
class __TwigTemplate_168f9c013706b72aa253f6b4a278ed54 extends Twig_Template
{
    protected function doDisplay(array $context, array $blocks = array())
    {
        $context = array_merge($this->env->getGlobals(), $context);

        // line 1
        echo "Hello ";
        echo twig_escape_filter($this->env, $this->getContext($context, 'name'), "html");
        echo "!
";
    }

    public function getTemplateName()
    {
        return "MinSalSidPlaTemplateUnisalBundle:Default:index.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }
}
