<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Routing\RouteCollectorProxy;
use Slim\Routing\RouteContext;

require __DIR__ . '/../vendor/autoload.php';
require_once './controllers/UsuarioController.php';
require_once './controllers/ProductoController.php';
require_once './controllers/VentaController.php';
require_once './db/AccesoDatos.php';
require_once './middlewares/Logger.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$app = AppFactory::create();
$app->setBasePath('/public');
$app->addRoutingMiddleware();
$app->addBodyParsingMiddleware();

$errorMiddleware = $app->addErrorMiddleware(true, true, true);


// peticiones

$app->group('/verificar', function (RouteCollectorProxy $group){
  $group->get('/listadoClima/{clima}', \ProductoController::class . ':TraerProductosxClima');
  $group->get('/listadoUnidad/{tipoUnidad}', \ProductoController::class . ':TraerProductosxUnidad');
  $group->get('/traerProducto/{idProducto}', \ProductoController::class . ':TraerUno')
  ->add(\Logger::class . ':EsVendedorOProveedor');
});

$app->group('/verificarCredencial', function (RouteCollectorProxy $group){
  $group->post('[/]', \Logger::class . '::VerificarCredencial');
});

  $app->group('/administracion', function (RouteCollectorProxy $group) {
    $group->post('/crearVenta', \VentaController::class . ':CargarUno');
    $group->post('/crearUsuario', \UsuarioController::class . ':CargarUno');
  })->add(\Logger::class . ':EsVendedorOProveedor');

  $app->group('/administracion', function (RouteCollectorProxy $group) {
    $group->get('/buscarVenta/{nombre}', \VentaController::class . ':TraerTodosPorNombre');
  })->add(\Logger::class . ':EsProveedor');

  $app->group('/producto', function (RouteCollectorProxy $group) {
    $group->post('/crear', \ProductoController::class . ':CargarUno');
    $group->delete('/borrar', \ProductoController::class . ':BorrarUno');
    $group->get('/todasVentasClimaFecha/{clima}/{fechaVenta}', \VentaController::class . ':TraerTodosPorClimaFecha');
    $group->put('/modificar', \ProductoController::class . ':ModificarUno');
  })->add(\Logger::class . ':EsVendedor');

// Run app
$app->run();

