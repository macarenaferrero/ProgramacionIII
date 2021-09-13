<?php
/*
Aplicación No 9 (Arrays asociativos)
Realizar las líneas de código necesarias para generar un Array asociativo $lapicera, que
contenga como elementos: ‘color’, ‘marca’, ‘trazo’ y ‘precio’. Crear, cargar y mostrar tres
lapiceras.

Macarena Ferrero
*/

$lapiceraUno['Color']='Negra';$lapiceraUno['Marca']='BIC';$lapiceraUno['Trazo']='Fino';$lapiceraUno['Precio']=20.50;
$lapiceraDos['Color']='Azul';$lapiceraDos['Marca']='Billiken';$lapiceraDos['Trazo']='Medio';$lapiceraDos['Precio']=10.70;
$lapiceraTres['Color']='Roja';$lapiceraTres['Marca']='Pelikan';$lapiceraTres['Trazo']='Grueso';$lapiceraTres['Precio']=15.80;

printf("Lapicera Uno: <br/>");
foreach ($lapiceraUno as $key => $value) 
{	
    print("<br/>  $key : $value");	
}

printf("<br/><br/>Lapicera Dos: <br/>");
foreach ($lapiceraDos as $key => $value) 
{	
    print("<br/> $key : $value");	
}

printf("<br/><br/>Lapicera Tres: <br/>");
foreach ($lapiceraTres as $key => $value) 
{	
    print("<br/> $key : $value");	
}


?>