<?php

require_once "producto.php";

$sabor = $_GET['sabor'];
$precioBruto = $_GET['precioBruto'];
$tipo = $_GET['tipo'];
$cantidadUn = $_GET['cantidadUn'];

if(isset($sabor) && isset($precioBruto)
&& isset($tipo) && isset($cantidadUn))
{
    $productoAux = Producto::CrearProducto($id=0, $_GET['sabor'], $_GET['precioBruto'], $_GET['tipo'], $_GET['cantidadUn']);

    echo "Cargando producto... \n";
    var_dump($productoAux);
    $productoAux->ActualizarLista($productoAux, "Agregar");
}





?>