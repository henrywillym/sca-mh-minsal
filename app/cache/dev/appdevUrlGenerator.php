<?php

use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Exception\RouteNotFoundException;


/**
 * appdevUrlGenerator
 *
 * This class has been auto-generated
 * by the Symfony Routing Component.
 */
class appdevUrlGenerator extends Symfony\Component\Routing\Generator\UrlGenerator
{
    static private $declaredRouteNames = array(
       '_wdt' => true,
       '_profiler_search' => true,
       '_profiler_purge' => true,
       '_profiler_import' => true,
       '_profiler_export' => true,
       '_profiler_search_results' => true,
       '_profiler' => true,
       '_configurator_home' => true,
       '_configurator_step' => true,
       '_configurator_final' => true,
       'MinSalSidPlaDependenciaBundle_homepage' => true,
       'MinSalSidPlaBundle_homepage' => true,
       'MinSalSidPlaAdminBundle_homepage' => true,
       'MinSalSidPlaAdminBundle_crearOpc' => true,
       'MinSalSidPlaAdminBundle_nuevaOpc' => true,
       'MinSalSidPlaAdminBundle_nuevoRol' => true,
       'MinSalSidPlaAdminBundle_crearRol' => true,
       'MinSalSidPlaAdminBundle_consultarRoles' => true,
       'MinSalSidPlaAdminBundle_consultarOpciones' => true,
       'MinSalSidPlaAdminBundle_manttRoles' => true,
       'MinSalSidPlaAdminBundle_mattOpciones' => true,
       'MinSalSidPlaAdminBundle_manttOpcEdicion' => true,
       'MinSalSidPlaAdminBundle_manttRolEdicion' => true,
       'MinSalSidPlaAdminBundle_asignarOpcRoles' => true,
       'MinSalSidPlaAdminBundle_opcionesAsignadas' => true,
       'MinSalSidPlaAdminBundle_insertOpcSeleccRol' => true,
       'MinSalSidPlaAdminBundle_deleteOpcSeleccRol' => true,
       'MinSalSidPlaAdminBundle_opcionesSinAsignar' => true,
       'MinSalSidPlaAdminBundle_consultarUnidadesOrg' => true,
       'MinSalSidPlaAdminBundle_ingresoNuevaUnidadesOrg' => true,
       'MinSalSidPlaAdminBundle_ingresarUnidadOrg' => true,
       'MinSalSidPlaAdminBundle_consultarMunicipiosJSON' => true,
       'MinSalSidPlaAdminBundle_consultarUnidadesOrgJSON' => true,
       'MinSalSidPlaAdminBundle_consultarMenCorrtemp' => true,
       'MinSalSidPlaAdminBundle_consultarMenCorrtempJSON' => true,
       'MinSalSidPlaAdminBundle_manttMenCorrtempEdicion' => true,
       'MinSalSidPlaAdminBundle_mantenimientoNotificacion' => true,
       'MinSalSidPlaAdminBundle_consultarNotificacionJSON' => true,
       'MinSalSidPlaAdminBundle_manttNotificacionEdicion' => true,
       'MinSalSidPlaAdminBundle_mattUnidadesOrg' => true,
       'MinSalSidPlaAdminBundle_mattEmpleados' => true,
       'MinSalSidPlaAdminBundle_consultarEmpleadosJSON' => true,
       'MinSalSidPlaAdminBundle_manttEmpleadoEdicion' => true,
       'MinSalSidPlaAdminBundle_consultarUnidadesOrgJSONSelect' => true,
       'MinSalSidPlaAdminBundle_editarUnidadesOrg' => true,
       'MinSalSidPlaAdminBundle_editandoUnidadesOrg' => true,
       'MinSalSidPlaUsersBundle_mostrarUsuariosSinRol' => true,
       'MinSalSidPlaUsersBundle_consultarUsuarioSinRolJSON' => true,
       'MinSalSidPlaUsersBundle_editarUsuarioSinRol' => true,
       'MinSalSidPlaUsersBundle_verificaCreacion' => true,
       'MinSalSidPlaReportesBundle_homepage' => true,
       'MinSalSidPlaReportesBundle_reporteJustificacion' => true,
       'MinSalSidPlaReportesBundle_reporteIndicadoresSalud' => true,
       'MinSalSidPlaReportesBundle_reporteInfraEvaluada' => true,
       'MinSalSidPlaReportesBundle_reporteElementoInfra' => true,
       'MinSalSidPlaReportesBundle_reporteActividadesAtrasadas' => true,
       'MinSalSidPlaReportesBundle_reporteConsolidadoNivelCentral' => true,
       'MinSalSidPlaReportesBundle_reporteMatrizdeObjetivosyResultados' => true,
       'MinSalSidPlaReportesBundle_reporteInfoGeneral' => true,
       'MinSalSidPlaReportesBundle_reporteFormulario1' => true,
       'MinSalSidPlaReportesBundle_reporteFormulario1Unisal' => true,
       'MinSalSidPlaReportesBundle_showConsolidadosNivelCentral' => true,
       'MinSalSidPlaReportesBundle_reportesUniSal' => true,
       'MinSalSidPlaReportesBundle_reportesUniSalJSON' => true,
       'MinSalSidPlaReportesBundle_reportesDepen' => true,
       'MinSalSidPlaReportesBundle_reportesDepenJSON' => true,
       'MinSalSidPlaReportesBundle_reporteEmpleadosOrg' => true,
       'MinSalSidPlaReportesBundle_reporteCompromisoCumplimiento' => true,
       'MinSalSidPlaReportesBundle_reporteCaracOrg' => true,
       'MinSalSidPlaReportesBundle_reporteDependenciaInvidual' => true,
       'fos_user_security_login' => true,
       'fos_user_security_check' => true,
       'fos_user_security_logout' => true,
       'fos_user_profile_show' => true,
       'fos_user_profile_edit' => true,
       'fos_user_registration_register' => true,
       'fos_user_registration_check_email' => true,
       'fos_user_registration_confirm' => true,
       'fos_user_registration_confirmed' => true,
       'fos_user_resetting_request' => true,
       'fos_user_resetting_send_email' => true,
       'fos_user_resetting_check_email' => true,
       'fos_user_resetting_reset' => true,
       'fos_user_change_password' => true,
    );

