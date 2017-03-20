<?php

  function call($controller, $action) 
  {
    require_once('controllers/' . $controller . '_controller.php');

    switch($controller) {
     
      case 'pages':
        if($action=='login' || $action=='register')
        {
            require_once('Models/User.php');

        }
        $controller = new PagesController();
      break;

      case 'photos':
        // we need the model to query the database later in the controller
        require_once('Models/Photo.php');
        require_once('Models/User.php');
        require_once('Models/Comment.php');

        $controller = new PhotosController();
      break;

      case 'friends':

        $controller = new FriendsController();
      break;
    }

    $controller->{ $action }();
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
                                      'cherche_photo'],
                        'friends' => ['friends_groups']
                       );

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