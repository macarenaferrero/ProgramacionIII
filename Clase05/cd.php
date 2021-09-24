<?php

require_once "DataConnection.php";

class Cd
{
    public $id;
    public $titulo;
    public $interprete;
    public $fechaCreacion;

public function __construct() {

}

public static function TraerTodosLosCds()
{
    $accesoBD = AccesoDatos::dameUnObjetoAcceso();
    $query = "select id, titel as titulo, interpret as interprete, jahr as fechaCreacion from cds";
    $consulta = $accesoBD->RetornarConsulta($query);
    $consulta->Execute();

    return $consulta->fetchAll(PDO::FETCH_CLASS, "cd");
}

}

?>