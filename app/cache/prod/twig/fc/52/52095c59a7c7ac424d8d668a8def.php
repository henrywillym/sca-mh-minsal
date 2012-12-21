<?php

/* MinSalSidPlaUsersBundle:Default:index.html.twig */
class __TwigTemplate_fc5252095c59a7c7ac424d8d668a8def extends Twig_Template
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
        return "MinSalSidPlaUsersBundle:Default:index.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }
}
