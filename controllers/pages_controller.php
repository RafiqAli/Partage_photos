<?php
  class PagesController 
  {

    public function home() 
    {
      try 
      {
        require_once('../Models/Photo.php');
        $images = Photo::all();
        require_once('../public/views/elements/navbar.php');
        require_once('views/pages/home.php'); 
      } 
      catch (Exception $e) 
      {     
        $_SESSION['error'] = $e->getMessage();
        require_once('../public/views/elements/navbar.php');
        require_once('views/pages/home.php');
      }
    }

    public function login() 
    {
      try 
      {
        if(isset($_POST['login_submit'])) 
        {
          $pseudo = test_input($_POST['pseudo']);
          $pass = test_input($_POST['pass']);

          if(!empty($pseudo) && !empty($pass))
          {
            $user = array('login' => $pseudo, 'password' => $pass);
            $userInstance = User::exists($user);

            $_SESSION['user']['username'] = $userInstance->login;
            $_SESSION['success'] = "Contents de vous revoir ".$userInstance->login;

            $this->home();  
          }
          else
          {
              $_SESSION['error'] = 'Veillez remplire tous les champs';
              require_once('../public/views/elements/navbar.php');
              require_once('views/pages/login.php'); 
          }
        }
        else
        {
          require_once('../public/views/elements/navbar.php');
          require_once('views/pages/login.php'); 
        }

      } 
      catch (Exception $e) 
      {
        $_SESSION['error'] = $e->getMessage();
        require_once('../public/views/elements/navbar.php');
        require_once('views/pages/login.php'); 
      }

    }

    public function register() {

    try 
    {
        if(isset($_POST['register_submit'])) 
        {
          $pseudo = test_input($_POST['pseudo']);
          $pass = test_input($_POST['pass']);

          if(!empty($pseudo) && !empty($pass))
          {

            $user = array('login' => $pseudo, 'password' => $pass);
            $result = User::create($user);
            $_SESSION['user']['username'] = $pseudo;
            $_SESSION['success'] = "Bienvenue ".$pseudo;
            $this->home(); 
          }
          else
          {
            $_SESSION['error'] = 'Veillez remplire tous les champs!';
            require_once('../public/views/elements/navbar.php');
            require_once('views/pages/register.php');

          }
        }
        else
        {
          require_once('../public/views/elements/navbar.php');
          require_once('views/pages/register.php'); 
        }

    } 
    catch (Exception $e) 
    {
        $_SESSION['error'] = $e->getMessage();
        require_once('../public/views/elements/navbar.php');
        require_once('views/pages/register.php');
    }
      
    }

    //PAGE Erreur 404
    public function error() 
    {
      require_once('../public/views/elements/navbar.php');
      require_once('views/pages/error.php');
    }


    public function logout()
    {

      $_SESSION = array();
      session_destroy();
      require_once('../public/views/elements/navbar.php');
      require_once('views/pages/login.php');
    }

  }
?>

