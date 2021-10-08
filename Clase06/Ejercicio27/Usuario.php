<?php

class Usuario
{
    private $nombre;
    private $apellido;
    private $clave;
    private $mail;
    private $localidad;
    private $fecha_de_registro;
    //private $rutaArchivo;

    public function __construct($nombre, $apellido, $clave, $mail, $localidad, $fecha_de_registro = 'empty')

    {
        $this->nombre = $nombre;
        $this->clave = $clave;
        $this->mail = $mail;
        $this->apellido = $apellido;
        $this->localidad = $localidad;
        if ($fecha_de_registro == 'empty') {
            $fecha_de_registro = new DateTime("now");
            $this->fecha_de_registro = $fecha_de_registro->format('d-m-Y');
        } else {
            $this->fecha_de_registro = $fecha_de_registro;
        }
    }

    public function MostrarUsuario()
    {
        echo "Nombre : " . $this->nombre . "<br/>";
        echo "Apellido : " . $this->apellido . "<br/>";
        echo "Mail :" . $this->mail . "<br/>";
        echo "Clave:" . $this->clave . "<br/>";
        echo "Localidad:" . $this->localidad . "<br/>";
        echo "Fecha de registro:" . $this->fecha_de_registro . "<br/>";
    }

    public function GuardarCSV(): bool
    {
        $retorno = false;
        $archivo = fopen("Usuarios.csv", "a+");
        if ($archivo != false) {
            $usuarioArray = array($this->nombre, $this->apellido, $this->clave, $this->mail, $this->localidad, $this->fecha_de_registro);

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
            $user = new Usuario($datos[0], $datos[1], $datos[2], $datos[3], $datos[4]);
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

    public function GuardarEnJson($filename = "usuarios.json"): bool
    {
        $success = false;
        $file = fopen($filename, "a+");
        if ($file) {
            $json = json_encode($this);
            fwrite($file, $json);
            $success = true;
            fclose($file);
        }
        return $success;
    }

    public static function LeerEnJson($filename = "usuarios.json"): bool
    {
        $success = false;
        $users = array();
        $file = fopen($filename, "r");
        if ($file) {
            $json = fread($file, filesize($filename));
            $users = json_decode($json);
            $success = true;
        }
        fclose($file);
        return $success;
    }

    public static function GuardarenBD()
    {
        $accesoBD = AccesoDatos::dameUnObjetoAcceso();
        $query = "INSERT INTO usuarios (nombre, apellido, clave, mail, localidad, fechaCreacion) VALUES (:nombre, :apellido, :clave, :mail, :localidad,:fechaCreacion)";
        $consulta = $accesoBD->RetornarConsulta($query);
        $consulta->bindValue(':nombre');
        if ($consulta != null)
            $consulta->Execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, "Usuario");
    }
}

/*
 public function InsertarElCdParametros()
	 {
				$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
				$consulta =$objetoAccesoDato->RetornarConsulta("INSERT into cds (titel,interpret,jahr)values(:titulo,:cantante,:anio)");
				$consulta->bindValue(':titulo',$this->titulo, PDO::PARAM_INT);
				$consulta->bindValue(':anio', $this->año, PDO::PARAM_STR);
				$consulta->bindValue(':cantante', $this->cantante, PDO::PARAM_STR);
				$consulta->execute();		
				return $objetoAccesoDato->RetornarUltimoIdInsertado();
	 }
*/