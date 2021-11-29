<?php
require_once './models/Producto.php';
require_once './interfaces/IApiUsable.php';

class ProductoController extends Producto implements IApiUsable
{
  public function CargarUno($request, $response, $args)
  {
    $parametros = $request->getParsedBody();

    $descripcion = $parametros['descripcion'];
    $idSector = $parametros['idSector'];
    $precio = $parametros['precio'];
    $demoraProducto = $parametros['demoraProducto'];
    $orden = $parametros['orden'];

    // Creamos el producto
    $producto = new Producto();
    $producto->descripcion = $descripcion;
    $producto->idSector = $idSector;
    $producto->precio = $precio;
    $producto->demoraProducto = $demoraProducto;
    $producto->orden = $orden;
    $producto->crearProducto();

    $payload = json_encode(array("mensaje" => "Producto creado con exito"));

    $response->getBody()->write($payload);
    return $response
      ->withHeader('Content-Type', 'application/json');
  }

  public function TraerUno($request, $response, $args)
  {
    // Buscamos producto por idProducto
    $idProducto = $args['idProducto'];
    $producto = Producto::obtenerProducto($idProducto);
    $payload = json_encode($producto);

    $response->getBody()->write($payload);
    return $response
      ->withHeader('Content-Type', 'application/json');
  }

  public function TraerTodos($request, $response, $args)
  {
    $lista = producto::obtenerTodos();
    $payload = json_encode(array("listaProductos" => $lista));

    $response->getBody()->write($payload);
    return $response
      ->withHeader('Content-Type', 'application/json');
  }

  public function ModificarUno($request, $response, $args)
  {
    $parametros = $request->getParsedBody();
    $idProducto = $parametros['idProducto'];
    $descripcion = $parametros['descripcion'];
    $precio = $parametros['precio'];
    $idSector = $parametros['idSector'];
    $demoraProducto = $parametros['demoraProducto'];

    $producto = new Producto();
    $producto->idProducto = $idProducto;
    $producto->descripcion = $descripcion;
    $producto->precio = $precio;
    $producto->idSector = $idSector;
    $producto->demoraProducto = $demoraProducto;
    $respuesta = Producto::modificarProducto($producto->idProducto, $producto->descripcion, $producto->precio, $producto->idSector, $producto->demoraProducto);
    if ($respuesta != 0) {
      $payload = json_encode(array("mensaje" => "Producto modificado con exito"));
    } else {
      $payload = json_encode(array("mensaje" => "Error al modificar el producto"));
    }
    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');
  }

  public function FinalizarProducto($request, $response, $args)
  {
    $idProducto = $args['idProducto'];

    $producto = new Producto();
    $producto->idProducto = $idProducto;
    $respuesta = Producto::TerminarProducto($producto->idProducto, 2);
    if ($respuesta != 0) {
      $payload = json_encode(array("mensaje" => "Producto terminado con exito"));
    } else {
      $payload = json_encode(array("mensaje" => "Error al terminar el producto"));
    }
    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');
  }

  public function TraerProductosPorSector($request, $response, $args)
  {
    $idSector = $args['idSector'];
    $lista = Producto::obtenerProductosXSector($idSector);
    $payload = json_encode(array("listaPedidos" => $lista));

    $response->getBody()->write($payload);
    return $response
      ->withHeader('Content-Type', 'application/json');
  }

  public function BorrarUno($request, $response, $args)
  {
    $parametros = $request->getParsedBody();

    $idProducto = $parametros['idProducto'];
    $respuesta = Producto::borrarProducto($idProducto);
    if($respuesta > 0)
    {
      $payload = json_encode(array("mensaje" => "Producto borrado con exito"));
    }
    else {
      $payload = json_encode(array("mensaje" => "Error al borrar el producto"));
    }
    $response->getBody()->write($payload);
    return $response
      ->withHeader('Content-Type', 'application/json');
  }

  public function TraerPendientes($request, $response, $args)
  {
    $parametros = $request->getParsedBody();
    $idSector = $parametros['idSector'];
    $lista = Producto::obtenerPendientes($idSector);
    $payload = json_encode(array("listaPedidos" => $lista));

    $response->getBody()->write($payload);
    return $response
      ->withHeader('Content-Type', 'application/json');
  }
}
