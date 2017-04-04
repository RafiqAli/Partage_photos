<?php
  class GroupsController 
  {

    public function my_groups() 
    {
		require_once('../public/views/elements/navbar.php');
        require_once('views/groups/my_groups.php');
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

			$group = array(	'title' => $title,
			 				'admin' => $admin,
			 				'description' => $desc);

			$result = Group::create($group);

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

