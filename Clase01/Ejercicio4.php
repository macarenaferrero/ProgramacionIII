<?php
/*Aplicación No 4 (Calculadora)
Escribir un programa que use la variable $operador que pueda almacenar los símbolos
matemáticos: ‘+’, ‘-’, ‘/’ y ‘*’; y definir dos variables enteras $op1 y $op2. De acuerdo al
símbolo que tenga la variable $operador, deberá realizarse la operación indicada y mostrarse el
resultado por pantalla.

Ferrero Macarena
*/

$operador = '/';
$op1 = 2;
$op2 = 50;
$respuesta = 0;

switch ($operador) {
    case '+':
        $respuesta = $op1 + $op2;
        printf("La suma da ".$respuesta);
        break;
    case '-':
        $respuesta = $op1 - $op2;
        printf("La resta da ".$respuesta);
        break;
    case '*':
        $respuesta = $op1 * $op2;
        printf("La multiplicación da ".$respuesta);
        break;
    default:
       if($op2 != 0)
       {
        $respuesta = $op1 / $op2;
        printf("La división da ".$respuesta);
        break;
       }
       printf("No se puede dividir por 0");
        break;
}

?>