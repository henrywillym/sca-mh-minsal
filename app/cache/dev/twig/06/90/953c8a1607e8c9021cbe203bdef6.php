<?php

/* MinSalSidPlaUsersBundle:Default:index.html.twig */
class __TwigTemplate_0690953c8a1607e8c9021cbe203bdef6 extends Twig_Template
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
