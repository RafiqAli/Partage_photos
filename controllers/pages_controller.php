<?php
  class PagesController 
  {

    public function home() 
    {

      require_once('../Models/Photo.php');

      $photos_result = Photo::all();

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
        require_once('views/pages/home.php'); 
      }

    }

    public function login() 
    {

      if(isset($_POST['login_submit'])) 
      {
        $pseudo = $_POST['pseudo'];
        $pass = $_POST['pass'];

        $user = array('login' => $pseudo, 'password' => $pass);

        $result = User::exists($user);

        if ($result['failed']) 
        {
              $_SESSION['error'] = $result['error'];
              require_once('../public/views/elements/navbar.php');
              require_once('views/pages/login.php'); 
        }
        else
        {
              $_SESSION['user']['username'] = $result['user']->login;
              $_SESSION['success'] = "Contents de vous revoir ".$result['user']->login;
              $this->home();  
        }

      }
      else
      {
        require_once('../public/views/elements/navbar.php');
        require_once('views/pages/login.php');
      }
    }

    public function register() {

      if(isset($_POST['register_submit'])) 
      {
        $pseudo = $_POST['pseudo'];
        $pass = $_POST['pass'];

        $user = array('login' => $pseudo, 'password' => $pass);

        $result = User::create($user);

        if ($result['failed']) 
        {
              $_SESSION['error'] = $result['error'];
              require_once('../public/views/elements/navbar.php');
              require_once('views/pages/register.php');
        }
        else
        {
              $_SESSION['user']['username'] = $pseudo;
              $_SESSION['success'] = "Bienvenue ".$pseudo;
              require_once('../public/views/elements/navbar.php');
              require_once('views/pages/home.php');       
        }

      }
      else
      {
        require_once('../public/views/elements/navbar.php');
        require_once('views/pages/register.php');
      }
    }


    public function error() {
      require_once('../public/views/elements/navbar.php');
      require_once('views/pages/error.php');
    }

    public function logout()
    {
      
      session_start();
      $_SESSION = array();
      session_destroy();
      require_once('../public/views/elements/navbar.php');
      require_once('views/pages/login.php');
    }

  }
?>

