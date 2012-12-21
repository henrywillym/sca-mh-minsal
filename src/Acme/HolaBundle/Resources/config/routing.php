<?php
// src/Acme/HolaBundle/Resources/config/routing.php
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$coleccion = new RouteCollection();
$coleccion->add('hola', new Route('/hola/{nombre}', array(
    '_controller' => 'AcmeHolaBundle:Hola:index',
)));

return $coleccion;
