<?php
/* Aplicación No 1 (Sumar números)
Confeccionar un programa que sume todos los números enteros desde 1 mientras la suma no
supere a 1000. Mostrar los números sumados y al finalizar el proceso indicar cuantos números
se sumaron.

Ferrero Macarena
*/
$suma = 0;
$cantidad=0;

for( $i=1 ;$suma<=1000;$i++)
{
    $suma += $i;
    $cantidad = $cantidad + 1;
}


printf("<br>La suma es ".$suma);
printf("<br>La cantidad es  ".$cantidad);


?>