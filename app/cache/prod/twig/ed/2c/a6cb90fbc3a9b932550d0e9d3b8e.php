<?php

/* MinSalSidPlaBundle:Default:index.html.twig */
class __TwigTemplate_ed2ca6cb90fbc3a9b932550d0e9d3b8e extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->blocks = array(
            'titulo' => array($this, 'block_titulo'),
            'stylesheets' => array($this, 'block_stylesheets'),
            'javascripts' => array($this, 'block_javascripts'),
            'body' => array($this, 'block_body'),
            'login' => array($this, 'block_login'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $context = array_merge($this->env->getGlobals(), $context);

        // line 1
        echo "<!DOCTYPE html>
<HTML>
    <head>
        <meta http-equiv=\"content-type\" content=\"text/html;charset=utf-8\" />
        <title>";
        // line 5
        $this->displayBlock('titulo', $context, $blocks);
        echo "</title>

        ";
        // line 7
        $this->displayBlock('stylesheets', $context, $blocks);
        // line 16
        echo "

    </head>
    <body>   
    ";
        // line 20
        $this->displayBlock('javascripts', $context, $blocks);
        // line 35
        echo " 
            <script type=\"text/javascript\">
                  \$(document).ready(function(){
                     ";
        // line 38
        $context['nivel'] = 1;
        echo " 
                     \$(function crearMenu() {
                         ";
        // line 40
        if ($this->env->getExtension('security')->isGranted("IS_AUTHENTICATED_REMEMBERED")) {
            echo " 
                             ";
            // line 41
            if (array_key_exists("opciones", $context)) {
                // line 42
                echo "                                 \$('#nav').append('<li id=\"liInicio0\" class=\"top\"><a  class=\"top_link\" href=\"";
                echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("MinSalSidPlaBundle_homepage"), "html");
                echo "\"><span >Inicio</span></a></li>');                                        
                                 ";
                // line 43
                if (($this->getContext($context, 'nivel') < 3)) {
                    echo "                                    
                                    ";
                    // line 44
                    $context['_parent'] = (array) $context;
                    $context['_seq'] = twig_ensure_traversable($this->getContext($context, 'opciones'));
                    foreach ($context['_seq'] as $context['_key'] => $context['opc']) {
                        // line 45
                        echo "                                        ";
                        if (twig_test_empty($this->getAttribute($this->getContext($context, 'opc'), "idOpcionSistema2", array(), "any", false))) {
                            // line 46
                            echo "                                            ";
                            if (($this->getAttribute($this->getContext($context, 'opc'), "nombreOpcion", array(), "any", false) == "Inicio")) {
                                echo "                                                    
                                                    
                                            ";
                            } else {
                                // line 49
                                echo "                                                \$('#nav').append('<li id=\"li";
                                echo twig_escape_filter($this->env, $this->getAttribute($this->getContext($context, 'opc'), "idOpcionSistema", array(), "any", false), "html");
                                echo "\" class=\"top\"><a  class=\"top_link\" href=\"";
                                echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath($this->getAttribute($this->getContext($context, 'opc'), "enlace", array(), "any", false)), "html");
                                echo "\"><span class=\"down\">";
                                echo twig_escape_filter($this->env, $this->getAttribute($this->getContext($context, 'opc'), "nombreOpcion", array(), "any", false), "html");
                                echo "</span></a></li>');                                        
                                                \$('#li";
                                // line 50
                                echo twig_escape_filter($this->env, $this->getAttribute($this->getContext($context, 'opc'), "idOpcionSistema", array(), "any", false), "html");
                                echo "').append('<ul id=\"opc";
                                echo twig_escape_filter($this->env, $this->getAttribute($this->getContext($context, 'opc'), "idOpcionSistema", array(), "any", false), "html");
                                echo "\" class=\"sub\"></ul>');  
                                            ";
                            }
                            // line 51
                            echo "                                                                                                     
                                            ";
                            // line 52
                            $context['_parent'] = (array) $context;
                            $context['_seq'] = twig_ensure_traversable($this->getContext($context, 'opciones'));
                            foreach ($context['_seq'] as $context['_key'] => $context['subopc']) {
                                echo "  
                                                ";
                                // line 53
                                if (($this->getAttribute($this->getContext($context, 'subopc'), "idOpcionSistema2", array(), "any", false) == $this->getAttribute($this->getContext($context, 'opc'), "idOpcionSistema", array(), "any", false))) {
                                    // line 54
                                    echo "                                                    \$('#opc";
                                    echo twig_escape_filter($this->env, $this->getAttribute($this->getContext($context, 'opc'), "idOpcionSistema", array(), "any", false), "html");
                                    echo "').append('<li> <a href=\"";
                                    echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath($this->getAttribute($this->getContext($context, 'subopc'), "enlace", array(), "any", false)), "html");
                                    echo "\">";
                                    echo twig_escape_filter($this->env, $this->getAttribute($this->getContext($context, 'subopc'), "nombreOpcion", array(), "any", false), "html");
                                    echo "</a></li>');
                                                    ";
                                    // line 55
                                    $context['nivel'] = 3;
                                    // line 56
                                    echo "                                                    //crearMenu();
                                                ";
                                }
                                // line 57
                                echo "                                
                                            ";
                            }
                            $_parent = $context['_parent'];
                            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['subopc'], $context['_parent'], $context['loop']);
                            $context = array_merge($_parent, array_intersect_key($context, $_parent));
                            // line 58
                            echo "                                                                                           
                                        ";
                        }
                        // line 59
                        echo "                                
                                    ";
                    }
                    $_parent = $context['_parent'];
                    unset($context['_seq'], $context['_iterated'], $context['_key'], $context['opc'], $context['_parent'], $context['loop']);
                    $context = array_merge($_parent, array_intersect_key($context, $_parent));
                    // line 61
                    echo "                                 ";
                } else {
                    echo "        
                                        \$('#nav').append('<li class=\"top\"><a  class=\"top_link\" href=\"";
                    // line 62
                    echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("fos_user_security_logout"), "html");
                    echo "\"><span >";
                    echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("Salir", array(), "FOSUserBundle"), "html");
                    echo " </span></a></li>');                                           
                                 ";
                }
                // line 63
                echo "  
                             ";
            }
            // line 64
            echo "  
                             \$('#nav').append('<li class=\"top\"><a  class=\"top_link\" href=\"";
            // line 65
            echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("fos_user_security_logout"), "html");
            echo "\"><span >";
            echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("Salir", array(), "FOSUserBundle"), "html");
            echo "</span></a></li>');                                
                             <!--\$('#nav').append('<li class=\"top\"><a  class=\"top_link\" href=\"";
            // line 66
            echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("fos_user_profile_show"), "html");
            echo "\"><span >";
            echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("Perfil", array(), "FOSUserBundle"), "html");
            echo "</span></a></li>');-->
                         ";
        } else {
            // line 67
            echo "                                 
                             \$('#nav').append(\"<li  class='top'><a  class='top_link' href='";
            // line 68
            echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("fos_user_security_login"), "html");
            echo "'><span>";
            echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("Iniciar", array(), "FOSUserBundle"), "html");
            echo "</span></a></li>\");
                             \$('#nav').append(\"<li class='top'><a  class='top_link' href='";
            // line 69
            echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("fos_user_registration_register"), "html");
            echo "'><span >";
            echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("Registrarse", array(), "FOSUserBundle"), "html");
            echo "</span></a></li>\");                                 
                         ";
        }
        // line 70
        echo " 
                        
                      });
                  });
                </script>
                <div class=\"container\">
                    <div id=\"header\">
                        <img align=\"center\" src=\"";
        // line 77
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/minsalsidpla/images/logo_sidpla.png"), "html");
        echo "\" height=\"115px\" alt=\"\" />
                        <span class=\"preload1\"></span>
                        <span class=\"preload2\"></span>                            
                        <ul id=\"nav\"></ul>
                            ";
        // line 81
        if ($this->env->getExtension('security')->isGranted("IS_AUTHENTICATED_REMEMBERED")) {
            // line 82
            echo "                        <h3 align=\"right\">Bienvenid@ ";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getContext($context, 'app'), "user", array(), "any", false), "userPrimerNombre", array(), "any", false), "html");
            echo "&nbsp;";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getContext($context, 'app'), "user", array(), "any", false), "userApellidos", array(), "any", false), "html");
            echo "!!</h3>                            
                            ";
            // line 83
            if ($this->getAttribute($this->getAttribute($this->getContext($context, 'app'), "user", array(), "any", false), "entidad", array(), "any", false)) {
                // line 84
                echo "                        <h3 align=\"right\">";
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute($this->getContext($context, 'app'), "user", array(), "any", false), "entidad", array(), "any", false), "entNombComercial", array(), "any", false), "html");
                echo "</h3>
                            ";
            }
            // line 86
            echo "                        
                            ";
        }
        // line 87
        echo "    
                    </div>

                    <div id=\"contenido\">

                             ";
        // line 92
        if ($this->env->getExtension('security')->isGranted("IS_AUTHENTICATED_REMEMBERED")) {
            echo "              
                                ";
            // line 93
            $this->displayBlock('body', $context, $blocks);
            // line 120
            echo " 
                             ";
        } else {
            // line 122
            echo "                                ";
            $this->displayBlock('login', $context, $blocks);
            // line 123
            echo " 
                             ";
        }
        // line 124
        echo " 
                    </div>
                    <div id=\"pie\">Copyright (C) 2013 Ministerio de Salud</div>

                </div>
            </body>
        </HTML>
