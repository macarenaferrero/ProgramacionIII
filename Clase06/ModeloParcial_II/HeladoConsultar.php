<?php

require_once "producto.php";

if(isset($_POST['sabor']) && isset($_POST['tipo'])){
    $sabor = $_POST['sabor'];
    $tipo = $_POST['tipo'];
    var_dump(key($_POST));

    $arrayProducto = Producto::LeerEnJson();

    echo '<h1>Producto a Buscar</h1>';
    echo '<h1> Sabor: '.$sabor.' Tipo: '.$tipo.'</h1>' ."\n";

    
    $arrayProducto = Producto::LeerEnJson();
    Producto::BuscarProducto($arrayProducto, $sabor, $tipo);
}






?>