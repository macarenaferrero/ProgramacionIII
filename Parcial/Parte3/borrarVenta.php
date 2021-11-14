<?php

require_once "pizza.php";
require_once "Ventas.php";


$variable = json_decode(file_get_contents("php://input"), true);
Ventas::BorrarImagen($variable["numero_pedido"]);
$retorno = Ventas::EliminarVenta($variable["numero_pedido"]);

if ($retorno != 0) {

    echo "Eliminado con exito";
} else {

    echo "Nro de pedido inexistente";
}

?>