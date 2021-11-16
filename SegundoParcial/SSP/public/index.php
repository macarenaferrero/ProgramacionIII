<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Routing\RouteCollectorProxy;
use Slim\Routing\RouteContext;

require __DIR__ . '/../vendor/autoload.php';
require_once './controllers/UsuarioController.php';
require_once './controllers/CriptoController.php';
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


  $app->group('/verificarCredencial', function (RouteCollectorProxy $group){
    $group->post('[/]', \Logger::class . '::VerificarCredencial');
  });

  $app->group('/cripto', function (RouteCollectorProxy $group) {
    $group->post('/crear', \CriptoController::class . ':CargarUno');
    $group->get('/ventas/{nacionalidad}/{fechaInicio}/{fechaFin}', \VentaController::class . ':TraerUnoPorNacionalidadFechas');
    $group->get('/buscarVenta/{nombre}', \VentaController::class . ':TraerTodosPorNombre');    
    $group->delete('/baja', \CriptoController::class . ':BorrarUno');
    $group->put('/modificar', \CriptoController::class . ':ModificarUno');
  })->add(\Logger::class . ':EsAdmin');


  $app->group('/listar', function (RouteCollectorProxy $group){
    $group->get('/criptos', \CriptoController::class . ':TraerTodos');
    $group->get('/criptos/{nacionalidad}', \CriptoController::class . ':TraerUnoPorNacionalidad');
    $group->get('/traerCripto/{idCripto}', \CriptoController::class . ':TraerUno')
  ->add(\Logger::class . ':EsClienteoAdmin');
  });

  $app->group('/administracion', function (RouteCollectorProxy $group) {
    $group->post('/crearVenta', \VentaController::class . ':CargarUno');
  })->add(\Logger::class . ':EsClienteoAdmin');

// Run app
$app->run();

