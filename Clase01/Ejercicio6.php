<?php

/*Aplicación No 6 (Carga aleatoria)
Definir un Array de 5 elementos enteros y asignar a cada uno de ellos un número (utilizar la
función rand). Mediante una estructura condicional, determinar si el promedio de los números
son mayores, menores o iguales que 6. Mostrar un mensaje por pantalla informando el
resultado.

Macarena Ferrero
*/


$arrayDeEnteros = array(rand(1, 10),rand(1, 10),rand(1, 10),rand(1, 10),rand(1, 10));

var_dump($arrayDeEnteros);
$total = array_sum($arrayDeEnteros);

if($total > 6)
{
    printf("La suma del array es mayor a 6, suman " .$total);
}
else if($total < 6)
{
    printf("La suma del array es menor a 6, suman " .$total);
}
else
{
    printf("La suma del array es igual a 6");
}


?>