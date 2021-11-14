<?php
require_once "Parte3/pizza.php";
require_once "Parte3/Ventas.php";
require_once "Parte3/AccesoDatos.php";


if (isset($_GET['sabor_pizza']) && isset($_GET['usuario']) && isset($_GET['fecha_inicio']) && isset($_GET['fecha_final'])) {
    $retorno = Ventas::TraerTodasLasVentas();
    echo "La cantidad de pizzas vendidas es: ".$retorno[0]['Cantidad'] ."</br>";
    

    echo "El listado de ventas entre " . $_GET['fecha_inicio'] . " y " . $_GET['fecha_final'] . " ordenado por sabor es: ";
    $retorno = Ventas::TraerVentasPorSaborYFechas($_GET['fecha_inicio'], $_GET['fecha_final']);
    "\n";
    var_dump($retorno);

    echo "El listado de ventas del usuario " . $_GET['usuario'] . " ingresado es : ";
    $retorno = Ventas::TraerVentasPorUsuario($_GET['usuario']);
    "\n";
    var_dump($retorno);

    echo "El listado de ventas del sabor " . $_GET['sabor_pizza'] . " es : ";
    $retorno = Ventas::TraerVentasPorSabor($_GET['sabor_pizza']);
    "\n";
    var_dump($retorno);
}
