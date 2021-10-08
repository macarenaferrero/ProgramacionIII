<?php
/*
Aplicación No 27 (Registro BD)
Archivo: registro.php
método:POST
Recibe los datos del usuario( nombre,apellido, clave,mail,localidad )por POST ,
crear un objeto con la fecha de registro y utilizar sus métodos para poder hacer el alta,
guardando los datos la base de datos
retorna si se pudo agregar o no.

Macarena Ferrero
*/

require_once "Usuario.php";
require_once "DataConnection.php";

$opcion = $_GET['opcion'];
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$clave = $_POST['clave'];
$mail = $_POST['mail'];
$localidad = $_POST['localidad'];


switch ($opcion) {
    case 'CrearUsuario':
        $newUsuario = new Usuario($nombre, $apellido, $clave, $mail, $localidad);
        echo "Usuario creado";
        break;
    case 'GuardarUsuarioDB':
        $retorno = Usuario::GuardarenBD();
        if($retorno != null)
        {
            echo "El usuario se guardo correctamente";
        }
        else {
            echo "Error al guardar la consulta";
        }
        break;
    default:
        # code...
        break;
}

?>