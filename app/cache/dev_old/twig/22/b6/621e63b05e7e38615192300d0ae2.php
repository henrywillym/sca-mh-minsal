<?php

/* FOSUserBundle:Security:login.html.twig */
class __TwigTemplate_22b6621e63b05e7e38615192300d0ae2 extends Twig_Template
{
    protected $parent;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->blocks = array(
            'fos_user_content' => array($this, 'block_fos_user_content'),
        );
    }

    public function getParent(array $context)
    {
        if (null === $this->parent) {
            $this->parent = $this->env->loadTemplate("MinSalSidPlaUsersBundle::layout.html.twig");
        }

        return $this->parent;
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $context = array_merge($this->env->getGlobals(), $context);

        $this->getParent($context)->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_fos_user_content($context, array $blocks = array())
    {
        // line 4
        echo "<script type=\"text/javascript\">
  \$(document).ready(function(){
      \$(\"#_submit\").button();
});
</script>
<br></br>
    
<form  action=\"";
        // line 11
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("fos_user_security_check"), "html");
        echo "\" method=\"post\">
    <table align='center'>
        <tr>
            <td colspan=\"2\" align='center' ><h1>Ingreso al Sistema</h1></td>
        </tr>
        <tr>
            <td>
                <label for=\"username\">";
        // line 18
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("Usuario:", array(), "FOSUserBundle"), "html");
        echo "</label>
            </td>
            <td>
                <input type=\"text\" id=\"username\" name=\"_username\" value=\"";
        // line 21
        echo twig_escape_filter($this->env, $this->getContext($context, 'last_username'), "html");
        echo "\" />
            </td>
        </tr>
        
         <tr>
            <td>
                 <label for=\"password\">";
        // line 27
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("Password:", array(), "FOSUserBundle"), "html");
        echo "</label>
            </td>
            <td>
                <input type=\"password\" id=\"password\" name=\"_password\" />                
            </td>            
        </tr>   
        <tr><td colspan=\"2\" align=\"center\" >
                <input type=\"checkbox\" id=\"remember_me\" name=\"_remember_me\" value=\"on\" />
                <label for=\"remember_me\">";
        // line 35
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("Recordar", array(), "FOSUserBundle"), "html");
        echo "</label>
            </td>            
        </tr>
        <tr>
            <td colspan=\"2\" style=\" font-size: 12px; font-family: Verdana, Geneva, sans-serif; color: red \" >
                ";
        // line 40
        if ($this->getContext($context, 'error')) {
            // line 41
            echo "                 ";
            if (($this->getContext($context, 'error') == "Bad credentials")) {
                // line 42
                echo "                    <div>NO EXISTE ESE USUARIO</div>
                 ";
            }
            // line 44
            echo "                 ";
            if (($this->getContext($context, 'error') == "The presented password is invalid.")) {
                // line 45
                echo "                    <div>PASSWORD EQUIVOCADO VUELVA A DIGITARLO</div>
                 ";
            }
            // line 47
            echo "                ";
        }
        // line 48
        echo "            </td>
        </tr>
        <tr>
            <td colspan=\"2\" align='center' >
                <input type=\"submit\" id=\"_submit\" name=\"_submit\" value=\"";
        // line 52
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("Ingresar", array(), "FOSUserBundle"), "html");
        echo "\" />
            </td>
        </tr>
    </table>
    
</form>

";
    }

    public function getTemplateName()
    {
        return "FOSUserBundle:Security:login.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }
}
