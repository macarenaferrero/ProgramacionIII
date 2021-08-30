<?php
/*Aplicación No 2 (Mostrar fecha y estación)
Obtenga la fecha actual del servidor (función date) y luego imprímala dentro de la página con
distintos formatos (seleccione los formatos que más le guste). Además indicar que estación del
año es. Utilizar una estructura selectiva múltiple.

Ferrero Macarena
*/

echo "Fecha ISO 8601 (añadido en PHP 5): ", date($format = "c");
echo "<br/>Fecha con formato » RFC 2822: ", date($format = "r");

switch (date($format = "n")) {
	case 6:
    case 7:
    case 8:
        echo "<br/>Estamos en invierno";
        break;	
    case 12:
	case 1:
	case 2:
		echo "<br/>Estamos en verano";
		break;
	case 3:
	case 4:
	case 5:
		echo "<br/>Estamos en otoño";
		break;	
	default:
		echo "<br/>Estamos en primavera";
		break;
}

# No usar tantos echo. Mejor definir una variable

?>