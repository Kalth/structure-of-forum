<?php

class Route
{
  private $page;
  private $routes;

  public function __construct()
  {
    $this->routes = include BASE_DIR . '/config/routing.php';
    // default val
    if (!isset($_GET['page']) || !array_key_exists($_GET['page'], $this->routes)) {
      $this->page = 'accueil';
    } else {
      $this->page = $_GET['page'];
    }
    //$this->routes = $this->routes[$this->page];
  }

  public function getCtrl()
  {
    $aHttpVars = [
      'get' => Firewall::secureGet($this->routes[$this->page]),
      'post' => Firewall::securePost($this->routes[$this->page]),
      'files' => Firewall::secureGet($this->routes[$this->page]),
    ];
    unset($_POST, $_GET, $_FILES);

    $ctrlName = $this->routes[$this->page]['controller'];
    $ctrlName = ucwords($ctrlName) . 'Controller';
    return new $ctrlName($this->page, $aHttpVars);
  }

}
