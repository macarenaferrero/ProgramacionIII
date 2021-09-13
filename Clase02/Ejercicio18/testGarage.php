<?php
/*En testGarage.php, crear autos y un garage. Probar el buen funcionamiento de todos los
métodos.

Macarena Ferrero
*/
include "Garage.php";

$auto1 = new Auto("Fiat","Negro");
$auto2 = new Auto("Fiat","Blanco");
$miGarage = new Garage("Teloguardo.com", 50);

echo "<br/>Añado autos al garage:";
$miGarage->Add($auto1);
$miGarage->Add($auto2);

echo "<br/>Muestro garage:<br/>";
$miGarage->MostrarGarage();

echo "<br/>Comparo el garage con un auto:<br/>";
if($miGarage->Equals($auto1))
{
    echo "<br/>El auto se encuentra en el Garage.<br/>";
}
else
{
    echo "<br/>El auto no se encuentra en el Garage.<br/>";
}
echo "<br/>Elimino un auto del garage.<br/>";
echo $miGarage->Remove($auto2);

?>