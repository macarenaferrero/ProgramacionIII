<?php
/*
Aplicación No 22 ( Login)
Archivo: Login.php
método:POST
Recibe los datos del usuario(clave,mail )por POST ,
crear un objeto y utilizar sus métodos para poder verificar si es un usuario registrado,
Retorna un :
“Verificado” si el usuario existe y coincide la clave también.
“Error en los datos” si esta mal la clave.
“Usuario no registrado si no coincide el mail“
Hacer los métodos necesarios en la clase usuario

Macarena Ferrero
*/
require_once "Usuario.php";

$nombre = $_POST['nombre'];
$clave = $_POST['clave'];
$mail = $_POST['mail'];


$usuario = new Usuario($nombre,$clave,$mail);
//$usuario->GuardarCSV();
$login = Usuario::ValidarUsuario($usuario);
switch ($login) {
    case '1':
        echo "Verificado";
        break;
    case '0':
        echo "Error en los datos";
        break;    
    default:
        echo "Usuario no registrado";
        break;
}


?>