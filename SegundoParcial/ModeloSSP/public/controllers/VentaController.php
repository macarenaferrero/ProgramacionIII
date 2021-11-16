<?php
require_once './models/venta.php';
require_once './interfaces/IApiUsable.php';

class VentaController extends Venta implements IApiUsable
{
  public function CargarUno($request, $response, $args)
  {
    $parametros = $request->getParsedBody();

    $cantidad = $parametros['cantidad'];
    $nombre = $parametros['nombre'];
    $tipoUnidad = $parametros['tipoUnidad'];
    $idUsuario = $parametros['idUsuario'];
    $clima = $parametros['clima'];
    

    // Creamos la venta
    $venta = new Venta();
    $venta->cantidad = $cantidad;
    $venta->nombre = $nombre;
    $venta->tipoUnidad = $tipoUnidad;
    $venta->idUsuario = $idUsuario;
    $venta->clima = $clima;
    $venta->foto = $_FILES['foto']['name'];
        $path_info = pathinfo($venta->foto, PATHINFO_EXTENSION);
        $destino = './FotosHortalizas/' . $venta->fechaVenta . $venta->nombre . $venta->foto;
        move_uploaded_file($_FILES['foto']['tmp_name'], $destino);
    $venta->crearVenta();

    $payload = json_encode(array("mensaje" => "Venta creada con exito"));

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

  public function TraerTodosPorClimaFecha($request, $response, $args)
  {
    $clima = $args['clima'];
    $fechaVenta = $args['fechaVenta'];
    $lista = Venta::obtenerVentasXClimaYFecha($clima, $fechaVenta);
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
