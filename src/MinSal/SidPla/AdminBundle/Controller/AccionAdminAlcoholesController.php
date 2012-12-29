<?php

namespace MinSal\SidPla\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use MinSal\SidPla\AdminBundle\EntityDao\AlcoholDao;
use MinSal\SidPla\AdminBundle\Entity\Alcohol;


class AccionAdminAlcoholesController extends Controller {

    public function consultarUnidadesOrgAction() {

        $opciones = $this->getRequest()->getSession()->get('opciones');

        $alcoholDao = new AlcoholDao($this->getDoctrine());
        $alcoholes = $alcoholDao->getUnidadesOrg();

        return $this->render('MinSalSidPlaAdminBundle:Alcohol:showAllAlcoholes.html.twig'
                        , array('opciones' => $opciones, 'unidadesorg' => $alcoholes));
    }

    public function consultarUnidadesOrgJSONAction() {

        $alcoholDao = new AlcoholDao($this->getDoctrine());
        $alcoholes = $alcoholDao->getUnidadesOrg();

        $numfilas = count($alcoholes);

        $uni = new Alcohol();
        $i = 0;

        foreach ($alcoholes as $uni) {


            $rows[$i]['id'] = $uni->getIdUnidadOrg();
            $rows[$i]['cell'] = array($uni->getIdUnidadOrg(),
                $uni->getNombreUnidad(),
                $uni->getDescripcionUnidad(),
                '',
                $infogeneral->getDireccion(),
                $infogeneral->getTelefono());
            if ($uni->getResponsable() != NULL) {
                $empleadoDao = new EmpleadoDao($this->getDoctrine());
                $empleado = $empleadoDao->getEmpleado($uni->getResponsable());
                $rows[$i]['cell'][3] = $empleado->getPrimerNombre() . " " . $empleado->getSegundoNombre() . " " . $empleado->getPrimerApellido() . " " . $empleado->getSegundoApellido();
            }
            $i++;
        }

        if ($numfilas != 0) {
            array_multisort($rows, SORT_ASC);
        } else {
            $rows[0]['id'] = 0;
            $rows[0]['cell'] = array(' ', ' ', ' ', ' ', ' ' . ' ');
        }
        $datos = json_encode($rows);

        $pages = floor($numfilas / 10) + 1;

        $jsonresponse = '{
               "page":"1",
               "total":"' . $pages . '",
               "records":"' . $numfilas . '", 
               "rows":' . $datos . '}';



