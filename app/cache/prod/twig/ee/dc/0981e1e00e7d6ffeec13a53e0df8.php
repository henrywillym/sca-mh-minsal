<?php

/* MinSalSidPlaAdminBundle:UnidadOrganizativa:EditarUnidadOrganizativa.html.twig */
class __TwigTemplate_eedc0981e1e00e7d6ffeec13a53e0df8 extends Twig_Template
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
          
          \$('#limpiar').button();
          \$('#guardar').button();
          \$('#buscar').button();
          \$('#dialog').jqm();
          \$('#tabs').tabs(); 
         
          \$(\"#formulario\").validate();
         \$(\"#telefono\").mask(\"9999-9999\",{placeholder:\" \"});
         \$(\"#fax\").mask(\"9999-9999\",{placeholder:\" \"});
         
          
          \$('#departamento').change(function(){   
              \$('#municipio').children().remove();
             
            
              \$.getJSON('consultarMunicipiosJSON?departamento='+\$('#departamento').val(), function(data) {
                  var i=0;
                  \$.each(data, function(key, val) {
                      if(key=='rows'){
                        \$.each(val, function(id, registro){
                          
                           \$('#municipio').append('<option value=\"'+registro['cell'][0]+'\">'+registro['cell'][1]+'</option>');
                        });                    
                      }
                  });
              });              
          });
      });
      
      
                     
            
     
      
      
    
</script>

<style type=\"text/css\">



form.cmxform label.error, label.error {
\t/* remove the next line when you have trouble in IE6 with labels in list */
\tcolor: red;
\tfont-style: italic
            
}
input.error { border: 1px dotted red; }
textarea.error { border: 1px dotted red; }
      </style>
      
<h2 class=\"demoHeaders\">Edici&oacute;n  de Unidad Organizativa</h2>
<div id=\"tabs\">
        <ul>
                <li><a href=\"#tabs-1\">Edici&oacute;n</a></li>
                
        </ul>
        <div id=\"tabs-1\" >
            <form id=\"formulario\" action=\"";
        // line 66
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("MinSalSidPlaAdminBundle_editandoUnidadesOrg"), "html");
        echo "\" method=\"post\" >
                <table align=\"center\" id=\"datosgeneralesTabla\"  >
                    <tr>
                        <td colspan=\"4\" align=\"center\" >Datos Generales de la Unidad<br><br></td>
                    </tr>
                    <tr>
                        <td >Nombre unidad:</td>
                        <td colspan=\"3\" ><input size=\"60%\" class=\"required\" name=\"nombreUnidad\" id=\"nombreUnidad\" value=\"";
        // line 73
        echo twig_escape_filter($this->env, $this->getContext($context, 'nombreUnidad'), "html");
        echo "\" ></input></td>
                    </tr>
                    <tr>
                        <td >Descripcion:</td>
                        <td colspan=\"3\" ><textarea rows=\"4\" cols=\"58\" name=\"descripcion\" size=\"60%\" id=\"textoMensaje\" >";
        // line 77
        echo twig_escape_filter($this->env, $this->getContext($context, 'descripcion'), "html");
        echo "</textarea></td>
                    </tr>
                    <tr>
                        <td >Direcci&oacute;n:</td>
                        <td colspan=\"3\" ><input name=\"direccion\" size=\"60%\" id=\"direccion\" value=\"";
        // line 81
        echo twig_escape_filter($this->env, $this->getContext($context, 'direccion'), "html");
        echo "\" ></input></td>
                    </tr>
                    <tr>
                        <td >Responsable: </td>
                        <td colspan=\"3\" ><input size=\"60%\" name=\"responsable\" id=\"responsable\" value=\"";
        // line 85
        echo twig_escape_filter($this->env, $this->getContext($context, 'nombreempleado'), "html");
        echo " ";
        echo twig_escape_filter($this->env, $this->getContext($context, 'segundonombre'), "html");
        echo " ";
        echo twig_escape_filter($this->env, $this->getContext($context, 'apellidoempleado'), "html");
        echo " ";
        echo twig_escape_filter($this->env, $this->getContext($context, 'segundoapellido'), "html");
        echo "\"></input><input type=\"button\" class=\"jqModal\" value=\"...\" id=\"buscar\"></input></td>
                    </tr>  
                    <tr>
                        <td >Tel&eacute;fono:</td>
                        <td ><input id=\"telefono\" name=\"telefono\"value=\"";
        // line 89
        echo twig_escape_filter($this->env, $this->getContext($context, 'telefono'), "html");
        echo "\" ></input></td>
                        <td>Fax:</td> 
                        <td><input id=\"fax\" name=\"fax\"value=\"";
        // line 91
        echo twig_escape_filter($this->env, $this->getContext($context, 'fax'), "html");
        echo "\" ></input></td>
                    </tr>
                    <tr>
                        <td  >Tipo Unidad:</td>
                        <td colspan=\"3\">
                            <select id=\"tipoUnidad\" class=\"required\" name=\"tipoUnidad\">
                                 <option value=\"1\" ";
        // line 97
        if (("1" == $this->getContext($context, 'tipounidad'))) {
            echo " selected=\"selected\" ";
        }
        echo ">Dependencia</option>    
                                 <option value=\"2\"";
        // line 98
        if (("2" == $this->getContext($context, 'tipounidad'))) {
            echo " selected=\"selected\" ";
        }
        echo " >Unidad de Salud</option>    
                                 <option value=\"3\" ";
        // line 99
        if (("3" == $this->getContext($context, 'tipounidad'))) {
            echo " selected=\"selected\" ";
        }
        echo ">Entidad de Control</option>    
                                 <option value=\"4\"";
        // line 100
        if (("4" == $this->getContext($context, 'tipounidad'))) {
            echo " selected=\"selected\" ";
        }
        echo " >Ministerio</option>    
                                 <option value=\"5\"";
        // line 101
        if (("5" == $this->getContext($context, 'tipounidad'))) {
            echo " selected=\"selected\" ";
        }
        echo " >Departamento</option>    
                            </select>
                        </td>
                    </tr> 
                    <tr>
                        <td  >Unidad Padre:</td>
                        <td colspan=\"3\"  >
                            <select id=\"unidadPadre\" name=\"unidadPadre\">
                                 <option value=\"0\" >--Seleccione Unidad Padre--</option>    
                          
                                        ";
        // line 111
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getContext($context, 'unidadPadre'));
        foreach ($context['_seq'] as $context['_key'] => $context['uniorg']) {
            echo " 
                                        
                                           <option value=\"";
            // line 113
            echo twig_escape_filter($this->env, $this->getAttribute($this->getContext($context, 'uniorg'), "idUnidadOrg", array(), "any", false), "html");
            echo "\" ";
            if (($this->getAttribute($this->getContext($context, 'uniorg'), "idUnidadOrg", array(), "any", false) == $this->getAttribute($this->getContext($context, 'unidadpadre'), "getIdUnidadOrg", array(), "any", false))) {
                echo " selected=\"selected\" ";
            }
            echo " >";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getContext($context, 'uniorg'), "descripcionUnidad", array(), "any", false), "html");
            echo "</option>                                        
                                
                                   ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['uniorg'], $context['_parent'], $context['loop']);
        $context = array_merge($_parent, array_intersect_key($context, $_parent));
        // line 116
        echo "                                        
                           
                            </select></td>                            
                    </tr> 
                    <tr>
                        <td>Departamento:</td>
                        <td><select id=\"departamento\"class=\"required\" name=\"departamento\">
                                <option value=\"0\" >--Seleccione un Departamento--</option>    
                                ";
        // line 124
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getContext($context, 'deptos'));
        foreach ($context['_seq'] as $context['_key'] => $context['dpto']) {
            echo " 
                                        <option value=\"";
            // line 125
            echo twig_escape_filter($this->env, $this->getAttribute($this->getContext($context, 'dpto'), "idDepto", array(), "any", false), "html");
            echo "\" ";
            if (($this->getAttribute($this->getContext($context, 'dpto'), "idDepto", array(), "any", false) == $this->getAttribute($this->getContext($context, 'iddepartamento'), "getIdDepto", array(), "any", false))) {
                echo " selected=\"selected\" ";
            }
            echo " >";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getContext($context, 'dpto'), "nombreDepto", array(), "any", false), "html");
            echo "</option>                                        
                                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['dpto'], $context['_parent'], $context['loop']);
        $context = array_merge($_parent, array_intersect_key($context, $_parent));
        // line 127
        echo "                            </select></td>
                        <td>Municipio:</td>
                        <td><select id=\"municipio\"class=\"required\" name=\"municipio\">
                                 <option value=\"0\" >--Seleccione un Municipio--</option>    
                            </select></td>
                    </tr> 
                    
            <script type=\"text/javascript\">   
                var idmun=";
        // line 135
        echo twig_escape_filter($this->env, $this->getContext($context, 'idmunicipio'), "html");
        echo ";
      \$.getJSON('consultarMunicipiosJSON?departamento=";
        // line 136
        echo twig_escape_filter($this->env, $this->getAttribute($this->getContext($context, 'iddepartamento'), "getIdDepto", array(), "any", false), "html");
        echo "',function(data) {
                  var i=0;
                  \$.each(data, function(key, val) {
                      if(key=='rows'){
                        \$.each(val, function(id, registro){
                          
                          \$('#municipio').append('<option value=\"'+registro['cell'][0]+'\" >'+registro['cell'][1]+'</option>');
                          
                     });                    
                      }
                  });
                  
              });   
           // \$('#municipio').append('<option value=\"";
        // line 149
        echo twig_escape_filter($this->env, $this->getContext($context, 'idmunicipio'), "html");
        echo "\"Selected ></option>'); 
            
           \$(\"#municipio\").find(\"option[value='";
        // line 151
        echo twig_escape_filter($this->env, $this->getContext($context, 'idmunicipio'), "html");
        echo "']\").remove();
            \$('#municipio').append('<option value=\"";
        // line 152
        echo twig_escape_filter($this->env, $this->getContext($context, 'idmunicipio'), "html");
        echo "\"Selected >'+\"";
        echo twig_escape_filter($this->env, $this->getContext($context, 'nombremunicipio'), "html");
        echo "\"+'</option>');                   
           
              </script>      
                    
                    
                    
                    
                    <tr>
                        <td colspan=\"4\" align=\"center\" ><button type=\"submmit\" id=\"guardar\"  >Guardar</button>
                            <button type=\"reset\" id='limpiar'  >Limpiar</button>
                            <input type='hidden' name='idfila' id=\"idfila\" value='";
        // line 162
        echo twig_escape_filter($this->env, $this->getContext($context, 'idfila'), "html");
        echo "' />
                            <input type='hidden' name='idinfogeneral' id=\"idfila\" value='";
        // line 163
        echo twig_escape_filter($this->env, $this->getContext($context, 'idinfogeneral'), "html");
        echo "' />
                            <input type='hidden' name='idempleado' id=\"idempleado\" value='";
        // line 164
        echo twig_escape_filter($this->env, $this->getContext($context, 'responsable'), "html");
        echo "' />
                        </td>                        
                    </tr>                    
                </table>
            </form>            
        </div>
       
        <div class=\"jqmWindow\" id=\"dialog\">
            <a href=\"#\" class=\"jqmClose\">Cerrar</a>
            <hr>
            ";
        // line 174
        $this->env->loadTemplate("MinSalSidPlaAdminBundle:Empleado:showAllEmpleadosforUnitOrg.html.twig")->display($context);
        // line 175
        echo "        </div>
</div>
<script type=\"text/javascript\">

</script>
";
    }

    public function getTemplateName()
    {
        return "MinSalSidPlaAdminBundle:UnidadOrganizativa:EditarUnidadOrganizativa.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }
}
