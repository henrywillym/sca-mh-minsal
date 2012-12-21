<?php

/* FOSUserBundle:Profile:show_content.html.twig */
class __TwigTemplate_9fac6c35cd54947e69a2f16edcdaeb87 extends Twig_Template
{
    protected function doDisplay(array $context, array $blocks = array())
    {
        $context = array_merge($this->env->getGlobals(), $context);

        // line 1
        echo "<div class=\"fos_user_user_show\">
    <p>";
        // line 2
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("profile.show.username", array(), "FOSUserBundle"), "html");
        echo ": ";
        echo twig_escape_filter($this->env, $this->getAttribute($this->getContext($context, 'user'), "username", array(), "any", false), "html");
        echo "</p>
    <p>";
        // line 3
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("profile.show.email", array(), "FOSUserBundle"), "html");
        echo ": ";
        echo twig_escape_filter($this->env, $this->getAttribute($this->getContext($context, 'user'), "email", array(), "any", false), "html");
        echo "</p>
</div>
";
    }

    public function getTemplateName()
    {
        return "FOSUserBundle:Profile:show_content.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }
}
