<?php

include "Auto.php";
/*En testAuto.php:

● Crear dos objetos “Auto” de la misma marca y distinto color.
● Crear dos objetos “Auto” de la misma marca, mismo color y distinto precio.
● Crear un objeto “Auto” utilizando la sobrecarga restante.
● Utilizar el método “AgregarImpuesto” en los últimos tres objetos, agregando $ 1500
al atributo precio.
● Obtener el importe sumado del primer objeto “Auto” más el segundo y mostrar el
resultado obtenido.
● Comparar el primer “Auto” con el segundo y quinto objeto e informar si son iguales o
no.
● Utilizar el método de clase “MostrarAuto” para mostrar cada los objetos impares (1, 3, 5)

Macarena Ferrero
*/

$auto1 = new Auto("Fiat","Negro");
$auto2 = new Auto("Fiat","Blanco");
$auto3 = new Auto("Palio","Negro", 200);
$auto4 = new Auto("Palio","Negro", 500);
$auto5 = new Auto("Palio","Negro", 700, new DateTime());

$auto3->AgregarImpuesto(1500);
$auto4->AgregarImpuesto(1500);
$auto5->AgregarImpuesto(1500);

$montoAcumulado = Auto::Add($auto1, $auto2);
echo "El monto de ambos autos es $ $montoAcumulado.<br/>";

if($auto1->Equals($auto2))
{
    echo "<br/>El primer auto y el segundo son iguales.<br/>";
}
else
{
    echo "<br/>El primer auto y el segundo son diferentes.<br/>";
}

if($auto1->Equals($auto5))
{
    echo "<br/>El primer auto y el quinto son iguales.<br/>";
}
else
{
    echo "<br/>El primer auto y el quinto son diferentes.<br/>";
}

echo "<br>";
Auto::MostrarAuto($auto1);
echo "<br>";
Auto::MostrarAuto($auto3);
echo "<br>";
Auto::MostrarAuto($auto5);
echo "<br>";

?>