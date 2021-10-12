<?php

require_once "pizza.php";
require_once "Ventas.php";

$numero_pedido = $_PUT['numero_pedido'];
$usuario = $_PUT['usuario'];
$sabor = $_PUT['sabor_pizza'];
$tipo = $_PUT['tipo_pizza'];
$cantidad = $_PUT['cantidad'];

if(isset($_PUT['numero_pedido']) && isset($_PUT['usuario']) && isset($_PUT['sabor_pizza'])
&& isset($_PUT['tipo_pizza']) && isset($_PUT['cantidad']))
{
    Ventas::ModificarVenta($_PUT['numero_pedido'], $_PUT['usuario'], $_PUT['sabor_pizza'], $_PUT['tipo_pizza'], $_PUT['cantidad']);
    echo "Venta N: " .$_PUT['numero_pedido'] ." modificada correctamente.";
}else {
    echo "No existe la venta informada.";
}








?>