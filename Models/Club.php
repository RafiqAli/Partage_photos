<?php

require_once("../core/enable_errors.php");
require_once("../core/Request.php");
require_once("../core/Regex.php");


class Club {

	public  $id;
	public  $title;
	public  $admin;
	public  $description;
	private $user;

	public function __construct($id = null,$title,$description,$admin,$user = null)
	{


		 $this->id          = $id;
		 $this->title       = $title;
		 $this->admin       = $admin;
		 $this->description = $description; 
		 
		 /* this member variable holdes the instance of the user
		  * as a source reference. e.g 
		  * $user->get_club($id)->add_photo($photo)
		  * this variable will preserve the user instance to be 
		  * used on the add_photo function. 
		  */
		 $this->user = $user;

	}

	/**
	 * Returns the club given the identifer
	 * @param  Integer $id the identifer of the club
	 * @return associative array see Models/README.md
	 */
	public static function find($id){

      		if(Regex::validate(Regex::DIGITS,$id))
      		{

	      		$sql = "SELECT * FROM clubs WHERE id=".$id;

	      		$club = Request::execute($sql);

	      		if($club != null)
	      		{

	      			$club = $club[0];

		      		$club_instance = new club($club['id'],$club['title'],$club['admin'],$club['description'],$club['description']);

		      		return array('failed' => false, 'object' => $club_instance, 'error' => '');

	      		}
	      		else
	      		{
	      			return array('failed' => true, 'error' => 'we couldn\'t find a group with this id value');
	      		}

	      	}
	      	else
	      	{
	      		return array('failed' => true, 'error' => 'please enter a numeric value for the id');
	      	}



	}


	public static function all(){


	  	$list = [];

		$sql = "SELECT * FROM clubs";

		$output = Request::execute($sql);

		if($output != null)
		{

		  	foreach ($output as $club) {
		  		
		  		$list[] = new club($club['id'],$club['title'],$club['admin'],$club['description']);
		  	}

		  	return  array('failed' => false, 'objects' => $list, 'error' => '');
	    }
	    else
	    {
	    	return array('failed' => true, 'error' => 'coudn\'t find clubs on database');
	    }


	}


	public function users()
	{

		$list_users = [];

		$sql = "SELECT p.login
				 		FROM users p WHERE p.id IN 
				 			(SELECT user_id FROM user_club WHERE club_id = '$this->id');";


		$users = Request::execute($sql);

		if($users != null)
		{

			foreach ($users as $user)
			{
				$list_users[] = new User($user['login'],null);
			}

			return array('failed' => false,'objects' => $list_users, 'error' => '');
		}
		else
		{
			return array('failed' => true, 'error' => 'this group has no users.');
		}


	}

	public function photos()
	{

		$list_photos = [];

		$sql = "SELECT p.id,p.title,p.name,p.date,p.description,p.file,p.owner
				 		FROM photos p WHERE p.id IN 
				 			(SELECT photo_id FROM photo_club WHERE club_id = '$this->id');";


		$photos = Request::execute($sql);

		if($photos != null)
		{

			foreach ($photos as $photo)
			{
				$list_photos[] = new Photo($photo['id'],$photo['title'],$photo['name'],$photo['date'],$photo['description'],$photo['file'],$photo['owner']);
			}

			return array('failed' => false,'objects' => $list_photos, 'error' => '');
		}
		else
		{
			return array('failed' => true, 'error' => 'this group has no photos.');
		}
	}


	public static function create($club)
	{

		if(Regex::validate(Regex::NAME,$club['title']) 
			&& Regex::validate(Regex::NAME,$club['admin']) 
				&& Regex::validate(Regex::RICHTEXT,$club['description']))
		{

		 	$sql = "INSERT INTO clubs (title,admin,description) VALUES (:title,:admin,:description)";

		 	$data = array(':title' => $club['title'], 'admin' => $club['admin'], 'description' => $club['description']);

		 	$output = Request::execute($sql,$data);

		 	$sql = "INSERT INTO user_club (user_login,club_id) VALUES (:user_id,:club_id)";

		 	$data = array('user_id' => $club['admin'],'club_id' => Request::lastInsertId());

		 	$output = Request::execute($sql,$data);

		 	return array('failed' => false, 'output' => $output, 'error' => '');

		}
		else
		{
			return array('failed' => true, 'error' => 'please check the format of your fields');
		} 
	}


	public function add_photo($user,$photo)
	{

		$photo = Photo::create($photo['info'],$photo['file']);

		if($photo['failed'] == false)
		{
			$sql = "INSERT INTO photo_club (photo_id,club_id) VALUES (:photo_id,:club_id)";

			$data = array('photo_id' => $photo['object']->id,'club_id' => $this->id);

			Request::execute($sql,$data);

			return array('failed' => false, 'error' => '');

		}
		else
		{
			return array('failed' => true, 'error' => $photo['error']);

		}

	}

	public function add_user($user)
	{

		$sql = "SELECT * FROM users u WHERE u.login = ".$user['login'];

		$output = Request::query($sql);

		if($output != null)
		{
			
			$sql = "INSERT INTO user_club (user_id,club_id) VALUES (:user_id,:club_id)";

			$data = array(':user_id' => $user['id'],':club_id' => $this->id);

			Request::execute($sql,$data);

			return array('failed' => false, 'error' => '');

		}
		else
		{
			return array('failed' => true, 'error' => 'this user does not exist in our database.');
		}

	}

	public static function delete($id)
	{

		// on delete cascade photos and users

		if(Regex::validate(Regex::DIGITS,$id))
		{

			$sql = "DELETE FROM comments WHERE id=$id";

			$output = Request::query($sql);

			return array('failed' => false, 'output' => $output, 'error' => '');
		}
		else
		{
			return array('failed' => true, 'error' => 'please enter a numeric value');
		}

	}

	public function user_ref()
	{
		print_r($this->user);

		echo $this->user->login."\n";
	}

}


?>