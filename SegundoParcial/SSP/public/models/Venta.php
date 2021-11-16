<?php

use Venta as GlobalUsuario;

require_once './models/Cripto.php';

class Venta
{
    public $idVenta;
    public $fechaVenta;
    public $cantidad;
    public $nombre;
    public $idUsuario;
    public $total;
    public $foto;
    public $nacionalidad;
    public $nombreCliente;

    public function __construct() {
    }

    public function CalcularTotal($nombre, $cantidad)
    {
        $cripto = Cripto::obtenerCriptoxNombre($nombre);
        $total = $cantidad * $cripto->precio;
        return $total;
    }

    public function crearVenta()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO ventaCripto ( cantidad, nombre, idUsuario, total, foto, nacionalidad, nombreCliente) 
        VALUES (:cantidad, :nombre, :idUsuario, :total, :foto, :nacionalidad, :nombreCliente)");
        $venta = new Venta();
        $total = $venta->CalcularTotal($this->nombre, $this->cantidad);
        $consulta->bindValue(':cantidad', $this->cantidad, PDO::PARAM_INT);
        $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':idUsuario', $this->idUsuario, PDO::PARAM_INT);
        $consulta->bindValue(':total', $total, PDO::PARAM_INT);
        $consulta->bindValue(':foto', $this->foto, PDO::PARAM_INT);
        $consulta->bindValue(':nacionalidad', $this->nacionalidad, PDO::PARAM_STR);
        $consulta->bindValue(':nombreCliente', $this->nombreCliente, PDO::PARAM_STR);
        $consulta->execute();

        return $objAccesoDatos->obtenerUltimoId();
    }

    public static function obtenerVentaxNacionalidadFechas($nacionalidad, $fechaInicio, $fechaFin)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM ventaCripto WHERE nacionalidad = :nacionalidad BETWEEN :fechaInicio AND :fechaFin");
        $consulta->bindValue(':nacionalidad', $nacionalidad, PDO::PARAM_INT);
        $consulta->bindValue(':fechaInicio', $fechaInicio, PDO::PARAM_STR);
        $consulta->bindValue(':fechaFin', $fechaFin, PDO::PARAM_STR);
        $consulta->execute();

        return $consulta->fetchObject('Venta');
    }

    public static function obtenerVentaPorNombre($nombre)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM ventaCripto WHERE nombre = :nombre");
        $consulta->bindValue(':nombre', $nombre, PDO::PARAM_STR);
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Venta');
    }

    public static function obtenerTodos()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM ventaCripto");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Venta');
    }

    public static function obtenerVenta($idVenta)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM ventaCripto WHERE idVenta = :idVenta");
        $consulta->bindValue(':idVenta', $idVenta, PDO::PARAM_INT);
        $consulta->execute();

        return $consulta->fetchObject('Venta');
    }

    public static function borrarVenta($idVenta)
    {
        $objAccesoDato = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDato->prepararConsulta("DELETE FROM ventaCripto WHERE idVenta = :idVenta");
        $consulta->bindValue(':idVenta', $idVenta, PDO::PARAM_INT);
        $consulta->execute();
        return $consulta->rowCount();
    }

    
    public static function modificarVenta($idVenta, $cantidad, $tipoUnidad, $nombre, $idUsuario, $total, $clima)
    {
        $objAccesoDato = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDato->prepararConsulta("UPDATE ventaCripto SET cantidad = :cantidad, tipoUnidad = :tipoUnidad, nombre = :nombre, idUsuario = :idUsuario, total = :total, clima = :clima WHERE idVenta = :idVenta");
        $consulta->bindValue(':idVenta', $idVenta, PDO::PARAM_INT);
        $consulta->bindValue(':cantidad', $cantidad, PDO::PARAM_INT);
        $consulta->bindValue(':tipoUnidad', $tipoUnidad, PDO::PARAM_INT);
        $consulta->bindValue(':nombre', $nombre, PDO::PARAM_STR);  
        $consulta->bindValue(':idUsuario', $idUsuario, PDO::PARAM_INT);
        $consulta->bindValue(':total', $total, PDO::PARAM_INT);
        $consulta->bindValue(':clima', $clima, PDO::PARAM_INT);
        $consulta->execute();
        return $consulta->rowCount();
    }

    
}