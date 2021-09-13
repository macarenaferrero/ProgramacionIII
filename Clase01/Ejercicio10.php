<?php
/*Aplicación No 10 (Arrays de Arrays)
Realizar las líneas de código necesarias para generar un Array asociativo y otro indexado que
contengan como elementos tres Arrays del punto anterior cada uno. Crear, cargar y mostrar los
Arrays de Arrays.


Macarena Ferrero
*/

$lapiceraUno['Color']='Negra';$lapiceraUno['Marca']='BIC';$lapiceraUno['Trazo']='Fino';$lapiceraUno['Precio']=20.50;
$lapiceraDos['Color']='Azul';$lapiceraDos['Marca']='Billiken';$lapiceraDos['Trazo']='Medio';$lapiceraDos['Precio']=10.70;
$lapiceraTres['Color']='Roja';$lapiceraTres['Marca']='Pelikan';$lapiceraTres['Trazo']='Grueso';$lapiceraTres['Precio']=15.80;
$v[1]=90; $v[30]=7; $v['e']=99; $v['hola']= 'mundo';
$array = array();
$arrayDos = array();

array_push($array, $lapiceraUno, $lapiceraDos, $lapiceraTres);
array_push($arrayDos, $v);

for ($i=0; $i < count($array); $i++) 
{ 	
	echo "<br/><br/>Se imprime lapicera en posicion: ", $i;

	foreach ($array[$i] as $key => $value) {
	
	print("<br/> $key : $value");
	
	}
}

for ($i=0; $i < count($arrayDos); $i++) 
{ 	
	echo "<br/><br/>Se imprime arrayDos indexado en posicion: ", $i;

	foreach ($arrayDos[$i] as $key => $value) {
	
	print("<br/> $key : $value");
	
	}
}

?>