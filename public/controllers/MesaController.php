<?php
require_once './models/Mesa.php';
require_once './interfaces/IApiUsable.php';

class MesaController extends Mesa implements IApiUsable
{
  public function CargarUno($request, $response, $args)
  {
    $parametros = $request->getParsedBody();

    $idUsuario = $parametros['idUsuario'];

    // Creamos la mesa
    $mesa = new Mesa();
    $mesa->idUsuario = $idUsuario;
    $mesa->crearMesa();

    $payload = json_encode(array("mensaje" => "Mesa creada con exito"));

    $response->getBody()->write($payload);
    return $response
      ->withHeader('Content-Type', 'application/json');
  }

  public function TraerUno($request, $response, $args)
  {
    // Buscamos Mesa por idMesa
    $idMesa = $args['idMesa'];
    $mesa = Mesa::obtenerMesa($idMesa);
    if($mesa != null)
    {
      $payload = json_encode($mesa);
    }
    else {
      $payload = "Mesa no encontrada";
    }

    $response->getBody()->write($payload);
    return $response
      ->withHeader('Content-Type', 'application/json');
  }

  public function TraerTodos($request, $response, $args)
  {
    $lista = Mesa::obtenerTodos();
    $payload = json_encode(array("listaDeMesas" => $lista));

    $response->getBody()->write($payload);
    return $response
      ->withHeader('Content-Type', 'application/json');
  }

  public function CerrarMesaPorId($request, $response, $args)
  {
    $parametros = $request->getParsedBody();
    $idMesa = $parametros['idMesa'];

    $mesa = new Mesa();
    $mesa->idMesa = $idMesa;

    $respuesta = Mesa::CerrarMesa($mesa->idMesa);
    if ($respuesta != 0) {
      $payload = json_encode(array("mensaje" => "Mesa cerrada con exito."));
    } else {
      $payload = json_encode(array("mensaje" => "Error al modificar la mesa."));
    }
    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');
  }

  public function ModificarUno($request, $response, $args)
  {
    $parametros = $request->getParsedBody();
    $idMesa = $parametros['idMesa'];
    $estado = $parametros['estado'];

    $mesa = new Mesa();
    $mesa->idMesa = $idMesa;
    $mesa->estado = $estado;

    $respuesta = Mesa::modificarEstadoMesa($mesa->idMesa, $mesa->estado);
    if ($respuesta != 0) {
      $payload = json_encode(array("mensaje" => "Se cambio el estado con exito."));
    } else {
      $payload = json_encode(array("mensaje" => "Error al modificar el estado de la mesa."));
    }
    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');
  }

  public function BorrarUno($request, $response, $args)
  {
    $parametros = $request->getParsedBody();

    $idMesa = $parametros['idMesa'];
    $respuesta = Mesa::borrarMesa($idMesa);
    if($respuesta > 0)
    {
      $payload = json_encode(array("mensaje" => "Mesa borrada con exito."));
    }else {
      $payload = json_encode(array("mensaje" => "Error al borrar la mesa."));
    }
    $response->getBody()->write($payload);
    return $response
      ->withHeader('Content-Type', 'application/json');
  }

}
