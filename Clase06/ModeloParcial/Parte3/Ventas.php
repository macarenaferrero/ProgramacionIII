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
			$consulta =$objetoAccesoDato->RetornarConsulta("SELECT SUM(cantidad) FROM ventas");
			$consulta->execute();			
			return $consulta->fetchAll(PDO::FETCH_ASSOC);		
	}
    

    public static function TraerVentasPorSaborYFechas()
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("SELECT * FROM `ventas` WHERE fecha BETWEEN '2021-10-1' AND '2021-10-30' ORDER BY sabor_pizza ASC");
			$consulta->execute();			
			return $consulta->fetchAll(PDO::FETCH_ASSOC);		
	}

    public static function TraerVentasPorUsuario()
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("SELECT * FROM `ventas` WHERE usuario='rober@gmail.com'");
			$consulta->execute();			
			return $consulta->fetchAll(PDO::FETCH_ASSOC);		
	}

    public static function TraerVentasPorSabor()
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("SELECT * FROM `ventas` WHERE sabor_pizza='jamon y morron'");
			$consulta->execute();			
			return $consulta->fetchAll(PDO::FETCH_ASSOC);		
	}
}
