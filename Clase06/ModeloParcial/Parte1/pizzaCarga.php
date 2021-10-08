<?php

require_once "pizza.php";

$sabor = $_GET['sabor'];
$precio = $_GET['precio'];
$tipo = $_GET['tipo'];
$cantidad = $_GET['cantidad'];


if(isset($_GET['sabor']) && isset($_GET['precio'])
&& isset($_GET['tipo']) && isset($_GET['cantidad']))
{
    $pizzaUno = new Pizza($id=0, $_GET['sabor'], $_GET['precio'], $_GET['tipo'], $_GET['cantidad']);

    echo "Cargando pizza... \n";
    var_dump($pizzaUno);
    $pizzaUno->ActualizarLista($pizzaUno, "Agregar");

}








?>