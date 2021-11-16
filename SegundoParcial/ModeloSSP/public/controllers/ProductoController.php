<?php
require_once './models/Producto.php';
require_once './interfaces/IApiUsable.php';

class ProductoController extends Producto implements IApiUsable
{
  public function CargarUno($request, $response, $args)
  {
    $parametros = $request->getParsedBody();

    $precio = $parametros['precio'];
    $nombre = $parametros['nombre'];
    $clima = $parametros['clima'];
    $tipoUnidad = $parametros['tipoUnidad'];

    // Creamos el producto
    $producto = new Producto();
    $producto->precio = $precio;
    $producto->nombre = $nombre;
    $producto->clima = $clima;
    $producto->tipoUnidad = $tipoUnidad;

    $archivo = $request->getUploadedFiles();
        if (array_key_exists("foto", $archivo)) {
            $producto->foto = $_FILES['foto']['tmp_name'];
        }
    $producto->crearProducto();

    $payload = json_encode(array("mensaje" => "Producto creado con exito"));

    $response->getBody()->write($payload);
    return $response
      ->withHeader('Content-Type', 'application/json');
  }

  public function TraerUno($request, $response, $args)
  {
    // Buscamos producto por idProducto
    $producto = $args['idProducto'];
    $producto = Producto::obtenerProducto($producto);
    $payload = json_encode($producto);

    $response->getBody()->write($payload);
    return $response
      ->withHeader('Content-Type', 'application/json');
  }

  public function TraerTodos($request, $response, $args)
  {
    $lista = Producto::obtenerTodos();
    $payload = json_encode(array("listaProductos" => $lista));

    $response->getBody()->write($payload);
    return $response
      ->withHeader('Content-Type', 'application/json');
  }


  public function TraerProductosxClima($request, $response, $args)
  {    
    $clima = $args['clima'];
    $lista = Producto::obtenerProductoPorClima($clima);
    $payload = json_encode(array("listaProductos" => $lista));

    $response->getBody()->write($payload);
    return $response
      ->withHeader('Content-Type', 'application/json');
  }

  public function TraerProductosxUnidad($request, $response, $args)
  {
    $tipoUnidad = $args['tipoUnidad'];
    $lista = Producto::obtenerProductoPorUnidad($tipoUnidad);
    $payload = json_encode(array("listaProductos" => $lista));

    $response->getBody()->write($payload);
    return $response
      ->withHeader('Content-Type', 'application/json');
  }

  public function ModificarUno($request, $response, $args)
  {
    $parametros = $request->getParsedBody();

    $idProducto = $parametros['idProducto'];
    $nombre = $parametros['nombre'];
    $clima = $parametros['clima'];
    $precio = $parametros['precio'];
    $tipoUnidad = $parametros['tipoUnidad'];


    $producto = new Producto();
    $producto->idProducto = $idProducto;
    $producto->nombre = $nombre;
    $producto->clima = $clima;
    $producto->precio = $precio;
    $producto->tipoUnidad = $tipoUnidad;
    $datos = Producto::obtenerProducto($producto->idProducto);
    $respuesta = Producto::modificarProducto($producto->idProducto, $producto->nombre, $producto->clima, $producto->precio, $producto->tipoUnidad);
    
    $archivo = $request->getUploadedFiles();

    if (array_key_exists('foto', $archivo)) {
      if (file_exists($_FILES['foto']['tmp_name'])) {
          $destino = './Backup/' . $datos->foto;
          move_uploaded_file($_FILES['foto']['tmp_name'], $destino);
      } else {
          $datos->foto = $_FILES['foto']['name'];
      }
  }
    
    if ($respuesta != 0) {
      $payload = json_encode(array("mensaje" => "Producto modificado con exito."));
    } else {
      $payload = json_encode(array("mensaje" => "Error al modificar el producto."));
    }
    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');
  }


  public function BorrarUno($request, $response, $args)
  {
    $parametros = $request->getParsedBody();

    $idProducto = $parametros['idProducto'];
    $respuesta = Producto::borrarProducto($idProducto);
    if($respuesta > 0)
    {
      $payload = json_encode(array("mensaje" => "Producto borrado con exito."));
    }else {
      $payload = json_encode(array("mensaje" => "Error al borrar el producto."));
    }
    $response->getBody()->write($payload);
    return $response
      ->withHeader('Content-Type', 'application/json');
  }  
}
