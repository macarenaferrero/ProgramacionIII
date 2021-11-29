<?php

use Pedido as GlobalUsuario;

class Pedido
{
    public $idPedido;
    public $fechaIngreso;
    public $estado;
    public $nombre_cliente;
    public $idMesa;
    public $idUsuario;
    public $precio;
    public $fotoMesa;
    public $demoraPedido;
    

    public function __construct() {
    }

    public function crearPedido()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO pedidos (nombre_cliente, idMesa, idUsuario, fotoMesa) VALUES (:nombre_cliente, :idMesa, :idUsuario, :fotoMesa)");
        $consulta->bindValue(':nombre_cliente', $this->nombre_cliente, PDO::PARAM_STR);
        $consulta->bindValue(':idMesa', $this->idMesa, PDO::PARAM_INT);
        $consulta->bindValue(':idUsuario', $this->idUsuario, PDO::PARAM_INT);
        $consulta->bindValue(':fotoMesa', $this->fotoMesa, PDO::PARAM_STR);
        $consulta->execute();

        return $objAccesoDatos->obtenerUltimoId();
    }

    public static function obtenerTodos()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM pedidos");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Pedido');
    }

    public static function obtenerPedido($idPedido)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM pedidos WHERE idPedido = :idPedido");
        $consulta->bindValue(':idPedido', $idPedido, PDO::PARAM_INT);
        $consulta->execute();

        return $consulta->fetchObject('Pedido');
    }

    public static function servirPedido($idPedido, $estado)
    {
        $objAccesoDato = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDato->prepararConsulta("UPDATE pedidos SET estado = :estado WHERE idPedido = :idPedido");
        $consulta->bindValue(':idPedido', $idPedido, PDO::PARAM_INT);
        $consulta->bindValue(':estado', $estado, PDO::PARAM_INT);
        $consulta->execute();
        return $consulta->rowCount();
    }

    public static function CalcularPedido($orden)
    {
        $productos = Producto::obtenerOrden($orden);
        $total = 0;

        foreach ($productos as $producto) {
            $total += intval($producto->precio);
        }
        return $total;
    }

    public static function CalcularDemora($orden)
    {
        $productos = Producto::obtenerOrden($orden);
        $demora = 0;
        for ($i=0; $i < count($productos) ; $i++) { 
            if($productos[$i]->demoraProducto > $demora){
                $demora = $productos[$i]->demoraProducto;
            }
        }
        return $demora;
    }

    public static function modificarDemorayCostoPedido($idPedido)
    {
        $objAccesoDato = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDato->prepararConsulta("UPDATE pedidos SET estado = :estado, demoraPedido = :demoraPedido, precio = :precio WHERE idPedido = :idPedido");
        $total = Pedido::CalcularPedido($idPedido);
        $demoraPedido = Pedido::CalcularDemora($idPedido);
        $consulta->bindValue(':idPedido', $idPedido, PDO::PARAM_INT);
        $consulta->bindValue(':estado', 2, PDO::PARAM_INT);
        $consulta->bindValue(':demoraPedido', $demoraPedido, PDO::PARAM_STR);
        $consulta->bindValue(':precio', $total, PDO::PARAM_INT);
        $consulta->execute();
        return $consulta->rowCount();
    }
    
    public static function modificarPedido($idPedido, $fechaIngreso, $estado, $nombre_cliente, $idMesa, $idUsuario, $precio, $fotoMesa, $demoraPedido)
    {
        $objAccesoDato = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDato->prepararConsulta("UPDATE pedidos SET fechaIngreso = :fechaIngreso, estado = :estado, nombre_cliente = :nombre_cliente, idMesa = :idMesa, idUsuario = :idUsuario, precio = :precio, fotoMesa = :fotoMesa, demoraPedido = :demoraPedido WHERE idPedido = :idPedido");
        $consulta->bindValue(':idPedido', $idPedido, PDO::PARAM_INT);
        $consulta->bindValue(':fechaIngreso', $fechaIngreso, PDO::PARAM_STR);
        $consulta->bindValue(':estado', $estado, PDO::PARAM_INT);
        $consulta->bindValue(':nombre_cliente', $nombre_cliente, PDO::PARAM_STR);  
        $consulta->bindValue(':idMesa', $idMesa, PDO::PARAM_INT);
        $consulta->bindValue(':idUsuario', $idUsuario, PDO::PARAM_INT);
        $consulta->bindValue(':precio', $precio, PDO::PARAM_INT);
        $consulta->bindValue(':fotoMesa', $fotoMesa, PDO::PARAM_STR);
        $consulta->bindValue(':demoraPedido', $demoraPedido, PDO::PARAM_STR);
        $consulta->execute();
        return $consulta->rowCount();
    }

    public static function borrarPedido($idPedido)
    {
        $objAccesoDato = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDato->prepararConsulta("DELETE FROM pedidos WHERE idPedido = :idPedido");
        $consulta->bindValue(':idPedido', $idPedido, PDO::PARAM_INT);
        $consulta->execute();
        return $consulta->rowCount();
    }

    
}