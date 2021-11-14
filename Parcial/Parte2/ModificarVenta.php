<?php

require_once "pizza.php";
require_once "Parte2/Ventas.php";


    $variable = json_decode(file_get_contents("php://input"),true);

   $retorno = Ventas::ModificarVenta($variable["numero_pedido"], $variable["usuario"], $variable["sabor"], $variable["tipo"], $variable["cantidad"]);

    if($retorno != 0){

        echo "Modificado con exito";
    
    } else{
    
        echo "Nro de pedido inexistente";    
    }
    ?>
