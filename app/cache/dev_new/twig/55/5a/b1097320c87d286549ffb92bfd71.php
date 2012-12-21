<?php

/* MinSalSidPlaReportesBundle:Consolidados:reportesDependencias.html.twig */
class __TwigTemplate_555ab1097320c87d286549ffb92bfd71 extends Twig_Template
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
   
   \$(\"#idDepen\").combobox();
   \$('#idDepen').css(\"width\", '150px');
    
   \$('#enviar1').button();
   \$('#enviar1').click(function(evento) {
          if(\$(\"#idDepen\").val()==0){
                       alert(\"Seleccione una Unidad de Salud para generar el Reporte\");
                        evento.preventDefault();
          }
          else{ 
             this.form.action='";
        // line 17
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("MinSalSidPlaReportesBundle_reporteDependenciaInvidual"), "html");
        echo "';
          }
    });
    
    
   \$('#enviar2').button();
   \$('#enviar2').click(function(evento) {
          if(\$(\"#idDepen\").val()==0){
                       alert(\"Seleccione una Unidad de Salud para generar el Reporte\");
                        evento.preventDefault();
          }
         else{ 
             this.form.action= '";
        // line 29
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("MinSalSidPlaReportesBundle_reporteFormulario1"), "html");
        echo "';            
         }
    });
    
   \$('#enviar3').button();
   \$('#enviar3').click(function(evento) {
          if(\$(\"#idDepen\").val()==0){
                       alert(\"Seleccione una Unidad de Salud para generar el Reporte\");
                        evento.preventDefault();
          }
         else{ 
             this.form.action='";
        // line 40
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("MinSalSidPlaReportesBundle_reporteCaracOrg"), "html");
        echo "';
         }
    });
    
   \$('#enviar4').button();
   \$('#enviar4').click(function(evento) {
          if(\$(\"#idDepen\").val()==0){
                       alert(\"Seleccione una Unidad de Salud para generar el Reporte\");
                        evento.preventDefault();
          }
         else{ 
             this.form.action='";
        // line 51
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("MinSalSidPlaReportesBundle_reporteCompromisoCumplimiento"), "html");
        echo "';
         }
    });
   
   \$('#enviar5').button();
   \$('#enviar5').click(function(evento) {
          if(\$(\"#idDepen\").val()==0){
                       alert(\"Seleccione una Unidad de Salud para generar el Reporte\");
                        evento.preventDefault();
          }
         else{ 
             this.form.action='";
        // line 62
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("MinSalSidPlaReportesBundle_reporteActividadesAtrasadas"), "html");
        echo "';
         }
    });
   
    
    \$.getJSON('reportesDepenJSON', function(data) {
         var i=0;
         \$.each(data, function(key, val) {
           if(key=='rows'){
             \$.each(val, function(id, registro){
                 \$('#idDepen').append('<option value=\"'+registro['cell'][1]+'\">'+registro['cell'][0]+'</option>');
             });
            }
          });
    });
});\t

 </script>

    <br></br>               
    <form action=\"\" method=\"post\">
        <input type=\"hidden\" name=\"anioConsultar\" value=\"";
        // line 83
        echo twig_escape_filter($this->env, twig_date_format_filter("now", "Y"), "html");
        echo " \" />
        <table align=\"center\">
            <tr>
                <td colspan=\"2\" align=\"center\"><h1>Reportes de Dependencias</h1>                    
                </td>
            </tr>
            <tr>
                <td align=\"center\">
                    <p style=\" font-family: Verdana, Geneva, sans-serif; font-size: 12px;\" > Seleccione la Dependencia para generar el reporte<br/>
                        Luego de Clic en el reporte que desea Generar   
                    </p>
                </td>
                <td>
                    <select id='idDepen' name='idDepen'>
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
                    <input type=\"submit\" value=\"Programacion de Resultados y Actividades\" id=\"enviar1\"/>
                    <input type=\"submit\" value=\"Informacion General\" id=\"enviar2\"/>
                    <input type=\"submit\" value=\"Caracteristicas de la Organizacion\" id=\"enviar3\"/>
                    <input type=\"submit\" value=\"Compromiso Cumplimiento\" id=\"enviar4\"/>
                    <input type=\"submit\" value=\"Actividades Atrasadas\" id=\"enviar5\"/>
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
        return "MinSalSidPlaReportesBundle:Consolidados:reportesDependencias.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }
}
