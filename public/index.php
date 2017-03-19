<?php
 
  session_start();

  require_once('../config.php');
  require_once('../core/Connection.php');
  require_once('../core/enable_errors.php');
  require_once('../controllers/functions.php');


  if (isset($_SESSION['user'])) 
  {
    if (isset($_GET['controller']) && isset($_GET['action']))
    {
      $controller = $_GET['controller'];
      $action     = $_GET['action'];     
    }
    else
    {
        $controller = 'pages';
        $action     = 'home';
    }

  }
  else
  {
    
    if (isset($_GET['controller']) && isset($_GET['action']))
    {
      if($_GET['controller'] == 'pages')
      {
          if ($_GET['action'] != 'login' && $_GET['action'] != 'register') 
          {
            $controller = 'pages';
            $action     = 'login';
          }
          else
          {
            $controller = $_GET['controller'];
            $action     = $_GET['action'];
          }
      }
      else
      {
        $controller = 'pages';
        $action     = 'login';
      }   
    }
    else
    {
        $controller = 'pages';
        $action     = 'login';
    }

  }


  $page_title = $action;
  require_once('views/layout.php');
?>