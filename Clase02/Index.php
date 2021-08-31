<?php

/*
Saludar by Macarena Ferrero
*/
include "Funciones.php";
include "Usuario.php";


$unUsuario = new Usuario();
$unUsuario->nombre = "Macarena";
Saludar($unUsuario->nombre);



?>