    /**
     * Constructor.
     */
    public function __construct(RequestContext $context)
    {
        $this->context = $context;
    }

    public function generate($name, $parameters = array(), $absolute = false)
    {
        if (!isset(self::$declaredRouteNames[$name])) {
            throw new RouteNotFoundException(sprintf('Route "%s" does not exist.', $name));
        }

        $escapedName = str_replace('.', '__', $name);

        list($variables, $defaults, $requirements, $tokens) = $this->{'get'.$escapedName.'RouteInfo'}();

        return $this->doGenerate($variables, $defaults, $requirements, $tokens, $parameters, $name, $absolute);
    }

    private function get_wdtRouteInfo()
    {
        return array(array (  0 => 'token',), array (  '_controller' => 'Symfony\\Bundle\\WebProfilerBundle\\Controller\\ProfilerController::toolbarAction',), array (), array (  0 =>   array (    0 => 'variable',    1 => '/',    2 => '[^/]+?',    3 => 'token',  ),  1 =>   array (    0 => 'text',    1 => '/_wdt',  ),));
    }

    private function get_profiler_searchRouteInfo()
    {
        return array(array (), array (  '_controller' => 'Symfony\\Bundle\\WebProfilerBundle\\Controller\\ProfilerController::searchAction',), array (), array (  0 =>   array (    0 => 'text',    1 => '/_profiler/search',  ),));
    }

    private function get_profiler_purgeRouteInfo()
    {
        return array(array (), array (  '_controller' => 'Symfony\\Bundle\\WebProfilerBundle\\Controller\\ProfilerController::purgeAction',), array (), array (  0 =>   array (    0 => 'text',    1 => '/_profiler/purge',  ),));
    }

    private function get_profiler_importRouteInfo()
    {
        return array(array (), array (  '_controller' => 'Symfony\\Bundle\\WebProfilerBundle\\Controller\\ProfilerController::importAction',), array (), array (  0 =>   array (    0 => 'text',    1 => '/_profiler/import',  ),));
    }

    private function get_profiler_exportRouteInfo()
    {
        return array(array (  0 => 'token',), array (  '_controller' => 'Symfony\\Bundle\\WebProfilerBundle\\Controller\\ProfilerController::exportAction',), array (), array (  0 =>   array (    0 => 'text',    1 => '.txt',  ),  1 =>   array (    0 => 'variable',    1 => '/',    2 => '[^/\\.]+?',    3 => 'token',  ),  2 =>   array (    0 => 'text',    1 => '/_profiler/export',  ),));
    }

    private function get_profiler_search_resultsRouteInfo()
    {
        return array(array (  0 => 'token',), array (  '_controller' => 'Symfony\\Bundle\\WebProfilerBundle\\Controller\\ProfilerController::searchResultsAction',), array (), array (  0 =>   array (    0 => 'text',    1 => '/search/results',  ),  1 =>   array (    0 => 'variable',    1 => '/',    2 => '[^/]+?',    3 => 'token',  ),  2 =>   array (    0 => 'text',    1 => '/_profiler',  ),));
    }

    private function get_profilerRouteInfo()
    {
        return array(array (  0 => 'token',), array (  '_controller' => 'Symfony\\Bundle\\WebProfilerBundle\\Controller\\ProfilerController::panelAction',), array (), array (  0 =>   array (    0 => 'variable',    1 => '/',    2 => '[^/]+?',    3 => 'token',  ),  1 =>   array (    0 => 'text',    1 => '/_profiler',  ),));
    }

    private function get_configurator_homeRouteInfo()
    {
        return array(array (), array (  '_controller' => 'Sensio\\Bundle\\DistributionBundle\\Controller\\ConfiguratorController::checkAction',), array (), array (  0 =>   array (    0 => 'text',    1 => '/_configurator/',  ),));
    }

