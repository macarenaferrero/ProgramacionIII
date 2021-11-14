<?php

require_once "pizza.php";
require_once "Ventas.php";


  if(isset($_POST['sabor_pizza']) && isset($_POST['usuario']) && isset($_POST['tipo_pizza']) && isset($_POST['cantidad']))
  {
    $pizzaUno = new Pizza(null, $_POST['sabor_pizza'], null, $_POST['tipo_pizza'], $_POST['cantidad']);

    
    echo "Cargando pizza... \n";
    var_dump($pizzaUno);
 
    $hayStock = $pizzaUno->ActualizarListaII($pizzaUno, "Entregar");
    if($hayStock)
    {
      $ventaAux = new Ventas();
      $ventaAux->CrearVenta($_POST['usuario'], $pizzaUno->sabor, $pizzaUno->tipo, $pizzaUno->cantidad );
      $ventaAux->InsertarLaVenta();
      echo "Venta realizada \n";

      

      //Creo la carpeta
        $dir_subida = 'ImagenesDeLaVenta/';
        if (!file_exists($dir_subida)) {
            mkdir($dir_subida, 0777, true);
        }

        //La extension viene despues del punto
        $extension = "jpg";//explode(".",$_FILES["archivo"]["name"])[1];

        //Asigno el nombre con los parametrossolicitados
        $nombreArchivo = $ventaAux->tipo_pizza ."-" .$ventaAux->sabor_pizza."-" .explode("@", $ventaAux->usuario)[0]."-" .$ventaAux->fecha;

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
    else {
      echo "No hay stock de la pizza seleccionada \n";
    }

  }

?>