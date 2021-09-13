<?php

require_once "Usuario.php";
$opcion = $_GET['Tarea'];
$nombre = $_POST['Nombre'];
$password = $_POST['Password'];

var_dump($opcion);

switch ($opcion) {
    case 'Mostrar':
        Usuario::MostrarUsuario($nombre);
        break;    
    case 'Crear':
        $usuarionuevo = new Usuario($nombre,$password);
        var_dump($usuarionuevo);
    case 'Guardar':
        GuardarCSV
    default:        
        break;
}


?>