<?php

$uri = parse_url($_SERVER['REQUEST_URI'])['path'];

$routes = [
  '/' => 'public/index.php',
  '/add-product' => 'public/add-product.php',
];

function route($uri,$routes) {
  if (array_key_exists($uri, $routes)) {
    require $routes[$uri];
  } else {
    abort();
  }
}

function abort($code = 404) {
  http_response_code($code);

  require "public/shared/{$code}.php";

  die();
}

route($uri, $routes);