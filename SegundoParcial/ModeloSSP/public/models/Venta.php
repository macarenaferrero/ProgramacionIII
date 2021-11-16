<?php

use Venta as GlobalUsuario;

require_once './models/Producto.php';

class Venta
{
    public $idVenta;
    public $fechaVenta;
    public $cantidad;
    public $tipoUnidad;
    public $nombre;
    public $idUsuario;
    public $total;
    public $foto;

    public function __construct() {
    }

    public function CalcularTotal($nombre, $cantidad)
    {
        $producto = Producto::obtenerProductoxNombre($nombre);
        $total = $cantidad * $producto->precio;
        return $total;
    }

    public function crearVenta()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO ventaproducto ( cantidad, tipoUnidad, nombre, idUsuario, total, clima, foto) 
        VALUES (:cantidad, :tipoUnidad, :nombre, :idUsuario, :total, :clima, :foto)");
        $venta = new Venta();
        $total = $venta->CalcularTotal($this->nombre, $this->cantidad);
        $consulta->bindValue(':cantidad', $this->cantidad, PDO::PARAM_INT);
        $consulta->bindValue(':tipoUnidad', $this->tipoUnidad, PDO::PARAM_INT);
        $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':idUsuario', $this->idUsuario, PDO::PARAM_INT);
        $consulta->bindValue(':total', $total, PDO::PARAM_INT);
        $consulta->bindValue(':clima', $this->clima, PDO::PARAM_INT);
        $consulta->bindValue(':foto', $this->foto, PDO::PARAM_INT);
        $consulta->execute();

        return $objAccesoDatos->obtenerUltimoId();
    }

    public static function obtenerVentasXClimaYFecha($clima, $fechaVenta)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM ventaProducto WHERE clima = :clima AND fechaVenta = :fechaVenta");
        $consulta->bindValue(':clima', $clima, PDO::PARAM_INT);
        $consulta->bindValue(':fechaVenta', $fechaVenta, PDO::PARAM_STR);
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Venta');
    }

    public static function obtenerVentaPorNombre($nombre)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM ventaProducto WHERE nombre = :nombre");
        $consulta->bindValue(':nombre', $nombre, PDO::PARAM_STR);
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Venta');
    }

    public static function obtenerTodos()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM ventaProducto");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Venta');
    }

    public static function obtenerVenta($idVenta)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM ventaProducto WHERE idVenta = :idVenta");
        $consulta->bindValue(':idVenta', $idVenta, PDO::PARAM_INT);
        $consulta->execute();

        return $consulta->fetchObject('Venta');
    }

    public static function borrarVenta($idVenta)
    {
        $objAccesoDato = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDato->prepararConsulta("DELETE FROM ventaProducto WHERE idVenta = :idVenta");
        $consulta->bindValue(':idVenta', $idVenta, PDO::PARAM_INT);
        $consulta->execute();
        return $consulta->rowCount();
    }

    
    public static function modificarVenta($idVenta, $cantidad, $tipoUnidad, $nombre, $idUsuario, $total, $clima)
    {
        $objAccesoDato = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDato->prepararConsulta("UPDATE ventaProducto SET cantidad = :cantidad, tipoUnidad = :tipoUnidad, nombre = :nombre, idUsuario = :idUsuario, total = :total, clima = :clima WHERE idVenta = :idVenta");
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