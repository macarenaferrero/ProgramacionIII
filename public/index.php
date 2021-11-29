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
require_once './controllers/PedidoController.php';
require_once './controllers/MesaController.php';
require_once './controllers/ArchivosController.php';
require_once './controllers/EncuestaController.php';
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

$app->group('/verificarCredencial', function (RouteCollectorProxy $group){
  $group->post('[/]', \Logger::class . '::VerificarCredencial');
});

$app->group('/mipedido', function (RouteCollectorProxy $group){
  $group->get('/{idPedido}', \PedidoController::class . ':TraerUno'); 
  $group->post('/entregarEncuesta', \EncuestaController::class . ':CargarUno');
});

  $app->group('/pedido', function (RouteCollectorProxy $group) {
    $group->post('/crearMesa', \MesaController::class . ':CargarUno');
    $group->post('/crearPedido', \PedidoController::class . ':CargarUno');
    $group->post('/crearProducto', \ProductoController::class . ':CargarUno');
    $group->put('/agregarCostos', \PedidoController::class . ':ModificarCostos');
    $group->put('/modificarPedido', \PedidoController::class . ':ModificarUno');
    $group->post('/pendientes', \ProductoController::class . ':TraerPendientes');
    $group->get('/buscar/{idSector}', \ProductoController::class . ':TraerProductosPorSector'); 
    $group->get('/paraservir/{idProducto}', \ProductoController::class . ':FinalizarProducto');
    $group->put('/servir', \PedidoController::class . ':ModificarUno');
    $group->put('/cobrar', \PedidoController::class . ':Cobrar');    
    $group->put('/promediar', \EncuestaController::class . ':ModificarUno');
  })->add(\Logger::class . ':EsEmpleadoOSocio');

  

  $app->group('/administracion', function (RouteCollectorProxy $group) {
    $group->post('[/]', \Logger::class . '::VerificarCredencial');
    $group->put('/cerrarMesa', \MesaController::class . ':CerrarMesaPorId');
    $group->get('/pedidos', \PedidoController::class . ':TraerTodos');
    $group->get('/buscar/{idUsuario}', \UsuarioController::class . ':TraerUno');    
    $group->post('/crearUsuario', \UsuarioController::class . ':CargarUno');
    $group->put('/suspenderUsuario', \UsuarioController::class . ':SuspenderUno');
    $group->delete('/borrarUsuario', \UsuarioController::class . ':BorrarUno');
    $group->get('/descargaIngresos', \UsuarioController::class . ':GuardarCSV');
    $group->get('/cargaIngresos', \UsuarioController::class . ':LeerCSV');
    $group->get('/crearReporte', \ArchivosController::class . ':DescargaPDF');
    $group->get('/estrellas', \EncuestaController::class . ':TraerMejorEncuesta');
  })->add(\Logger::class . ':EsSocio');


  $app->get('[/]', function (Request $request, Response $response) {    
    $response->getBody()->write("Pagina de Prueba");
    return $response;
});

// Run app
$app->run();