        $response = new Response($jsonresponse);
        return $response;
    }

    public function consultarAlcoholesJSONSelectAction() {
        $alcoholDao = new AlcoholDao($this->getDoctrine());
        $alcoholes = $alcoholDao->getAlcoholes();

        $numfilas = count($alcoholes);
        
        $alc = new Alcohol();
        $i = 0;

        $select = "<select>";
        foreach ($alcoholes as $alc) {
            $select = $select . "<option value=" . $alc->getAlcId() . " grado=" . $alc->getAlcGrado() . ">" . $alc->getAlcNombre() . "</option>";
        }
        $select = $select . "</select>";

        $response = new Response($select);
        return $response;
    }

    public function ingresoNuevaUnidadesOrgAction() {
        $opciones = $this->getRequest()->getSession()->get('opciones');

        $departamDao = new DepartametoPaisDao($this->getDoctrine());
        $departamentos = $departamDao->getDepartametos();

        return $this->render('MinSalSidPlaAdminBundle:Alcohol:ingresoAlcohol.html.twig', array('opciones' => $opciones, 'deptos' => $departamentos));
    }

    public function ingresarUnidadOrgAction() {

        $opciones = $this->getRequest()->getSession()->get('opciones');
        $request = $this->getRequest();

        $nombreUnidad = $request->get('nombreUnidad');
        $direccion = $request->get('direccion');
        $responsable = $request->get('idempleado');
        $telefono = $request->get('telefono');
        $fax = $request->get('fax');
        $tipoUnidad = $request->get('tipoUnidad');
        $unidadPadre = $request->get('unidadPadre');
        $departameto = $request->get('departamento');
        $municipio = $request->get('municipio');
        $descripcion = $request->get('descripcion');

        $alcoholDao = new AlcoholDao($this->getDoctrine());
        $alcoholDao->ingresarUnidadOrg($nombreUnidad, $direccion, $responsable, $telefono, $fax, $tipoUnidad, $unidadPadre, $departameto, $municipio, $descripcion);

        $departamDao = new DepartametoPaisDao($this->getDoctrine());
        $departamentos = $departamDao->getDepartametos();


        return $this->render('MinSalSidPlaAdminBundle:Alcohol:manttAlcoholes.html.twig', array('opciones' => $opciones,));
    }

    public function consultarMunicipiosJSONAction() {
        $request = $this->getRequest();
        $idDpto = $request->get('departamento');
        $departamDao = new DepartametoPaisDao($this->getDoctrine());
        $municipios = $departamDao->consultarMunicipioDpto($idDpto);

        $numfilas = count($municipios);

        $muni = new Municipio();
        $i = 0;

        foreach ($municipios as $muni) {
            $rows[$i]['id'] = $muni->getIdMunicipio();
            $rows[$i]['cell'] = array($muni->getIdMunicipio(),
                $muni->getNombreMunicipio(),
                $muni->getIdDepto());
            $i++;
        }

        $datos = json_encode($rows);
        $pages = floor($numfilas / 10) + 1;

        $jsonresponse = '{
               "page":"1",
               "total":"' . $pages . '",
               "records":"' . $numfilas . '", 
               "rows":' . $datos . '}';



        $response = new Response($jsonresponse);
        return $response;
    }

    public function mattUnidadesOrgAction() {
        $opciones = $this->getRequest()->getSession()->get('opciones');

        return $this->render('MinSalSidPlaAdminBundle:Alcohol:manttAlcoholes.html.twig', array('opciones' => $opciones,));
    }

    public function editarUnidadesOrgAction() {
        $nombreempleado = "";
        $segundonombre = "";
        $apellidoempleado = "";
        $segundoapellido = "";


        $opciones = $this->getRequest()->getSession()->get('opciones');
        $request = $this->getRequest();
        $idfila = $request->get('idfila');

        $alcoholDao = new AlcoholDao($this->getDoctrine());
        $uni = new Alcohol();
        $uni = $alcoholDao->getUnidadOrg($idfila);

        $nombreUnidad = $uni->getNombreUnidad();
        $descripcion = $uni->getDescripcionUnidad();
       // $direccion = $uni->getInformacionGeneral()->getDireccion();
        $responsable = $uni->getResponsable();
        //$telefono = $uni->getInformacionGeneral()->getTelefono();
        $tipounidad = $uni->getTipoUnidad();
        $unidadpadre = $uni->getParent();
        $idmunicipio = $uni->getIdMunicipio();
       // $fax = $uni->getInformacionGeneral()->getFax();
       // $idinfogeneral = $uni->getInformacionGeneral()->getIdInformacionGeneral();
        $municipioDao = new MunicipioDao($this->getDoctrine());
        $muni = new Municipio();
        $muni = $municipioDao->getMunicipio($idmunicipio);

        $muncipio = $muni->getNombreMunicipio();
        $iddepartamento = $muni->getIdDepto();
        $nombremunicipio = $muni->getNombreMunicipio();
        $responsableDao = new EmpleadoDao($this->getDoctrine());
        $empleado = new Empleado();
        $empleado = $responsableDao->getEmpleado($responsable);


        if ($empleado != NULL) {
            $nombreempleado = $empleado->getPrimerNombre();
            $segundonombre = $empleado->getSegundoNombre();
            $apellidoempleado = $empleado->getPrimerApellido();
            $segundoapellido = $empleado->getSegundoApellido();
        }

        if ($unidadpadre == NULL) {

            $alcoholpadreextraDao = new AlcoholDao($this->getDoctrine());
            $uniextra = new Alcohol();
            $unidadpadre = $alcoholpadreextraDao->getUnidadOrg(44);
        }


        $departamento = $muni->getIdDepto()->getNombreDepto();

        $departamDao = new DepartametoPaisDao($this->getDoctrine());
        $departamentos = $departamDao->getDepartametos();

        $municipiosDao = new MunicipioDao($this->getDoctrine());
        $municipis = $municipiosDao->getMunicipios();

        $unidadpadreDao = new AlcoholDao($this->getDoctrine());
        $unidadsPadre = $unidadpadreDao->getUnidadesOrg();

        return $this->render('MinSalSidPlaAdminBundle:Alcohol:EditarAlcohol.html.twig', array('opciones' => $opciones
                    , 'deptos' => $departamentos
                    , 'nombreUnidad' => $nombreUnidad
                    , 'descripcion' => $descripcion
                    , 'direccion' => $direccion
                    , 'telefono' => $telefono
                    , 'tipounidad' => $tipounidad
                    , 'unidadpadre' => $unidadpadre
                    , 'idmunicipio' => $idmunicipio
                    , 'iddepartamento' => $iddepartamento
                    , 'responsable' => $responsable
                    , 'fax' => $fax
                    , 'nombreempleado' => $nombreempleado
                    , 'segundonombre' => $segundonombre
                    , 'apellidoempleado' => $apellidoempleado
                    , 'segundoapellido' => $segundoapellido
                    , 'idfila' => $idfila
                    , 'idinfogeneral' => $idinfogeneral
                    , 'departamento' => $departamento
                    , 'nombremunicipio' => $nombremunicipio
                    , 'unidadPadre' => $unidadsPadre
                ));
    }

    public function editandoUnidadesOrgAction() {
        $opciones = $this->getRequest()->getSession()->get('opciones');
        $request = $this->getRequest();
        $idfila = $request->get('idfila');
        $idinfogeneral = $request->get('idinfogeneral');

        $request = $this->getRequest();
        $respon = $request->get('responsable');
        $nombreUnidad = $request->get('nombreUnidad');
        $direccion = $request->get('direccion');
        $responsable = $request->get('idempleado');
        $telefono = $request->get('telefono');
        $fax = $request->get('fax');
        $tipoUnidad = $request->get('tipoUnidad');
        $unidadPadre = $request->get('unidadPadre');
        $departameto = $request->get('departamento');
        $municipio = $request->get('municipio');
        $descripcion = $request->get('descripcion');

        $alcoholDao = new AlcoholDao($this->getDoctrine());
        $alcoholDao->editarUnidadOrg($nombreUnidad, $direccion, $responsable, $telefono, $fax, $tipoUnidad, $unidadPadre, $departameto, $municipio, $descripcion, $idfila, $idinfogeneral, $respon);


        $infogenDao->editarInfoGeneral($direccion, $telefono, $fax, $idinfogeneral);



        $departamDao = new DepartametoPaisDao($this->getDoctrine());
        $departamentos = $departamDao->getDepartametos();

        return $this->render('MinSalSidPlaAdminBundle:Alcohol:manttAlcoholes.html.twig', array('opciones' => $opciones,));
    }

}

?>
