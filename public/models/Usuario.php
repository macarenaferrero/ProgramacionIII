<?php

use Usuario as GlobalUsuario;

class Usuario
{
    public $idUsuario;
    public $usuario;
    public $tipoUsuario;
    public $clave;
    public $fechaIngreso;
    public $fechaBaja;


    public function __construct() {
    }

    public function crearUsuario()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO usuarios (usuario, tipoUsuario, clave, fechaIngreso) VALUES (:usuario, :tipoUsuario, :clave, :fechaIngreso)");
        $claveHash = password_hash($this->clave, PASSWORD_DEFAULT);
        $consulta->bindValue(':usuario', $this->usuario, PDO::PARAM_STR);
        $consulta->bindValue(':tipoUsuario', $this->tipoUsuario, PDO::PARAM_STR);
        $consulta->bindValue(':clave', $claveHash);
        $consulta->bindValue(':fechaIngreso', $this->fechaIngreso, PDO::PARAM_STR);
        $consulta->execute();

        return $objAccesoDatos->obtenerUltimoId();
    }

    public static function crearUsuarioPorArchivo($usuario, $tipoUsuario, $clave, $fechaIngreso, $fechaBaja)
    {
        $usuarioNuevo = new Usuario();
        $usuarioNuevo->usuario = $usuario; 
        $usuarioNuevo->tipoUsuario = $tipoUsuario;        
        $usuarioNuevo->clave = password_hash($clave, PASSWORD_DEFAULT);
        $usuarioNuevo->fechaIngreso = $fechaIngreso;        
        $usuarioNuevo->fechaBaja = $fechaBaja;

        return $usuarioNuevo;
    }

    public static function obtenerTodos()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM usuarios");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Usuario');
    }

    public static function obtenerUsuario($idUsuario)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM usuarios WHERE idUsuario = :idUsuario");
        $consulta->bindValue(':idUsuario', $idUsuario, PDO::PARAM_INT);
        $consulta->execute();

        return $consulta->fetchObject('Usuario');
    }

    public static function obtenerUsuarioPorUser($usuario)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM usuarios WHERE usuario = :usuario");
        $consulta->bindValue(':usuario', $usuario, PDO::PARAM_STR);
        $consulta->execute();
        if($consulta->execute() > 0)
        {
            return $consulta->fetchObject('Usuario');
        }
        else {
            return null;
        }
    }

    public static function modificarUsuario($idUsuario,$usuario, $tipoUsuario, $clave, $fechaIngreso, $fechaBaja)
    {
        $objAccesoDato = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDato->prepararConsulta("UPDATE usuarios SET usuario = :usuario, tipoUsuario = :tipoUsuario, clave = :clave, fechaIngreso = :fechaIngreso, fechaBaja = :fechaBaja WHERE idUsuario = :idUsuario");
        $consulta->bindValue(':idUsuario', $idUsuario, PDO::PARAM_INT);
        $consulta->bindValue(':usuario', $usuario, PDO::PARAM_STR);
        $consulta->bindValue(':tipoUsuario', $tipoUsuario, PDO::PARAM_STR);
        $consulta->bindValue(':clave', $clave, PDO::PARAM_STR);
        $consulta->bindValue(':fechaIngreso', $fechaIngreso, PDO::PARAM_STR);
        $consulta->bindValue(':fechaBaja', $fechaBaja, PDO::PARAM_STR);
        $consulta->execute();
        return $consulta->rowCount();
    }

    public static function suspenderUsuario($idUsuario)
    {
        $objAccesoDato = AccesoDatos::obtenerInstancia();        
        $consulta = $objAccesoDato->prepararConsulta("UPDATE usuarios SET fechaBaja = :fechaBaja WHERE idUsuario = :idUsuario");
        $fecha = new DateTime(date("d-m-Y"));
        $consulta->bindValue(':idUsuario', $idUsuario, PDO::PARAM_INT);
        $consulta->bindValue(':fechaBaja', date_format($fecha, 'Y-m-d H:i:s'));
        $consulta->execute();
        return $consulta->rowCount();
    }

    public static function borrarUsuario($idUsuario)
    {
        $objAccesoDato = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDato->prepararConsulta("DELETE FROM usuarios WHERE idUsuario = :idUsuario");
        $consulta->bindValue(':idUsuario', $idUsuario, PDO::PARAM_INT);
        $consulta->execute();
        return $consulta->rowCount();
    }
}

