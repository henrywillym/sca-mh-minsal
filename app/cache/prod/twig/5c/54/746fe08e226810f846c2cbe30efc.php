<?php

/* MinSalSidPlaAdminBundle:Roles:asignarOpcionesARoles.html.twig */
class __TwigTemplate_5c54746fe08e226810f846c2cbe30efc extends Twig_Template
{
    protected $parent;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->blocks = array(
            'titulo' => array($this, 'block_titulo'),
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
    public function block_titulo($context, array $blocks = array())
    {
        echo "Asignaci&oacute;n de Opciones a Roles del Sistema";
    }

    // line 4
    public function block_body($context, array $blocks = array())
    {
        // line 5
        echo "<script type=\"text/javascript\">
        
  \$(document).ready(function(){
      \$('#agregar').click(pasar);
      \$('#quitar').click(eliminar); 
      \$('#selecrol').change(cargarSeleccionado);
      \$('#agregar').button();
      \$('#quitar').button(); 
      \$('#regresar').button();
      \$('#regresar').click(function() {
              document.location.href='";
        // line 15
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("MinSalSidPlaAdminBundle_manttRoles"), "html");
        echo "'
          });    
          
       var myGridDisponibles = \$('#gridDisponibles');        
        myGridDisponibles.jqGrid({    
          url: 'consultarOpc',
          datatype:'json',
          altRows:true,          
          colNames:['Id','Nombre'],
          colModel:[            
            { name:'id', index: 'id', width:15,editable:false,editoptions:{size:10}  },
            { name:'nombre', index: 'nombre', width:200,editable:true,editoptions:{size:40}  }
            ],          
          multiselect: false,
          rowNum:25,
          loadonce:true,
          pager:jQuery('#pagerDis'),
          viewrecords: true,          
          caption: 'Opciones del sistema disponible',
          height: \"100%\"
        });
           
       myGridDisponibles.jqGrid('navGrid','#pagerDis',{edit:false,add:false,del:false,refresh:false,search:false,
          beforeRefresh: function() {myGridDisponibles.jqGrid('setGridParam',{datatype:'json',loadonce:true}).trigger('reloadGrid');}}).hideCol('id');     
            
        var myGridSeleccionadas = \$('#gridSelecc');        
        myGridSeleccionadas.jqGrid({    
          url: 'opcionesAsignadas',
          datatype:'json',
          altRows:true,          
          colNames:['Id','Nombre'],
          colModel:[            
            { name:'id', index: 'id', width:15,editable:false,editoptions:{size:10}  },
            { name:'nombre', index: 'nombre', width:200,editable:true,editoptions:{size:40}  }
            ],          
          multiselect: false,              
          viewrecords: true,
          rowNum:25,
          loadonce:true,
          pager:jQuery('#pagerAsig'),
          caption: 'Opciones seleccionadas',
          height: \"100%\"
        });            
        myGridSeleccionadas.jqGrid('navGrid','#pagerAsig',{edit:false,add:false,del:false,refresh:false,search:false,
         beforeRefresh: function() {myGridSeleccionadas.jqGrid('setGridParam',{datatype:'json',loadonce:true}).trigger('reloadGrid');}}).hideCol('id');         
            
            
      \$.getJSON('consultarRoles', function(data) {
              var i=0;
              \$.each(data, function(key, val) {
                  if(key=='rows'){
                    \$.each(val, function(id, registro){
                        \$('#selecrol').append('<option value=\"'+registro['cell'][0]+'\">'+registro['cell'][1]+'</option>');
                    });                    
                  }
              });
      });
  
  function cargarSeleccionado(){
        \$('#gridSelecc').setGridParam({url:'opcionesAsignadas?reg='+\$('#selecrol').val()}); 
        \$('#gridSelecc').jqGrid('setGridParam',{datatype:'json',loadonce:true}).trigger('reloadGrid');
                    
        \$('#gridDisponibles').setGridParam({url:'opcionesSinAsignar?reg='+\$('#selecrol').val()}); 
        //\$('#gridDisponibles').trigger(\"reloadGrid\");
        \$('#gridDisponibles').jqGrid('setGridParam',{datatype:'json',loadonce:true}).trigger('reloadGrid');
  }
      
  function pasar(){ 
          
        var id = jQuery(\"#gridDisponibles\").jqGrid('getGridParam','selrow'); 
        if (id) { 
            var ret = jQuery(\"#gridDisponibles\").jqGrid('getRowData',id);                     

            \$('#gridSelecc').setGridParam({url:'insertOpcSeleccRol?opc='+ret.id+'&reg='+\$('#selecrol').val()}); 
            \$('#gridSelecc').jqGrid('setGridParam',{datatype:'json',loadonce:true}).trigger('reloadGrid');

            \$('#gridDisponibles').setGridParam({url:'opcionesSinAsignar?reg='+\$('#selecrol').val()}); 
            \$('#gridDisponibles').jqGrid('setGridParam',{datatype:'json',loadonce:true}).trigger('reloadGrid');
        } 
        else {
            alert(\"Por favor seleccione una opcion\");
        } 
           
   }
       
   function eliminar(){    
       var id = jQuery(\"#gridSelecc\").jqGrid('getGridParam','selrow'); 
        if (id) { 
            var ret = jQuery(\"#gridSelecc\").jqGrid('getRowData',id);                     

            \$('#gridSelecc').setGridParam({url:'deleteOpcSeleccRol?opc='+ret.id+'&reg='+\$('#selecrol').val()}); 
            \$('#gridSelecc').jqGrid('setGridParam',{datatype:'json',loadonce:true}).trigger('reloadGrid');
            \$('#gridDisponibles').jqGrid('setGridParam',{datatype:'json',loadonce:true}).trigger('reloadGrid');
        } 
        else {
            alert(\"Por favor seleccione una opcion\");
        }            
   }
   
   });
    </script>
       
    <table align=\"center\" >
        <tr>
            <td align=\"center\" colspan=\"3\" ><h1>Asignaci&oacute;n de Opciones a Roles del Sistema</h1></td>        
        </tr>
        <tr>
            <td colspan=\"3\" align='right'><input type=\"button\" value=\"Regresar\" id=\"regresar\"/></td>
        </tr>
        <tr>
            <td align='right'>Seleccione un rol: </td>
            <td colspan=2 ><select id='selecrol'><option value='0'>Seleccione un rol</option></select></td>        
        </tr>
        <tr>
            <td align=\"center\">Disponibles</td>
            <td align=\"center\"></td>
            <td align=\"center\">Asignadas</td>
        </tr>
        <tr>
            <td align=\"center\" valign=\"top\">
                <div id=\"grid_disponibles\" >
                    <table id=\"gridDisponibles\" class=\"scroll\" ></table> 
                    <div id=\"pagerDis\" class=\"scroll\"></div> 
                </div>            
            </td>

            <td align=\"center\">
                <p><input  id='agregar' type=\"button\" class=\"ui-button-text\"  value=\">>\"/></p>
                <p><input id='quitar' type=\"button\"  class=\"ui-button-text\"  value=\"<<\"/></p>
            </td>
            <td align=\"center\" valign=\"top\">
                <div id=\"grid_selecc\" >
                    <table id=\"gridSelecc\" class=\"scroll\" ></table> 
                    <div id=\"pagerAsig\" class=\"scroll\"></div> 
                </div> 

            </td>
        </tr>
    </table>

";
    }

    public function getTemplateName()
    {
        return "MinSalSidPlaAdminBundle:Roles:asignarOpcionesARoles.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }
}
