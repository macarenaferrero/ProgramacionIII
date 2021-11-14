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

    public static function BuscarVenta($numero_pedido)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM `ventas` WHERE numero_pedido=:numero_pedido");
        $consulta->bindValue(':numero_pedido', $numero_pedido, PDO::PARAM_STR);
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_CLASS, "Ventas");
    }
    
}