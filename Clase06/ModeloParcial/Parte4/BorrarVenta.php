<?php

require_once "pizza.php";
require_once "Ventas.php";


$put_vars = json_decode(file_get_contents("php://input"), true);
Ventas::BorrarImagen($put_vars["numero_pedido"]);
$retorno = Ventas::EliminarVenta($put_vars["numero_pedido"]);

if ($retorno != 0) {

    echo "Eliminado con exito";
} else {

    echo "Nro de pedido inexistente";
}
