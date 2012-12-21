<?php

use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\RequestContext;

/**
 * appdevUrlMatcher
 *
 * This class has been auto-generated
 * by the Symfony Routing Component.
 */
class appdevUrlMatcher extends Symfony\Bundle\FrameworkBundle\Routing\RedirectableUrlMatcher
{
    /**
     * Constructor.
     */
    public function __construct(RequestContext $context)
    {
        $this->context = $context;
    }

    public function match($pathinfo)
    {
        $allow = array();
        $pathinfo = urldecode($pathinfo);

        // _wdt
        if (preg_match('#^/_wdt/(?P<token>[^/]+?)$#x', $pathinfo, $matches)) {
            return array_merge($this->mergeDefaults($matches, array (  '_controller' => 'Symfony\\Bundle\\WebProfilerBundle\\Controller\\ProfilerController::toolbarAction',)), array('_route' => '_wdt'));
        }

        if (0 === strpos($pathinfo, '/_profiler')) {
            // _profiler_search
            if ($pathinfo === '/_profiler/search') {
                return array (  '_controller' => 'Symfony\\Bundle\\WebProfilerBundle\\Controller\\ProfilerController::searchAction',  '_route' => '_profiler_search',);
            }

            // _profiler_purge
            if ($pathinfo === '/_profiler/purge') {
                return array (  '_controller' => 'Symfony\\Bundle\\WebProfilerBundle\\Controller\\ProfilerController::purgeAction',  '_route' => '_profiler_purge',);
            }

            // _profiler_import
            if ($pathinfo === '/_profiler/import') {
                return array (  '_controller' => 'Symfony\\Bundle\\WebProfilerBundle\\Controller\\ProfilerController::importAction',  '_route' => '_profiler_import',);
            }

            // _profiler_export
            if (0 === strpos($pathinfo, '/_profiler/export') && preg_match('#^/_profiler/export/(?P<token>[^/\\.]+?)\\.txt$#x', $pathinfo, $matches)) {
                return array_merge($this->mergeDefaults($matches, array (  '_controller' => 'Symfony\\Bundle\\WebProfilerBundle\\Controller\\ProfilerController::exportAction',)), array('_route' => '_profiler_export'));
            }

            // _profiler_search_results
            if (preg_match('#^/_profiler/(?P<token>[^/]+?)/search/results$#x', $pathinfo, $matches)) {
                return array_merge($this->mergeDefaults($matches, array (  '_controller' => 'Symfony\\Bundle\\WebProfilerBundle\\Controller\\ProfilerController::searchResultsAction',)), array('_route' => '_profiler_search_results'));
            }

            // _profiler
            if (preg_match('#^/_profiler/(?P<token>[^/]+?)$#x', $pathinfo, $matches)) {
                return array_merge($this->mergeDefaults($matches, array (  '_controller' => 'Symfony\\Bundle\\WebProfilerBundle\\Controller\\ProfilerController::panelAction',)), array('_route' => '_profiler'));
            }

        }

        if (0 === strpos($pathinfo, '/_configurator')) {
            // _configurator_home
            if (rtrim($pathinfo, '/') === '/_configurator') {
                if (substr($pathinfo, -1) !== '/') {
                    return $this->redirect($pathinfo.'/', '_configurator_home');
                }
                return array (  '_controller' => 'Sensio\\Bundle\\DistributionBundle\\Controller\\ConfiguratorController::checkAction',  '_route' => '_configurator_home',);
            }

            // _configurator_step
            if (0 === strpos($pathinfo, '/_configurator/step') && preg_match('#^/_configurator/step/(?P<index>[^/]+?)$#x', $pathinfo, $matches)) {
                return array_merge($this->mergeDefaults($matches, array (  '_controller' => 'Sensio\\Bundle\\DistributionBundle\\Controller\\ConfiguratorController::stepAction',)), array('_route' => '_configurator_step'));
            }

            // _configurator_final
            if ($pathinfo === '/_configurator/final') {
                return array (  '_controller' => 'Sensio\\Bundle\\DistributionBundle\\Controller\\ConfiguratorController::finalAction',  '_route' => '_configurator_final',);
            }

        }

        // MinSalSidPlaBundle_homepage
        if (rtrim($pathinfo, '/') === '/SidPla') {
            if (substr($pathinfo, -1) !== '/') {
                return $this->redirect($pathinfo.'/', 'MinSalSidPlaBundle_homepage');
            }
            return array (  '_controller' => 'MinSal\\SidPlaBundle\\Controller\\DefaultController::indexAction',  '_route' => 'MinSalSidPlaBundle_homepage',);
        }

        if (0 === strpos($pathinfo, '/SidPla')) {
            // MinSalSidPlaAdminBundle_homepage
            if (rtrim($pathinfo, '/') === '/SidPla/admin') {
                if (substr($pathinfo, -1) !== '/') {
                    return $this->redirect($pathinfo.'/', 'MinSalSidPlaAdminBundle_homepage');
                }
                return array (  '_controller' => 'MinSal\\SidPla\\AdminBundle\\Controller\\DefaultController::indexAction',  '_route' => 'MinSalSidPlaAdminBundle_homepage',);
            }

            // MinSalSidPlaAdminBundle_crearOpc
            if ($pathinfo === '/SidPla/admin/crearOpc') {
                return array (  '_controller' => 'MinSal\\SidPla\\AdminBundle\\Controller\\AccionAdminOpcionesController::addOcpAction',  '_route' => 'MinSalSidPlaAdminBundle_crearOpc',);
            }

            // MinSalSidPlaAdminBundle_nuevaOpc
            if ($pathinfo === '/SidPla/admin/nuevaOpc') {
                return array (  '_controller' => 'MinSal\\SidPla\\AdminBundle\\Controller\\AccionAdminOpcionesController::nuevaOpcAction',  '_route' => 'MinSalSidPlaAdminBundle_nuevaOpc',);
            }

            // MinSalSidPlaAdminBundle_nuevoRol
            if ($pathinfo === '/SidPla/admin/nuevoRol') {
                return array (  '_controller' => 'MinSal\\SidPla\\AdminBundle\\Controller\\AccionAdminRolesController::nuevoRolAction',  '_route' => 'MinSalSidPlaAdminBundle_nuevoRol',);
            }

            // MinSalSidPlaAdminBundle_crearRol
            if ($pathinfo === '/SidPla/admin/crearRol') {
                return array (  '_controller' => 'MinSal\\SidPla\\AdminBundle\\Controller\\AccionAdminRolesController::addRolAction',  '_route' => 'MinSalSidPlaAdminBundle_crearRol',);
            }

            // MinSalSidPlaAdminBundle_consultarRoles
            if ($pathinfo === '/SidPla/admin/consultarRoles') {
                return array (  '_controller' => 'MinSal\\SidPla\\AdminBundle\\Controller\\AccionAdminRolesController::consultarRolesAction',  '_route' => 'MinSalSidPlaAdminBundle_consultarRoles',);
            }

            // MinSalSidPlaAdminBundle_consultarOpciones
            if ($pathinfo === '/SidPla/admin/consultarOpc') {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_MinSalSidPlaAdminBundle_consultarOpciones;
                }
                return array (  '_controller' => 'MinSal\\SidPla\\AdminBundle\\Controller\\AccionAdminOpcionesController::consultarOpcAction',  '_format' => 'json',  '_route' => 'MinSalSidPlaAdminBundle_consultarOpciones',);
            }
            not_MinSalSidPlaAdminBundle_consultarOpciones:

            // MinSalSidPlaAdminBundle_manttRoles
            if ($pathinfo === '/SidPla/admin/manttRoles') {
                return array (  '_controller' => 'MinSal\\SidPla\\AdminBundle\\Controller\\AccionAdminRolesController::mattRolesAction',  '_route' => 'MinSalSidPlaAdminBundle_manttRoles',);
            }

            // MinSalSidPlaAdminBundle_mattOpciones
            if ($pathinfo === '/SidPla/admin/mattOpciones') {
                return array (  '_controller' => 'MinSal\\SidPla\\AdminBundle\\Controller\\AccionAdminOpcionesController::mattOpcionesAction',  '_route' => 'MinSalSidPlaAdminBundle_mattOpciones',);
            }

            // MinSalSidPlaAdminBundle_manttOpcEdicion
            if ($pathinfo === '/SidPla/admin/manttOpcEdicion') {
                return array (  '_controller' => 'MinSal\\SidPla\\AdminBundle\\Controller\\AccionAdminOpcionesController::manttOpcEdicionAction',  '_route' => 'MinSalSidPlaAdminBundle_manttOpcEdicion',);
            }

            // MinSalSidPlaAdminBundle_manttRolEdicion
            if ($pathinfo === '/SidPla/admin/manttRolEdicion') {
                return array (  '_controller' => 'MinSal\\SidPla\\AdminBundle\\Controller\\AccionAdminRolesController::manttRolEdicionAction',  '_route' => 'MinSalSidPlaAdminBundle_manttRolEdicion',);
            }

            // MinSalSidPlaAdminBundle_asignarOpcRoles
            if ($pathinfo === '/SidPla/admin/asignarOpcRoles') {
                return array (  '_controller' => 'MinSal\\SidPla\\AdminBundle\\Controller\\AccionAdminRolesController::asignarOpcRolesAction',  '_route' => 'MinSalSidPlaAdminBundle_asignarOpcRoles',);
            }

            // MinSalSidPlaAdminBundle_opcionesAsignadas
            if ($pathinfo === '/SidPla/admin/opcionesAsignadas') {
                return array (  '_controller' => 'MinSal\\SidPla\\AdminBundle\\Controller\\AccionAdminRolesController::opcionesAsignadasAction',  '_route' => 'MinSalSidPlaAdminBundle_opcionesAsignadas',);
            }

            // MinSalSidPlaAdminBundle_insertOpcSeleccRol
            if ($pathinfo === '/SidPla/admin/insertOpcSeleccRol') {
                return array (  '_controller' => 'MinSal\\SidPla\\AdminBundle\\Controller\\AccionAdminRolesController::insertOpcSeleccRolAction',  '_route' => 'MinSalSidPlaAdminBundle_insertOpcSeleccRol',);
            }

            // MinSalSidPlaAdminBundle_deleteOpcSeleccRol
            if ($pathinfo === '/SidPla/admin/deleteOpcSeleccRol') {
                return array (  '_controller' => 'MinSal\\SidPla\\AdminBundle\\Controller\\AccionAdminRolesController::deleteOpcSeleccRolAction',  '_route' => 'MinSalSidPlaAdminBundle_deleteOpcSeleccRol',);
            }

            // MinSalSidPlaAdminBundle_opcionesSinAsignar
            if ($pathinfo === '/SidPla/admin/opcionesSinAsignar') {
                return array (  '_controller' => 'MinSal\\SidPla\\AdminBundle\\Controller\\AccionAdminRolesController::opcionesSinAsignarAction',  '_route' => 'MinSalSidPlaAdminBundle_opcionesSinAsignar',);
            }

            // MinSalSidPlaAdminBundle_consultarUnidadesOrg
            if ($pathinfo === '/SidPla/admin/consultarUnidadesOrg') {
                return array (  '_controller' => 'MinSal\\SidPla\\AdminBundle\\Controller\\AccionAdminUnidadOrgController::consultarUnidadesOrgAction',  '_route' => 'MinSalSidPlaAdminBundle_consultarUnidadesOrg',);
            }

            // MinSalSidPlaAdminBundle_ingresoNuevaUnidadesOrg
            if ($pathinfo === '/SidPla/admin/ingresoNuevaUnidadesOrg') {
                return array (  '_controller' => 'MinSal\\SidPla\\AdminBundle\\Controller\\AccionAdminUnidadOrgController::ingresoNuevaUnidadesOrgAction',  '_route' => 'MinSalSidPlaAdminBundle_ingresoNuevaUnidadesOrg',);
            }

            // MinSalSidPlaAdminBundle_ingresarUnidadOrg
            if ($pathinfo === '/SidPla/admin/ingresarUnidadOrg') {
                return array (  '_controller' => 'MinSal\\SidPla\\AdminBundle\\Controller\\AccionAdminUnidadOrgController::ingresarUnidadOrgAction',  '_route' => 'MinSalSidPlaAdminBundle_ingresarUnidadOrg',);
            }

            // MinSalSidPlaAdminBundle_consultarMunicipiosJSON
            if ($pathinfo === '/SidPla/admin/consultarMunicipiosJSON') {
                return array (  '_controller' => 'MinSal\\SidPla\\AdminBundle\\Controller\\AccionAdminUnidadOrgController::consultarMunicipiosJSONAction',  '_route' => 'MinSalSidPlaAdminBundle_consultarMunicipiosJSON',);
            }

            // MinSalSidPlaAdminBundle_consultarUnidadesOrgJSON
            if ($pathinfo === '/SidPla/admin/consultarUnidadesOrgJSON') {
                return array (  '_controller' => 'MinSal\\SidPla\\AdminBundle\\Controller\\AccionAdminUnidadOrgController::consultarUnidadesOrgJSONAction',  '_route' => 'MinSalSidPlaAdminBundle_consultarUnidadesOrgJSON',);
            }

            // MinSalSidPlaAdminBundle_consultarMenCorrtemp
            if ($pathinfo === '/SidPla/admin/consultarMenCorrtemp') {
                return array (  '_controller' => 'MinSal\\SidPla\\AdminBundle\\Controller\\AccionAdminMenCorreTempController::consultarMenCorrtempAction',  '_route' => 'MinSalSidPlaAdminBundle_consultarMenCorrtemp',);
            }

            // MinSalSidPlaAdminBundle_consultarMenCorrtempJSON
            if ($pathinfo === '/SidPla/admin/consultarMenCorrtempJSON') {
                return array (  '_controller' => 'MinSal\\SidPla\\AdminBundle\\Controller\\AccionAdminMenCorreTempController::consultarMenCorrtempJSONAction',  '_route' => 'MinSalSidPlaAdminBundle_consultarMenCorrtempJSON',);
            }

            // MinSalSidPlaAdminBundle_manttMenCorrtempEdicion
            if ($pathinfo === '/SidPla/admin/manttMenCorrtempEdicion') {
                return array (  '_controller' => 'MinSal\\SidPla\\AdminBundle\\Controller\\AccionAdminMenCorreTempController::manttMenCorrtempEdicionAction',  '_route' => 'MinSalSidPlaAdminBundle_manttMenCorrtempEdicion',);
            }

            // MinSalSidPlaAdminBundle_mantenimientoNotificacion
            if ($pathinfo === '/SidPla/admin/mantenimientoNotificacion') {
                return array (  '_controller' => 'MinSal\\SidPla\\AdminBundle\\Controller\\AccionNotificacionSistemaController::mantenimientoNotificacionAction',  '_route' => 'MinSalSidPlaAdminBundle_mantenimientoNotificacion',);
            }

            // MinSalSidPlaAdminBundle_consultarNotificacionJSON
            if ($pathinfo === '/SidPla/admin/consultarNotificacionJSON') {
                return array (  '_controller' => 'MinSal\\SidPla\\AdminBundle\\Controller\\AccionNotificacionSistemaController::consultarNotificacionJSONAction',  '_route' => 'MinSalSidPlaAdminBundle_consultarNotificacionJSON',);
            }

            // MinSalSidPlaAdminBundle_manttNotificacionEdicion
            if ($pathinfo === '/SidPla/admin/manttNotificacionEdicion') {
                return array (  '_controller' => 'MinSal\\SidPla\\AdminBundle\\Controller\\AccionNotificacionSistemaController::manttNotificacionEdicionAction',  '_route' => 'MinSalSidPlaAdminBundle_manttNotificacionEdicion',);
            }

            // MinSalSidPlaAdminBundle_mattUnidadesOrg
            if ($pathinfo === '/SidPla/admin/mattUnidadesOrg') {
                return array (  '_controller' => 'MinSal\\SidPla\\AdminBundle\\Controller\\AccionAdminUnidadOrgController::mattUnidadesOrgAction',  '_route' => 'MinSalSidPlaAdminBundle_mattUnidadesOrg',);
            }

            // MinSalSidPlaAdminBundle_mattEmpleados
            if ($pathinfo === '/SidPla/admin/mattEmpleados') {
                return array (  '_controller' => 'MinSal\\SidPla\\AdminBundle\\Controller\\AccionAdminEmpleadosController::mattEmpleadosAction',  '_route' => 'MinSalSidPlaAdminBundle_mattEmpleados',);
            }

            // MinSalSidPlaAdminBundle_consultarEmpleadosJSON
            if ($pathinfo === '/SidPla/admin/consultarEmpleadosJSON') {
                return array (  '_controller' => 'MinSal\\SidPla\\AdminBundle\\Controller\\AccionAdminEmpleadosController::consultarEmpleadosJSONAction',  '_route' => 'MinSalSidPlaAdminBundle_consultarEmpleadosJSON',);
            }

            // MinSalSidPlaAdminBundle_manttEmpleadoEdicion
            if ($pathinfo === '/SidPla/admin/manttEmpleadoEdicion') {
                return array (  '_controller' => 'MinSal\\SidPla\\AdminBundle\\Controller\\AccionAdminEmpleadosController::manttEmpleadoEdicionAction',  '_route' => 'MinSalSidPlaAdminBundle_manttEmpleadoEdicion',);
            }

            // MinSalSidPlaAdminBundle_consultarUnidadesOrgJSONSelect
            if ($pathinfo === '/SidPla/admin/consultarUnidadesOrgJSONSelect') {
                return array (  '_controller' => 'MinSal\\SidPla\\AdminBundle\\Controller\\AccionAdminUnidadOrgController::consultarUnidadesOrgJSONSelectAction',  '_route' => 'MinSalSidPlaAdminBundle_consultarUnidadesOrgJSONSelect',);
            }

            // MinSalSidPlaAdminBundle_editarUnidadesOrg
            if ($pathinfo === '/SidPla/admin/editarUnidadesOrg') {
                return array (  '_controller' => 'MinSal\\SidPla\\AdminBundle\\Controller\\AccionAdminUnidadOrgController::editarUnidadesOrgAction',  '_route' => 'MinSalSidPlaAdminBundle_editarUnidadesOrg',);
            }

            // MinSalSidPlaAdminBundle_editandoUnidadesOrg
            if ($pathinfo === '/SidPla/admin/editandoUnidadesOrg') {
                return array (  '_controller' => 'MinSal\\SidPla\\AdminBundle\\Controller\\AccionAdminUnidadOrgController::editandoUnidadesOrgAction',  '_route' => 'MinSalSidPlaAdminBundle_editandoUnidadesOrg',);
            }

            if (0 === strpos($pathinfo, '/SidPla/users')) {
                // MinSalSidPlaUsersBundle_mostrarUsuariosSinRol
                if ($pathinfo === '/SidPla/users/mostrarUsuariosSinRol') {
                    return array (  '_controller' => 'MinSal\\SidPla\\UsersBundle\\Controller\\DefaultController::mostrarUsuariosSinRolAction',  '_route' => 'MinSalSidPlaUsersBundle_mostrarUsuariosSinRol',);
                }

                // MinSalSidPlaUsersBundle_consultarUsuarioSinRolJSON
                if ($pathinfo === '/SidPla/users/consultarUsuarioSinRolJSON') {
                    return array (  '_controller' => 'MinSal\\SidPla\\UsersBundle\\Controller\\DefaultController::consultarUsuarioSinRolJSONAction',  '_route' => 'MinSalSidPlaUsersBundle_consultarUsuarioSinRolJSON',);
                }

                // MinSalSidPlaUsersBundle_editarUsuarioSinRol
                if ($pathinfo === '/SidPla/users/editarUsuarioSinRol') {
                    return array (  '_controller' => 'MinSal\\SidPla\\UsersBundle\\Controller\\DefaultController::editarUsuarioSinRolAction',  '_route' => 'MinSalSidPlaUsersBundle_editarUsuarioSinRol',);
                }

                // MinSalSidPlaUsersBundle_verificaCreacion
                if ($pathinfo === '/SidPla/users/verificaCreacion') {
                    return array (  '_controller' => 'MinSal\\SidPla\\UsersBundle\\Controller\\DefaultController::verificaCreacionAction',  '_route' => 'MinSalSidPlaUsersBundle_verificaCreacion',);
                }

            }

            if (0 === strpos($pathinfo, '/SidPla/reportes')) {
                // MinSalSidPlaReportesBundle_homepage
                if (rtrim($pathinfo, '/') === '/SidPla/reportes') {
                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', 'MinSalSidPlaReportesBundle_homepage');
                    }
                    return array (  '_controller' => 'MinSal\\SidPla\\ReportesBundle\\Controller\\DefaultController::indexAction',  '_route' => 'MinSalSidPlaReportesBundle_homepage',);
                }

                // MinSalSidPlaReportesBundle_reporteJustificacion
                if ($pathinfo === '/SidPla/reportes/reportjustificacion') {
                    return array (  '_controller' => 'MinSal\\SidPla\\ReportesBundle\\Controller\\PaoController::reporteJustificacionAction',  '_route' => 'MinSalSidPlaReportesBundle_reporteJustificacion',);
                }

                // MinSalSidPlaReportesBundle_reporteIndicadoresSalud
                if ($pathinfo === '/SidPla/reportes/reporteIndicadoresSalud') {
                    return array (  '_controller' => 'MinSal\\SidPla\\ReportesBundle\\Controller\\PaoController::reporteIndicadoresSaludAction',  '_route' => 'MinSalSidPlaReportesBundle_reporteIndicadoresSalud',);
                }

                // MinSalSidPlaReportesBundle_reporteInfraEvaluada
                if ($pathinfo === '/SidPla/reportes/reporteInfraEvaluada') {
                    return array (  '_controller' => 'MinSal\\SidPla\\ReportesBundle\\Controller\\EstadoInfraestructuraController::reporteInfraEvaluadaAction',  '_route' => 'MinSalSidPlaReportesBundle_reporteInfraEvaluada',);
                }

                // MinSalSidPlaReportesBundle_reporteElementoInfra
                if ($pathinfo === '/SidPla/reportes/reporteElementoInfra') {
                    return array (  '_controller' => 'MinSal\\SidPla\\ReportesBundle\\Controller\\EstadoInfraestructuraController::reporteElementoInfraAction',  '_route' => 'MinSalSidPlaReportesBundle_reporteElementoInfra',);
                }

                // MinSalSidPlaReportesBundle_reporteActividadesAtrasadas
                if ($pathinfo === '/SidPla/reportes/reporteActividadesAtrasadas') {
                    return array (  '_controller' => 'MinSal\\SidPla\\ReportesBundle\\Controller\\DefaultController::reporteActividadesAtrasadasAction',  '_route' => 'MinSalSidPlaReportesBundle_reporteActividadesAtrasadas',);
                }

                // MinSalSidPlaReportesBundle_reporteConsolidadoNivelCentral
                if ($pathinfo === '/SidPla/reportes/reporteConsolidadoNivelCentral') {
                    return array (  '_controller' => 'MinSal\\SidPla\\ReportesBundle\\Controller\\DefaultController::reporteConsolidadoNivelCentralAction',  '_route' => 'MinSalSidPlaReportesBundle_reporteConsolidadoNivelCentral',);
                }

                // MinSalSidPlaReportesBundle_reporteMatrizdeObjetivosyResultados
                if ($pathinfo === '/SidPla/reportes/reporteMatrizdeObjetivosyResultados') {
                    return array (  '_controller' => 'MinSal\\SidPla\\ReportesBundle\\Controller\\DefaultController::reporteMatrizdeObjetivosyResultadosAction',  '_route' => 'MinSalSidPlaReportesBundle_reporteMatrizdeObjetivosyResultados',);
                }

                // MinSalSidPlaReportesBundle_reporteInfoGeneral
                if ($pathinfo === '/SidPla/reportes/reporteInfoGeneral') {
                    return array (  '_controller' => 'MinSal\\SidPla\\ReportesBundle\\Controller\\AdminController::reporteInfoGeneralAction',  '_route' => 'MinSalSidPlaReportesBundle_reporteInfoGeneral',);
                }

                // MinSalSidPlaReportesBundle_reporteFormulario1
                if ($pathinfo === '/SidPla/reportes/reporteFormulario1') {
                    return array (  '_controller' => 'MinSal\\SidPla\\ReportesBundle\\Controller\\AdminController::reporteFormulario1Action',  '_route' => 'MinSalSidPlaReportesBundle_reporteFormulario1',);
                }

                // MinSalSidPlaReportesBundle_reporteFormulario1Unisal
                if ($pathinfo === '/SidPla/reportes/reporteFormulario1Unisal') {
                    return array (  '_controller' => 'MinSal\\SidPla\\ReportesBundle\\Controller\\AdminController::reporteFormulario1UnisalAction',  '_route' => 'MinSalSidPlaReportesBundle_reporteFormulario1Unisal',);
                }

                // MinSalSidPlaReportesBundle_showConsolidadosNivelCentral
                if ($pathinfo === '/SidPla/reportes/showConsolidadosNivelCentral') {
                    return array (  '_controller' => 'MinSal\\SidPla\\ReportesBundle\\Controller\\AccionConsolidadosNivelCentralController::showConsolidadosNivelCentralAction',  '_route' => 'MinSalSidPlaReportesBundle_showConsolidadosNivelCentral',);
                }

                // MinSalSidPlaReportesBundle_reportesUniSal
                if ($pathinfo === '/SidPla/reportes/reportesUniSal') {
                    return array (  '_controller' => 'MinSal\\SidPla\\ReportesBundle\\Controller\\AccionConsolidadosNivelCentralController::reportesUniSalAction',  '_route' => 'MinSalSidPlaReportesBundle_reportesUniSal',);
                }

                // MinSalSidPlaReportesBundle_reportesUniSalJSON
                if ($pathinfo === '/SidPla/reportes/reportesUniSalJSON') {
                    return array (  '_controller' => 'MinSal\\SidPla\\ReportesBundle\\Controller\\AccionConsolidadosNivelCentralController::reportesUniSalJSONAction',  '_route' => 'MinSalSidPlaReportesBundle_reportesUniSalJSON',);
                }

                // MinSalSidPlaReportesBundle_reportesDepen
                if ($pathinfo === '/SidPla/reportes/reportesDepen') {
                    return array (  '_controller' => 'MinSal\\SidPla\\ReportesBundle\\Controller\\AccionConsolidadosNivelCentralController::reportesDepenAction',  '_route' => 'MinSalSidPlaReportesBundle_reportesDepen',);
                }

                // MinSalSidPlaReportesBundle_reportesDepenJSON
                if ($pathinfo === '/SidPla/reportes/reportesDepenJSON') {
                    return array (  '_controller' => 'MinSal\\SidPla\\ReportesBundle\\Controller\\AccionConsolidadosNivelCentralController::reportesDepenJSONAction',  '_route' => 'MinSalSidPlaReportesBundle_reportesDepenJSON',);
                }

                // MinSalSidPlaReportesBundle_reporteEmpleadosOrg
                if ($pathinfo === '/SidPla/reportes/reporteEmpleadosOrg') {
                    return array (  '_controller' => 'MinSal\\SidPla\\ReportesBundle\\Controller\\AdminController::reporteEmpleadosOrgAction',  '_route' => 'MinSalSidPlaReportesBundle_reporteEmpleadosOrg',);
                }

                // MinSalSidPlaReportesBundle_reporteCompromisoCumplimiento
                if ($pathinfo === '/SidPla/reportes/reporteCompromisoCumplimiento') {
                    return array (  '_controller' => 'MinSal\\SidPla\\ReportesBundle\\Controller\\ProgramacionMonitoreoController::reporteCompromisoCumplimientoAction',  '_route' => 'MinSalSidPlaReportesBundle_reporteCompromisoCumplimiento',);
                }

                // MinSalSidPlaReportesBundle_reporteCaracOrg
                if ($pathinfo === '/SidPla/reportes/reporteCaracOrg') {
                    return array (  '_controller' => 'MinSal\\SidPla\\ReportesBundle\\Controller\\DefaultController::reporteCaracOrgAction',  '_route' => 'MinSalSidPlaReportesBundle_reporteCaracOrg',);
                }

                // MinSalSidPlaReportesBundle_reporteDependenciaInvidual
                if ($pathinfo === '/SidPla/reportes/reporteDependenciaInvidual') {
                    return array (  '_controller' => 'MinSal\\SidPla\\ReportesBundle\\Controller\\ProgramacionMonitoreoController::reporteDependenciaInvidualAction',  '_route' => 'MinSalSidPlaReportesBundle_reporteDependenciaInvidual',);
                }

            }

        }

        // fos_user_security_login
        if ($pathinfo === '/login') {
            return array (  '_controller' => 'FOS\\UserBundle\\Controller\\SecurityController::loginAction',  '_route' => 'fos_user_security_login',);
        }

        // fos_user_security_check
        if ($pathinfo === '/login_check') {
            return array (  '_controller' => 'FOS\\UserBundle\\Controller\\SecurityController::checkAction',  '_route' => 'fos_user_security_check',);
        }

        // fos_user_security_logout
        if ($pathinfo === '/logout') {
            return array (  '_controller' => 'FOS\\UserBundle\\Controller\\SecurityController::logoutAction',  '_route' => 'fos_user_security_logout',);
        }

        if (0 === strpos($pathinfo, '/profile')) {
            // fos_user_profile_show
            if (rtrim($pathinfo, '/') === '/profile') {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_fos_user_profile_show;
                }
                if (substr($pathinfo, -1) !== '/') {
                    return $this->redirect($pathinfo.'/', 'fos_user_profile_show');
                }
                return array (  '_controller' => 'FOS\\UserBundle\\Controller\\ProfileController::showAction',  '_route' => 'fos_user_profile_show',);
            }
            not_fos_user_profile_show:

            // fos_user_profile_edit
            if ($pathinfo === '/profile/edit') {
                return array (  '_controller' => 'FOS\\UserBundle\\Controller\\ProfileController::editAction',  '_route' => 'fos_user_profile_edit',);
            }

        }

        if (0 === strpos($pathinfo, '/register')) {
            // fos_user_registration_register
            if (rtrim($pathinfo, '/') === '/register') {
                if (substr($pathinfo, -1) !== '/') {
                    return $this->redirect($pathinfo.'/', 'fos_user_registration_register');
                }
                return array (  '_controller' => 'FOS\\UserBundle\\Controller\\RegistrationController::registerAction',  '_route' => 'fos_user_registration_register',);
            }

            // fos_user_registration_check_email
            if ($pathinfo === '/register/check-email') {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_fos_user_registration_check_email;
                }
                return array (  '_controller' => 'FOS\\UserBundle\\Controller\\RegistrationController::checkEmailAction',  '_route' => 'fos_user_registration_check_email',);
            }
            not_fos_user_registration_check_email:

            // fos_user_registration_confirm
            if (0 === strpos($pathinfo, '/register/confirm') && preg_match('#^/register/confirm/(?P<token>[^/]+?)$#x', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_fos_user_registration_confirm;
                }
                return array_merge($this->mergeDefaults($matches, array (  '_controller' => 'FOS\\UserBundle\\Controller\\RegistrationController::confirmAction',)), array('_route' => 'fos_user_registration_confirm'));
            }
            not_fos_user_registration_confirm:

            // fos_user_registration_confirmed
            if ($pathinfo === '/register/confirmed') {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_fos_user_registration_confirmed;
                }
                return array (  '_controller' => 'FOS\\UserBundle\\Controller\\RegistrationController::confirmedAction',  '_route' => 'fos_user_registration_confirmed',);
            }
            not_fos_user_registration_confirmed:

        }

        if (0 === strpos($pathinfo, '/resetting')) {
            // fos_user_resetting_request
            if ($pathinfo === '/resetting/request') {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_fos_user_resetting_request;
                }
                return array (  '_controller' => 'FOS\\UserBundle\\Controller\\ResettingController::requestAction',  '_route' => 'fos_user_resetting_request',);
            }
            not_fos_user_resetting_request:

            // fos_user_resetting_send_email
            if ($pathinfo === '/resetting/send-email') {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_fos_user_resetting_send_email;
                }
                return array (  '_controller' => 'FOS\\UserBundle\\Controller\\ResettingController::sendEmailAction',  '_route' => 'fos_user_resetting_send_email',);
            }
            not_fos_user_resetting_send_email:

            // fos_user_resetting_check_email
            if ($pathinfo === '/resetting/check-email') {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_fos_user_resetting_check_email;
                }
                return array (  '_controller' => 'FOS\\UserBundle\\Controller\\ResettingController::checkEmailAction',  '_route' => 'fos_user_resetting_check_email',);
            }
            not_fos_user_resetting_check_email:

            // fos_user_resetting_reset
            if (0 === strpos($pathinfo, '/resetting/reset') && preg_match('#^/resetting/reset/(?P<token>[^/]+?)$#x', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('GET', 'POST', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'POST', 'HEAD'));
                    goto not_fos_user_resetting_reset;
                }
                return array_merge($this->mergeDefaults($matches, array (  '_controller' => 'FOS\\UserBundle\\Controller\\ResettingController::resetAction',)), array('_route' => 'fos_user_resetting_reset'));
            }
            not_fos_user_resetting_reset:

        }

        // fos_user_change_password
        if ($pathinfo === '/change-password/change-password') {
            if (!in_array($this->context->getMethod(), array('GET', 'POST', 'HEAD'))) {
                $allow = array_merge($allow, array('GET', 'POST', 'HEAD'));
                goto not_fos_user_change_password;
            }
            return array (  '_controller' => 'FOS\\UserBundle\\Controller\\ChangePasswordController::changePasswordAction',  '_route' => 'fos_user_change_password',);
        }
        not_fos_user_change_password:

        throw 0 < count($allow) ? new MethodNotAllowedException(array_unique($allow)) : new ResourceNotFoundException();
    }
}
