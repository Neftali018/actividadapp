<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';
require '../src/config/db.php';

$app = new \Slim\App;
$app->get('/hello/{name}', function (Request $request, Response $response){

	$name = $request->getAttribute('name');
	$response->getBody()->write("Hello,$name");

		return $response;

});

//Estudiantes routes
require '../src/routes/estudiantes.php';

$app->run();
