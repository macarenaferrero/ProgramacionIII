<?php
require_once './models/Cripto.php';
require_once './interfaces/IApiUsable.php';

class CriptoController extends Cripto implements IApiUsable
{
  public function CargarUno($request, $response, $args)
  {
    $parametros = $request->getParsedBody();

    $precio = $parametros['precio'];
    $nombre = $parametros['nombre'];
    $nacionalidad = $parametros['nacionalidad'];
        

    // Creamos el cripto
    $cripto = new Cripto();
    $cripto->precio = $precio;
    $cripto->nombre = $nombre;
    $cripto->nacionalidad = $nacionalidad;

    $foto = $request->getUploadedFiles();
        if (array_key_exists("foto", $foto)) {
            $cripto->foto = $_FILES['foto']['tmp_name'];
        }
    $cripto->crearCripto();

    $payload = json_encode(array("mensaje" => "Cripto creado con exito"));

    $response->getBody()->write($payload);
    return $response
      ->withHeader('Content-Type', 'application/json');
  }

  public function TraerUnoPorNacionalidad($request, $response, $args)
  {
    // Buscamos cripto por idCripto
    $nacionalidad = $args['nacionalidad'];
    $cripto = Cripto::obtenerCriptoxNacionalidad($nacionalidad);
    $payload = json_encode($cripto);

    $response->getBody()->write($payload);
    return $response
      ->withHeader('Content-Type', 'application/json');
  }

  


  public function TraerUno($request, $response, $args)
  {
    // Buscamos cripto por idCripto
    $cripto = $args['idCripto'];
    $cripto = Cripto::obtenerCripto($cripto);
    $payload = json_encode($cripto);

    $response->getBody()->write($payload);
    return $response
      ->withHeader('Content-Type', 'application/json');
  }




  public function TraerTodos($request, $response, $args)
  {
    $lista = Cripto::obtenerTodos();
    $payload = json_encode(array("listaCriptos" => $lista));

    $response->getBody()->write($payload);
    return $response
      ->withHeader('Content-Type', 'application/json');
  }

  public function ModificarUno($request, $response, $args)
  {
    $parametros = $request->getParsedBody();

    $idCripto = $parametros['idCripto'];
    $nombre = $parametros['nombre'];
    $precio = $parametros['precio'];
    $nacionalidad = $parametros['nacionalidad'];


    $cripto = new Cripto();
    $cripto->idCripto = $idCripto;
    $cripto->nombre = $nombre;
    $cripto->precio = $precio;
    $cripto->nacionalidad = $nacionalidad;
    $datos = Cripto::obtenerCripto($cripto->idCripto);
    $respuesta = Cripto::modificarCripto($cripto->idCripto, $cripto->nombre, $cripto->precio, $cripto->nacionalidad);
    
    $dir_origen = 'FotosCripto/';
        $dir_destino = 'BACKUP/';
        if (!file_exists($dir_destino)) {
            mkdir($dir_destino, 0777, true);
        }
        $nombreArchivo = $cripto->nombre ."-" .$cripto->nacionalidad."-";
        $origen = $dir_origen .$nombreArchivo ."." ."jpg";
        $destino = $dir_destino .$nombreArchivo ."." ."jpg";
        if(rename($origen, $destino))
        {
            echo "Archivo movido correctamente." ."</br>";
        }
        else
        {
            echo "Error al mover el archivo";
        }
  
    
    if ($respuesta != 0) {
      $payload = json_encode(array("mensaje" => "Cripto modificado con exito."));
    } else {
      $payload = json_encode(array("mensaje" => "Error al modificar el cripto."));
    }
    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');
  }


  public function BorrarUno($request, $response, $args)
  {
    $parametros = $request->getParsedBody();
    $idCripto = $parametros['idCripto'];
    $respuesta = Cripto::borrarCripto($idCripto);
    if($respuesta > 0)
    {
      $payload = json_encode(array("mensaje" => "Cripto borrado con exito."));
    }else {
      $payload = json_encode(array("mensaje" => "Error al borrar el cripto."));
    }
    $response->getBody()->write($payload);
    return $response
      ->withHeader('Content-Type', 'application/json');
  }  
}