    private function get_configurator_stepRouteInfo()
    {
        return array(array (  0 => 'index',), array (  '_controller' => 'Sensio\\Bundle\\DistributionBundle\\Controller\\ConfiguratorController::stepAction',), array (), array (  0 =>   array (    0 => 'variable',    1 => '/',    2 => '[^/]+?',    3 => 'index',  ),  1 =>   array (    0 => 'text',    1 => '/_configurator/step',  ),));
    }

    private function get_configurator_finalRouteInfo()
    {
        return array(array (), array (  '_controller' => 'Sensio\\Bundle\\DistributionBundle\\Controller\\ConfiguratorController::finalAction',), array (), array (  0 =>   array (    0 => 'text',    1 => '/_configurator/final',  ),));
    }

    private function getMinSalSidPlaDependenciaBundle_homepageRouteInfo()
    {
        return array(array (), array (  '_controller' => 'MinSal\\SidPla\\DependenciaBundle\\Controller\\DefaultController::indexAction',), array (), array (  0 =>   array (    0 => 'text',    1 => '/SidPla/Dependencia',  ),));
    }

    private function getMinSalSidPlaBundle_homepageRouteInfo()
    {
        return array(array (), array (  '_controller' => 'MinSal\\SidPlaBundle\\Controller\\DefaultController::indexAction',), array (), array (  0 =>   array (    0 => 'text',    1 => '/SidPla/',  ),));
    }

    private function getMinSalSidPlaAdminBundle_homepageRouteInfo()
    {
        return array(array (), array (  '_controller' => 'MinSal\\SidPla\\AdminBundle\\Controller\\DefaultController::indexAction',), array (), array (  0 =>   array (    0 => 'text',    1 => '/SidPla/admin/',  ),));
    }

    private function getMinSalSidPlaAdminBundle_crearOpcRouteInfo()
    {
        return array(array (), array (  '_controller' => 'MinSal\\SidPla\\AdminBundle\\Controller\\AccionAdminOpcionesController::addOcpAction',), array (), array (  0 =>   array (    0 => 'text',    1 => '/SidPla/admin/crearOpc',  ),));
    }

    private function getMinSalSidPlaAdminBundle_nuevaOpcRouteInfo()
    {
        return array(array (), array (  '_controller' => 'MinSal\\SidPla\\AdminBundle\\Controller\\AccionAdminOpcionesController::nuevaOpcAction',), array (), array (  0 =>   array (    0 => 'text',    1 => '/SidPla/admin/nuevaOpc',  ),));
    }

    private function getMinSalSidPlaAdminBundle_nuevoRolRouteInfo()
    {
        return array(array (), array (  '_controller' => 'MinSal\\SidPla\\AdminBundle\\Controller\\AccionAdminRolesController::nuevoRolAction',), array (), array (  0 =>   array (    0 => 'text',    1 => '/SidPla/admin/nuevoRol',  ),));
    }

    private function getMinSalSidPlaAdminBundle_crearRolRouteInfo()
    {
        return array(array (), array (  '_controller' => 'MinSal\\SidPla\\AdminBundle\\Controller\\AccionAdminRolesController::addRolAction',), array (), array (  0 =>   array (    0 => 'text',    1 => '/SidPla/admin/crearRol',  ),));
    }

    private function getMinSalSidPlaAdminBundle_consultarRolesRouteInfo()
    {
        return array(array (), array (  '_controller' => 'MinSal\\SidPla\\AdminBundle\\Controller\\AccionAdminRolesController::consultarRolesAction',), array (), array (  0 =>   array (    0 => 'text',    1 => '/SidPla/admin/consultarRoles',  ),));
    }

    private function getMinSalSidPlaAdminBundle_consultarOpcionesRouteInfo()
    {
        return array(array (), array (  '_controller' => 'MinSal\\SidPla\\AdminBundle\\Controller\\AccionAdminOpcionesController::consultarOpcAction',  '_format' => 'json',), array (  '_format' => '(xml|json)',  '_method' => 'GET',), array (  0 =>   array (    0 => 'text',    1 => '/SidPla/admin/consultarOpc',  ),));
    }

    private function getMinSalSidPlaAdminBundle_manttRolesRouteInfo()
    {
        return array(array (), array (  '_controller' => 'MinSal\\SidPla\\AdminBundle\\Controller\\AccionAdminRolesController::mattRolesAction',), array (), array (  0 =>   array (    0 => 'text',    1 => '/SidPla/admin/manttRoles',  ),));
    }

    private function getMinSalSidPlaAdminBundle_mattOpcionesRouteInfo()
    {
        return array(array (), array (  '_controller' => 'MinSal\\SidPla\\AdminBundle\\Controller\\AccionAdminOpcionesController::mattOpcionesAction',), array (), array (  0 =>   array (    0 => 'text',    1 => '/SidPla/admin/mattOpciones',  ),));
    }

