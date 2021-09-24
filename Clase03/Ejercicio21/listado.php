<?php
/*Aplicación No 21 ( Listado CSV y array de usuarios)
Archivo: listado.php
método:GET
Recibe qué listado va a retornar(ej:usuarios,productos,vehículos,...etc),por ahora solo tenemos
usuarios).
En el caso de usuarios carga los datos del archivo usuarios.csv.
se deben cargar los datos en un array de usuarios.
Retorna los datos que contiene ese array en una lista
<ul>
<li>Coffee</li>
<li>Tea</li>
<li>Milk</li>
</ul>
Hacer los métodos necesarios en la clase usuario

Macarena Ferrero
*/
require_once "Usuario.php";

$nombre = $_POST['nombre'];
$clave = $_POST['clave'];
$mail = $_POST['mail'];


$usuario = new Usuario($nombre,$clave,$mail);
$usuario->MostrarUsuario();
$usuario->GuardarCSV();

$listado = array();
$listado = $usuario->LeerCSV();

/* SIRVE PARA LISTAR EN HTML
foreach ($listado as $value) {
    echo "<h1>$value->nombre</h1>";
} */

//LISTAR EN JSON
$json = json_encode($listado);
echo $json;


?>