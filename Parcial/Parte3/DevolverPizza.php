<?php
require_once "pizza.php";
require_once "Parte3/Ventas.php";
require_once "Parte3/AccesoDatos.php";


if (isset($_GET['numero_pedido']) && isset($_GET['causa'])) {

    $numeroPedido = $_GET['numero_pedido'];
    $causa = $_GET['causa'];
    $array;
    array_push($array,$numeroPedido,"-",$causa);

    $devolucion = Ventas::GuardarDevolucion($array);
    if($devolucion)
    {
        echo "Reclamo guardado.";
        if($_FILES["archivo"])
        {
            $cupon = "Descuento10%";
            array_push($array,$cupon);
            Ventas::GenerarCupon($array);
        }
    }
    else{
        echo "Error al guardar el mensaje.";
    }

}



?>