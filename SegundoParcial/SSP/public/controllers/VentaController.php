<?php
require_once './models/Venta.php';
require_once './interfaces/IApiUsable.php';

class VentaController extends Venta implements IApiUsable
{
  public function CargarUno($request, $response, $args)
  {
    $parametros = $request->getParsedBody();

    $cantidad = $parametros['cantidad'];
    $nombre = $parametros['nombre'];
    $idUsuario = $parametros['idUsuario'];    
    $nacionalidad = $parametros['nacionalidad'];    
    $nombreCliente = $parametros['nombreCliente'];    

    // Creamos la venta
    $venta = new Venta();
    $venta->cantidad = $cantidad;
    $venta->nombre = $nombre;
    $venta->idUsuario = $idUsuario;
    $venta->nacionalidad = $nacionalidad;
    $venta->nombreCliente = $nombreCliente;
    
        $dir_subida = 'FotosCripto/';
        if (!file_exists($dir_subida)) {
            mkdir($dir_subida, 0777, true);
        }
        $extension = explode(".",$_FILES["archivo"]["name"])[1];
        $nombreArchivo = $venta->nombre ."-" .$venta->idUsuario."-" .$venta->fechaVenta;
        $destino = $dir_subida .$nombreArchivo ."." .$extension;
        if(move_uploaded_file($_FILES["archivo"]["tmp_name"],$destino)){
          echo "Cargado correctamente";
      }
      else {
          var_dump($_FILES["archivo"]["name"]);
    }
    $venta->crearVenta();

    $payload = json_encode(array("mensaje" => "Venta creada con exito"));

    $response->getBody()->write($payload);
    return $response
      ->withHeader('Content-Type', 'application/json');
  }

  
  public function TraerUnoPorNacionalidadFechas($request, $response, $args)
  {
    // Buscamos venta 
    $nacionalidad = $args['nacionalidad'];
    $fechaInicio = $args['fechaInicio'];
    $fechaFin = $args['fechaFin'];
    $venta = Venta::obtenerVentaxNacionalidadFechas($nacionalidad,$fechaInicio, $fechaFin);
    $payload = json_encode($venta); 

    $response->getBody()->write($payload);
    return $response
      ->withHeader('Content-Type', 'application/json');
  }

  public function TraerUno($request, $response, $args)
  {
    // Buscamos venta por idVenta
    $idVenta = $args['idVenta'];
    $venta = Venta::obtenerVenta($idVenta);
    $payload = json_encode($venta);

    $response->getBody()->write($payload);
    return $response
      ->withHeader('Content-Type', 'application/json');
  }

  public function TraerTodos($request, $response, $args)
  {
    $lista = Venta::obtenerTodos();
    $payload = json_encode(array("listaVentas" => $lista));

    $response->getBody()->write($payload);
    return $response
      ->withHeader('Content-Type', 'application/json');
  }
  public function TraerTodosPorNombre($request, $response, $args)
  {
    $nombre = $args['nombre'];
    $lista = Venta::obtenerVentaPorNombre($nombre);
    $payload = json_encode(array("listaVentas" => $lista));

    $response->getBody()->write($payload);
    return $response
      ->withHeader('Content-Type', 'application/json');
  }

  public function ModificarUno($request, $response, $args)
  {
    $parametros = $request->getParsedBody();
    $idVenta = $parametros['idVenta'];
    $cantidad = $parametros['cantidad'];
    $tipoUnidad = $parametros['tipoUnidad'];
    $nombre = $parametros['nombre'];
    $idUsuario = $parametros['idUsuario'];
    $total = $parametros['total'];
    $clima = $parametros['clima'];

    $venta = new Venta();
    $venta->idVenta = $idVenta;
    $venta->cantidad = $cantidad;
    $venta->tipoUnidad = $tipoUnidad;
    $venta->nombre = $nombre;
    $venta->idUsuario = $idUsuario;
    $venta->total = $total;
    $venta->clima = $clima;

    $respuesta = Venta::modificarventa($venta->idVenta, $venta->cantidad, $venta->tipoUnidad, $venta->nombre, $venta->idUsuario, $venta->total, $venta->clima);
    if ($respuesta != 0) {
      $payload = json_encode(array("mensaje" => "Venta modificada con exito"));
    } else {
      $payload = json_encode(array("mensaje" => "Error al modificar la venta"));
    }
    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');
  }

  public function BorrarUno($request, $response, $args)
  {
    $parametros = $request->getParsedBody();

    $idVenta = $parametros['idVenta'];
    $respuesta = Venta::borrarVenta($idVenta);
    if($respuesta > 0)
    {
      $payload = json_encode(array("mensaje" => "Venta borrada con exito"));
    }
    else {
      $payload = json_encode(array("mensaje" => "Error al borrar la venta"));
    }
    $response->getBody()->write($payload);
    return $response
      ->withHeader('Content-Type', 'application/json');
  }
}
