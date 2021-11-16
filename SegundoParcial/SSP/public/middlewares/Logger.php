<?php

use GuzzleHttp\Psr7\Request;
use Slim\Handlers\Strategies\RequestHandler;
use Slim\Psr7\Response;

require_once 'AutentificadorJWT.php';

class Logger
{
    public static function LogOperacion($request, $response, $next)
    {
        $retorno = $next($request, $response);
        return $retorno;
    }


    public static function VerificarCredencial($request, $handler)
    {
        $parametros = $request->getParsedBody();
        $mail = $parametros['mail'];
        $clave = $parametros['clave'];
        $usuario = Usuario::obtenerUsuarioPorUser($mail);

        if ($usuario != null) {
            $ingreso = array('mail' => $mail, 'clave' => $clave, 'tipo' => $usuario->tipo);
            $token = AutentificadorJWT::CrearToken($ingreso);
            $payload = json_encode(array("jwt" => $token, "Ingreso" => " OK. Bienvenido " . $usuario->tipo));
        }else {
            $payload = json_encode(array('error' => 'No existe el usuario'));        
        }
        $response = new Response();
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function EsAdmin($request, $handler)
    {
        $header = $request->getHeaderLine('authorization');
        $response = new Response();
        if (!empty($header)) {
            $token = trim(explode('authorization', $header)[0]);
            $data = AutentificadorJWT::ObtenerData($token);
            if ($data->tipo == "admin") {                
                $response = $handler->handle($request);
            } else {
                $response->getBody()->write(json_encode(array("error" => "Solo los vendedores tienen acceso")));
                $response = $response->withStatus(401);
            }
        } else {
            $response->getBody()->write(json_encode(array("error" => "Falta ingresar el token")));
            $response = $response->withStatus(401);
        }
        return $response->withHeader('Content-Type', 'application/json');
    }





    public function EsClienteoAdmin($request, $handler)
    {
        $header = $request->getHeaderLine('authorization');
        $response = new Response();
        if (!empty($header)) {
            $token = trim(explode("authorization", $header)[0]);
            $data = AutentificadorJWT::ObtenerData($token);
            if ($data->tipo == "admin" || $data->tipo == "cliente") {
                $response = $handler->handle($request);
            } else {
                $response->getBody()->write(json_encode(array("error" => "Solo personal registrado tienen acceso")));
                $response = $response->withStatus(401);
            }
        } else {
            $response->getBody()->write(json_encode(array("error" => "Falta ingresar el token")));
            $response = $response->withStatus(401);
        }
        return $response->withHeader('Content-Type', 'application/json');
    }  
}
