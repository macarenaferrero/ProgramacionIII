<?php
require_once "pizza.php";
require_once "Parte2/Ventas.php";
require_once "Parte2/AccesoDatos.php";


if (isset($_GET['sabor']) && isset($_GET['usuario']) && isset($_GET['fecha_inicio']) && isset($_GET['fecha_final'])) {
    
    if(isset($_GET['fecha']))
    {
        $fecha = $_GET['fecha'];
    }
    else{
        $fecha = date("Y-m-d");
    }
    $retorno = Ventas::TraerTodasLasVentasSegunFecha($fecha);
    echo "La cantidad de pizzas vendidas el dia " . $_GET['fecha'] . " es: ".$retorno[0]['Cantidad'] ."</br>";
    

    echo "El listado de ventas entre " . $_GET['fecha_inicio'] . " y " . $_GET['fecha_final'] . " ordenado por sabor es: ";
    $retorno = Ventas::TraerVentasPorSaborYFechas($_GET['fecha_inicio'], $_GET['fecha_final']);
    "\n";
    var_dump($retorno);

    echo "El listado de ventas del usuario " . $_GET['usuario'] . " ingresado es : ";
    $retorno = Ventas::TraerVentasPorUsuario($_GET['usuario']);
    "\n";
    var_dump($retorno);

    echo "El listado de ventas del sabor " . $_GET['sabor'] . " es : ";
    $retorno = Ventas::TraerVentasPorSabor($_GET['sabor']);
    "\n";
    var_dump($retorno);
}