<?php

$metodo = $_SERVER['REQUEST_METHOD'];
$opcion = $_GET['opcion'];


switch ($metodo) {
    case 'POST':
        switch ($opcion) {
            case 'Agregar':
                include_once "Parte1/PizzaCarga.php";
                break;
            case 'Consultar':
                include_once "Parte1/PizzaConsultar.php";
                break;
            case 'Vender':
                include_once "Parte1/AltaVenta.php";
                break;
        }
    case 'GET':
        switch ($opcion) {
            case 'Query':
                include_once "Parte2/ConsultarVentas.php";
                break;
            }
    case 'PUT':
        switch ($opcion) {
            case 'Modificar':
                include_once "Parte2/ModificarVenta.php";
                break;
        }
    case 'DELETE':
        switch ($opcion) {
            case 'Eliminar':
            include_once "Parte3/borrarVenta.php";
            break;
            }
}
?>
