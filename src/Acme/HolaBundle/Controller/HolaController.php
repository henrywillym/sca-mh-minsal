<?php
namespace Acme\HolaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HolaController extends Controller
{
    public function indexAction($nombre)
    {
        return $this->render('AcmeHolaBundle:Hola:index.html.twig', array('nombre' => $nombre));

        // produce una plantilla PHP en su lugar
        // return $this->render('AcmeHolaBundle:Hola:index.html.php', array('nombre' => $nombre));
    }
}