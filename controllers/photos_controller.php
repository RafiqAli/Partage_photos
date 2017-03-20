<?php
  class PhotosController 
  {

    public function ajout_photo()
    {
      
      if (isset($_POST['submit_addphoto']))
      {

        $result = Photo::create($_POST, $_FILES);
  
        if ($result['failed']) 
        {
          $_SESSION['error'] = $result['error'];
          require_once('../public/views/elements/navbar.php');
          require_once('views/pages/home.php'); 
        }
        else
        {
          $_SESSION['success'] = "Photo ajoute avec succes";
          $this->mes_photos();       
        }

        }
        else
        {
          require_once('../public/views/elements/navbar.php');
          require_once('views/pages/error.php');
        }
    }


    public function mes_photos() {

      $user_result = User::find($_SESSION['user']['username']);

      if ($user_result['failed']) 
      {
            $_SESSION['error'] = $user_result['error'];
            require_once('../public/views/elements/navbar.php');
            require_once('views/pages/home.php'); 
      }
      else
      {
            $photos_result = $user_result['object']->photos();

            if($photos_result['failed'])
            {
              $_SESSION['error'] = $photos_result['error'];
              require_once('../public/views/elements/navbar.php');
              require_once('views/pages/home.php');
            }
            else
            {
              $images = $photos_result['objects'];
              require_once('../public/views/elements/navbar.php');
              require_once('views/photos/mes_photos.php'); 
            }    
      }

    }

    public function affiche_photo() 
    {
      $photo_result = Photo::find($_GET['id']);

      if ($photo_result['failed']) 
      {
            $_SESSION['error'] = $photo_result['error'];
            require_once('../public/views/elements/navbar.php');
            require_once('views/pages/home.php'); 
      }
      else
      {
            $photo = $photo_result['object'];
            $comment_result = $photo->comments();
            
            if($comment_result['failed'])
            {
              $_SESSION['error'] = $comment_result['error'];
              require_once('../public/views/elements/navbar.php');
              require_once('views/photos/affiche_photo.php');  
            }
            else
            {
              $comments = $comment_result['objects'];
              require_once('../public/views/elements/navbar.php');
              require_once('views/photos/affiche_photo.php');             
            }
      }      
    }


    public function modif_photo() 
    {
      if (isset($_POST['submit_modif']))
      {

        $id = $_POST['photo_id'];
        $photo_result = Photo::find($id);

        if($photo_result['failed'])
        {
            $_SESSION['error'] = $photo_result['error'];
            require_once('../public/views/elements/navbar.php');
            require_once('views/pages/home.php'); 
        }
        else
        {
            $photo = $photo_result['object'];

            if (isset($_POST['title'])) 
            {
               $title = $_POST['title'];
               $photo->update_title($title);
            }
            
            if(isset($_POST['date']))
            {
              $date = $_POST['date'];
              $photo->update_date($date);
            }

            if(isset($_POST['desc']))
            {
              $desc = $_POST['desc'];
              $photo->update_description($desc);
            }

            $_SESSION['success'] = "Champs modifies avec succes";
            require_once('pages_controller.php');
            $pages = new PagesController();
            $pages->home();
        }    
        
      }
      else
      {

        $photo_result = Photo::find($_GET['id']);

        if ($photo_result['failed']) 
        {
              $_SESSION['error'] = $photo_result['error'];
              require_once('../public/views/elements/navbar.php');
              require_once('views/pages/home.php'); 
        }
        else
        {
              $photo = $photo_result['object'];
              require_once('../public/views/elements/navbar.php');
              require_once('views/photos/modif_photo.php');  
        }   
      }

    }

    public function cherche_photo()
    {
      if(isset($_POST['submit_recherche']))
      {
        $mot_cle = $_POST['mot_cle'];
        echo $mot_cle;

        $photo_result = Photo::search($mot_cle);

        if ($photo_result['failed']) 
        {
          $_SESSION['error'] = $photo_result['error'];
          require_once('../public/views/elements/navbar.php');
          require_once('views/pages/home.php'); 
        }
        else
        {
          $images = $photo_result['objects'];
          require_once('../public/views/elements/navbar.php');
          require_once('views/photos/recherche.php');             

        }

        }
    }

  }
?>

