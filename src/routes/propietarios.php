<?php
use Slim\Routing\RouteCollectorProxy;
use App\Controllers\PropietarioController;

$app->group('/api/propietarios', function (RouteCollectorProxy $group) {
    $group->get('', PropietarioController::class . ':getAll');
    $group->get('/{id}', PropietarioController::class . ':getById');
    $group->post('', PropietarioController::class . ':create');
});