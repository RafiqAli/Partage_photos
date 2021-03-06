<?php

//function for removing special chars
function test_input($data)
{
  $data=trim($data);//remove extra space
  $data=stripslashes($data);//remove backslash
  $data=htmlspecialchars($data);//remove special char

  return $data;
}


// we're adding an entry for the new controller and its actions
$controllers = array( 'pages'   => ['home',
                                    'login',
                                    'register',
                                    'logout',
                                    'error'],

                      'photos'  => ['ajout_photo',
                                    'mes_photos',
                                    'affiche_photo',
                                    'modif_photo',
                                    'cherche_photo',
                                    'neo_search'],

                      'groups'  => ['my_groups',
                                   'show_all',
                                   'create'],
                                   
                      'api'     => ['test']
                     );



function call($controller, $action) 
{
  require_once('controllers/' . $controller . '_controller.php');

  switch($controller) {

//------------------------------------------------------------------------

    case 'pages':
      if($action=='login' || $action=='register')
      {
          require_once('Models/User.php');

      }
      $controller = new PagesController();
    break;
//-------------------------------------------------------------------------

    case 'photos':
      // we need the model to query the database later in the controller
      require_once('Models/Photo.php');
      require_once('Models/User.php');
      require_once('Models/Comment.php');

      $controller = new PhotosController();
    break;
//-------------------------------------------------------------------------

    case 'groups':

      // we need the model to query the database later in the controller
      require_once('Models/Club.php');
      require_once('Models/User.php');
      $controller = new GroupsController();

    break;
  }

//---------------------------------------------------------------------------

  $controller->{ $action }();
}


if (array_key_exists($controller, $controllers))
{
    if (in_array($action, $controllers[$controller]))
    {
      call($controller, $action);
    }
    else
    {
      call('pages', 'error');
    }
}
else
{
  call('pages', 'error');
}


?>