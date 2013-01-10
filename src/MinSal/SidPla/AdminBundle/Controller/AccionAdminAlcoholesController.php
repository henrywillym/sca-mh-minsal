<?php

namespace MinSal\SidPla\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use MinSal\SidPla\AdminBundle\EntityDao\AlcoholDao;
use MinSal\SidPla\AdminBundle\Entity\Alcohol;


class AccionAdminAlcoholesController extends Controller {

    public function consultarAlcoholesAction() {

        $opciones = $this->getRequest()->getSession()->get('opciones');

        $alcoholDao = new AlcoholDao($this->getDoctrine());
        $alcoholes = $alcoholDao->getUnidadesOrg();

        return $this->render('MinSalSidPlaAdminBundle:Alcohol:showAllAlcoholes.html.twig'
                        , array('opciones' => $opciones, 'unidadesorg' => $alcoholes));
    }

    public function consultarAlcoholesJSONAction() {

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

}

?>
