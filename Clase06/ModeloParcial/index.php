<?php

$metodo = $_SERVER['REQUEST_METHOD'];
$opcion = $_GET['opcion'];


switch ($metodo) {
    case 'GET':
        switch ($opcion) {
            case 'Pedir':
                include_once "Parte1/pizzaCarga.php";
                break;
        }
    break;
    case 'POST':
        switch ($opcion) {
            case 'Consultar':
                include_once "Parte1/pizzaConsultar.php";
                break;
            case 'Entregar':
                include_once "Parte2/AltaVenta.php";
                break;
        }
    break;
}

?>
