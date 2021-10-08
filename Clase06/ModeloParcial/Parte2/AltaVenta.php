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
    }
    else {
      echo "No hay stock de la pizza seleccionada \n";
    }

  }

?>