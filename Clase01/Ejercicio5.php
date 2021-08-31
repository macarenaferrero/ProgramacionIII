<?php
/*Aplicación No 5 (Números en letras)
Realizar un programa que en base al valor numérico de una variable $num, pueda mostrarse
por pantalla, el nombre del número que tenga dentro escrito con palabras, para los números
entre el 20 y el 60.
Por ejemplo, si $num = 43 debe mostrarse por pantalla “cuarenta y tres”.

Ferrero Macarena
*/

$num = random_int(20,60);

if($num >= 20 && $num <= 60)
{
    $aux = (string)$num;

    switch ($aux[0]) {
        case '2':
            if($aux[1] == '0')
            {
                $decena = "Veinte";
                $unidad = ".";
                break;
            }
            else
            {
                $decena = "Veinti";
            }
            break;
        case '3':
            if($aux[1] == '0')
            {
                $decena = "Treinta";
                $unidad = ".";
                break;
            }
            else
            {
                $decena = "Treinta y ";
            }
            break;
        case '4':
            if($aux[1] == '0')
            {
                $decena = "Cuarenta";
                $unidad = ".";
                break;
            }
            else
            {
                $decena = "Cuarenta y ";
            }
            break;
        case '5':
            if($aux[1] == '0')
            {
                $decena = "Cincuenta";
                $unidad = ".";
                break;
            }
            else
            {
                $decena = "Cincuenta y ";
            }
            break;
        default:
            $decena = "Sesenta";
            $unidad = ".";
            break;
    }

    switch ($aux[1]) {
        case '1':
            $unidad = "uno.";
            break;
        case '2':
            $unidad = "dos.";
            break;
        case '3':
            $unidad = "tres.";
            break;
        case '4':
            $unidad = "cuatro.";
            break;
        case '5':
            $unidad = "cinco.";
            break;
        case '6':
            $unidad = "seis.";
            break;
        case '7':
            $unidad = "siete.";
            break;
        case '8':
            $unidad = "ocho.";
            break;        
        case '9':
            $unidad = "nueve.";
            break;
    }

    printf($decena .$unidad);
    
}
else
{
    printf("El valor está fuera del rango.");
}


?>