<?php

/* MinSalSidPlaUnidadOrgBundle:InforCaractOrg:showObjetivosEspecificosAll.html.twig */
class __TwigTemplate_084c176a74c86a984f696d965daf0968 extends Twig_Template
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
        $this->displayBlock('body', $context, $blocks);
    }

    public function block_body($context, array $blocks = array())
    {
        // line 3
        echo "    <script type=\"text/javascript\">
      \$(document).ready(function(){

        var myGrid = \$('#theGridObj');        
        myGrid.jqGrid({    
          url: 'consultarObjetivosOrgEspec?idCaractOrg=";
        // line 8
        echo twig_escape_filter($this->env, $this->getContext($context, 'idCaractOrg'), "html");
        echo "',
          datatype:'json',
          altRows:true,          
          colNames:['Id','Objetivo'],
          colModel:[            
            { name:'id', index: 'id', width:15,editable:false,editoptions:{size:10},sorttype:'int',searchtype:\"integer\", searchrules:{\"required\":true, \"number\":true, \"maxValue\":2000000}   },
            { name:'objetivo', index: 'objetivo', edittype:\"textarea\",width:700,editable:true,editoptions:{rows:\"8\",cols:\"40\",maxlength: 300},formoptions:{ rowpos:1, label: \"Objetivos Especificos\", elmprefix:\"(*)\"},editrules:{required:true}  }
            ],
          rowNum:10,
          rowList:[10,20,30],
          multiselect: false,
          sortname: 'id',
          sortorder: \"asc\",
          loadonce:true,
          pager: jQuery('#pagerObj'),
          viewrecords: true,          
          caption: 'Objetivos Especificos',
          height: \"100%\",
          editCaption: \"Editar Registro\",
          addCaption: \"Nuevo Registro\",
          editurl:'manttObjEspec?idCaractOrg=";
        // line 28
        echo twig_escape_filter($this->env, $this->getContext($context, 'idCaractOrg'), "html");
        echo "'         
            
        });
        myGrid.jqGrid('navGrid','#pagerObj',
        {edit:true,add:true,del:false,beforeRefresh: function() {myGrid.jqGrid('setGridParam',{datatype:'json',loadonce:true}).trigger('reloadGrid');}},
        {width:450,height:250, afterSubmit: fn_editSubmit, closeOnEscape: true,bottominfo:\"Campos marcados con (*) son obligatorios\", onclickSubmit: function(rp_ge, postdata) {
        alert(\"datos editados con exito!\");},closeAfterEdit:true,afterSubmit:despuesAgregarEditar },//edit
        {width:450,height:250,bottominfo:\"Campos marcados con (*) son obligatorios\", onclickSubmit: function(rp_ge, postdata) {
        alert(\"datos guardados con exito!\");},closeAfterAdd:true,afterSubmit:despuesAgregarEditar },//add
        {},//del
        {},//search
        {} //view
       ).hideCol('id');
           
           function despuesAgregarEditar() {
        myGrid.jqGrid('setGridParam',{datatype:'json',loadonce:true}).trigger('reloadGrid');
        return[true,'']; //no error
      }    
       
      });
      
       //define handler for 'editSubmit' event
    var fn_editSubmit=function(response,postdata){
     var json=response.responseText; //in my case response text form server is \"{sc:true,msg:''}\"
     var result=eval(\"(\"+json+\")\"); //create js object from server reponse
     return [result.sc,result.msg,null]; 
    }  

    
   
    
    </script>
      <div id=\"grid_wrapper\" class=\"ui-corner-all floatLeft\">
        <table id=\"theGridObj\" class=\"scroll\" ></table> 
        <div id=\"pagerObj\"  class=\"scroll\" style=\"text-align:center;\"></div> 
      </div>
       
    
";
    }

    public function getTemplateName()
    {
        return "MinSalSidPlaUnidadOrgBundle:InforCaractOrg:showObjetivosEspecificosAll.html.twig";
    }

    public function isTraitable()
    {
        return true;
    }
}
