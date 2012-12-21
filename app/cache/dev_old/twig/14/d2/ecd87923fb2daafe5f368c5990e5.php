<?php

/* MinSalSidPlaCensoBundle:CensoUsuario:showAllInformacionRelevante.html.twig */
class __TwigTemplate_14d2ecd87923fb2daafe5f368c5990e5 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->blocks = array(
            'body' => array($this, 'block_body'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $context = array_merge($this->env->getGlobals(), $context);

        // line 17
        echo "
";
        // line 18
        $this->displayBlock('body', $context, $blocks);
    }

    public function block_body($context, array $blocks = array())
    {
        // line 19
        echo " <script type=\"text/javascript\">
      \$(document).ready(function(){
          
      });     
 </script>
 
";
        // line 25
        if (array_key_exists("bloques", $context)) {
            // line 26
            echo "    ";
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable($this->getContext($context, 'bloques'));
            foreach ($context['_seq'] as $context['_key'] => $context['bloque']) {
                // line 27
                echo "        ";
                if (($this->getAttribute($this->getContext($context, 'bloque'), "ordenBloque", array(), "any", false) == 4)) {
                    // line 28
                    echo "            <h3>";
                    echo twig_escape_filter($this->env, $this->getAttribute($this->getContext($context, 'bloque'), "nombreBloque", array(), "any", false), "html");
                    echo "</h3>
            <table border=\"1\">
                <thead>                    
                    <tr>
                         <td rowspan=\"2\" colspan=\"1\" >  </td>
                         <th colspan=\"2\" >Total</th>                        
                    </tr>                   
                </thead>
                <tbody>
            ";
                    // line 37
                    $context['_parent'] = (array) $context;
                    $context['_seq'] = twig_ensure_traversable($this->getAttribute($this->getContext($context, 'bloque'), "getCategoriasCenso", array(), "any", false));
                    foreach ($context['_seq'] as $context['_key'] => $context['categoria']) {
                        echo " 
                 ";
                        // line 38
                        if (array_key_exists("censoPoblacion", $context)) {
                            echo "                    
                    <tr>
                        <td colspan=\"1\" >";
                            // line 40
                            echo twig_escape_filter($this->env, $this->getAttribute($this->getContext($context, 'categoria'), "descripcionCategoria", array(), "any", false), "html");
                            echo " </td>                             
                    ";
                            // line 41
                            $context['_parent'] = (array) $context;
                            $context['_seq'] = twig_ensure_traversable($this->getAttribute($this->getContext($context, 'censoPoblacion'), "getInformacionRelevante", array(), "any", false));
                            foreach ($context['_seq'] as $context['_key'] => $context['infRelvante']) {
                                echo "                     
                        ";
                                // line 42
                                if (($this->getAttribute($this->getAttribute($this->getContext($context, 'infRelvante'), "categoriaCenso", array(), "any", false), "idCategoriaCenso", array(), "any", false) == $this->getAttribute($this->getContext($context, 'categoria'), "idCategoriaCenso", array(), "any", false))) {
                                    echo "                           
                                <td align=\"center\" >  
                                        <input size=\"2\" readonly=\"readonly\" name=\"idInfoComURBANA";
                                    // line 44
                                    echo twig_escape_filter($this->env, $this->getAttribute($this->getContext($context, 'categoria'), "idCategoriaCenso", array(), "any", false), "html");
                                    echo "\" value=\"";
                                    echo twig_escape_filter($this->env, $this->getAttribute($this->getContext($context, 'infRelvante'), "getInfRelCant", array(), "any", false), "html");
                                    echo "\"></input>
                                </td>                                                   
                        ";
                                }
                                // line 46
                                echo "   
                    ";
                            }
                            $_parent = $context['_parent'];
                            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['infRelvante'], $context['_parent'], $context['loop']);
                            $context = array_merge($_parent, array_intersect_key($context, $_parent));
                            // line 47
                            echo "                                      
                    </tr>
                  ";
                        }
                        // line 50
                        echo "            ";
                    }
                    $_parent = $context['_parent'];
                    unset($context['_seq'], $context['_iterated'], $context['_key'], $context['categoria'], $context['_parent'], $context['loop']);
                    $context = array_merge($_parent, array_intersect_key($context, $_parent));
                    // line 51
                    echo "                </tbody>
            </table>                    
        ";
                }
                // line 54
                echo "    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['bloque'], $context['_parent'], $context['loop']);
            $context = array_merge($_parent, array_intersect_key($context, $_parent));
        }
        // line 56
        echo "                       


";
    }

    public function getTemplateName()
    {
        return "MinSalSidPlaCensoBundle:CensoUsuario:showAllInformacionRelevante.html.twig";
    }

    public function isTraitable()
    {
        return true;
    }
}
