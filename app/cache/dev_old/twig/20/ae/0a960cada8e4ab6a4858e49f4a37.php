<?php

/* MinSalSidPlaTemplateUnisalBundle:ActividadUnisalTemplate:gestionActividadUnisalTemplate.html.twig */
class __TwigTemplate_20ae0a960cada8e4ab6a4858e49f4a37 extends Twig_Template
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

    // line 2
    public function block_body($context, array $blocks = array())
    {
        // line 3
        echo "<script type=\"text/javascript\">
\$(document).ready(function(){
    \$('#guardarResEsp').button();
    \$('#limpiarResEsp').button();
    \$('#regresarResEsp').button();
    
    \$('#guardarResEsp').click(function(evento) {
          this.form.action='";
        // line 10
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("MinSalSidPlaTemplateUnisalBundle_manttActUnisalTemplate"), "html");
        echo "';
    });
    
   \$(\"#regresarResEsp\").click(function(){
       window.location='mostrarActUnisalTemplate?idObj=";
        // line 14
        echo twig_escape_filter($this->env, $this->getContext($context, 'idObj'), "html");
        echo "&idResEsp=";
        echo twig_escape_filter($this->env, $this->getContext($context, 'idResEsp'), "html");
        echo "';
   });
   
   \$.getJSON('";
        // line 17
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("MinSalSidPlaCensoBundle_consultarCategoriaCensoJSON"), "html");
        echo "', function(data) {
      var i=0;
      \$.each(data, function(key, val) {
        if(key=='rows'){
          \$.each(val, function(id, registro){
           ";
        // line 22
        if (array_key_exists("universo", $context)) {
            // line 23
            echo "               if(registro['cell'][0]!=";
            echo twig_escape_filter($this->env, $this->getContext($context, 'universo'), "html");
            echo ")
                  \$('#categoriaCenso').append('<option value=\"'+registro['cell'][0]+'\">'+registro['cell'][1]+'</option>');
           ";
        } else {
            // line 26
            echo "               \$('#categoriaCenso').append('<option value=\"'+registro['cell'][0]+'\">'+registro['cell'][1]+'</option>');                                
           ";
        }
        // line 28
        echo "           
          });                    
        }
      });
   });
   \$(\"#categoriaCenso\").combobox();
   \$('#categoriaCenso').css(\"width\", '150px');
    
    \$(\"#forResEsp\").validate();
    \$('#tabs').tabs();
    
});
    </script>
    <style type=\"text/css\">
            form.cmxform label.error, label.error {
                /* remove the next line when you have trouble in IE6 with labels in list */
                color: red;
                font-style: italic
            }
            input.error { border: 1px dotted red; }
            textarea.error { border: 1px dotted red; }
        </style>  

        <form id=\"forResEsp\" name=\"forResEsp\" method=\"post\" >
";
        // line 52
        if (array_key_exists("idAct", $context)) {
            // line 53
            echo "                 <h1 style=\" text-align: center\">Modifique la Actividad para Unidades de Salud</h1>
        <div id=\"tabs\">
                <ul><li><a href=\"#tabs-1\">Actividad para Unidades de Salud</a></li></ul>
                <div id=\"tabs-1\" >
             <table colspan=\"4\"  align=\"center\">
                     <tr>
                        <td style=\" font-size: 12px\" >Objetivo:</td>   
                        <td align=\"center\" style=\" font-size: 12px\">
                            <textarea readonly=\"readonly\"  rows=\"4\" cols=\"83\" name= 'objEspTmp'  size=\"83%\" id=\"objEspTmp\" >";
            // line 61
            echo twig_escape_filter($this->env, $this->getContext($context, 'descObj'), "html");
            echo "</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td style=\" font-size: 12px\" >Resultado Esperado:</td>   
                        <td align=\"center\" style=\" font-size: 12px\">
                            <textarea readonly=\"readonly\"  rows=\"2\" cols=\"83\" name= 'descResEsp'  size=\"83%\" id=\"descResEsp\" >";
            // line 67
            echo twig_escape_filter($this->env, $this->getContext($context, 'descResEsp'), "html");
            echo "</textarea>
                        </td>
                    </tr>
                     <tr>
                        <td style=\" font-size: 12px\" >Actividad(*):</td>
                        <td><textarea class=\"required\" rows=\"4\" cols=\"83\" name= 'descAct'  size=\"83%\" id=\"descAct\" >";
            // line 72
            echo twig_escape_filter($this->env, $this->getContext($context, 'descAct'), "html");
            echo "</textarea></td>
                    </tr>
                     <tr>
                        <td style=\" font-size: 12px\" >Responsable(*):</td>
                        <td><input name=\"resAct\" id=\"resAct\" type=\"text\" size=\"60\" maxlength=\"150\" value=\"";
            // line 76
            echo twig_escape_filter($this->env, $this->getContext($context, 'resAct'), "html");
            echo "\" /></td>
                    </tr>
                    <tr>
                        <td style=\" font-size: 12px\" >Beneficiarios(*):</td>
                        <td><input name=\"benAct\" id=\"benAct\" type=\"text\" size=\"60\" maxlength=\"80\" value=\"";
            // line 80
            echo twig_escape_filter($this->env, $this->getContext($context, 'benAct'), "html");
            echo "\" /></td>
                    </tr>
                    <tr>
                        <td style=\" font-size: 12px\" >Universo:</td>
                          <td>                           
                            <select  id=\"categoriaCenso\" name=\"categoriaCenso\">
                               <option value=\"0\" >Seleccione una Categoria</option>
                               ";
            // line 87
            if (array_key_exists("universo", $context)) {
                // line 88
                echo "                               <option value=\"";
                echo twig_escape_filter($this->env, $this->getContext($context, 'universo'), "html");
                echo "\" selected=\"selected\" >";
                echo twig_escape_filter($this->env, $this->getContext($context, 'descuniverso'), "html");
                echo "</option>
                               ";
            }
            // line 90
            echo "                            </select>
                        </td> 
                    </tr>
                    <tr>
                        <td style=\" font-size: 12px; text-align: right\" valign=\"top\" >Total a utilizar para el Universo:</td>
                        <td><input type=\"radio\" name=\"tipTotAct\" value=\"1\"";
            // line 95
            if (array_key_exists("tipoTotAct", $context)) {
                if (($this->getContext($context, 'tipoTotAct') == 1)) {
                    echo "  checked=\"checked\" ";
                }
                echo " ";
            }
            echo "/> Total General<br></br>
                            <input type=\"radio\" name=\"tipTotAct\" value=\"2\" ";
            // line 96
            if (array_key_exists("tipoTotAct", $context)) {
                if (($this->getContext($context, 'tipoTotAct') == 2)) {
                    echo "  checked=\"checked\" ";
                }
                echo " ";
            }
            echo " /> Poblacion Promotores de Salud
                        </td>
                    </tr>
                    <tr>
                        <td style=\" font-size: 12px\" >Cobertura:</td>
                        <td><input name=\"cobAct\" id=\"cobAct\" type=\"text\" size=\"20\" value=\"";
            // line 101
            echo twig_escape_filter($this->env, $this->getContext($context, 'cobAct'), "html");
            echo "\" /></td>
                    </tr>
                    <tr>
                        <td style=\" font-size: 12px\" >Concentracion:</td>
                        <td><input name=\"conAct\" id=\"conAct\" type=\"text\" size=\"20\" value=\"";
            // line 105
            echo twig_escape_filter($this->env, $this->getContext($context, 'conAct'), "html");
            echo "\" /></td>
                    </tr>
                     <tr>
                        <td style=\" font-size: 12px\" >Supuestos Factores Condicionantes:</td>
                        <td><input name=\"supAct\" id=\"supAct\" type=\"text\" size=\"60\" maxlength=\"255\" value=\"";
            // line 109
            echo twig_escape_filter($this->env, $this->getContext($context, 'supAct'), "html");
            echo "\" /></td>
                    </tr>
                      <tr>
                          <td style=\" font-size: 12px\" ><br></br></td>
                        <td></td>
                    </tr>
                     <tr>
                        <td style=\" font-size: 12px; text-align: right\" valign=\"top\" >Meta Anual(*):</td>
                        <td><input type=\"radio\" name=\"metAnuAct\" value=\"1\"";
            // line 117
            if (($this->getContext($context, 'metAnuAct') == 1)) {
                echo "  checked=\"checked\" ";
            }
            echo " > Digitada<br></br>
                            <input type=\"radio\" name=\"metAnuAct\" value=\"2\" ";
            // line 118
            if (($this->getContext($context, 'metAnuAct') == 2)) {
                echo "  checked=\"checked\" ";
            }
            echo " > Calculada por Cantidad *  Concentracion<br></br>
                            <input type=\"radio\" name=\"metAnuAct\" value=\"3\" ";
            // line 119
            if (($this->getContext($context, 'metAnuAct') == 3)) {
                echo "  checked=\"checked\" ";
            }
            echo " > Formula
                        </td>
                    </tr>
                    <tr>
                        <td colspan=\"2\" align=\"center\">
                            <button type=\"submmit\" id=\"guardarResEsp\"  >Guardar</button>
                            <button type=\"reset\" id=\"limpiarResEsp\"  >Limpiar</button>
                            <button type=\"button\" id=\"regresarResEsp\"  >Regresar</button>
                        </td>
                    </tr>

                </table>
                <input type='hidden' name='idObj' id=\"idObj\" value='";
            // line 131
            echo twig_escape_filter($this->env, $this->getContext($context, 'idObj'), "html");
            echo "' />
                <input type='hidden' name='idResEsp' id=\"idResEsp\" value='";
            // line 132
            echo twig_escape_filter($this->env, $this->getContext($context, 'idResEsp'), "html");
            echo "' />  
                <input type='hidden' name='idAct' id=\"idAct\" value='";
            // line 133
            echo twig_escape_filter($this->env, $this->getContext($context, 'idAct'), "html");
            echo "' />  
                <input type='hidden' name='oper' id=\"oper\" value='edit' /> 
                  </div>
                </div>
";
        } else {
            // line 138
            echo "                  <h1 style=\" text-align: center\">Ingrese la Actividad para Unidades de Salud</h1>
        <div id=\"tabs\">
                <ul><li><a href=\"#tabs-1\">Actividad para Unidades de Salud</a></li></ul>
                <div id=\"tabs-1\" >
                <table colspan=\"4\"  align=\"center\"><!-- id=\"datos\"  -->
                    <tr>
                        <td style=\" font-size: 12px\" >Objetivo:</td>   
                        <td align=\"center\" style=\" font-size: 12px\">
                            <textarea readonly=\"readonly\"  rows=\"4\" cols=\"83\" name= 'objEspTmp'  size=\"83%\" id=\"objEspTmp\" >";
            // line 146
            echo twig_escape_filter($this->env, $this->getContext($context, 'descObj'), "html");
            echo "</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td style=\" font-size: 12px\" >Resultado Esperado:</td>   
                        <td align=\"center\" style=\" font-size: 12px\">
                            <textarea readonly=\"readonly\"  rows=\"2\" cols=\"83\" name= 'descResEsp'  size=\"83%\" id=\"descResEsp\" >";
            // line 152
            echo twig_escape_filter($this->env, $this->getContext($context, 'descResEsp'), "html");
            echo "</textarea>
                        </td>
                    </tr>
                     <tr>
                        <td style=\" font-size: 12px\" >Actividad(*):</td>
                        <td><textarea class=\"required\" rows=\"4\" cols=\"83\" name= 'descAct'  size=\"83%\" id=\"descAct\" ></textarea></td>
                    </tr>
                     <tr>
                        <td style=\" font-size: 12px\" >Responsable(*):</td>
                        <td><input class=\"required\" name=\"resAct\" id=\"resAct\" type=\"text\" size=\"60\" maxlength=\"150\" /></td>
                    </tr>
                    <tr>
                        <td style=\" font-size: 12px\" >Beneficiarios(*):</td>
                        <td><input class=\"required\" name=\"benAct\" id=\"benAct\" type=\"text\" size=\"60\" maxlength=\"80\" /></td>
                    </tr>
                                        <tr>
                        <td style=\" font-size: 12px\" >Universo:</td>
                          <td>                           
                            <select  id=\"categoriaCenso\" name=\"categoriaCenso\">
                                 <option value=\"0\" >Seleccione una Categoria</option>
                            </select>
                        </td> 
                    </tr>
                    <tr>
                        <td style=\" font-size: 12px; text-align: right\" valign=\"top\" >Total a utilizar para el Universo:</td>
                        <td><input type=\"radio\" name=\"tipTotAct\" value=\"1\"/> Total General<br></br>
                            <input type=\"radio\" name=\"tipTotAct\" value=\"2\"/> Poblacion Promotores de Salud
                        </td>
                    </tr>
                    <tr>
                        <td style=\" font-size: 12px\" >Cobertura:</td>
                        <td><input name=\"cobAct\" id=\"cobAct\" type=\"text\" size=\"20\" value=\"0\" /></td>
                    </tr>
                    <tr>
                        <td style=\" font-size: 12px\" >Concentracion:</td>
                        <td><input name=\"conAct\" id=\"conAct\" type=\"text\" size=\"20\" value=\"0\" /></td>
                    </tr>
                     <tr>
                        <td style=\" font-size: 12px\" >Supuestos Factores Condicionantes:</td>
                        <td><input name=\"supAct\" id=\"supAct\" type=\"text\" size=\"60\" maxlength=\"255\" /></td>
                    </tr>
                      <tr>
                          <td style=\" font-size: 12px\" ><br></br></td>
                        <td></td>
                    </tr>
                     <tr>
                        <td style=\" font-size: 12px; text-align: right\" valign=\"top\" >Meta Anual(*):</td>
                        <td><input class=\"required\" type=\"radio\" name=\"metAnuAct\" value=\"1\"> Digitada<br></br>
                            <input class=\"required\" type=\"radio\" name=\"metAnuAct\" value=\"2\"> Calculada por Cantidad *  Concentracion<br></br>
                            <input class=\"required\" type=\"radio\" name=\"metAnuAct\" value=\"3\"> Formula
                        </td>
                    </tr>
                    <tr>
                        <td colspan=\"2\" align=\"center\">
                            <button type=\"submmit\" id=\"guardarResEsp\"  >Guardar</button>
                            <button type=\"reset\" id=\"limpiarResEsp\"  >Limpiar</button>
                            <button type=\"button\" id=\"regresarResEsp\"  >Regresar</button>
                        </td>
                    </tr>

                </table>
                <input type='hidden' name='idObj' id=\"idObj\" value='";
            // line 213
            echo twig_escape_filter($this->env, $this->getContext($context, 'idObj'), "html");
            echo "' />
                <input type='hidden' name='idResEsp' id=\"idResEsp\" value='";
            // line 214
            echo twig_escape_filter($this->env, $this->getContext($context, 'idResEsp'), "html");
            echo "' />  
                <input type='hidden' name='oper' id=\"oper\" value='add' />
                  </div>
                </div>
";
        }
        // line 219
        echo "            </form>
";
    }

    public function getTemplateName()
    {
        return "MinSalSidPlaTemplateUnisalBundle:ActividadUnisalTemplate:gestionActividadUnisalTemplate.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }
}
