<?php
// ini_set('display_errors',0);
// ini_set('display_startup_erros',0);
// error_reporting(E_ALL);

require_once(dirname(__FILE__, 2) . '/src/config/config.php');

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);

if ($uri === '/' || $uri === '' || $uri === '/index.php') {
    $uri = '/painel.php';
}

require_once(CONTROLLER_PATH . "/".$uri);

