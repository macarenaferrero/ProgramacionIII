<?php
require_once "Parte3/pizza.php";
require_once "Parte3/Ventas.php";
require_once "Parte3/AccesoDatos.php";


echo "La cantidad de pizzas vendidas es: ";
$retorno = Ventas::TraerTodasLasVentas();
"\n";
var_dump($retorno);

echo "El listado de ventas entre 2021-10-01 y 2021-10-30 ordenado por sabor es: ";
$retorno = Ventas::TraerVentasPorSaborYFechas();
"\n";
var_dump($retorno);

echo "El listado de ventas de el usuario 'rober@gmail.com' ingresado es : ";
$retorno = Ventas::TraerVentasPorUsuario();
"\n";
var_dump($retorno);

echo "El listado de ventas del sabor jamon y morron es : ";
$retorno = Ventas::TraerVentasPorSabor();
"\n";
var_dump($retorno);
?>