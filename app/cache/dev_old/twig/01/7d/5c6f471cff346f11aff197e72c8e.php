<?php

/* MinSalSidPlaGesObjEspBundle:GestionVincular:gestionVinculacion.html.twig */
class __TwigTemplate_017d5c6f471cff346f11aff197e72c8e extends Twig_Template
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
        echo "
<script type=\"text/javascript\">
     \$(document).ready(function(){
        \$('#agregarVinculacion').click(function() {
        \$('#agregarVincForm').get(0).setAttribute('action', '";
        // line 7
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("MinSalSidPlaGesObjEspBundle_agregarVinculacion"), "html");
        echo "');            
        
        });   
        
        \$('#agregarVinculacionDep').click(function() {
        \$('#agregarVincForm').get(0).setAttribute('action', '";
        // line 12
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("MinSalSidPlaGesObjEspBundle_agregarVinculacionDependencias"), "html");
        echo "');            
        
        });
        
        
     });
    
</script>

<form id=\"agregarVincForm\" action=\"";
        // line 21
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("MinSalSidPlaGesObjEspBundle_gestionVinculacion"), "html");
        echo "\" method=\"post\" >
    <button type=\"submmit\"  id=\"agregarVinculacion\" >Agregar Vinculaci&oacute;n</button>
    <button type=\"submmit\"  id=\"agregarVinculacionDep\" >Agregar Vinculaci&oacute;n con Dependencias</button>
    
    
    
</form>        
";
    }

    public function getTemplateName()
    {
        return "MinSalSidPlaGesObjEspBundle:GestionVincular:gestionVinculacion.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }
}
