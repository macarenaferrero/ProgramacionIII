<?php
require_once './models/Pedido.php';
require_once './interfaces/IApiUsable.php';

class PedidoController extends Pedido implements IApiUsable
{
  public function CargarUno($request, $response, $args)
  {
    $parametros = $request->getParsedBody();

    $nombre_cliente = $parametros['nombre_cliente'];
    $idMesa = $parametros['idMesa'];
    $idUsuario = $parametros['idUsuario'];

    // Creamos el pedido
    $pedido = new Pedido();
    $pedido->nombre_cliente = $nombre_cliente;
    $pedido->idMesa = $idMesa;
    $pedido->idUsuario = $idUsuario;

    $dir_subida = 'FotosPedidos/';
    if (!file_exists($dir_subida)) {
      mkdir($dir_subida, 0777, true);
    }
    $extension = explode(".", $_FILES["archivo"]["name"])[1];
    $nombreArchivo = $pedido->nombre_cliente . "-mesa" . $pedido->idMesa . "-idUsuario" . $pedido->idUsuario;
    $destino = $dir_subida . $nombreArchivo . "." . $extension;
    if (move_uploaded_file($_FILES["archivo"]["tmp_name"], $destino)) {
      echo "Cargado correctamente";
    } else {
      var_dump($_FILES["archivo"]["name"]);
    }
    $pedido->fotoMesa = $destino;
    $pedido->crearPedido();

    $payload = json_encode(array("mensaje" => "Pedido creado con exito"));

    $response->getBody()->write($payload);
    return $response
      ->withHeader('Content-Type', 'application/json');
  }

  public function TraerUno($request, $response, $args)
  {
    // Buscamos pedido por idPedido
    $idPedido = $args['idPedido'];
    $pedido = Pedido::obtenerPedido($idPedido);
    if ($pedido != null) {
      $payload = json_encode($pedido);
    } else {
      $payload = "Pedido no encontrado";
    }

    $response->getBody()->write($payload);
    return $response
      ->withHeader('Content-Type', 'application/json');
  }

  public function TraerTodos($request, $response, $args)
  {
    $lista = Pedido::obtenerTodos();
    $payload = json_encode(array("listaPedidos" => $lista));

    $response->getBody()->write($payload);
    return $response
      ->withHeader('Content-Type', 'application/json');
  }

  
  public function ModificarUno($request, $response, $args)
  {
    $parametros = $request->getParsedBody();
    $idPedido = $parametros['idPedido'];

    $pedido = Pedido::obtenerPedido($idPedido);
    $mesa = Mesa::obtenerMesa($pedido->idMesa);
    $respuesta = Pedido::servirPedido($pedido->idPedido, 4);
    $productosxOrden = Producto::obtenerOrden($idPedido);

    foreach ($productosxOrden as $producto) {
      Producto::TerminarProducto($producto->idProducto, 3);
    }
    if ($mesa->estado == "con cliente esperando pedido") {
      Mesa::modificarEstadoMesa($mesa->idMesa, 3);
    }
    if ($respuesta != 0) {
      $payload = json_encode(array("mensaje" => "Pedido entregado con exito."));
    } else {
      $payload = json_encode(array("mensaje" => "Error al entregar el pedido."));
    }
    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');
  }

  public function ModificarCostos($request, $response, $args)
  {
    $parametros = $request->getParsedBody();
    $idPedido = $parametros['idPedido'];

    $pedido = Pedido::obtenerPedido($idPedido);
    $mesa = Mesa::obtenerMesa($pedido->idMesa);
    $respuesta = Pedido::modificarDemorayCostoPedido($idPedido);
    if ($mesa->estado == "vacia") {
      Mesa::modificarEstadoMesa($mesa->idMesa, 2);
    }

    if ($respuesta != 0) {
      $payload = json_encode(array("mensaje" => "Pedido modificado con exito."));
    } else {
      $payload = json_encode(array("mensaje" => "Error al modificar el pedido."));
    }
    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');
  }

  public function BorrarUno($request, $response, $args)
  {
    $parametros = $request->getParsedBody();

    $idPedido = $parametros['idPedido'];
    $respuesta = Pedido::borrarPedido($idPedido);
    if ($respuesta > 0) {
      $payload = json_encode(array("mensaje" => "Pedido borrado con exito."));
    } else {
      $payload = json_encode(array("mensaje" => "Error al borrar el pedido."));
    }
    $response->getBody()->write($payload);
    return $response
      ->withHeader('Content-Type', 'application/json');
  }

  public function Cobrar($request, $response, $args)
  {
    $parametros = $request->getParsedBody();
    $idPedido = $parametros['idPedido'];

    $pedido = Pedido::obtenerPedido($idPedido);
    $mesa = Mesa::obtenerMesa($pedido->idMesa);
    $respuesta = Pedido::servirPedido($pedido->idPedido, 5);
    $productosxOrden = Producto::obtenerOrden($idPedido);

    foreach ($productosxOrden as $producto) {
      Producto::TerminarProducto($producto->idProducto, 4);
    }
    if ($mesa->estado == "con cliente comiendo") {
      Mesa::modificarEstadoMesa($mesa->idMesa, 4);
    }
    if ($respuesta != 0) {
      $payload = json_encode(array("mensaje" => "Pedido entregado con exito."));
    } else {
      $payload = json_encode(array("mensaje" => "Error al entregar el pedido."));
    }
    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');
  }
}
