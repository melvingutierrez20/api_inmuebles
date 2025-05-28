<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/database.php';

$app = AppFactory::create();

// Middlewares
$app->addBodyParsingMiddleware();
$app->add(new App\Middleware\CorsMiddleware());
$app->addErrorMiddleware(true, true, true);

// Rutas
require __DIR__ . '/../src/routes/inmuebles.php';
require __DIR__ . '/../src/routes/propietarios.php';

$app->run();