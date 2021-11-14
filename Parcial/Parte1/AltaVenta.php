<?php
require_once "pizza.php";
require_once "Ventas.php";


  if(isset($_POST['sabor']) && isset($_POST['usuario']) && isset($_POST['tipo']) && isset($_POST['cantidad']))
  {
    $pizzaUno = new Pizza(0, $_POST['sabor'], null, $_POST['tipo'], $_POST['cantidad']);

    
    echo "Cargando pizza... \n";
    var_dump($pizzaUno);
 
    $hayStock = $pizzaUno->ActualizarListaII($pizzaUno, "Entregar");
    if($hayStock)
    {
      $ventaAux = new Ventas();
      $ventaAux->CrearVenta($_POST['usuario'], $pizzaUno->sabor, $pizzaUno->tipo, $pizzaUno->cantidad );
      $ventaAux->InsertarLaVenta();
      echo "Venta realizada \n";
      $ventaAux->usuario = $_POST['usuario'];

      $dir_origen = 'ImagenesDePizzas/';
      $dir_destino = 'ImagenesDeLaVenta/';
      if (!file_exists($dir_destino)) {
          mkdir($dir_destino, 0777, true);
      }
      $nombreArchivo = $ventaAux->tipo ."-" .$ventaAux->sabor."-" .explode("@", $ventaAux->usuario)[0]."-" .$ventaAux->fecha;
      $origen = $dir_origen .$nombreArchivo ."." ."jpg";
      $destino = $dir_destino .$nombreArchivo ."." ."jpg";
      if(rename($origen, $destino))
      {
          echo "Archivo movido correctamente." ."</br>";
      }
      else
      {
          echo "Error al mover el archivo";
      }

    }
    else {
      echo "No hay stock de la pizza seleccionada \n";
    }

  }

?>