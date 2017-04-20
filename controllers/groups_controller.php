<?php
class GroupsController 
{
    public function my_groups() 
    {
		try 
		{
	   		$userInstance = User::find($_SESSION['user']['username']);
	   		$groups = $userInstance->clubs();
	   		require_once('../public/views/elements/navbar.php');
		    require_once('views/groups/my_groups.php'); 
		} 
		catch (Exception $e) 
		{     
			$_SESSION['error'] = $e->getMessage();
			require_once('../public/views/elements/navbar.php');
			require_once('views/pages/home.php');
		}
	}

    public function show_all() 
    {
		try 
		{
	   		$groups = Club::all();
	   		require_once('../public/views/elements/navbar.php');
		    require_once('views/groups/show_all.php'); 
		} 
		catch (Exception $e) 
		{     
			$_SESSION['error'] = $e->getMessage();
			require_once('../public/views/elements/navbar.php');
			require_once('views/pages/home.php');
		}
	}

	public function create() 
    {
    	try 
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

				$_SESSION['success'] = "Groupe ajoute avec succes";
				require_once('../public/views/elements/navbar.php');
				require_once('views/groups/my_groups.php'); 

			}
			else
			{
				require_once('../public/views/elements/navbar.php');
	        	require_once('views/groups/create.php');
			}
		} 
		catch (Exception $e) 
		{     
			$_SESSION['error'] = $e->getMessage();
			require_once('../public/views/elements/navbar.php');
			require_once('views/groups/create.php');
		}
  }

}

?>

