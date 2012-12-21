<?php

/* MinSalSidPlaUnidadOrgBundle:InforCaractOrg:ingresoInfoCaractOrg.html.twig */
class __TwigTemplate_1fed263a01914c951faeb0104ffeee44 extends Twig_Template
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
        \$(\"#formulario1\").validate();
        \$('#form1').button();
        \$('#form1').click(function() {
          ";
        // line 10
        if (($this->getContext($context, 'tipoUnidad') != "2")) {
            // line 11
            echo "            this.form.action= '";
            echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("MinSalSidPlaReportesBundle_reporteFormulario1"), "html");
            echo "';            
          ";
        } else {
            // line 13
            echo "            this.form.action= '";
            echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("MinSalSidPlaReportesBundle_reporteFormulario1Unisal"), "html");
            echo "';            
          ";
        }
        // line 14
        echo "    
        });
        
        \$('#reportCarac').click(function() {
            \$('#formulario').get(0).setAttribute('action', '";
        // line 18
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("MinSalSidPlaReportesBundle_reporteCaracOrg"), "html");
        echo "');            
           
                
        
        }); 
        
        \$('#guardarCarac').click(function() {
        \$('#formulario').get(0).setAttribute('action', '";
        // line 25
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("MinSalSidPlaUnidadOrgBundle_guardarCaracteristicas"), "html");
        echo "');            
        
        }); 
           
           \$('#reportCarac').button();
           \$('#tabs').tabs(); 
           \$('#guardarInfoGen').button();
           \$('#guardarCarac').button();
           \$('#dialog').jqm();
            \$(\"#telefono\").mask(\"9999-9999\",{placeholder:\" \"});
            \$(\"#fax\").mask(\"9999-9999\",{placeholder:\" \"});
           
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
<h1 style=\"text-align: center\"> Informaci&oacute;n General y Caracteristicas de la Organizaci&oacute;n</h1>
<div id=\"tabs\">
        <ul>
                <li><a href=\"#tabs-1\">Informacion General</a></li>
                <li><a href=\"#tabs-2\">Caracteristicas Organizaci&oacute;n</a></li>                
        </ul>
        <div id=\"tabs-1\" align=\"center\">
            <form id =\"formulario1\"action=\"";
        // line 56
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("MinSalSidPlaUnidadOrgBundle_guardarInfoGeneral"), "html");
        echo "\" method=\"post\" ";
        echo $this->env->getExtension('form')->renderEnctype($this->getContext($context, 'form'));
        echo ">              
                    <table size=\"100%\" >
                        <tr>
                            <td size=\"30%\" colspan=\"2\" >Nombre Unidad:</td>
                            <td size=\"70%\" colspan=\"2\">";
        // line 60
        echo twig_escape_filter($this->env, $this->getContext($context, 'unidadOrg'), "html");
        echo "</td>
                        </tr>
                        <tr>
                            <td colspan=\"2\">Instancia de quien depende:</td>
                            <td colspan=\"2\">";
        // line 64
        echo twig_escape_filter($this->env, $this->getContext($context, 'unidadPadre'), "html");
        echo "</td>
                        </tr>
                        <tr>
                            <td colspan=\"2\">Direcci&oacute;n:</td>
                            <td colspan=\"2\"><input size=\"60%\" name=\"direccion\" id=\"direccion\" value=\"";
        // line 68
        echo twig_escape_filter($this->env, $this->getContext($context, 'infoGeneralcoddireccion'), "html");
        echo " \"></input></td>
                        </tr>
                        <tr>
                            <td colspan=\"2\">Telefono: <td colspan=\"1\" ><input size=\"20%\" name=\"telefono\" id=\"telefono\" value=\"";
        // line 71
        echo twig_escape_filter($this->env, $this->getContext($context, 'infoGeneralcodtelefono'), "html");
        echo " \"></input></td>
                            <td colspan=\"1\">Fax:<input size=\"20%\" name=\"fax\" id=\"fax\" value=\"";
        // line 72
        echo twig_escape_filter($this->env, $this->getContext($context, 'infoGeneralcodfax'), "html");
        echo " \"></input></td>
                        </tr> 
                        <tr>
                            <td colspan=\"2\">Email:</td>
                            <td colspan=\"3\" ><input size=\"30%\" class=\"required email\" name=\"mail\" id=\"mail\" value=\"";
        // line 76
        echo twig_escape_filter($this->env, $this->getContext($context, 'infoGeneralcodmail'), "html");
        echo "\"></input>
                        </tr>
                        <tr>
                        <td >Responsable: </td>
                        <td colspan=\"3\" >";
        // line 80
        echo twig_escape_filter($this->env, $this->getContext($context, 'nombreempleado'), "html");
        echo " ";
        echo twig_escape_filter($this->env, $this->getContext($context, 'segundonombre'), "html");
        echo " ";
        echo twig_escape_filter($this->env, $this->getContext($context, 'apellidoempleado'), "html");
        echo " ";
        echo twig_escape_filter($this->env, $this->getContext($context, 'segundoapellido'), "html");
        echo "<input type='hidden' size=\"60%\" name=\"responsable\" readonly=\"readonly\" id=\"responsable\" value=\"";
        echo twig_escape_filter($this->env, $this->getContext($context, 'nombreempleado'), "html");
        echo " ";
        echo twig_escape_filter($this->env, $this->getContext($context, 'segundonombre'), "html");
        echo " ";
        echo twig_escape_filter($this->env, $this->getContext($context, 'apellidoempleado'), "html");
        echo " ";
        echo twig_escape_filter($this->env, $this->getContext($context, 'segundoapellido'), "html");
        echo "\"></input><input type='hidden' class=\"jqModal\" value=\"...\" id=\"buscar\"></input></td>
                        </tr> 
                        <tr>
                        <td colspan=\"2\">Actualizado:</td>
                        <td colspan=\"2\" readonly=\"readonly\" style=\"border:none\" >";
        // line 84
        echo twig_escape_filter($this->env, twig_date_format_filter($this->getContext($context, 'infoGeneralfecha'), "d/m/Y"), "html");
        echo "</td>
                        </tr> 
                        <tr>
                            <td colspan=\"4\"><br></br>Departamentos, Unidades, Secciones, ó Disciplinas que componen la dependencia y número de empleados. 
                                <br></br>
                            ";
        // line 89
        $this->env->loadTemplate("MinSalSidPlaDepUniBundle:DepartamentoUni:gridDeptoUni.html.twig")->display($context);
        // line 90
        echo "                                <p>Si desea cambiar la cantidad de personas asignadas a su departamento o agregar mas departamentos de <a href=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("MinSalSidPlaDepUniBundle_principal"), "html");
        echo "\">De clic aqui</a> </p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan=\"4\" align=\"center\">
                              <input type='hidden' name='idempleado' id=\"idempleado\" value='";
        // line 95
        echo twig_escape_filter($this->env, $this->getContext($context, 'responsable'), "html");
        echo "'> </input>
                               <input type='hidden' name='unidadorgcod' id=\"unidadorgcod\" value='";
        // line 96
        echo twig_escape_filter($this->env, $this->getContext($context, 'unidadorgcod'), "html");
        echo "'> </input>
                                <input type='hidden' name='infoGeneralcod' id=\"infoGeneralcod\" value='";
        // line 97
        echo twig_escape_filter($this->env, $this->getContext($context, 'infoGeneralcod'), "html");
        echo "'> </input>
                                <button type=\"submmit\" id=\"guardarInfoGen\"  >Guardar</button>
                                <button type=\"submmit\" id=\"form1\"  >Reporte</button> 
                            </td>                            
                        </tr>
                      </table>     


            </form>
               
        
            </div>
        
     <div id=\"tabs-2\" align=\"center\"   >
            <form id=\"formulario\" action=\"";
        // line 111
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("MinSalSidPlaUnidadOrgBundle_guardarCaracteristicas"), "html");
        echo "\" method=\"post\" ";
        echo $this->env->getExtension('form')->renderEnctype($this->getContext($context, 'formOrg'));
        echo ">
                <input type=\"hidden\" id=\"totalFunciones\" name=\"totalFunciones\" value=\"\" />
                <input type=\"hidden\" id=\"totalObjetivos\" name=\"totalObjetivos\" value=\"\" />
                <table size=\"100%\" border=\"0\" >
                    <tr>
                        <td size=\"30%\" >Misión: </td>
                        <td size=\"70%\" >";
        // line 117
        echo $this->env->getExtension('form')->renderWidget($this->getAttribute($this->getContext($context, 'formOrg'), "mision", array(), "any", false), array("attr" => array("class" => "textAreaGrande")));
        echo "        </td>
                    </tr>
                    <tr>
                        <td>Visión: </td>
                        <td style=\"width: 591px; height: 61px;\">";
        // line 121
        echo $this->env->getExtension('form')->renderWidget($this->getAttribute($this->getContext($context, 'formOrg'), "vision", array(), "any", false), array("attr" => array("class" => "textAreaGrande")));
        echo "        </td>
                    </tr>
                    <tr>
                        <td>Objetivo General: </td>
                        <td style=\"width: 591px; height: 61px;\">";
        // line 125
        echo $this->env->getExtension('form')->renderWidget($this->getAttribute($this->getContext($context, 'formOrg'), "objetivoGeneral", array(), "any", false), array("attr" => array("class" => "textAreaGrande")));
        echo "        </td>
                    </tr>
                    
                    <tr>
                        <td  colspan=\"4\">Objetivos Especificos: </td>                    
                    </tr> 
                    <tr>
                         <td colspan=\"4\" >";
        // line 132
        $this->env->loadTemplate("MinSalSidPlaUnidadOrgBundle:InforCaractOrg:showObjetivosEspecificosAll.html.twig")->display(array_merge($context, array("idCaractOrg" => $this->getContext($context, 'idCaractOrg'))));
        echo " </td>                        
                    </tr>                     
                    <tr>
                        <td>Función Principal: </td>
                        <td>";
        // line 136
        echo $this->env->getExtension('form')->renderWidget($this->getAttribute($this->getContext($context, 'formOrg'), "funcionPrincipal", array(), "any", false), array("attr" => array("class" => "textAreaGrande")));
        echo "</td>
                    </tr>
                    
                    <tr>
                        <td colspan=\"4\" >Funciones Especificas:</td>
                    </tr>
                     <tr>
                         <td colspan=\"4\" >";
        // line 143
        $this->env->loadTemplate("MinSalSidPlaUnidadOrgBundle:InforCaractOrg:showFuncionesOrganizativasAll.html.twig")->display(array_merge($context, array("idCaractOrg" => $this->getContext($context, 'idCaractOrg'))));
        echo " </td>                        
                    </tr>                      
                   
                    <tr>
                       <td colspan=\"4\" align=\"center\">
                           <input type='hidden' name='idUnidad' id=\"idUnidad\" value='";
        // line 148
        echo twig_escape_filter($this->env, $this->getContext($context, 'idUnidad'), "html");
        echo "' />
                                <button type=\"submmit\" id=\"guardarCarac\"  >Guardar</button>   
                                 <button type=\"submmit\" id=\"reportCarac\"  >Reporte</button> 
                            </td>                            
                    </tr>
                </table>   
                    
                ";
        // line 155
        echo $this->env->getExtension('form')->renderRest($this->getContext($context, 'formOrg'));
        echo " 
            </form>               
        </div>

";
    }

    public function getTemplateName()
    {
        return "MinSalSidPlaUnidadOrgBundle:InforCaractOrg:ingresoInfoCaractOrg.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }
}