";
    }

    // line 5
    public function block_titulo($context, array $blocks = array())
    {
        echo "Sistema para la Planificaci&oacute;n Anual Operativa";
    }

    // line 7
    public function block_stylesheets($context, array $blocks = array())
    {
        // line 8
        echo "        <link href=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/minsalsidpla/css/redmond/jquery-ui-1.8.16.custom.css"), "html");
        echo "\" type=\"text/css\" rel=\"stylesheet\" />
        <link href=\"";
        // line 9
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/minsalsidpla/css/ui.jqgrid.css"), "html");
        echo "\" type=\"text/css\" rel=\"stylesheet\" />
        <link href=\"";
        // line 10
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/minsalsidpla/css/estiloPrincipalMenu.css"), "html");
        echo "\" type=\"text/css\" rel=\"stylesheet\" />           
        <link href=\"";
        // line 11
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/minsalsidpla/css/elementosSidPla.css"), "html");
        echo "\" type=\"text/css\" rel=\"stylesheet\" />           
        <link href=\"";
        // line 12
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/minsalsidpla/css/jqModal.css"), "html");
        echo "\" type=\"text/css\" rel=\"stylesheet\" />           
        <link href=\"";
        // line 13
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/minsalsidpla/menuSidPla/pro_drop_1.css"), "html");
        echo "\" type=\"text/css\" rel=\"stylesheet\" /> 
        <link href=\"";
        // line 14
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/minsalsidpla/images/icono.png"), "html");
        echo "\" type=\"imagen/png\" rel=\"Shortcut Icon\" /> 
        ";
    }

    // line 20
    public function block_javascripts($context, array $blocks = array())
    {
        echo " 
            <script type=\"text/javascript\" src=\"";
        // line 21
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/minsalsidpla/js/jquery-1.6.2.min.js"), "html");
        echo "\" ></script>
            <script type=\"text/javascript\" src=\"";
        // line 22
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/minsalsidpla/js/jquery-ui-1.8.16.custom.min.js"), "html");
        echo "\"></script>
            <script src=\"";
        // line 23
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/minsalsidpla/js/i18n/grid.locale-es.js"), "html");
        echo "\" type=\"text/javascript\"></script>
            <script src=\"";
        // line 24
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/minsalsidpla/js/jquery.jqGrid.min.js"), "html");
        echo "\" type=\"text/javascript\"></script>
            <script src=\"";
        // line 25
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/minsalsidpla/js/jqModal.js"), "html");
        echo "\" type=\"text/javascript\"></script>
            <script src=\"";
        // line 26
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/minsalsidpla/js/jquery.calculation.min.js"), "html");
        echo "\" type=\"text/javascript\"></script>
            <script src=\"";
        // line 27
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/minsalsidpla/js/jquery.combobox.js"), "html");
        echo "\" type=\"text/javascript\"></script>
            <script src=\"";
        // line 28
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/minsalsidpla/menuSidPla/stuHover.js"), "html");
        echo "\" type=\"text/javascript\"></script> 
            <script src=\"";
        // line 29
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/minsalsidpla/js/jquery.validate.js"), "html");
        echo "\" type=\"text/javascript\"></script>
            <script src=\"";
        // line 30
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/minsalsidpla/js/jquery.maskedinput.js"), "html");
        echo "\" type=\"text/javascript\"></script>
            <script src=\"";
        // line 31
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/minsalsidpla/js/jquery.ui.datepicker-es.js"), "html");
        echo "\" type=\"text/javascript\"></script>
            <script src=\"";
        // line 32
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/minsalsidpla/js/highcharts/highcharts.js"), "html");
        echo "\" type=\"text/javascript\"></script>
            <script src=\"";
        // line 33
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/minsalsidpla/js/jquery.keyfilter.js"), "html");
        echo "\" type=\"text/javascript\"></script>

    ";
    }

    // line 93
    public function block_body($context, array $blocks = array())
    {
        echo "                                    
                                    ";
        // line 94
        if ((!array_key_exists("opciones", $context))) {
            // line 95
            echo "                        <h2>Contacte al Administrador del Sistema para que le asigne un rol y asi podra ingresar al sistema correctamente</h2>
                                    ";
        }
        // line 97
        echo "                        <table>
                            <tr>
                                <td align=\"center\">                                                
                                    <br>                                               
                                    <img align=\"center\" src=\"";
        // line 101
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/minsalsidpla/images/sidpla1.png"), "html");
        echo "\" alt=\"descripción\" height=\"100px\" />                                    

                                </td>
                                <td>
                                    <img align=\"right\" src=\"";
        // line 105
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/minsalsidpla/images/planificacion.png"), "html");
        echo "\" alt=\"descripción\" height=\"280px\"  />                                    
                                </td>
                            </tr>
                            <tr>
                                <td >
                                    <h3>“El Plan, lejos de ser un requisito jurídico legal, es
                                        una herramienta para cuantificar los productos y
                                        efectos reales que como gobierno generamos en la
                                        sociedad a partir de la ejecución de nuestra
                                        política y reforma de salud”.  </h3>                                                      
                                    <h4>Adaptado de la Guía metodológica aplicada para la formulación de indicadores y el seguimiento a metas de gobierno en el municipio de Tocancipá, Cundinamarca, Colombia.</h4>
                                </td>
                            </tr>
                        </table>

                                ";
    }

    // line 122
    public function block_login($context, array $blocks = array())
    {
        // line 123
        echo "                                ";
    }

    public function getTemplateName()
    {
        return "MinSalSidPlaBundle:Default:index.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }
}
