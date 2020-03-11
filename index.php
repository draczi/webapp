<?php
  use Core\Session;
  use Core\Cookie;
  use Core\Router;
  use Core\DB;
  use App\Models\Users;
  define('DS', DIRECTORY_SEPARATOR); //per jelet helyettesiti
  define('ROOT', dirname(__FILE__)); // documentum gyökérkönyvtára

  //load configuration and helper functions
  require_once(ROOT . DS . 'config' . DS . 'config.php');

  //nevtér használathoz.
  function semiautoload($className) {
    $classAry = explode('\\', $className);
    $class = array_pop($classAry);
    $subPath = strtolower(implode(DS, $classAry));
    $path = ROOT . DS . $subPath . DS . $class . '.php';
    if(file_exists($path)) {
      require_once($path);
    }
  }
  spl_autoload_register('semiautoload');
  session_start();

  $url = isset($_SERVER['PATH_INFO']) ? explode('/', ltrim($_SERVER['PATH_INFO'], '/')) : []; // minden amit a gyökeren kívül beírunk.
  $db = DB::getInstance();

  if(!Session::exists(CURRENT_USER_SESSION_NAME) && COOKIE::exists(REMEMBER_ME_COOKIE_NAME)) {
    Users::loginUserFromCookie();
  }

  // Route the request
  Router::route($url);
