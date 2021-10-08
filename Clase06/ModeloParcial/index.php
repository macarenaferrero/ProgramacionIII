<?php

$metodo = $_SERVER['REQUEST_METHOD'];
$opcion = $_GET['opcion'];

switch ($metodo) {
    case 'GET':
        switch ($opcion) {
            case 'Pedir':
                include_once "pizzaCarga.php";
                break;
        }
    break;
    case 'POST':
        switch ($opcion) {
            case 'Consultar':
                include_once "pizzaConsultar.php";
                break;
        }
    break;
}

?>
