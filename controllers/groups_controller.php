<?php
  class GroupsController 
  {

    public function my_groups() 
    {
   		$user_result = User::find($_SESSION['user']['username']);

		if ($user_result['failed']) 
		{
		    $_SESSION['error'] = $user_result['error'];
		    require_once('../public/views/elements/navbar.php');
		    require_once('views/pages/home.php'); 
		}
		else
		{
		    $club_result = $user_result['object']->clubs();

		    if($club_result['failed'])
		    {
		      $_SESSION['error'] = $club_result['error'];
		      require_once('../public/views/elements/navbar.php');
		      require_once('views/pages/home.php');
		    }
		    else
		    {
		      $groups = $club_result['objects'];
			require_once('../public/views/elements/navbar.php');
	        require_once('views/groups/my_groups.php');
		    }    
		}

	}

    public function show_all() 
    {
		require_once('../public/views/elements/navbar.php');
        require_once('views/groups/show_all.php');
	}

	public function create() 
    {
   		if (isset($_POST['submit_create_grp']))
      	{
			$title = test_input($_POST['nom_grp']);
			$desc = test_input($_POST['desc_grp']);
			$admin = $_SESSION['user']['username'];

			$club = array(	'title' => $title,
			 				'admin' => $admin,
			 				'description' => $desc);

			$result = Club::create($club);

			if ($result['failed']) 
	        {
	          $_SESSION['error'] = $result['error'];
	          require_once('../public/views/elements/navbar.php');
	          require_once('views/groups/create.php'); 
	        }
	        else
	        {
	          $_SESSION['success'] = "Groupe ajoute avec succes";
	          require_once('../public/views/elements/navbar.php');
	          require_once('views/groups/my_groups.php'); 
	      	}

		}
		else
		{
			require_once('../public/views/elements/navbar.php');
        	require_once('views/groups/create.php');
		}
	}

  }
?>

