<?php
use Slim\Routing\RouteCollectorProxy;
use App\Controllers\InmuebleController;

$app->group('/api/inmuebles', function (RouteCollectorProxy $group) {
    $group->get('', InmuebleController::class . ':getAll');
    $group->post('', InmuebleController::class . ':add');
});