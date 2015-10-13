<?php

class AbstractController
{
  // HTTP VARIABLES
  private $post;
  private $get;
  private $session;
  private $files;
  // Twig & Conn MySQL
  private $twig;
  private $mysql;

  private $page;

  public function __construct($page, $aHttpVars)
  {
    $this->page = $page;

    $this->post = $aHttpVars['post'];
    $this->get = $aHttpVars['get'];
    $this->session = &$_SESSION;
    $this->files = $aHttpVars['files'];
    unset($_POST, $_GET, $_FILES);

    $loader = new Twig_Loader_Filesystem(BASE_DIR . '/src/views/');
    $this->twig = new Twig_Environment($loader, [
        'cache' => false,
        'debug' => true,
        'strict_variables' => true,
        'charset' => 'utf-8',
    ]);
    unset($loader);

    $this->mysql = new MySQL();
    $this->mysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
  }

  public function handleRequest()
  {
    return $this->{$this->page . 'Action'}();
  }

  public function getPost($key = null)
  {
    if (array_key_exists($key, $this->post)) {
      return $this->post[$key];
    }
    if ($key !== null) {
      return null;
    }
    return $this->post;
  }

  public function getGet($key = null)
  {
    if (array_key_exists($key, $this->get)) {
      return $this->get[$key];
    }
    if ($key !== null) {
      return null;
    }
    return $this->get;
  }

  public function getSession($key = null)
  {
    if (array_key_exists($key, $this->session)) {
      return $this->session[$key];
    }
    if ($key !== null) {
      return null;
    }
    return $this->session;
  }

  public function setSession($value ,$key = null)
  {
    if ($key !== null) {
      $this->session[$key] = $value;
      return $this->session[$key];
    }
    $this->session = $value;
    return $this->session;
  }

  public function unsetSession($key = null)
  {
    if ($key !== null) {
      unset($this->session[$key]);
    }
    $this->session = [];
  }

  public function getFiles($key = null)
  {
    if (array_key_exists($key, $this->files)) {
      return $this->files[$key];
    }
    if ($key !== null) {
      return null;
    }
    return $this->files;
  }

  public function getTwig()
  {
    return $this->twig;
  }

  public function getMySQL()
  {
    return $this->mysql;
  }
}
