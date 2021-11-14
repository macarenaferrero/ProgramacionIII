<?php

$metodo = $_SERVER['REQUEST_METHOD'];
$opcion = $_GET['opcion'];


switch ($metodo) {
    case 'GET':
        switch ($opcion) {
            case 'Agregar':
                include_once "HeladoCarga.php";
                break;
            
        }
        break;
    case 'POST':
        switch ($opcion) {
            case 'Consultar':
                include_once "HeladoConsultar.php";
                break;
            }
}
