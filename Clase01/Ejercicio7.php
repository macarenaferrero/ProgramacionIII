<?php
/*Aplicación No 7 (Mostrar impares)
Generar una aplicación que permita cargar los primeros 10 números impares en un Array.
Luego imprimir (utilizando la estructura for) cada uno en una línea distinta (recordar que el
salto de línea en HTML es la etiqueta <br/>). Repetir la impresión de los números utilizando
las estructuras while y foreach.

Macarena Ferrero
*/

$array = array();

do {
    $numero = rand(1,100);

    if($numero % 2 != 0)
    {
        array_push($array, $numero);
    }
} while (count($array) < 10);

//Estructura FOR
printf("<br/>Imprimo con For<br/>");
for ($i=0; $i < 10; $i++) { 
    echo "<br/> Un valor del array es " .$array[$i];
}

//Estructura WHILE
printf("<br/><br/> Imprimo con While <br/>");
$contador = 0;

do {
    echo "<br/> Un valor del array es " .$array[$contador];
    $contador++;

} while ($contador < count($array));

//Estructura FORECH
printf("<br/><br/> Imprimo con Forech <br/>");

foreach ($array as $value) {
    
    echo "<br/> Un valor del array es " .$value;
}

?>