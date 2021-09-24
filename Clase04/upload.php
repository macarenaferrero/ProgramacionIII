<?php


//var_dump($_POST);

//Vemos la informacion de todo el archivo ya descargado
var_dump($_FILES);
$fecha = new DateTime();

//Creo la carpeta
$dir_subida = 'archivos-subidos/';
if (!file_exists($dir_subida)) {
    mkdir('archivos-subidos/', 0777, true);
}

//La extension viene despues del punto
$extension = explode(".",$_FILES["archivo"]["name"]);

//Otra forma de tomar la extension
//$extension = pathinfo($file_name, PATHINFO_EXTENSION);

//Indico el destino donde debe ser guardado
$destino = "archivos-subidos/".$_POST["name"] .date_format($fecha, "dmY") ."." .$extension[1];

//La funcion move_uploaded se lo copia a una carpeta temporal y la envia al destino indicado
//Devuelve true si pudo guardarlo, false si no
if(move_uploaded_file($_FILES["archivo"]["tmp_name"],$destino)){
    echo "Cargado correctamente";
}
else {
    var_dump($_FILES["archivo"]["name"]);
}

?>