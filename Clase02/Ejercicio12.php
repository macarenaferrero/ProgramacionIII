<?php

function DarVueltaPalabra($array)
{
    
    for($i = count($array)-1; $i >= 0; $i--)
    {
        echo $array[$i];
    }        
}

$arrayPalabra = array("S","A","L","U","D","A","R");
DarVueltaPalabra($arrayPalabra);

/*function DarVueltaPalabra($array)
{
    return array_reverse($array);
}

$arrayPalabra = ["S","A","L","U","D","A","R"];

DarVueltaPalabra($arrayPalabra);*/

?>