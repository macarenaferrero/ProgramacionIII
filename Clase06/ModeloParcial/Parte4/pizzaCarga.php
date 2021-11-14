<?php

require_once "pizza.php";
require_once "Ventas.php";

$sabor = $_POST['sabor'];
$precio = $_POST['precio'];
$tipo = $_POST['tipo'];
$cantidad = $_POST['cantidad'];


if(isset($_POST['sabor']) && isset($_POST['precio'])
&& isset($_POST['tipo']) && isset($_POST['cantidad']))
{
    $pizzaUno = new Pizza($id=0, $_POST['sabor'], $_POST['precio'], $_POST['tipo'], $_POST['cantidad']);

    echo "Cargando pizza... \n";
    var_dump($pizzaUno);
    $pizzaUno->ActualizarLista($pizzaUno, "Agregar");
    
    //   $ventaAux = new Ventas();
    //   $ventaAux->CrearVenta($_POST['usuario'], $pizzaUno->sabor, $pizzaUno->tipo, $pizzaUno->cantidad );
    //   $ventaAux->InsertarLaVenta();
    //   echo "Venta realizada \n";
      

      //Creo la carpeta
        $dir_subida = 'ImagenesDePizzas/';
        if (!file_exists($dir_subida)) {
            mkdir($dir_subida, 0777, true);
        }

        //La extension viene despues del punto
        $extension = explode(".",$_FILES["archivo"]["name"])[1];

        //Asigno el nombre con los parametrossolicitados
        $nombreArchivo = $pizzaUno->tipo ."-" .$pizzaUno->sabor;

        //Indico el destino donde debe ser guardado
        $destino = $dir_subida .$nombreArchivo ."." .$extension;

        //La funcion move_uploaded se lo copia a una carpeta temporal y la envia al destino indicado
        //Devuelve true si pudo guardarlo, false si no
        if(move_uploaded_file($_FILES["archivo"]["tmp_name"],$destino)){
            echo "Cargado correctamente";
        }
        else {
            var_dump($_FILES["archivo"]["name"]);
      }
}








?>