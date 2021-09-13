<?php
/*Aplicación No 13 (Invertir palabra)
Crear una función que reciba como parámetro un string ($palabra) y un entero ($max). La
función validará que la cantidad de caracteres que tiene $palabra no supere a $max y además
deberá determinar si ese valor se encuentra dentro del siguiente listado de palabras válidas:
“Recuperatorio”, “Parcial” y “Programacion”. Los valores de retorno serán:
1 si la palabra pertenece a algún elemento del listado.
0 en caso contrario.

MACARENA FERRERO*/

function VerificarPalabra($palabra, $max)
{
    $retorno = 0;

    $palabra = strtolower($palabra);
    $palabra = ucfirst($palabra);

if(strlen($palabra) <= $max)
{
    if(strcmp($palabra, "Parcial")==0 || (strcmp($palabra, "Recuperatorio"))==0 || strcmp($palabra, "Programacion")==0)
    {
        $retorno = 1;
    }
}
return $retorno;
}

echo VerificarPalabra("Programacion", 15);

?>