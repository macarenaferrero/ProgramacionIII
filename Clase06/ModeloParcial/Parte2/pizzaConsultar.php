<?php

require_once "pizza.php";

if(isset($_POST['sabor']) && isset($_POST['tipo'])){
    $sabor = $_POST['sabor'];
    $tipo = $_POST['tipo'];
    var_dump(key($_POST));

    $arrayPizzas = Pizza::LeerEnJson();

    echo '<h1>Pizzas a Buscar</h1>';
    echo '<h1> Sabor: '.$sabor.' Tipo: '.$tipo.'</h1>' ."\n";

    
    $arrayPizzas = Pizza::LeerEnJson();
    Pizza::BuscarPizza($arrayPizzas, $sabor, $tipo);
}
