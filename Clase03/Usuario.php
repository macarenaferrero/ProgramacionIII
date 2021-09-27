<?php

class Usuario
{
    public $nombre;
    public $password;

    public static function MostrarUsuario($user)
    {
        echo $user;
    }

    function __construct($nombre, $password) 
    {
        $this->$nombre = $nombre;
        $this->$password = $password;
    }

    public function GuardarCSV()
    {
        $archivo = fopen("Saludar.txt", "w");
        $usuarioArray = array($this->nombre, $this->password);  
    
        $guardarCSV = implode(',', $usuarioArray);
        $guardarCSV = $guardarCSV . "\n";
        fwrite($archivo, $guardarCSV);
        fclose($archivo);
    }

}




?>