<?php

/* MinSalSidPlaAdminBundle:MensajeCorreoTemplate:manttMensajesCorreoTemForm.html.twig */
class __TwigTemplate_3f00f79cb2d50598698b2172e20175b4 extends Twig_Template
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
        echo " <script type=\"text/javascript\">
      \$(document).ready(function(){
     \$('#nuevoMensajeButton').button();
     \$('#editarMensajeButton').button();
     \$('#eliminarMensajeButton').button();
     
     function despuesAgregarEditar() {
        \$(\"#theGrid\").jqGrid('setGridParam',{datatype:'json',loadonce:true}).trigger('reloadGrid');
        return[true,'']; //no error
     }
     
     
          //cuando le da click en el boton Nuevo
     \$(\"#nuevoMensajeButton\").click(function(){
        jQuery(\"#theGrid\").jqGrid('editGridRow',\"new\",{closeAfterAdd:true,addCaption: \"Nuevo Mensaje Correo\",height:325,reloadAfterSubmit:true,
        top : 250 ,left: 250,width: 800,processData: \"Cargando...\",afterSubmit:despuesAgregarEditar,
        bottominfo:\"Campos marcados con (*) son obligatorios\", onclickSubmit: function(rp_ge, postdata) {
        alert(\"datos guardados con exito!\");
          }});
     });
    
         //cuando le da click en el boton editar
    \$(\"#editarMensajeButton\").click(function(){
          var gr = jQuery(\"#theGrid\").jqGrid('getGridParam','selrow');
          if( gr != null )
             jQuery(\"#theGrid\").jqGrid('editGridRow',gr,{closeAfterEdit:true,editCaption: \"Editando Mensaje Corrreo\",height:325,reloadAfterSubmit:true,
                 top : 250 ,left: 250,width: 800,processData: \"Cargando...\",afterSubmit:despuesAgregarEditar, onclickSubmit: function(rp_ge, postdata) {
        alert(\"Mensaje editado con exito!\");
          }, bottominfo:\"Campos marcados con (*) son obligatorios\"});
             else alert(\"Por favor seleccione una fila para editar!\"); 
          });
    
        //cuando le da click en el boton borrar
    \$(\"#eliminarMensajeButton\").click(function(){
         var grs = jQuery(\"#theGrid\").jqGrid('getGridParam','selrow');
         if( grs != null ) jQuery(\"#theGrid\").jqGrid('delGridRow',grs,{msg: \"Desea eliminar este mensaje correo?\",caption:\"Eliminando mensaje correo\",height:100,reloadAfterSubmit:true,
             top : 300 ,left: 600,width: 300,processData: \"Cargando...\",onclickSubmit: function(rp_ge, postdata) {
        alert(\"Mensaje eliminado con exito!\");
          }}); 
         else alert(\"Por favor seleccione una fila para borrar!\"); }); 
     
     });
    </script>
    <form >
        <table align=\"center\">
            <tr><td align=\"center\">
                    <h1>Mantenimiento de Mensaje Correo</h1>
                </td>
            </tr>
            <tr>
                <td align=\"center\">
                                       
                </td>
            </tr>
            <tr>
                <td align=\"center\">
                  ";
        // line 60
        $this->env->loadTemplate("MinSalSidPlaAdminBundle:MensajeCorreoTemplate:showAllMensajesCorreoTem.html.twig")->display($context);
        // line 61
        echo "                <br></br>
                <input type=\"BUTTON\" id=\"nuevoMensajeButton\" value=\"Agregar Mensaje\" />
                <input type=\"BUTTON\" id=\"editarMensajeButton\" value=\"Editar Mensaje\" />
                <input type=\"BUTTON\" id=\"eliminarMensajeButton\" value=\"Eliminar Mensaje\" />
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
        return "MinSalSidPlaAdminBundle:MensajeCorreoTemplate:manttMensajesCorreoTemForm.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }
}
