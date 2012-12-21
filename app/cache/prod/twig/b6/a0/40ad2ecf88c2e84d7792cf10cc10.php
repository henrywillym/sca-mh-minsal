<?php

/* MinSalSidPlaReportesBundle:Consolidados:reportConsolidosPersonalizados.html.twig */
class __TwigTemplate_b6a040ad2ecf88c2e84d7792cf10cc10 extends Twig_Template
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

    // line 4
    public function block_body($context, array $blocks = array())
    {
        // line 5
        echo "<script type=\"text/javascript\">
\$(document).ready(function(){
    \$('#reporteMatrix').button();
    \$('#reporteConsolidado').button();
    \$('#reporteConsolidado').click(function(evento) {
        if(\$(\"#tipoUnidad\").val()==''){
            alert(\"Seleccione Dependencia o SIBASI/Region de Salud para generar el Reporte\");
            evento.preventDefault();
        }
        else{
          if(\$(\"#anio\").val()==''){
            alert(\"Seleccione un Año\");
            evento.preventDefault();
          }
          else
            this.form.action='";
        // line 20
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("MinSalSidPlaReportesBundle_reporteConsolidadoNivelCentral"), "html");
        echo "';
         }
    });
    
    \$('#reporteMatrix').click(function(evento) {
         if(\$(\"#tipoUnidadec\").val()==''){
            alert(\"Seleccione Dependencia o SIBASI/Region de Salud para generar el Reporte\");
            evento.preventDefault();
        }
        else{
          if(\$(\"#anioec\").val()==''){
            alert(\"Seleccione un Año\");
            evento.preventDefault();
          }
          else
            this.form.action='";
        // line 35
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("MinSalSidPlaReportesBundle_reporteMatrizdeObjetivosyResultados"), "html");
        echo "';
        }
    });
    
});\t

 </script>


    <br></br>               
    <form id = \"formulario\"  action=\"\" method=\"post\">
        <table align=\"center\"  >
            <tr><td colspan=\"10\" align=\"center\"><h1>Reportes Consolidados</h1>                    
                </td>
            </tr>
            <tr>
                <td colspan=\"10\" align=\"center\">
                    Seleccione los parametros correspondientes para la elaboracion de Reporte . <br>
                    De clic en el boton  generar reporte.<br><br>
                </td>
            </tr>            
           
            <tr>
               
                        <td  >Consolidado de Nivel Central y SIBASI/Regiones de Salud:<br></td>
                        <td colspan=\"3\">
                            <select id=\"tipoUnidad\" class=\"required\" name=\"tipoUnidad\">
                                 <option value='' selected=\"selected\" >Seleccione el tipo de unidad</option>
                                 <option value=\"1\" >Dependencia</option>    
                                 <option value=\"3\" >SIBASI/Regiones de Salud</option>    
                                   
                            </select>
                        </td>
                     <td colspan=\"3\">
                            <select id=\"anio\" class=\"required\" name=\"anio\">
                                 <option value=''selected=\"selected\" >Seleccione el año</option>
                                 <option value=\"2011\">2011</option>    
                                 <option value=\"2012\">2012</option>    
                                   
                            </select>
                        </td>
                        
                        
                        <td>
                        <input type=\"submit\" value=\"Generar Reporte\" name= \"reporte\" id=\"reporteConsolidado\"</input>
                        </td>
                        </tr> 
                        
                        
                         <tr>
               
                        <td  >Matriz de Objetivos y Resultados de Dependecias y SIBASI/Regiones de Salud:<br></td>
                        <td colspan=\"3\">
                            <select id=\"tipoUnidadec\" class=\"required\" name=\"tipoUnidadec\">
                                 <option value=''selected=\"selected\" >Seleccione el tipo de unidad</option>
                                 <option value=\"1\" >Dependencia</option>    
                                 <option value=\"3\" >SIBASI/Regiones de Salud</option>    
                                   
                            </select>
                        </td>
                     <td colspan=\"3\">
                            <select id=\"anioec\" class=\"required\" name=\"anioec\">
                                 <option value=''selected=\"selected\" >Seleccione el año</option>
                                 <option value=\"2011\">2011</option>    
                                 <option value=\"2012\">2012</option>    
                                   
                            </select>
                        </td>
                        
                        
                        <td>
                        <input type=\"submit\" value=\"Generar Reporte\" name= \"reporte2\" id=\"reporteMatrix\"</input>
                        </td>
                        </tr> 
            
            <tr>           
                <td colspan=\"2\" align=\"center\">
                <br></br>                                    
                </td>
            </tr>        
                  
        </table>   
    </form>
    <br></br>
    <br></br>

";
    }

    public function getTemplateName()
    {
        return "MinSalSidPlaReportesBundle:Consolidados:reportConsolidosPersonalizados.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }
}
