<?php

/* FOSUserBundle:Registration:register_content.html.twig */
class __TwigTemplate_17d23fd7106143cabdb6f6c9f0d892a1 extends Twig_Template
{
    protected function doDisplay(array $context, array $blocks = array())
    {
        $context = array_merge($this->env->getGlobals(), $context);

        // line 1
        echo $this->env->getExtension('form')->setTheme($this->getContext($context, 'form'), array($this->getContext($context, 'theme'), ));
        // line 2
        echo "<script type=\"text/javascript\">
 \$(document).ready(function(){
   \$('#verificaEmpleado').button();
   \$('#verificaEmpleado').click(function(evento) {
       \$.getJSON('";
        // line 6
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("MinSalSidPlaUsersBundle_verificaCreacion"), "html");
        echo "?idEmpleado='+\$(\"#fos_user_registration_form_idEmpleado\").get(0).value+'&username='+\$(\"#fos_user_registration_form_username\").get(0).value+'&email='+\$(\"#fos_user_registration_form_email\").get(0).value, function(data) {
         \$.each(data, function(key, val) {
           if(key=='msj'){
                \$.each(val, function(id, registro){
                  if(!registro[1]) 
                    \$(\"#mensaje\").attr('value', registro[0]);
                else
                      \$('#formUsuario').submit();
             });                    
           }
          });
      });
          
   });//FIn del clic
});
    </script>
    <form id=\"formUsuario\" action=\"";
        // line 22
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("fos_user_registration_register"), "html");
        echo "\" ";
        echo $this->env->getExtension('form')->renderEnctype($this->getContext($context, 'form'));
        echo " method=\"POST\" class=\"fos_user_registration_register\">
    ";
        // line 23
        echo $this->env->getExtension('form')->renderErrors($this->getContext($context, 'form'));
        echo "
            <table align='center' >
                <tr>
                    <td align='center' colspan=\"2\"><h3>Registro de Nuevos Usuarios</h3></td>
                </tr>
                <tr>
                    <td><label id=\"username\" >Nombre de Usuario:</label></td>
                    <td>";
        // line 30
        echo $this->env->getExtension('form')->renderWidget($this->getAttribute($this->getContext($context, 'form'), "username", array(), "any", false));
        echo "</td>
                </tr>
                <tr>
                    <td><label id=\"email\" >Email:</label></td>
                    <td>";
        // line 34
        echo $this->env->getExtension('form')->renderWidget($this->getAttribute($this->getContext($context, 'form'), "email", array(), "any", false));
        echo "</td>
                </tr>            
                <tr>
                    <td><label id=\"plainPasswordfirst\" >Password:</label></td>
                    <td>";
        // line 38
        echo $this->env->getExtension('form')->renderWidget($this->getAttribute($this->getAttribute($this->getContext($context, 'form'), "plainPassword", array(), "any", false), "first", array(), "any", false));
        echo "</td>
                </tr>   
                <tr>
                    <td><label id=\"plainPasswordsecond\" >Re-Password:</label></td>
                    <td>";
        // line 42
        echo $this->env->getExtension('form')->renderWidget($this->getAttribute($this->getAttribute($this->getContext($context, 'form'), "plainPassword", array(), "any", false), "second", array(), "any", false));
        echo "</td>                
                </tr>  

                <tr>
                    <td><label id=\"idEmpleado\" >Digite su codigo de empleado:</label></td>
                    <td>";
        // line 47
        echo $this->env->getExtension('form')->renderWidget($this->getAttribute($this->getContext($context, 'form'), "idEmpleado", array(), "any", false));
        echo "</td>                
                </tr> 
                <tr>
                    <td align='center' colspan=2 >
                        <input type=\"button\" value=\"  Registrar Usuario  \" id=\"verificaEmpleado\"/>
                        <br>
                        <textarea readonly=\"readonly\" rows=\"2\" cols=\"50\" id=\"mensaje\" style=\"font-family: Verdana, Geneva, sans-serif; color: red; border: none; background-color: white; font-weight: bolder; font-size: 10px\" ></textarea>
                        <br>

                        <input style=\" visibility: hidden\" type=\"submit\" value=\"";
        // line 56
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("Registrar", array(), "FOSUserBundle"), "html");
        echo "\" />
                    </td>
                </tr>
            </table>    

    ";
        // line 61
        echo $this->env->getExtension('form')->renderRest($this->getContext($context, 'form'));
        echo "
        </form>";
    }

    public function getTemplateName()
    {
        return "FOSUserBundle:Registration:register_content.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }
}
