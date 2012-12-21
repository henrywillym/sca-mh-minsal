<?php

/* MinSalSidPlaIndicadoresTemplateBundle:TipoIndicador:showTipoIndicador.html.twig */
class __TwigTemplate_1e9e878de554a94548b253df8590c6eb extends Twig_Template
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

        // line 1
        $this->displayBlock('body', $context, $blocks);
    }

    public function block_body($context, array $blocks = array())
    {
        // line 2
        echo "<script type=\"text/javascript\">
      \$(document).ready(function(){
        
        \$('#agregarIndSalButton').button();
        \$('#editarIndSalButton').button();
        \$('#regresar').button();
       
       \$(\"#regresar\").click(function(){
          ";
        // line 10
        if (array_key_exists("idIndSal", $context)) {
            // line 11
            echo "               window.location='editarIndicadorSalud?idObj=";
            echo twig_escape_filter($this->env, $this->getContext($context, 'idObj'), "html");
            echo "&idIndSal=";
            echo twig_escape_filter($this->env, $this->getContext($context, 'idIndSal'), "html");
            echo "';  
           ";
        } else {
            // line 13
            echo "               window.location='ingresarIndicadorSalud?idObj=";
            echo twig_escape_filter($this->env, $this->getContext($context, 'idObj'), "html");
            echo "';     
           ";
        }
        // line 15
        echo "        });

        var myGrid = \$('#tabIndSal');        
        myGrid.jqGrid({ 
          url: 'consultarTipoIndicadorJSON',
          datatype:'json',
          altRows:true,
          colNames:['Codigo','Nombre'],
          colModel:[
            { name:'codigo', index: 'codigo', width:40,editable:false,editoptions:{size:15}  },
            { name:'nombre', index: 'nombre',width:250,editable:true,editoptions:{size:25,maxlength:25}, formoptions:{ rowpos:1, label: \"Nombre\",elmprefix:\"(*)\"},editrules:{required:true} }
           ],            
          rowNum:10,
          rowList:[10,20,30],
          multiselect: false,
          loadonce:true,
          pager: jQuery('#pager'),
          viewrecords: true,          
          caption: 'Tipos de Indicadores de Salud',
          height: \"100%\",
          editurl:'manttTipoIndicadorEdicion'
           
        });
        
         myGrid.jqGrid('navGrid','#pager',{edit:false,add:false,del:false,search:false,refresh:false,
             beforeRefresh: function() {myGrid.jqGrid('setGridParam',{datatype:'json',loadonce:true}).trigger('reloadGrid');}}).hideCol('codigo');
         
      /* Funcion para regargar los JQGRID luego de agregar y editar*/
      function despuesAgregarEditar() {
        myGrid.jqGrid('setGridParam',{datatype:'json',loadonce:true}).trigger('reloadGrid');
        return[true,'']; //no error
      }         
  //agregar
  \$(\"#agregarIndSalButton\").click(function(){
        jQuery('#tabIndSal').jqGrid('editGridRow',\"new\",
        {closeAfterAdd:true,addCaption: \"Agregar Tipo de Indicador de Salud\",
         height:200,align:'center',reloadAfterSubmit:true,width:550,
         processData: \"Cargando...\",afterSubmit:despuesAgregarEditar,
         bottominfo:\"Campos marcados con (*) son obligatorios\", onclickSubmit: function(rp_ge, postdata) {
                alert(\"datos guardados con exito!\");}
        });
        });

   //editar
    \$(\"#editarIndSalButton\").click(function(){
          var gr = jQuery('#tabIndSal').jqGrid('getGridParam','selrow');
          if( gr != null )
             jQuery(\"#tabIndSal\").jqGrid('editGridRow',gr,
            {closeAfterEdit:true,editCaption: \"Editando Tipo de Indicador de Salud\",
             height:200,align:'center',reloadAfterSubmit:true,width:550,
             processData: \"Cargando...\",afterSubmit:despuesAgregarEditar,
             bottominfo:\"Campos marcados con (*) son obligatorios\", onclickSubmit: function(rp_ge, postdata) {
                    alert(\"Tipo de Indicador de Salud editado con exito!\");
                ;}
        });
          else alert(\"Por favor seleccione una fila para editar!\"); 
          });
 
  //fin          
          
      });
    </script>
                <table id=\"tabIndSal\" class=\"scroll\" align=\"center\"></table>
                <div id=\"pager\" class=\"scroll\"></div>
  
";
    }

    public function getTemplateName()
    {
        return "MinSalSidPlaIndicadoresTemplateBundle:TipoIndicador:showTipoIndicador.html.twig";
    }

    public function isTraitable()
    {
        return true;
    }
}
