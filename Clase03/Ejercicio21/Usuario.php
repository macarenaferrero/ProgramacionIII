<?php

class Usuario
{
    public $nombre;
    public $clave;
    public $mail;
    
    public function __construct($nombre, $clave, $mail)
     
    {
        $this->nombre = $nombre;
        $this->clave = $clave;
        $this->mail = $mail;        
    }

    public function MostrarUsuario()
    {
        echo "Nombre : " .$this->nombre ."<br/>";
        echo "Mail :" .$this->mail ."<br/>";
    }

    public function ArrayUsuarios()
    {
        return array($this->nombre, $this->clave, $this->mail);
    }

    public function GuardarCSV()
    {
        $archivo = fopen("Usuarios.csv", "a+");
        $usuarioArray = array($this->nombre, $this->clave, $this->mail);  
    
        $guardarCSV = implode(',', $usuarioArray);
        //$rows = str_getcsv($str, PHP_EOL);
        $guardarCSV = $guardarCSV . "\n";
        
        if(fwrite($archivo, $guardarCSV) != false)
        {
            fclose($archivo);
            echo "<br/>Se ha guardardado el usuario satisfactoriamente.<br/>";
        }
        else {
                echo "<br/>Ha ocurrido un problema al intentar guardar el usuario.<br/>";
        }
    }

    public function LeerCSV()
    {
        $archivo = fopen("Usuarios.csv", "r");
        $usuariosCargados = array();
                
        while ($datos = fgetcsv($archivo)) {
            $user = new Usuario($datos[0],$datos[1],$datos[2]);
            array_push($usuariosCargados, $user);
        }
        
        fclose($archivo);
        return $usuariosCargados;
    }
}

?>