    private function getMinSalSidPlaAdminBundle_manttOpcEdicionRouteInfo()
    {
        return array(array (), array (  '_controller' => 'MinSal\\SidPla\\AdminBundle\\Controller\\AccionAdminOpcionesController::manttOpcEdicionAction',), array (), array (  0 =>   array (    0 => 'text',    1 => '/SidPla/admin/manttOpcEdicion',  ),));
    }

    private function getMinSalSidPlaAdminBundle_manttRolEdicionRouteInfo()
    {
        return array(array (), array (  '_controller' => 'MinSal\\SidPla\\AdminBundle\\Controller\\AccionAdminRolesController::manttRolEdicionAction',), array (), array (  0 =>   array (    0 => 'text',    1 => '/SidPla/admin/manttRolEdicion',  ),));
    }

    private function getMinSalSidPlaAdminBundle_asignarOpcRolesRouteInfo()
    {
        return array(array (), array (  '_controller' => 'MinSal\\SidPla\\AdminBundle\\Controller\\AccionAdminRolesController::asignarOpcRolesAction',), array (), array (  0 =>   array (    0 => 'text',    1 => '/SidPla/admin/asignarOpcRoles',  ),));
    }

    private function getMinSalSidPlaAdminBundle_opcionesAsignadasRouteInfo()
    {
        return array(array (), array (  '_controller' => 'MinSal\\SidPla\\AdminBundle\\Controller\\AccionAdminRolesController::opcionesAsignadasAction',), array (), array (  0 =>   array (    0 => 'text',    1 => '/SidPla/admin/opcionesAsignadas',  ),));
    }

    private function getMinSalSidPlaAdminBundle_insertOpcSeleccRolRouteInfo()
    {
        return array(array (), array (  '_controller' => 'MinSal\\SidPla\\AdminBundle\\Controller\\AccionAdminRolesController::insertOpcSeleccRolAction',), array (), array (  0 =>   array (    0 => 'text',    1 => '/SidPla/admin/insertOpcSeleccRol',  ),));
    }

    private function getMinSalSidPlaAdminBundle_deleteOpcSeleccRolRouteInfo()
    {
        return array(array (), array (  '_controller' => 'MinSal\\SidPla\\AdminBundle\\Controller\\AccionAdminRolesController::deleteOpcSeleccRolAction',), array (), array (  0 =>   array (    0 => 'text',    1 => '/SidPla/admin/deleteOpcSeleccRol',  ),));
    }

    private function getMinSalSidPlaAdminBundle_opcionesSinAsignarRouteInfo()
    {
        return array(array (), array (  '_controller' => 'MinSal\\SidPla\\AdminBundle\\Controller\\AccionAdminRolesController::opcionesSinAsignarAction',), array (), array (  0 =>   array (    0 => 'text',    1 => '/SidPla/admin/opcionesSinAsignar',  ),));
    }

    private function getMinSalSidPlaAdminBundle_consultarUnidadesOrgRouteInfo()
    {
        return array(array (), array (  '_controller' => 'MinSal\\SidPla\\AdminBundle\\Controller\\AccionAdminUnidadOrgController::consultarUnidadesOrgAction',), array (), array (  0 =>   array (    0 => 'text',    1 => '/SidPla/admin/consultarUnidadesOrg',  ),));
    }

    private function getMinSalSidPlaAdminBundle_ingresoNuevaUnidadesOrgRouteInfo()
    {
        return array(array (), array (  '_controller' => 'MinSal\\SidPla\\AdminBundle\\Controller\\AccionAdminUnidadOrgController::ingresoNuevaUnidadesOrgAction',), array (), array (  0 =>   array (    0 => 'text',    1 => '/SidPla/admin/ingresoNuevaUnidadesOrg',  ),));
    }

    private function getMinSalSidPlaAdminBundle_ingresarUnidadOrgRouteInfo()
    {
        return array(array (), array (  '_controller' => 'MinSal\\SidPla\\AdminBundle\\Controller\\AccionAdminUnidadOrgController::ingresarUnidadOrgAction',), array (), array (  0 =>   array (    0 => 'text',    1 => '/SidPla/admin/ingresarUnidadOrg',  ),));
    }

    private function getMinSalSidPlaAdminBundle_consultarMunicipiosJSONRouteInfo()
    {
        return array(array (), array (  '_controller' => 'MinSal\\SidPla\\AdminBundle\\Controller\\AccionAdminUnidadOrgController::consultarMunicipiosJSONAction',), array (), array (  0 =>   array (    0 => 'text',    1 => '/SidPla/admin/consultarMunicipiosJSON',  ),));
    }

    private function getMinSalSidPlaAdminBundle_consultarUnidadesOrgJSONRouteInfo()
    {
        return array(array (), array (  '_controller' => 'MinSal\\SidPla\\AdminBundle\\Controller\\AccionAdminUnidadOrgController::consultarUnidadesOrgJSONAction',), array (), array (  0 =>   array (    0 => 'text',    1 => '/SidPla/admin/consultarUnidadesOrgJSON',  ),));
    }

