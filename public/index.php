<?php
 
  session_start();

  require_once('../config.php');
  require_once('../core/Connection.php');
  require_once('../core/enable_errors.php');
  require_once('../controllers/functions.php');




  if(isset($_GET['controller']) && ($_GET['controller'] == 'api'|| $_GET['controller']  == 'api_photo_io'))  //API CONTROLLER
  {
    $controller = $_GET['controller'];
    $action = $_GET['action'];
  }

  else //WEBSITE CONTROLLER
  {

    if (isset($_SESSION['user'])) //USER SESSION IS SET
    {
      if (isset($_GET['controller']) && isset($_GET['action'])) //USER SET AND CONTROLLER SET
      {
        $controller = $_GET['controller'];
        $action     = $_GET['action'];     
      }
      else //USER SET AND NO CONTROLLER
      {
          $controller = 'pages';
          $action     = 'home';
      }

    }
    else //SESSION NOT SET
    {    
      if (isset($_GET['controller']) && isset($_GET['action'])) //SESSION NOT SET BUT TRY TO ACCESS WEBSITE
      {
        if($_GET['controller'] == 'pages') //IF IT'S PAGES
        {
            if ($_GET['action'] != 'login' && $_GET['action'] != 'register') //IF DIFFERENT THAT LOGIN/REIGSTER 
            {
              $controller = 'pages';
              $action     = 'login';
            }
            else //IF WANT TO LOGIN/REGISTER
            {
              $controller = $_GET['controller'];
              $action     = $_GET['action'];
            }
        }
        else //ANOTHER CONTROLLER THAN PAGE
        {
          $controller = 'pages';
          $action     = 'login';
        }   
      }
      else //no controller and no action set
      {
          $controller = 'pages';
          $action     = 'login';
      }
    }
  }


  $page_title = $action;

  if ($controller == 'api' || $controller == 'api_photo_io')
  {
    require_once('views/layout_api.php');
  }
  else
  {
    require_once('views/layout.php');
  }
?>

