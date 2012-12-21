<?php

/* MinSalSidPlaReportesBundle:Consolidados:reportesUniSal.html.twig */
class __TwigTemplate_22bb015c439dba87ec8d9a962d861e5f extends Twig_Template
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

    // line 3
    public function block_body($context, array $blocks = array())
    {
        // line 4
        echo "<script type=\"text/javascript\">
\$(document).ready(function(){
   
   \$(\"#idUniSal\").combobox();
   \$('#idUnisal').css(\"width\", '150px');
   
   \$('#enviar3').button();
   \$('#enviar3').click(function(evento) {
          if(\$(\"#idUniSal\").val()==0){
                       alert(\"Seleccione una Unidad de Salud para generar el Reporte\");
                        evento.preventDefault();
          }
         else 
             this.form.action='";
        // line 17
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("MinSalSidPlaReportesBundle_reporteJustificacion"), "html");
        echo "';
    });
    
   \$('#enviar4').button();
   \$('#enviar4').click(function(evento) {
          if(\$(\"#idUniSal\").val()==0){
                       alert(\"Seleccione una Unidad de Salud para generar el Reporte\");
                        evento.preventDefault();
          }
         else{ 
              this.form.action='";
        // line 27
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("MinSalSidPlaReportesBundle_reporteInfraEvaluada"), "html");
        echo "';
        }
    });
    
   \$('#enviar2').button();
   \$('#enviar2').click(function(evento) {
          if(\$(\"#idUniSal\").val()==0){
                       alert(\"Seleccione una Unidad de Salud para generar el Reporte\");
                        evento.preventDefault();
          }
         else{ 
             this.form.action='";
        // line 38
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("MinSalSidPlaCensoBundle_generarCensoUsuarioDirPla"), "html");
        echo "';
         }
    });
    
   \$('#enviar1').button();
   \$('#enviar1').click(function(evento) {
          if(\$(\"#idUniSal\").val()==0){
                       alert(\"Seleccione una Unidad de Salud para generar el Reporte\");
                        evento.preventDefault();
          }
         else{ 
             this.form.action='";
        // line 49
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("MinSalSidPlaReportesBundle_reporteIndicadoresSalud"), "html");
        echo "';
         }
    });
    
   \$('#enviar5').button();
   \$('#enviar5').click(function(evento) {
          if(\$(\"#idUniSal\").val()==0){
                       alert(\"Seleccione una Unidad de Salud para generar el Reporte\");
                        evento.preventDefault();
          }
         /*else{ 
             this.form.action='";
        // line 60
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("MinSalSidPlaCensoBundle_generarCensoUsuario"), "html");
        echo "';
         }*/
    });
    
   \$('#enviar6').button();
   \$('#enviar6').click(function(evento) {
          if(\$(\"#idUniSal\").val()==0){
                       alert(\"Seleccione una Unidad de Salud para generar el Reporte\");
                        evento.preventDefault();
          }
         else{ 
             this.form.action= '";
        // line 71
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("MinSalSidPlaReportesBundle_reporteFormulario1Unisal"), "html");
        echo "';
         }
    });
    
   \$('#enviar7').button();
   \$('#enviar7').click(function(evento) {
          if(\$(\"#idUniSal\").val()==0){
                       alert(\"Seleccione una Unidad de Salud para generar el Reporte\");
                        evento.preventDefault();
          }
         else{ 
             this.form.action= '";
        // line 82
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("MinSalSidPlaReportesBundle_reporteCaracOrg"), "html");
        echo "';
         }
    });
    
    
    \$.getJSON('reportesUniSalJSON', function(data) {
         var i=0;
         \$.each(data, function(key, val) {
           if(key=='rows'){
             \$.each(val, function(id, registro){
                 \$('#idUniSal').append('<option value=\"'+registro['cell'][1]+'\">'+registro['cell'][0]+'</option>');
             });
            }
          });
    });
});\t

 </script>

    <br></br>               
    <form action=\"\" method=\"post\">
        <table align=\"center\">
            <tr>
                <td colspan=\"2\" align=\"center\"><h1>Reportes de Unidades de Salud</h1>                    
                </td>
            </tr>
            <tr>
                <td align=\"center\">
                    <p style=\" font-family: Verdana, Geneva, sans-serif; font-size: 12px;\" > Seleccione la Unidad de Salud para generar el reporte<br/>
                        Luego de Clic en el reporte que desea Generar   
                    </p>
                </td>
                <td>
                    <select id='idUniSal' name='idUniSal'>
                        <option value=\"0\" >Seleccione</option>
                    </select>
                </td>
                
            </tr>
            <tr>
                <td colspan=\"2\"  align=\"center\">
                    <br/><br/><br/>
                </td>
            </tr> 
            <tr>
                <td colspan=\"2\"  align=\"center\">
                    <input type=\"submit\" value=\"Informacion General\" id=\"enviar6\"/>
                    <input type=\"submit\" value=\"Caracteristicas de la Organizacion\" id=\"enviar7\"/>
                    <input type=\"submit\" value=\"Justificacion\" id=\"enviar3\"/>
                </td>
            </tr>
            <tr>
                <td colspan=\"2\"  align=\"center\">
                   <br/>
                    <input type=\"submit\" value=\"Evaluacion Infraestructura\" id=\"enviar4\"/>
                    <input type=\"submit\" value=\"Censo Poblacion\" id=\"enviar2\"/>
                    <input type=\"submit\" value=\"Indicadores de Salud\" id=\"enviar1\"/>
                    <input type=\"submit\" value=\"Plantilla de Act. Trazadoras\" id=\"enviar5\"/>
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
        return "MinSalSidPlaReportesBundle:Consolidados:reportesUniSal.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }
}