    private function getMinSalSidPlaAdminBundle_consultarMenCorrtempRouteInfo()
    {
        return array(array (), array (  '_controller' => 'MinSal\\SidPla\\AdminBundle\\Controller\\AccionAdminMenCorreTempController::consultarMenCorrtempAction',), array (), array (  0 =>   array (    0 => 'text',    1 => '/SidPla/admin/consultarMenCorrtemp',  ),));
    }

    private function getMinSalSidPlaAdminBundle_consultarMenCorrtempJSONRouteInfo()
    {
        return array(array (), array (  '_controller' => 'MinSal\\SidPla\\AdminBundle\\Controller\\AccionAdminMenCorreTempController::consultarMenCorrtempJSONAction',), array (), array (  0 =>   array (    0 => 'text',    1 => '/SidPla/admin/consultarMenCorrtempJSON',  ),));
    }

    private function getMinSalSidPlaAdminBundle_manttMenCorrtempEdicionRouteInfo()
    {
        return array(array (), array (  '_controller' => 'MinSal\\SidPla\\AdminBundle\\Controller\\AccionAdminMenCorreTempController::manttMenCorrtempEdicionAction',), array (), array (  0 =>   array (    0 => 'text',    1 => '/SidPla/admin/manttMenCorrtempEdicion',  ),));
    }

    private function getMinSalSidPlaAdminBundle_mantenimientoNotificacionRouteInfo()
    {
        return array(array (), array (  '_controller' => 'MinSal\\SidPla\\AdminBundle\\Controller\\AccionNotificacionSistemaController::mantenimientoNotificacionAction',), array (), array (  0 =>   array (    0 => 'text',    1 => '/SidPla/admin/mantenimientoNotificacion',  ),));
    }

    private function getMinSalSidPlaAdminBundle_consultarNotificacionJSONRouteInfo()
    {
        return array(array (), array (  '_controller' => 'MinSal\\SidPla\\AdminBundle\\Controller\\AccionNotificacionSistemaController::consultarNotificacionJSONAction',), array (), array (  0 =>   array (    0 => 'text',    1 => '/SidPla/admin/consultarNotificacionJSON',  ),));
    }

    private function getMinSalSidPlaAdminBundle_manttNotificacionEdicionRouteInfo()
    {
        return array(array (), array (  '_controller' => 'MinSal\\SidPla\\AdminBundle\\Controller\\AccionNotificacionSistemaController::manttNotificacionEdicionAction',), array (), array (  0 =>   array (    0 => 'text',    1 => '/SidPla/admin/manttNotificacionEdicion',  ),));
    }

    private function getMinSalSidPlaAdminBundle_mattUnidadesOrgRouteInfo()
    {
        return array(array (), array (  '_controller' => 'MinSal\\SidPla\\AdminBundle\\Controller\\AccionAdminUnidadOrgController::mattUnidadesOrgAction',), array (), array (  0 =>   array (    0 => 'text',    1 => '/SidPla/admin/mattUnidadesOrg',  ),));
    }

    private function getMinSalSidPlaAdminBundle_mattEmpleadosRouteInfo()
    {
        return array(array (), array (  '_controller' => 'MinSal\\SidPla\\AdminBundle\\Controller\\AccionAdminEmpleadosController::mattEmpleadosAction',), array (), array (  0 =>   array (    0 => 'text',    1 => '/SidPla/admin/mattEmpleados',  ),));
    }

    private function getMinSalSidPlaAdminBundle_consultarEmpleadosJSONRouteInfo()
    {
        return array(array (), array (  '_controller' => 'MinSal\\SidPla\\AdminBundle\\Controller\\AccionAdminEmpleadosController::consultarEmpleadosJSONAction',), array (), array (  0 =>   array (    0 => 'text',    1 => '/SidPla/admin/consultarEmpleadosJSON',  ),));
    }

    private function getMinSalSidPlaAdminBundle_manttEmpleadoEdicionRouteInfo()
    {
        return array(array (), array (  '_controller' => 'MinSal\\SidPla\\AdminBundle\\Controller\\AccionAdminEmpleadosController::manttEmpleadoEdicionAction',), array (), array (  0 =>   array (    0 => 'text',    1 => '/SidPla/admin/manttEmpleadoEdicion',  ),));
    }

    private function getMinSalSidPlaAdminBundle_consultarUnidadesOrgJSONSelectRouteInfo()
    {
        return array(array (), array (  '_controller' => 'MinSal\\SidPla\\AdminBundle\\Controller\\AccionAdminUnidadOrgController::consultarUnidadesOrgJSONSelectAction',), array (), array (  0 =>   array (    0 => 'text',    1 => '/SidPla/admin/consultarUnidadesOrgJSONSelect',  ),));
    }

    private function getMinSalSidPlaAdminBundle_editarUnidadesOrgRouteInfo()
    {
        return array(array (), array (  '_controller' => 'MinSal\\SidPla\\AdminBundle\\Controller\\AccionAdminUnidadOrgController::editarUnidadesOrgAction',), array (), array (  0 =>   array (    0 => 'text',    1 => '/SidPla/admin/editarUnidadesOrg',  ),));
    }

