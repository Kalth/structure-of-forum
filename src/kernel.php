<?php

// external libs (twig)
require_once BASE_DIR . '/vendor/autoload.php';

// autoload register
spl_autoload_register(function ($className) {
  if (strpos($className, 'Controller') !== false) {
      require_once BASE_DIR . '/src/controller/' . $className . '.php';
      return true;
  } elseif (strpos($className, 'Entity') !== false) {
    require_once BASE_DIR . '/src/entities/' . $className . '.php';
    return true;
  } elseif(strpos($className, 'Helper') !== false) {
    require_once BASE_DIR . '/src/helpers/' . $className . '.php';
    return true;
  } else {
    require_once BASE_DIR . '/src/model/' . $className . '.php';
    return true;
  }
});

// session
session_start();

// routing + ctrl
$route = new Route();
$ctrl = $route->getCtrl();
unset($route);
$response = $ctrl->handleRequest();
unset($ctrl);


foreach ($response['headers'] as $header) {
  header($header);
}
echo $response['content'];
unset($response);
die;
