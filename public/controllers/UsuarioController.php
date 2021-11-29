<?php
require_once './models/Usuario.php';
require_once './interfaces/IApiUsable.php';

class UsuarioController extends Usuario implements IApiUsable
{
  public function CargarUno($request, $response, $args)
  {
    $parametros = $request->getParsedBody();

    $usuario = $parametros['usuario'];
    $tipoUsuario = $parametros['tipoUsuario'];
    $clave = $parametros['clave'];

    // Creamos el usuario
    $usr = new Usuario();
    $usr->usuario = $usuario;
    $usr->tipoUsuario = $tipoUsuario;
    $usr->clave = $clave;
    $usr->fechaIngreso = date("Y-m-d H:i:s");
    $usr->crearUsuario();

    $payload = json_encode(array("mensaje" => "Usuario creado con exito"));

    $response->getBody()->write($payload);
    return $response
      ->withHeader('Content-Type', 'application/json');
  }

  public function TraerUno($request, $response, $args)
  {
    // Buscamos usuario por idUsuario
    $idUsuario = $args['idUsuario'];
    $usuario = Usuario::obtenerUsuario($idUsuario);
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
    $usuario = $parametros['usuario'];
    $tipoUsuario = $parametros['tipoUsuario'];
    $clave = $parametros['clave'];
    $idUsuario = $parametros['idUsuario'];
    $fechaIngreso = $parametros['fechaIngreso'];
    $fechaBaja = $parametros['fechaBaja'];

    $usr = new Usuario();
    $usr->usuario = $usuario;
    $usr->tipoUsuario = $tipoUsuario;
    $usr->clave = $clave;
    $usr->idUsuario = $idUsuario;
    $usr->fechaIngreso = $fechaIngreso;
    $usr->fechaBaja = $fechaBaja;
    $respuesta = Usuario::modificarUsuario($usr->idUsuario, $usr->usuario, $usr->tipoUsuario, $usr->clave, $usr->fechaIngreso, $usr->fechaBaja);
    if ($respuesta != 0) {
      $payload = json_encode(array("mensaje" => "Usuario modificado con exito."));
    } else {
      $payload = json_encode(array("mensaje" => "Error al modificar el usuario."));
    }
    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');
  }

  public function SuspenderUno($request, $response, $args)
  {
    $parametros = $request->getParsedBody();

    $idUsuario = $parametros['idUsuario'];
    $respuesta = Usuario::suspenderUsuario($idUsuario);
    if($respuesta > 0)
    {
      $payload = json_encode(array("mensaje" => "Usuario suspendido con exito."));
    }else {
      $payload = json_encode(array("mensaje" => "Error al suspender el usuario."));
    }
    $response->getBody()->write($payload);
    return $response
      ->withHeader('Content-Type', 'application/json');
  }  

  public function BorrarUno($request, $response, $args)
  {
    $parametros = $request->getParsedBody();

    $idUsuario = $parametros['idUsuario'];
    $respuesta = Usuario::borrarUsuario($idUsuario);
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

  public function GuardarCSV($request, $response, $args)
  {
    $archivo = fopen("ingresoUsuarios.csv", "w");
    $usuarioArray = Usuario::obtenerTodos();
    $usuarioData = "";
    foreach($usuarioArray as $usuario){
      if( $usuario->fechaBaja == null){
        $bajaAux = "null";
      }
      else{
        $bajaAux = $usuario->fechaBaja;
      }
      $usuarioData .= $usuario->usuario . "," . $usuario->tipoUsuario . "," . $usuario->clave . "," . $usuario->fechaIngreso . "," . $bajaAux  . PHP_EOL;
    }
    $respuesta = fwrite($archivo, $usuarioData);
    if($respuesta != false)
    {
      $payload = json_encode(array("mensaje" => "Se ha impreso el registro de los usuarios satisfactoriamente."));
    }
    else {
      $payload = json_encode(array("mensaje" => "Ha ocurrido un problema al intentar guardar el registro del usuario."));
    }
    fclose($archivo);
    $response->getBody()->write($payload);
    return $response
      ->withHeader('Content-Type', 'application/json');
  }

  public function LeerCSV($request, $response, $args)
  {
    $archivo = fopen("ingresoUsuarios.csv", "r");
    $usuariosCargados = array();
            
    while (!feof($archivo)) {
      $linea = fgets($archivo);
      if(!empty($linea)){
        $aux = 1;
        $linea = str_replace(PHP_EOL, "", $linea,$aux);
        $usuariosCarg = explode(",", $linea);
        $user = Usuario::crearUsuarioPorArchivo($usuariosCarg[0],$usuariosCarg[1],$usuariosCarg[2],$usuariosCarg[3],$usuariosCarg[4]);
        array_push($usuariosCargados, $user);
        $user->crearUsuario();
      }
    }
    fclose($archivo);
    if(count($usuariosCargados) > 0){

      $payload = json_encode(array("mensaje" => "Se ha leido el registro de usuarios satisfactoriamente."));
    }
    else{
      $payload = json_encode(array("mensaje" => "Ha ocurrido un problema al intentar guardar el registro de los usuarios."));
    }    
    $response->getBody()->write($payload);
    return $response
      ->withHeader('Content-Type', 'application/json');
  }  
}