    private function getMinSalSidPlaAdminBundle_editandoUnidadesOrgRouteInfo()
    {
        return array(array (), array (  '_controller' => 'MinSal\\SidPla\\AdminBundle\\Controller\\AccionAdminUnidadOrgController::editandoUnidadesOrgAction',), array (), array (  0 =>   array (    0 => 'text',    1 => '/SidPla/admin/editandoUnidadesOrg',  ),));
    }

    private function getMinSalSidPlaUsersBundle_mostrarUsuariosSinRolRouteInfo()
    {
        return array(array (), array (  '_controller' => 'MinSal\\SidPla\\UsersBundle\\Controller\\DefaultController::mostrarUsuariosSinRolAction',), array (), array (  0 =>   array (    0 => 'text',    1 => '/SidPla/users/mostrarUsuariosSinRol',  ),));
    }

    private function getMinSalSidPlaUsersBundle_consultarUsuarioSinRolJSONRouteInfo()
    {
        return array(array (), array (  '_controller' => 'MinSal\\SidPla\\UsersBundle\\Controller\\DefaultController::consultarUsuarioSinRolJSONAction',), array (), array (  0 =>   array (    0 => 'text',    1 => '/SidPla/users/consultarUsuarioSinRolJSON',  ),));
    }

    private function getMinSalSidPlaUsersBundle_editarUsuarioSinRolRouteInfo()
    {
        return array(array (), array (  '_controller' => 'MinSal\\SidPla\\UsersBundle\\Controller\\DefaultController::editarUsuarioSinRolAction',), array (), array (  0 =>   array (    0 => 'text',    1 => '/SidPla/users/editarUsuarioSinRol',  ),));
    }

    private function getMinSalSidPlaUsersBundle_verificaCreacionRouteInfo()
    {
        return array(array (), array (  '_controller' => 'MinSal\\SidPla\\UsersBundle\\Controller\\DefaultController::verificaCreacionAction',), array (), array (  0 =>   array (    0 => 'text',    1 => '/SidPla/users/verificaCreacion',  ),));
    }

    private function getMinSalSidPlaReportesBundle_homepageRouteInfo()
    {
        return array(array (), array (  '_controller' => 'MinSal\\SidPla\\ReportesBundle\\Controller\\DefaultController::indexAction',), array (), array (  0 =>   array (    0 => 'text',    1 => '/SidPla/reportes/',  ),));
    }

    private function getMinSalSidPlaReportesBundle_reporteJustificacionRouteInfo()
    {
        return array(array (), array (  '_controller' => 'MinSal\\SidPla\\ReportesBundle\\Controller\\PaoController::reporteJustificacionAction',), array (), array (  0 =>   array (    0 => 'text',    1 => '/SidPla/reportes/reportjustificacion',  ),));
    }

    private function getMinSalSidPlaReportesBundle_reporteIndicadoresSaludRouteInfo()
    {
        return array(array (), array (  '_controller' => 'MinSal\\SidPla\\ReportesBundle\\Controller\\PaoController::reporteIndicadoresSaludAction',), array (), array (  0 =>   array (    0 => 'text',    1 => '/SidPla/reportes/reporteIndicadoresSalud',  ),));
    }

    private function getMinSalSidPlaReportesBundle_reporteInfraEvaluadaRouteInfo()
    {
        return array(array (), array (  '_controller' => 'MinSal\\SidPla\\ReportesBundle\\Controller\\EstadoInfraestructuraController::reporteInfraEvaluadaAction',), array (), array (  0 =>   array (    0 => 'text',    1 => '/SidPla/reportes/reporteInfraEvaluada',  ),));
    }

    private function getMinSalSidPlaReportesBundle_reporteElementoInfraRouteInfo()
    {
        return array(array (), array (  '_controller' => 'MinSal\\SidPla\\ReportesBundle\\Controller\\EstadoInfraestructuraController::reporteElementoInfraAction',), array (), array (  0 =>   array (    0 => 'text',    1 => '/SidPla/reportes/reporteElementoInfra',  ),));
    }

    private function getMinSalSidPlaReportesBundle_reporteActividadesAtrasadasRouteInfo()
    {
        return array(array (), array (  '_controller' => 'MinSal\\SidPla\\ReportesBundle\\Controller\\DefaultController::reporteActividadesAtrasadasAction',), array (), array (  0 =>   array (    0 => 'text',    1 => '/SidPla/reportes/reporteActividadesAtrasadas',  ),));
    }

    private function getMinSalSidPlaReportesBundle_reporteConsolidadoNivelCentralRouteInfo()
    {
        return array(array (), array (  '_controller' => 'MinSal\\SidPla\\ReportesBundle\\Controller\\DefaultController::reporteConsolidadoNivelCentralAction',), array (), array (  0 =>   array (    0 => 'text',    1 => '/SidPla/reportes/reporteConsolidadoNivelCentral',  ),));
    }

