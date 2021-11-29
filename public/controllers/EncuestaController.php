<?php
require_once './models/encuestas.php';
require_once './interfaces/IApiUsable.php';

class EncuestaController extends Encuesta implements IApiUsable
{
  public function CargarUno($request, $response, $args)
  {
    $parametros = $request->getParsedBody();

    $idPedido = $parametros['idPedido'];
    $valoracionMesa = $parametros['valoracionMesa'];
    $valoracionRestaurant = $parametros['valoracionRestaurant'];
    $valoracionMozo = $parametros['valoracionMozo'];
    $valoracionCocinero = $parametros['valoracionCocinero'];
    $comentarios = $parametros['comentarios'];

    // Creamos la Encuesta
    $encuesta = new Encuesta();
    $encuesta->idPedido = $idPedido;
    $encuesta->valoracionMesa = $valoracionMesa;
    $encuesta->valoracionRestaurant = $valoracionRestaurant;
    $encuesta->valoracionMozo = $valoracionMozo;
    $encuesta->valoracionCocinero = $valoracionCocinero;
    $encuesta->comentarios = $comentarios;
    $encuesta->crearEncuesta();

    $payload = json_encode(array("mensaje" => "Encuesta creada con exito"));

    $response->getBody()->write($payload);
    return $response
      ->withHeader('Content-Type', 'application/json');
  }

  public function TraerUno($request, $response, $args)
  {
    // Buscamos Encuesta por idEncuesta
    $idEncuesta = $args['idEncuesta'];
    $encuesta = Encuesta::obtenerEncuesta($idEncuesta);
    if($encuesta != null)
    {
      $payload = json_encode($encuesta);
    }
    else {
      $payload = "Encuesta no encontrada";
    }

    $response->getBody()->write($payload);
    return $response
      ->withHeader('Content-Type', 'application/json');
  }

  public function TraerMejorEncuesta($request, $response, $args)
  {
    $encuesta = Encuesta::mejorPromedio();
    if($encuesta != null)
    {
      $payload = json_encode($encuesta);
    }
    else {
      $payload = "Encuesta no encontrada";
    }

    $response->getBody()->write($payload);
    return $response
      ->withHeader('Content-Type', 'application/json');
  }

  public function TraerTodos($request, $response, $args)
  {
    $lista = Encuesta::obtenerTodos();
    $payload = json_encode(array("listaDeEncuestas" => $lista));

    $response->getBody()->write($payload);
    return $response
      ->withHeader('Content-Type', 'application/json');
  }

  public function ModificarUno($request, $response, $args)
  {
    $parametros = $request->getParsedBody();
    $idEncuesta = $parametros['idEncuesta'];

    $encuesta = Encuesta::obtenerEncuesta($idEncuesta);

    $respuesta = Encuesta::promediarEncuesta($encuesta->idEncuesta);
    if ($respuesta != 0) {
      $payload = json_encode(array("mensaje" => "Se promedio la encuesta con exito."));
    } else {
      $payload = json_encode(array("mensaje" => "Error al promediar la encuesta."));
    }
    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');
  }

  public function BorrarUno($request, $response, $args)
  {
    $parametros = $request->getParsedBody();

    $idEncuesta = $parametros['idEncuesta'];
    $respuesta = Encuesta::borrarEncuesta($idEncuesta);
    if($respuesta > 0)
    {
      $payload = json_encode(array("mensaje" => "Encuesta borrada con exito."));
    }else {
      $payload = json_encode(array("mensaje" => "Error al borrar la encuesta."));
    }
    $response->getBody()->write($payload);
    return $response
      ->withHeader('Content-Type', 'application/json');
  }
}
