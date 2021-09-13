<?php

require_once "Usuario.php";

$nombre = $_POST['nombre'];
$clave = $_POST['clave'];
$mail = $_POST['mail'];


$usuario = new Usuario($nombre,$clave,$mail);
$usuario->MostrarUsuario();
$usuario->GuardarCSV();
 

?>