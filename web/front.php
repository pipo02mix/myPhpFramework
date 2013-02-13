<?php
ini_set('display_errors', 1);

require_once __DIR__.'/../vendor/autoload.php';
 
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Matcher\UrlMatcher;
 
$request = Request::createFromGlobals();
$response = new Response();

$routes = include __DIR__.'/../src/app.php';

$context = new RequestContext();
$context->fromRequest($request);
$matcher = new UrlMatcher($routes, $context);


try {
    $attributes = $matcher->match($request->getPathInfo());
    extract($attributes, EXTR_SKIP);
    ob_start();    
    include sprintf(__DIR__.'/../src/%s.php', $_route);
    
    $response = new Response(ob_get_clean());
} catch (Symfony\Component\Routing\Exception\ResourceNotFoundException $e) {
    $response = new Response('Not found', 404);
} catch (Exception $e) {
    $response = new Response('An error ocurred', 500);
}

$response->send();