    private function getMinSalSidPlaReportesBundle_reporteMatrizdeObjetivosyResultadosRouteInfo()
    {
        return array(array (), array (  '_controller' => 'MinSal\\SidPla\\ReportesBundle\\Controller\\DefaultController::reporteMatrizdeObjetivosyResultadosAction',), array (), array (  0 =>   array (    0 => 'text',    1 => '/SidPla/reportes/reporteMatrizdeObjetivosyResultados',  ),));
    }

    private function getMinSalSidPlaReportesBundle_reporteInfoGeneralRouteInfo()
    {
        return array(array (), array (  '_controller' => 'MinSal\\SidPla\\ReportesBundle\\Controller\\AdminController::reporteInfoGeneralAction',), array (), array (  0 =>   array (    0 => 'text',    1 => '/SidPla/reportes/reporteInfoGeneral',  ),));
    }

    private function getMinSalSidPlaReportesBundle_reporteFormulario1RouteInfo()
    {
        return array(array (), array (  '_controller' => 'MinSal\\SidPla\\ReportesBundle\\Controller\\AdminController::reporteFormulario1Action',), array (), array (  0 =>   array (    0 => 'text',    1 => '/SidPla/reportes/reporteFormulario1',  ),));
    }

    private function getMinSalSidPlaReportesBundle_reporteFormulario1UnisalRouteInfo()
    {
        return array(array (), array (  '_controller' => 'MinSal\\SidPla\\ReportesBundle\\Controller\\AdminController::reporteFormulario1UnisalAction',), array (), array (  0 =>   array (    0 => 'text',    1 => '/SidPla/reportes/reporteFormulario1Unisal',  ),));
    }

    private function getMinSalSidPlaReportesBundle_showConsolidadosNivelCentralRouteInfo()
    {
        return array(array (), array (  '_controller' => 'MinSal\\SidPla\\ReportesBundle\\Controller\\AccionConsolidadosNivelCentralController::showConsolidadosNivelCentralAction',), array (), array (  0 =>   array (    0 => 'text',    1 => '/SidPla/reportes/showConsolidadosNivelCentral',  ),));
    }

    private function getMinSalSidPlaReportesBundle_reportesUniSalRouteInfo()
    {
        return array(array (), array (  '_controller' => 'MinSal\\SidPla\\ReportesBundle\\Controller\\AccionConsolidadosNivelCentralController::reportesUniSalAction',), array (), array (  0 =>   array (    0 => 'text',    1 => '/SidPla/reportes/reportesUniSal',  ),));
    }

    private function getMinSalSidPlaReportesBundle_reportesUniSalJSONRouteInfo()
    {
        return array(array (), array (  '_controller' => 'MinSal\\SidPla\\ReportesBundle\\Controller\\AccionConsolidadosNivelCentralController::reportesUniSalJSONAction',), array (), array (  0 =>   array (    0 => 'text',    1 => '/SidPla/reportes/reportesUniSalJSON',  ),));
    }

    private function getMinSalSidPlaReportesBundle_reportesDepenRouteInfo()
    {
        return array(array (), array (  '_controller' => 'MinSal\\SidPla\\ReportesBundle\\Controller\\AccionConsolidadosNivelCentralController::reportesDepenAction',), array (), array (  0 =>   array (    0 => 'text',    1 => '/SidPla/reportes/reportesDepen',  ),));
    }

    private function getMinSalSidPlaReportesBundle_reportesDepenJSONRouteInfo()
    {
        return array(array (), array (  '_controller' => 'MinSal\\SidPla\\ReportesBundle\\Controller\\AccionConsolidadosNivelCentralController::reportesDepenJSONAction',), array (), array (  0 =>   array (    0 => 'text',    1 => '/SidPla/reportes/reportesDepenJSON',  ),));
    }

    private function getMinSalSidPlaReportesBundle_reporteEmpleadosOrgRouteInfo()
    {
        return array(array (), array (  '_controller' => 'MinSal\\SidPla\\ReportesBundle\\Controller\\AdminController::reporteEmpleadosOrgAction',), array (), array (  0 =>   array (    0 => 'text',    1 => '/SidPla/reportes/reporteEmpleadosOrg',  ),));
    }

    private function getMinSalSidPlaReportesBundle_reporteCompromisoCumplimientoRouteInfo()
    {
        return array(array (), array (  '_controller' => 'MinSal\\SidPla\\ReportesBundle\\Controller\\ProgramacionMonitoreoController::reporteCompromisoCumplimientoAction',), array (), array (  0 =>   array (    0 => 'text',    1 => '/SidPla/reportes/reporteCompromisoCumplimiento',  ),));
    }

    private function getMinSalSidPlaReportesBundle_reporteCaracOrgRouteInfo()
    {
        return array(array (), array (  '_controller' => 'MinSal\\SidPla\\ReportesBundle\\Controller\\DefaultController::reporteCaracOrgAction',), array (), array (  0 =>   array (    0 => 'text',    1 => '/SidPla/reportes/reporteCaracOrg',  ),));
    }

