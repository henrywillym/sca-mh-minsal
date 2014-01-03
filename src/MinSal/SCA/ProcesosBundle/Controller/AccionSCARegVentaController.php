<?php

/**
 * @author Daniel E. Diaz
 */

namespace MinSal\SCA\ProcesosBundle\Controller;

use MinSal\SCA\AdminBundle\EntityDao\AlcoholDao;
use MinSal\SCA\ProcesosBundle\Entity\RegVenta;
use MinSal\SCA\ProcesosBundle\EntityDao\RegVentaDao;
use MinSal\SCA\ProcesosBundle\Form\Type\RegVentaType;
use MinSal\SCA\UsersBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Mantenimineto de Ingreso inicial a Registro de Ventas...
 * 
 */
class AccionSCARegVentaController extends Controller {

    /**
     * Retorna la página principal del mantenimiento
     * @return type HTML.twig
     */
    public function mantRegVentaAction() {
        $opciones = $this->getRequest()->getSession()->get('opciones');
        $user = $this->get('security.context')->getToken()->getUser();

        if ($user->getEntidad() == null) {
            return $this->render('MinSalSCAProcesosBundle:Default:mantNoEntidad.html.twig', array(
                        'opciones' => $opciones
                            )
            );
        } else {
            return $this->render('MinSalSCAProcesosBundle:RegVenta:mantRegVenta.html.twig', array(
                        'opciones' => $opciones,
                        'entNombComercial' => $user->getEntidad()->getEntNombComercial()
                            )
            );
        }
    }

    /**
     * Devuelve el listado principal de registros del mantenimiento
     * @return Response
     */
    public function consultarRegVentaJSONAction() {
        //CARGA LA TABLA PRINCIPAL
        $user = $this->get('security.context')->getToken()->getUser();

        $RegVentaDao = new RegVentaDao($this->getDoctrine());
        $registros = $RegVentaDao->getJasonRegVenta($user->getEntidad()->getEntId());

        $numfilas = count($registros);

        $datos = json_encode($registros);
        $pages = floor($numfilas / 10) + 1;

        $jsonresponse = '{
               "page":"1",
               "total":"' . $pages . '",
               "records":"' . $numfilas . '", 
               "rows":' . $datos . '}';

        $response = new Response($jsonresponse);

        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /*
     * Se encarga de ejecutar las acciones de Eliminar, agregar y editar
     * del mantenimiento
     */

    public function mantRegVentaEdicionAction(request $request) {
        $RegVenta = new RegVenta();
        $RegVentaDao = new RegVentaDao($this->getDoctrine());

        $user = $this->get('security.context')->getToken()->getUser();
        $idEnt = $user->getEntidad()->getEntId();

        $form = $this->createForm(new RegVentaType($this->getDoctrine(), $idEnt), $RegVenta);
        $form->bindRequest($request);



        $id = $RegVenta->getRegVentaId('RegVentaId');
        $eliminar = $request->get('eliminar');
        //Verifica si se esta seleccionando la opcion de eliminar

        if ($eliminar == 'true') {
            /**
             * Eliminacion logica del registro en la tabla. Se encargada colocar el flag audit_deleted =true
             */
            $RegVentaDao->delRegVenta($id, $user);
            $this->get('session')->setFlash('notice', 'El registro se Elimino Exitosamente');
        } else {

            //SINO SE SELECCIONO LA OPCION DE ELIMINAR SE ACTUALIZARA O SE AGREGARA UN NUEVO REGISTRO   
            $operacion = $request->get('btnGuardar');

            $nit = $RegVenta->getregveNIT("nit");
            $nombcliente = $RegVenta->getregveNombre("nombcliente");
            $reg_user = $RegVenta->getregveMinsal("reg_user");
            $fecha = $RegVenta->getregveFecha("fecha");
            $n_res = $RegVenta->getregvedgii("n_res");
            $AlcId = $RegVenta->getAlcohol("AlcId");
            $RegVentaLitros = $RegVenta->getregveLitros("RegVentaLitros");
            $RegVentaGrado = $RegVenta->getregveGrado("RegVentaGrado");

            $errores = $RegVenta->isValid();
            if (count($errores) == 0) {
                if ($operacion == 'Actualizar') {
                    $RegVentaDao->editRegVenta($id, $idEnt, $fecha, $nit, $nombcliente, $reg_user, $n_res, $AlcId, $RegVentaLitros, $RegVentaGrado, $user);
                    $this->get('session')->setFlash('notice', 'Los datos se han Actualizado exitosamente');
                }

                if ($operacion == 'Guardar') {
                    $RegVentaDao->addRegVenta($fecha, $idEnt, $nit, $nombcliente, $reg_user, $n_res, $AlcId, $RegVentaLitros, $RegVentaGrado, $user);
                    $this->get('session')->setFlash('notice', 'Los datos se han Guardado exitosamente');
                }
            } else {
                $listaErrores = '';

                foreach ($errores as $error) {
                    $listaErrores = $listaErrores . $error;
                }
                $this->get('session')->setFlash('notice', $listaErrores);
                $form = $this->createForm(new RegVentaType($this->getDoctrine(), $idEnt), $RegVenta);
                
                $opciones = $this->getRequest()->getSession()->get('opciones');
                return $this->render('MinSalSCAProcesosBundle:RegVenta:showRegVenta.html.twig', array(
                            'form' => $form->createView(),
                            'opciones' => $opciones,
                            'RegVentaId' => $id,
                            'entNombComercial' => $user->getEntidad()->getEntNombComercial()
                        ));
            }
        }
        return $this->redirect($this->generateUrl('MinSalSCAProcesosBundle_mantRegVenta'));
    }

    /*
     * Se encarga de cargar los datos de la RegVenta para que sean editados
     */

    public function mantCargarRegVentaAction($RegVentaId) {
        $opciones = $this->getRequest()->getSession()->get('opciones');
        $user = $this->get('security.context')->getToken()->getUser();
        $idEnt = $user->getEntidad()->getEntId();

        $RegVentaDao = new RegVentaDao($this->getDoctrine());
        $RegVenta = $RegVentaDao->getRegVenta($RegVentaId);


//        if( !$RegVenta ){
//            $RegVenta = new RegVenta();
//        }else{
//        }

        $form = $this->createForm(new RegVentaType($this->getDoctrine(), $idEnt), $RegVenta);

        return $this->render('MinSalSCAProcesosBundle:RegVenta:showRegVenta.html.twig', array(
                    'form' => $form->createView(),
                    'opciones' => $opciones,
                    'RegVentaId' => $RegVentaId,
                    'entNombComercial' => $user->getEntidad()->getEntNombComercial()
                ));
    }

    public function getGradoRVAction($CuoId) {
        //FUNCION QUE GENERA EL VALOR DEL GRADO PARA MOSTRARLO EN EL CAMPO GRADO DEL FORM REGVENTA
        $RegVentaDao = new RegVentaDao($this->getDoctrine());
        $grado = $RegVentaDao->getGrado($CuoId);
        $response = new Response($grado);

        return $response;
    }

}

?>