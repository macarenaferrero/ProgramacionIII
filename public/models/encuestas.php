<?php

use Encuesta as GlobalMesas;

class Encuesta
{
    public $idEncuesta;
    public $idPedido;
    public $valoracionMesa;
    public $valoracionRestaurant;
    public $valoracionMozo;
    public $valoracionCocinero;
    public $comentarios;
    public $promedioValoracion;

    public function __construct() {
    }

    public function crearEncuesta()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO encuestas (idPedido, valoracionMesa, valoracionRestaurant, valoracionMozo, valoracionCocinero, comentarios) VALUES (:idPedido, :valoracionMesa, :valoracionRestaurant, :valoracionMozo, :valoracionCocinero, :comentarios)");
        $consulta->bindValue(':idPedido', $this->idPedido, PDO::PARAM_INT);
        $consulta->bindValue(':valoracionMesa', $this->valoracionMesa, PDO::PARAM_INT);
        $consulta->bindValue(':valoracionRestaurant', $this->valoracionRestaurant, PDO::PARAM_INT);
        $consulta->bindValue(':valoracionMozo', $this->valoracionMozo, PDO::PARAM_INT);
        $consulta->bindValue(':valoracionCocinero', $this->valoracionCocinero, PDO::PARAM_INT);
        $consulta->bindValue(':comentarios', $this->comentarios, PDO::PARAM_STR);
        $consulta->execute();

        return $objAccesoDatos->obtenerUltimoId();
    }

    public static function obtenerTodos()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM encuestas");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Encuesta');
    }

    public static function obtenerEncuesta($idEncuesta)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM encuestas WHERE idEncuesta = :idEncuesta");
        $consulta->bindValue(':idEncuesta', $idEncuesta, PDO::PARAM_INT);
        $consulta->execute();

        return $consulta->fetchObject('Encuesta');
    }


    public static function CalcularMejorPromedio()
    {
        $encuestas = Encuesta::obtenerTodos();
        $mejorpromedio = 0;
        
        foreach ($encuestas as $encuesta) {
            if($encuesta->promedioValoracion > $mejorpromedio){
                $mejorpromedio = $encuesta->promedioValoracion;
            }
        }
        return $mejorpromedio;
    }
    public static function mejorPromedio()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM encuestas WHERE promedioValoracion = :promedioValoracion");
        $promedioValoracion = Encuesta::CalcularMejorPromedio();
        $consulta->bindValue(':promedioValoracion', $promedioValoracion, PDO::PARAM_STR);
        $consulta->execute();

        return $consulta->fetchObject('Encuesta');
    }

    public static function modificarEncuesta($idEncuesta, $idPedido, $valoracionMesa, $valoracionRestaurant, $valoracionMozo, $valoracionCocinero, $comentarios)
    {
        $objAccesoDato = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDato->prepararConsulta("UPDATE encuestas SET idPedido = :idPedido, valoracionMesa = :valoracionMesa, valoracionRestaurant = :valoracionRestaurant,
        valoracionMozo = :valoracionMozo, valoracionCocinero = :valoracionCocinero, comentarios = :comentarios WHERE idEncuesta = :idEncuesta");
        $consulta->bindValue(':idPedido', $idPedido, PDO::PARAM_INT);
        $consulta->bindValue(':valoracionMesa', $valoracionMesa, PDO::PARAM_INT);
        $consulta->bindValue(':idEncuesta', $idEncuesta, PDO::PARAM_INT);
        $consulta->bindValue(':valoracionRestaurant', $valoracionRestaurant, PDO::PARAM_INT);
        $consulta->bindValue(':valoracionMozo', $valoracionMozo, PDO::PARAM_INT);
        $consulta->bindValue(':valoracionCocinero', $valoracionCocinero, PDO::PARAM_INT);
        $consulta->bindValue(':comentarios', $comentarios, PDO::PARAM_STR);
        $consulta->execute();
        return $consulta->rowCount();
    }

    public static function Promediar($idEncuesta)
    {
        $encuesta = Encuesta::obtenerEncuesta($idEncuesta);
        $promedio = 0;
        if($encuesta != null){
            $promedio = ($encuesta->valoracionMesa + $encuesta->valoracionMozo + $encuesta->valoracionRestaurant + $encuesta->valoracionCocinero)/4;
        }        
        return $promedio;
    }

    public static function promediarEncuesta($idEncuesta)
    {
        $objAccesoDato = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDato->prepararConsulta("UPDATE encuestas SET promedioValoracion = :promedioValoracion WHERE idEncuesta = :idEncuesta");
        $promedioValoracion = Encuesta::Promediar($idEncuesta);
        $consulta->bindValue(':idEncuesta', $idEncuesta, PDO::PARAM_INT);
        $consulta->bindValue(':promedioValoracion', $promedioValoracion, PDO::PARAM_STR);

        $consulta->execute();
        return $consulta->rowCount();
    }

    public static function borrarEncuesta($idEncuesta)
    {
        $objAccesoDato = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDato->prepararConsulta("DELETE FROM encuestas WHERE idEncuesta = :idEncuesta");
        $consulta->bindValue(':idEncuesta', $idEncuesta, PDO::PARAM_INT);
        $consulta->execute();
        return $consulta->rowCount();
    }
}