    private function getMinSalSidPlaReportesBundle_reporteDependenciaInvidualRouteInfo()
    {
        return array(array (), array (  '_controller' => 'MinSal\\SidPla\\ReportesBundle\\Controller\\ProgramacionMonitoreoController::reporteDependenciaInvidualAction',), array (), array (  0 =>   array (    0 => 'text',    1 => '/SidPla/reportes/reporteDependenciaInvidual',  ),));
    }

    private function getfos_user_security_loginRouteInfo()
    {
        return array(array (), array (  '_controller' => 'FOS\\UserBundle\\Controller\\SecurityController::loginAction',), array (), array (  0 =>   array (    0 => 'text',    1 => '/login',  ),));
    }

    private function getfos_user_security_checkRouteInfo()
    {
        return array(array (), array (  '_controller' => 'FOS\\UserBundle\\Controller\\SecurityController::checkAction',), array (), array (  0 =>   array (    0 => 'text',    1 => '/login_check',  ),));
    }

    private function getfos_user_security_logoutRouteInfo()
    {
        return array(array (), array (  '_controller' => 'FOS\\UserBundle\\Controller\\SecurityController::logoutAction',), array (), array (  0 =>   array (    0 => 'text',    1 => '/logout',  ),));
    }

    private function getfos_user_profile_showRouteInfo()
    {
        return array(array (), array (  '_controller' => 'FOS\\UserBundle\\Controller\\ProfileController::showAction',), array (  '_method' => 'GET',), array (  0 =>   array (    0 => 'text',    1 => '/profile/',  ),));
    }

    private function getfos_user_profile_editRouteInfo()
    {
        return array(array (), array (  '_controller' => 'FOS\\UserBundle\\Controller\\ProfileController::editAction',), array (), array (  0 =>   array (    0 => 'text',    1 => '/profile/edit',  ),));
    }

    private function getfos_user_registration_registerRouteInfo()
    {
        return array(array (), array (  '_controller' => 'FOS\\UserBundle\\Controller\\RegistrationController::registerAction',), array (), array (  0 =>   array (    0 => 'text',    1 => '/register/',  ),));
    }

    private function getfos_user_registration_check_emailRouteInfo()
    {
        return array(array (), array (  '_controller' => 'FOS\\UserBundle\\Controller\\RegistrationController::checkEmailAction',), array (  '_method' => 'GET',), array (  0 =>   array (    0 => 'text',    1 => '/register/check-email',  ),));
    }

    private function getfos_user_registration_confirmRouteInfo()
    {
        return array(array (  0 => 'token',), array (  '_controller' => 'FOS\\UserBundle\\Controller\\RegistrationController::confirmAction',), array (  '_method' => 'GET',), array (  0 =>   array (    0 => 'variable',    1 => '/',    2 => '[^/]+?',    3 => 'token',  ),  1 =>   array (    0 => 'text',    1 => '/register/confirm',  ),));
    }

    private function getfos_user_registration_confirmedRouteInfo()
    {
        return array(array (), array (  '_controller' => 'FOS\\UserBundle\\Controller\\RegistrationController::confirmedAction',), array (  '_method' => 'GET',), array (  0 =>   array (    0 => 'text',    1 => '/register/confirmed',  ),));
    }

    private function getfos_user_resetting_requestRouteInfo()
    {
        return array(array (), array (  '_controller' => 'FOS\\UserBundle\\Controller\\ResettingController::requestAction',), array (  '_method' => 'GET',), array (  0 =>   array (    0 => 'text',    1 => '/resetting/request',  ),));
    }

    private function getfos_user_resetting_send_emailRouteInfo()
    {
        return array(array (), array (  '_controller' => 'FOS\\UserBundle\\Controller\\ResettingController::sendEmailAction',), array (  '_method' => 'POST',), array (  0 =>   array (    0 => 'text',    1 => '/resetting/send-email',  ),));
    }

    private function getfos_user_resetting_check_emailRouteInfo()
    {
        return array(array (), array (  '_controller' => 'FOS\\UserBundle\\Controller\\ResettingController::checkEmailAction',), array (  '_method' => 'GET',), array (  0 =>   array (    0 => 'text',    1 => '/resetting/check-email',  ),));
    }

    private function getfos_user_resetting_resetRouteInfo()
    {
        return array(array (  0 => 'token',), array (  '_controller' => 'FOS\\UserBundle\\Controller\\ResettingController::resetAction',), array (  '_method' => 'GET|POST',), array (  0 =>   array (    0 => 'variable',    1 => '/',    2 => '[^/]+?',    3 => 'token',  ),  1 =>   array (    0 => 'text',    1 => '/resetting/reset',  ),));
    }

    private function getfos_user_change_passwordRouteInfo()
    {
        return array(array (), array (  '_controller' => 'FOS\\UserBundle\\Controller\\ChangePasswordController::changePasswordAction',), array (  '_method' => 'GET|POST',), array (  0 =>   array (    0 => 'text',    1 => '/change-password/change-password',  ),));
    }
}
