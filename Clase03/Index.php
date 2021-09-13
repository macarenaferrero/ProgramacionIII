<?php

//$archivo = fopen("Saludar.txt","w");
//fclose($archivo);


//$archivo = fopen("Saludar.txt","r");
//echo fread($archivo, 10);
//fclose($archivo);

$contador = 0;

$archivo = fopen("Saludar.txt","r");
while (!feof($archivo)) 
{
    $palabra = fgets($archivo);
    //$palabra.trim();
    if (!empty($palabra)) 
    {
        echo $palabra . "<br/>";
        $contador++;
    }   
}
printf($contador);
fclose($archivo);

?>