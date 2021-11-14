<?php

require_once "AccesoDatos.php";

class Ventas
{

    public $numero_pedido;
    public $fecha;
    public $usuario;
    public $sabor;
    public $tipo;
    public $cantidad;

    public function __construct() {       
    }

    public function CrearVenta($usuario, $sabor, $tipo, $cantidad)
    {        
        $this->numero_pedido = random_int(1,100);
        $this->usuario = $usuario;
        $this->sabor = $sabor;
        $this->tipo = $tipo;
        $this->cantidad = $cantidad;
        $this->fecha = date("Y-m-d");
    }

    public function InsertarLaVenta()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("INSERT into Ventas (numero_pedido, fecha, usuario, sabor, tipo, cantidad) values(:numero_pedido, :fecha, :usuario, :sabor, :tipo, :cantidad)");
        $consulta->bindValue(':numero_pedido', $this->numero_pedido, PDO::PARAM_STR);
        $consulta->bindValue(':fecha', $this->fecha, PDO::PARAM_STR);
        $consulta->bindValue(':usuario', $this->usuario, PDO::PARAM_STR);
        $consulta->bindValue(':sabor', $this->sabor, PDO::PARAM_STR);
        $consulta->bindValue(':tipo', $this->tipo, PDO::PARAM_STR);
        $consulta->bindValue(':cantidad', $this->cantidad, PDO::PARAM_INT);
        $consulta->execute();
        return $objetoAccesoDato->RetornarUltimoIdInsertado();
    }

    public static function TraerTodasLasVentasSegunFecha($fecha)
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("SELECT SUM(cantidad) AS Cantidad FROM ventas WHERE fecha=:fecha");
            $consulta->bindValue(':fecha', $fecha, PDO::PARAM_STR);
			$consulta->execute();			
			return $consulta->fetchAll(PDO::FETCH_ASSOC);		
	}
    

    public static function TraerVentasPorSaborYFechas($fechaUno, $fechaDos)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM `ventas` WHERE fecha BETWEEN :fechaUno AND :fechaDos");
        $consulta->bindValue(':fechaUno', $fechaUno, PDO::PARAM_STR);
        $consulta->bindValue(':fechaDos', $fechaDos, PDO::PARAM_STR);
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_CLASS, "Ventas");
    }

    public static function TraerVentasPorUsuario($user)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM `ventas` WHERE usuario=:usuario");
        $consulta->bindValue(':usuario', $user, PDO::PARAM_STR);
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function BuscarVenta($numero_pedido)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM `ventas` WHERE numero_pedido=:numero_pedido");
        $consulta->bindValue(':numero_pedido', $numero_pedido, PDO::PARAM_STR);
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_CLASS, "Ventas");
    }
    public static function TraerVentasPorSabor($sabor)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM `ventas` WHERE sabor=:sabor");
        $consulta->bindValue(':sabor', $sabor, PDO::PARAM_STR);
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function ModificarVenta($numero_pedido, $usuario, $sabor, $tipo, $cantidad)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("UPDATE Ventas SET usuario=:usuario, sabor=:sabor, tipo=:tipo, cantidad=:cantidad WHERE numero_pedido=:numero_pedido");
        $consulta->bindValue(':numero_pedido', $numero_pedido, PDO::PARAM_STR);
        $consulta->bindValue(':usuario', $usuario, PDO::PARAM_STR);
        $consulta->bindValue(':sabor', $sabor, PDO::PARAM_STR);
        $consulta->bindValue(':tipo', $tipo, PDO::PARAM_STR);
        $consulta->bindValue(':cantidad', $cantidad, PDO::PARAM_INT);
        $consulta->execute();
        return $consulta->rowCount();
    }
    
    public static function BorrarImagen($numero_pedido)
    {
        $dir_origen = 'ImagenesDeLaVenta/';
        $dir_destino = 'BACKUPVENTAS/';
        if (!file_exists($dir_destino)) {
            mkdir($dir_destino, 0777, true);
        }
        $ventaAux = Ventas::BuscarVenta($numero_pedido)[0];
        $nombreArchivo = $ventaAux->tipo ."-" .$ventaAux->sabor."-" .explode("@", $ventaAux->usuario)[0]."-" .$ventaAux->fecha;
        $origen = $dir_origen .$nombreArchivo ."." ."jpg";
        $destino = $dir_destino .$nombreArchivo ."." ."jpg";
        if(rename($origen, $destino))
        {
            echo "Archivo movido correctamente." ."</br>";
        }
        else
        {
            echo "Error al mover el archivo";
        }
    }

    public static function EliminarVenta($numero_pedido)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("DELETE FROM Ventas WHERE numero_pedido=:numero_pedido");
        $consulta->bindValue(':numero_pedido', $numero_pedido, PDO::PARAM_STR);
        $consulta->execute();
        return $consulta->rowCount();
    }

    public static function GuardarDevolucion($arrayDePizzas, $archivo = "devoluciones.json"): bool
    {
        $success = false;
        $file = fopen($archivo, "w");
        if ($file) {
            $json = json_encode($arrayDePizzas, JSON_PRETTY_PRINT);
            fwrite($file, $json);
            $success = true;
            echo "Archivo guardado satisfactoriamente.";
        } else {
            echo "Error al guardar el archivo.";
        }
        fclose($file);
        return $success;
    }

    public static function GenerarCupon($array, $archivo = "cupon.json"): bool
    {
        $success = false;
        $file = fopen($archivo, "w");
        if ($file) {
            $json = json_encode($array, JSON_PRETTY_PRINT);
            fwrite($file, $json);
            $success = true;
            echo "Archivo guardado satisfactoriamente.";
        } else {
            echo "Error al guardar el archivo.";
        }
        fclose($file);
        return $success;
    }


}