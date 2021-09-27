<?php

class Usuario
{
    private $nombre;
    private $clave;
    private $mail;
    private $id;
    private $fecha_de_registro;
    private $rutaArchivo;

    public function __construct($nombre, $clave, $mail, $id = 0, $fecha_de_registro = 'empty', $rutaArchivo = 'empty')

    {
        $this->nombre = $nombre;
        $this->clave = $clave;
        $this->mail = $mail;
        $this->rutaArchivo = $rutaArchivo;
        //Operador ternario
        //(condicion) ? (valor si da true) : (valor si da false)
        //$this->id != 0 ? $this->id = $id : $this->id = rand(1,10000);

        if ($this->id != 0) {
            $this->id = $id;
        } else {
            $this->id = rand(1, 10000);
        }

        if ($fecha_de_registro == 'empty') {
            $fecha_de_registro = new DateTime("now");
            $this->fecha_de_registro = $fecha_de_registro->format('d-m-Y');
        } else {
            $this->fecha_de_registro = $fecha_de_registro;
        }
    }

    public function MostrarUsuario()
    {
        echo "Id:" . $this->id . "<br/>";
        echo "Nombre : " . $this->nombre . "<br/>";
        echo "Mail :" . $this->mail . "<br/>";
        echo "Clave:" . $this->clave . "<br/>";
        echo "Fecha de registro:" . $this->fecha_de_registro . "<br/>";
    }

    public function GuardarCSV():bool
    {
        $retorno = false;
        $archivo = fopen("Usuarios.csv", "a+");
        if ($archivo != false) {
            $usuarioArray = array($this->id, $this->nombre, $this->clave, $this->mail, $this->fecha_de_registro);

            $guardarCSV = implode(',', $usuarioArray);
            //$rows = str_getcsv($str, PHP_EOL);
            $guardarCSV = $guardarCSV . "\n";

            if (fwrite($archivo, $guardarCSV) != false) {
                $retorno = true;
            }
            fclose($archivo);
        }
        return $retorno;
    }

    public static function LeerCSV()
    {
        $archivo = fopen("Usuarios.csv", "r");
        $usuariosCargados = array();

        while ($datos = fgetcsv($archivo)) {
            $user = new Usuario($datos[0], $datos[1], $datos[2]);
            array_push($usuariosCargados, $user);
        }

        fclose($archivo);
        return $usuariosCargados;
    }


    public function Equals($user)
    {
        if ($this->mail == $user->mail) {
            $retorno = 0;
            if ($this->clave == $user->clave) {
                $retorno = 1;
            }
        } else {

            $retorno = -1;
        }
        return $retorno;
    }

    public static function ValidarUsuario($u1)
    {
        if ($u1 != null) {
            $userLeido = array();
            $userLeido = self::LeerCSV();

            if ($userLeido != null) {
                foreach ($userLeido as $user) {
                    $retorno = $user->Equals($u1);
                    if ($retorno == 1 || $retorno == 0) {
                        return $retorno;
                    }
                }
                return -1;
            }
        }
    }




    
}
