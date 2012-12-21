<?php

/* MinSalSidPlaAdminBundle:UnidadOrganizativa:showAllUnidadesOrganizativas.html.twig */
class __TwigTemplate_ba9f73745b679b8acf16132cb3e2d7dc extends Twig_Template
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
        echo "
";
        // line 2
        $this->displayBlock('body', $context, $blocks);
    }

    public function block_body($context, array $blocks = array())
    {
        // line 3
        echo "<script type=\"text/javascript\">
      \$(document).ready(function(){
        
        var myGrid = \$('#theGridObj');        
        myGrid.jqGrid({ 
          url: 'consultarUnidadesOrgJSON',
          datatype:'json',
          altRows:true,
          colNames:['Id','Unidad', 'Descripcion', 'Responsable', 'Direccion', 'Telefono','Accion' ],
          colModel:[
            { name:'id', index: 'id', width:20,editable:false,editoptions:{size:15}  },
            { name:'nombre', index: 'nombre', width:150,editable:true,editoptions:{size:25}  },
            { name:'descripcion', index: 'descripcion',width:300,editable:true,editoptions:{size:50}},
            { name:'responable', index: 'responable',width:150,editable:true,editoptions:{size:50}},
            { name:'direccion', index: 'direccion',width:60,editable:true,editoptions:{size:50}},
            { name:'telefono', index: 'telefono',width:60,editable:true,editoptions:{size:50}},
             {name:'act',index:'act', width:120,sortable:false}],            
          rowNum:10,
          rowList:[10,20,30],
          multiselect: false,
          loadonce:true,
          gridComplete: function(){
              var ids = jQuery(\"#theGridObj\").jqGrid('getDataIDs');
              for(var i=0;i < ids.length;i++){ var cl = ids[i];                  
                  ce = \"<input style='height:22px;width:120px;' type='submit' value='Editar' onclick=\\\" \$('#idfila').attr('value', '\"+cl+\"'); this.form.action='";
        // line 27
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("MinSalSidPlaAdminBundle_editarUnidadesOrg"), "html");
        echo "' \\\" />\";
                  jQuery(\"#theGridObj\").jqGrid('setRowData',ids[i],{act:ce}); } 
          },
          pager: jQuery('#pager'),
          viewrecords: true,          
          caption: 'Unidades Organizativas',
          height: \"100%\",
          editurl: 'manttUnidadEdicion'
        });
        
        myGrid.jqGrid('navGrid','#pager',
        {edit:false,add:false,del:false,
            beforeRefresh: function() {myGridDisponibles.jqGrid('setGridParam',{datatype:'json',loadonce:true}).trigger('reloadGrid');}},
        {width:550,height:200},{width:550,height:200},{width:550,height:100},{multipleSearch:true, multipleGroup:true}
        ).hideCol('id');
          
      
      });
</script>
<input type='hidden' name='idfila' id=\"idfila\" value='' /> 
<table id=\"theGridObj\" class=\"scroll\"></table> 
<div id=\"pager\" class=\"scroll\" style=\"text-align:center;\"></div>

";
    }

    public function getTemplateName()
    {
        return "MinSalSidPlaAdminBundle:UnidadOrganizativa:showAllUnidadesOrganizativas.html.twig";
    }

    public function isTraitable()
    {
        return true;
    }
}
