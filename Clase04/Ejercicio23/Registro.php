<?php
/*Aplicación No 23 (Registro JSON)
Archivo: registro.php
método:POST
Recibe los datos del usuario(nombre, clave,mail )por POST ,
crea un ID autoincremental(emulado, puede ser un random de 1 a 10.000).
crear un dato con la fecha de registro , toma todos los datos y utilizar sus métodos para
poder hacer el alta,
guardando los datos en usuarios.json y subir la imagen al servidor en la carpeta
Usuario/Fotos/.
retorna si se pudo agregar o no.
Cada usuario se agrega en un renglón diferente al anterior.
Hacer los métodos necesarios en la clase usuario.

Macarena Ferrero
 */
require_once "Usuario.php";

$nombre = $_POST['nombre'];
$clave = $_POST['clave'];
$mail = $_POST['mail'];
$opcion = $GET['opcion'];

switch ($opcion) {
    case 'registro':
        $user = new Usuario($_POST["nombre"], $_POST["clave"], $_POST["mail"]);
        $user->GuardarEnJson();
        break;
}











?>