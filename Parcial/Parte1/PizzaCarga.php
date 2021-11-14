<?php

require_once "pizza.php";


if(isset($_POST['sabor']) && isset($_POST['precio'])
&& isset($_POST['tipo']) && isset($_POST['cantidad']))
{
    $pizzaUno = new Pizza($id=0, $_POST['sabor'], $_POST['precio'], $_POST['tipo'], $_POST['cantidad']);

    echo "Cargando pizza... \n";
    var_dump($pizzaUno);
    $pizzaUno->ActualizarLista($pizzaUno, "Agregar");
    Pizza::GuardarImagen($pizzaUno);

}








?>