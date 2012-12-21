<?php

/* MinSalSidPlaAdminBundle:MensajeCorreoTemplate:showAllMensajesCorreoTem.html.twig */
class __TwigTemplate_3cea74376f17799a6d51486e79ba7a0a extends Twig_Template
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

        // line 2
        echo "
";
        // line 3
        $this->displayBlock('body', $context, $blocks);
    }

    public function block_body($context, array $blocks = array())
    {
        // line 4
        echo "<script type=\"text/javascript\">
      \$(document).ready(function(){
        
        var myGrid = \$('#theGrid');        
        myGrid.jqGrid({ 
          url: 'consultarMenCorrtempJSON',
     scrolling: true,
          datatype:'json',
          altRows:true,
          colNames:['Id','Nombre', 'Texto'],
          colModel:[
            { name:'id', index: 'id',sorttype:'int', width:20,editable:false,editoptions:{size:15}, searchtype:\"integer\", searchrules:{\"required\":true, \"number\":true, \"maxValue\":2000000}  },
            { name:'Nombre', index: 'Nombre', width:300,editable:true,editoptions:{size:100,maxlength:100},formoptions:{ rowpos:1, label: \"Nombre\", elmprefix:\"(*)\"},editrules:{required:true}  },
            { name:'texto', index: 'texto',width:500, sortable:false,editable:true,edittype:\"textarea\", editoptions:{rows:\"15\",cols:\"100\",maxlength:2000},formoptions:{ rowpos:2, label: \"texto\", elmprefix:\"(*)\"},editrules:{required:true} } ],            
          rowNum:4,
          rowList:[4,8,12],
          multiselect: false,
          pager: jQuery('#pager'),
          viewrecords: true,          
          loadonce:true, 
          sortname: 'id',
          sortorder: \"asc\",
          caption: 'Mensaje Correo templates',
          height: \"100%\",
          editCaption: \"Editar Mensaje Correo\",
          addCaption: \"Nuevo Mensaje Correo\",
          editurl: 'manttMenCorrtempEdicion'
        });
         myGrid.jqGrid('navGrid','#pager',{edit:false,add:false,del:false,view:true,       
           beforeRefresh: function() {\$(\"#theGrid\").jqGrid('setGridParam',{datatype:'json',loadonce:true}).trigger('reloadGrid');}},
        {},//edit
        {},//add
        {},//del
        {multipleSearch:false, multipleGroup:false}, //search
        {width:550,height:100}//view
        ).hideCol('id');
        
 
          
      }
 
);
</script>


<table id=\"theGrid\" class=\"scroll\"></table> 
<div id=\"pager\" class=\"scroll\" style=\"text-align:center;\"></div>

";
    }

    public function getTemplateName()
    {
        return "MinSalSidPlaAdminBundle:MensajeCorreoTemplate:showAllMensajesCorreoTem.html.twig";
    }

    public function isTraitable()
    {
        return true;
    }
}
