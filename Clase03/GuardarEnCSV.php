<?php

class Usuario
{
    public $user;
    public $clave;
    public $mail;
}


for ($i=0; $i < 5; $i++) 
{ 
    $unUsuario = new Usuario();
    $unUsuario->user = $i;
    $unUsuario->clave = $i;
    $unUsuario->mail = $i;
    fwrite("Saludar.txt", $unUsuario->$user);
}







?>