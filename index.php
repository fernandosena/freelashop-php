<?php
ob_start();

require __DIR__ . "/vendor/autoload.php";

/**
 * BOOTSTRAP
 */

use CoffeeCode\Router\Router;
use Source\Core\Session;

$session = new Session();
$route = new Router(url(), ":");


/**
 * ***********************************************************************************
 */
/**
 * WEB
 */
$route->namespace("Source\App\Web");
$route->group(null);
$route->post("/home", "Testes:home");
$route->get("/home/{page}", "Testes:home");
$route->get("/teste/{teste}", "Testes:teste");
$route->post("/teste/{teste}/checkout", "Testes:testeCheckout");

/**
 * ***********************************************************************************
 */
/**
 * ERROR ROUTES
 */
$route->namespace("Source\App\Web");
$route->group("/ops");
$route->get("/{errcode}", "Web:error");

/**
 * ROUTE
 */
$route->dispatch();

/**
 * ERROR REDIRECT
 */
if ($route->error()) {
//    $route->redirect(CONF_URL_REDIRECT);
}

ob_end_flush();