<?php
require_once './models/Usuario.php';
require_once './interfaces/IApiUsable.php';

class UsuarioController extends Usuario implements IApiUsable
{
  public function CargarUno($request, $response, $args)
  {
    $parametros = $request->getParsedBody();

    $mail = $parametros['mail'];
    $clave = $parametros['clave'];
    $tipo = $parametros['tipo'];

    // Creamos el usuario
    $usr = new Usuario();
    $usr->mail = $mail;
    $usr->clave = $clave;
    $usr->tipo = $tipo;
    $usr->crearUsuario();

    $payload = json_encode(array("mensaje" => "Usuario creado con exito"));

    $response->getBody()->write($payload);
    return $response
      ->withHeader('Content-Type', 'application/json');
  }

  public function TraerUno($request, $response, $args)
  {
    // Buscamos usuario por idUsuario
    $usr = $args['idUsuario'];
    $usuario = Usuario::obtenerUsuario($usr);
    $payload = json_encode($usuario);

    $response->getBody()->write($payload);
    return $response
      ->withHeader('Content-Type', 'application/json');
  }

  public function TraerTodos($request, $response, $args)
  {
    $lista = Usuario::obtenerTodos();
    $payload = json_encode(array("listaUsuario" => $lista));

    $response->getBody()->write($payload);
    return $response
      ->withHeader('Content-Type', 'application/json');
  }

  public function ModificarUno($request, $response, $args)
  {
    $parametros = $request->getParsedBody();
    $idUsuario = $parametros['idUsuario'];
    $mail = $parametros['mail'];
    $clave = $parametros['clave'];
    $tipo = $parametros['tipo'];

    $usr = new Usuario();
    $usr->mail = $mail;
    $usr->idUsuario = $idUsuario;
    $usr->clave = $clave;
    $usr->tipo = $tipo;
    $respuesta = Usuario::modificarUsuario($usr->idUsuario, $usr->mail, $usr->clave, $usr->tipo);
    if ($respuesta != 0) {
      $payload = json_encode(array("mensaje" => "Usuario modificado con exito."));
    } else {
      $payload = json_encode(array("mensaje" => "Error al modificar el usuario."));
    }
    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');
  }

  public function BorrarUno($request, $response, $args)
  {
    $parametros = $request->getParsedBody();

    $idUsuario = $parametros['idUsuario'];
    $respuesta = Usuario::BorrarUsuario($idUsuario);
    if($respuesta > 0)
    {
      $payload = json_encode(array("mensaje" => "Usuario borrado con exito."));
    }else {
      $payload = json_encode(array("mensaje" => "Error al borrar el usuario."));
    }
    $response->getBody()->write($payload);
    return $response
      ->withHeader('Content-Type', 'application/json');
  }  
}
