<?php


use Cripto as Globalcripto;

class Cripto
{
    public $idCripto;
    public $nombre;
    public $precio;
    public $nacionalidad;
    public $foto;

    public function __construct() {
    }

    public function crearCripto()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO cripto (nombre, precio, nacionalidad, foto) VALUES (:nombre, :precio, :nacionalidad, :foto)");
        $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':precio', $this->precio, PDO::PARAM_INT);
        $consulta->bindValue(':nacionalidad', $this->nacionalidad, PDO::PARAM_STR);
        $consulta->bindValue(':foto', $this->foto, PDO::PARAM_STR);
        $consulta->execute();

        return $objAccesoDatos->obtenerUltimoId();
    }
    public static function obtenerTodos()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM cripto");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Cripto');
    }

    public static function obtenerCripto($idCripto)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM cripto WHERE idCripto = :idCripto");
        $consulta->bindValue(':idCripto', $idCripto, PDO::PARAM_INT);
        $consulta->execute();

        return $consulta->fetchObject('Cripto');
    }

    public static function obtenerCriptoxNacionalidad($nacionalidad)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM cripto WHERE nacionalidad = :nacionalidad");
        $consulta->bindValue(':nacionalidad', $nacionalidad, PDO::PARAM_INT);
        $consulta->execute();

        return $consulta->fetchObject('Cripto');
    }

    

    public static function obtenerCriptoxNombre($nombre)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM cripto WHERE nombre = :nombre");
        $consulta->bindValue(':nombre', $nombre, PDO::PARAM_INT);
        $consulta->execute();

        return $consulta->fetchObject('Cripto');
    }
    public static function borrarCripto($idCripto)
    {
        $objAccesoDato = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDato->prepararConsulta("DELETE FROM cripto WHERE idCripto = :idCripto");
        $consulta->bindValue(':idCripto', $idCripto, PDO::PARAM_INT);
        $consulta->execute();
        return $consulta->rowCount();
    }


    public static function modificarCripto($idCripto, $nombre, $nacionalidad, $precio)
    {
        $objAccesoDato = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDato->prepararConsulta("UPDATE cripto SET nombre = :nombre, precio = :precio, nacionalidad = :nacionalidad WHERE idCripto = :idCripto");
        $consulta->bindValue(':idCripto', $idCripto, PDO::PARAM_INT);
        $consulta->bindValue(':nombre', $nombre, PDO::PARAM_STR);
        $consulta->bindValue(':precio', $precio, PDO::PARAM_INT);
        $consulta->bindValue(':nacionalidad', $nacionalidad, PDO::PARAM_INT);
        $consulta->execute();
        return $consulta->rowCount();
    }
}