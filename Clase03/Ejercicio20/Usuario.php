<?php
/*Aplicación No 20 (Registro CSV)
Archivo: registro.php
método:POST
Recibe los datos del usuario(nombre, clave,mail )por POST ,
crear un objeto y utilizar sus métodos para poder hacer el alta,
guardando los datos en usuarios.csv.
retorna si se pudo agregar o no.
Cada usuario se agrega en un renglón diferente al anterior.
Hacer los métodos necesarios en la clase usuario

Macarena Ferrero
*/

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


    public function GuardarCSV()
    {
        $archivo = fopen("Usuarios.csv", "w");
        $usuarioArray = array($this->nombre, $this->clave, $this->mail);  
    
        $guardarCSV = implode(',', $usuarioArray);
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

}

?>