<?php

require_once "AccesoDatos.php";

class Ventas
{

    public $numero_pedido;
    public $fecha;
    public $usuario;
    public $sabor_pizza;
    public $tipo_pizza;
    public $cantidad;

    public function __construct() {       
    }

    public function CrearVenta($usuario, $sabor_pizza, $tipo_pizza, $cantidad)
    {
        $this->usuario = $usuario;
        $this->sabor_pizza = $sabor_pizza;
        $this->tipo_pizza = $tipo_pizza;
        $this->cantidad = $cantidad;
        $this->fecha = date("Y-m-d");
    }

    public function InsertarLaVenta()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("INSERT into Ventas (fecha, usuario, sabor_pizza, tipo_pizza, cantidad) values(:fecha, :usuario, :sabor_pizza, :tipo_pizza, :cantidad)");
        $consulta->bindValue(':fecha', $this->fecha, PDO::PARAM_STR);
        $consulta->bindValue(':usuario', $this->usuario, PDO::PARAM_STR);
        $consulta->bindValue(':sabor_pizza', $this->sabor_pizza, PDO::PARAM_STR);
        $consulta->bindValue(':tipo_pizza', $this->tipo_pizza, PDO::PARAM_STR);
        $consulta->bindValue(':cantidad', $this->cantidad, PDO::PARAM_INT);
        $consulta->execute();
        return $objetoAccesoDato->RetornarUltimoIdInsertado();
    }

    public static function TraerTodasLasVentas()
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("SELECT SUM(cantidad) AS Cantidad FROM ventas");
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

    public static function TraerVentasPorSabor($sabor_pizza)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM `ventas` WHERE sabor_pizza=:sabor_pizza");
        $consulta->bindValue(':sabor_pizza', $sabor_pizza, PDO::PARAM_STR);
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function ModificarVenta($numero_pedido, $usuario, $sabor_pizza, $tipo_pizza, $cantidad)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("UPDATE Ventas SET usuario=:usuario, sabor_pizza=:sabor_pizza, tipo_pizza=:tipo_pizza, cantidad=:cantidad WHERE numero_pedido=:numero_pedido");
        $consulta->bindValue(':numero_pedido', $numero_pedido, PDO::PARAM_STR);
        $consulta->bindValue(':usuario', $usuario, PDO::PARAM_STR);
        $consulta->bindValue(':sabor_pizza', $sabor_pizza, PDO::PARAM_STR);
        $consulta->bindValue(':tipo_pizza', $tipo_pizza, PDO::PARAM_STR);
        $consulta->bindValue(':cantidad', $cantidad, PDO::PARAM_INT);
        $consulta->execute();
        return $consulta->rowCount();
    }

    public static function EliminarVenta($numero_pedido)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("DELETE FROM Ventas WHERE numero_pedido=:numero_pedido");
        $consulta->bindValue(':numero_pedido', $numero_pedido, PDO::PARAM_STR);
        $consulta->execute();
        return $consulta->rowCount();
    }
}
