<?php

/* MinSalSidPlaAdminBundle:UnidadOrganizativa:ingresoUnidadOrganizativa.html.twig */
class __TwigTemplate_d50f9ff645b87c99dcfc172b73dc0252 extends Twig_Template
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
          \$(\"#formulario\").validate();
          \$('#limpiar').button();
          \$('#guardar').button();
          \$('#buscar').button();
          \$('#dialog').jqm();
          \$('#tabs').tabs(); 
         \$(\"#telefono\").mask(\"9999-9999\",{placeholder:\" \",completed:function(){alert(\"You typed the following: \"+this.val());}});
         \$(\"#fax\").mask(\"9999-9999\",{placeholder:\" \",completed:function(){alert(\"You typed the following: \"+this.val());}})
          
          \$.getJSON('consultarUnidadesOrgJSON', function(data) {
                  var i=0;
                  \$.each(data, function(key, val) {
                      if(key=='rows'){
                        \$.each(val, function(id, registro){
                            \$('#unidadPadre').append('<option value=\"'+registro['cell'][0]+'\">'+registro['cell'][1]+'</option>');
                        });                    
                      }
                  });
          });
         
          
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
<h2 class=\"demoHeaders\">Ingreso de Unidades Organizativas</h2>
<div id=\"tabs\">
        <ul>
                <li><a href=\"#tabs-1\">General</a></li>
                
        </ul>
        <div id=\"tabs-1\" >
            <form id=\"formulario\" action=\"";
        // line 66
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("MinSalSidPlaAdminBundle_ingresarUnidadOrg"), "html");
        echo "\" method=\"post\" >
                <table align=\"center\" id=\"datosgeneralesTabla\"  >
                    <tr>
                        <td colspan=\"4\" align=\"center\" >Datos Generales Nueva Unidad<br><br></td>
                    </tr>
                    <tr>
                        <td >Nombre unidad:</td>
                        <td colspan=\"3\" ><input size=\"60%\" class=\"required\" name=\"nombreUnidad\" id=\"nombreUnidad\" ></input></td>
                    </tr>
                    <tr>
                        <td >Descripcion:</td>
                        <td colspan=\"3\" ><textarea rows=\"4\" cols=\"58\" name=\"descripcion\" size=\"60%\" id=\"textoMensaje\" ></textarea></td>
                    </tr>
                    <tr>
                        <td >Direcci&oacute;n:</td>
                        <td colspan=\"3\" ><input name=\"direccion\" size=\"60%\" id=\"direccion\" ></input></td>
                    </tr>
                    <tr>
                        <td >Responsable: </td>
                        <td colspan=\"3\" ><input size=\"60%\" name=\"responsable\" id=\"responsable\"></input><input type=\"button\" class=\"jqModal\" value=\"...\" id=\"buscar\"></input></td>
                    </tr>  
                    <tr>
                        <td >Tel&eacute;fono:</td>
                        <td ><input id=\"telefono\" name=\"telefono\" ></input></td>
                        <td>Fax:</td> 
                        <td><input id=\"fax\" name=\"fax\" ></input></td>
                    </tr>
                    <tr>
                        <td  >Tipo Unidad:</td>
                        <td colspan=\"3\">
                            <select id=\"tipoUnidad\" class=\"required\" name=\"tipoUnidad\">
                                 <option value=''>Seleccione el tipo de unidad</option>
                                 <option value=\"1\" >Dependencia</option>    
                                 <option value=\"2\" >Unidad de Salud</option>    
                                 <option value=\"3\" >Entidad de Control</option>    
                                 <option value=\"4\" >Ministerio</option>    
                                 <option value=\"5\" >Departamento</option>    
                            </select>
                        </td>
                    </tr> 
                    <tr>
                        <td  >Unidad Padre:</td>
                        <td colspan=\"3\"  >
                            <select id=\"unidadPadre\" name=\"unidadPadre\">
                                 <option value=\"0\" >--Seleccione Unidad Padre--</option>    
                            </select></td>                            
                    </tr> 
                    <tr>
                        <td>Departamento:</td>
                        <td><select id=\"departamento\" class=\"required\" name=\"departamento\">
                                <option value=''>--Seleccione un Departamento--</option>
                                  
                                ";
        // line 118
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getContext($context, 'deptos'));
        foreach ($context['_seq'] as $context['_key'] => $context['dpto']) {
            echo " 
                                        <option value=\"";
            // line 119
            echo twig_escape_filter($this->env, $this->getAttribute($this->getContext($context, 'dpto'), "idDepto", array(), "any", false), "html");
            echo "\" >";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getContext($context, 'dpto'), "nombreDepto", array(), "any", false), "html");
            echo "</option>                                        
                                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['dpto'], $context['_parent'], $context['loop']);
        $context = array_merge($_parent, array_intersect_key($context, $_parent));
        // line 121
        echo "                            </select></td>
                        <td>Municipio:</td>
                        <td><select id=\"municipio\" class=\"required\" name=\"municipio\">
                                  <option value=''>--Seleccione un Municipio--</option>
                                    
                            </select></td>
                    </tr> 
                    <tr>
                        <td colspan=\"4\" align=\"center\" ><button type=\"submmit\" id=\"guardar\"  >Guardar</button>
                            <button type=\"reset\" id='limpiar'  >Limpiar</button>
                        <input type='hidden' name='idempleado' id=\"idempleado\" value='' />
                        </td>                        
                    </tr>                    
                </table>
            </form>            
        </div>
       
        <div class=\"jqmWindow\" id=\"dialog\">
            <a href=\"#\" class=\"jqmClose\">Cerrar</a>
            <hr>
            ";
        // line 141
        $this->env->loadTemplate("MinSalSidPlaAdminBundle:Empleado:showAllEmpleadosforUnitOrg.html.twig")->display($context);
        // line 142
        echo "        </div>
</div>


";
    }

    public function getTemplateName()
    {
        return "MinSalSidPlaAdminBundle:UnidadOrganizativa:ingresoUnidadOrganizativa.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }
}
