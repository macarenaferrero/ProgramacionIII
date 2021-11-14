<?php
require_once "Parte3/pizza.php";
require_once "Parte3/Ventas.php";
require_once "Parte3/AccesoDatos.php";

if(isset($_POST['sabor_pizza']) && isset($_POST['usuario']) && isset($_POST['tipo_pizza']) && isset($_POST['cantidad']))
  {
echo "La cantidad de pizzas vendidas es: ";
$retorno = Ventas::TraerTodasLasVentas();
"\n";
var_dump($retorno);

echo "El listado de ventas entre 2021-10-01 y 2021-10-30 ordenado por sabor es: ";
$retorno = Ventas::TraerVentasPorSaborYFechas("2021-10-01","2021-10-30");
"\n";
var_dump($retorno);

echo "El listado de ventas de el usuario 'rober@gmail.com' ingresado es : ";
$retorno = Ventas::TraerVentasPorUsuario('rober@gmail.com');
"\n";
var_dump($retorno);

echo "El listado de ventas del sabor jamon y morron es : ";
$retorno = Ventas::TraerVentasPorSabor("jamon y morron");
"\n";
var_dump($retorno);
  }
