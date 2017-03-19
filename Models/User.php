<?php 

require_once("../core/enable_errors.php");
require_once("../core/Request.php");
require_once("../core/Regex.php");
require_once("Upload.php");
require_once("Photo.php");


class User {

	public $login;

	public $password;

	const PATH_TO_PHOTOS = "/media/ali/New Volume/Study/4iéme année/S1/PHP/Partage_photos/public/ressources/users/";

	private function __construct($login,$password) {

		$this->login = $login;
		$this->password = $password;
	}

	public static function all() {

		$list = [];

		$sql = "SELECT * FROM users;";

		$users = Request::execute($sql);

		if($users != null)
		{

			foreach ($users as $user)
			{
				
				$list[] = new User($user['login'],$user['password']);
			}

		  	return  array('failed' => false, 'objects' => $list, 'error' => '');
	    }
	    else
	    {
	    	return array('failed' => true, 'error' => 'coudn\'t find users on database');
	    } 

	}

	public static function find($login)
	{

		if(Regex::validate(Regex::NAME,$login))
		{

      		$sql = "SELECT * FROM users WHERE login='".$login."' ;";

      		$user = Request::execute($sql);

      		if($user != null)
      		{
      			$user = $user[0];
      			$user_instance = new User($user['login'],$user['password']);

      			return array('failed' => false,'object' => $user_instance,'error' => '');	
      		} 
			else
			{
				return array('failed' => true, 'object' => '', 'error' => 'This login is either wrong or does not exist.');
			}
		}
		else
		{
			return array('failed' => true, 'object' => '', 'error' => 'The format of login is invalid');
		}
	}


	public static function exists($u)
	{
		if(Regex::validate(Regex::NAME,$u['login']) && $u['password'] != null)
		{

			$password = sha1($u['password']);

			$sql = "SELECT * FROM users WHERE login='".$u['login']."' AND password='".$password."';";

			$user = Request::execute($sql,null,false);

			if($user != null)
			{

				$user = $user[0];

				$user_instance = new User($user['login'],$user['password']);

				 return array('failed' => false, 'user' => $user_instance,'error' => '');
			}
			else
			{
				 return array('failed' => true, 'error' => 'wrong credentials or this user doesnt exist.');
			}

		}
		else
		{
			 return array('failed' => true, 'error' => 'the format of your input is not valid');
		}
	}



	public function photos() {

		$list_photos = [];

		$sql = "SELECT p.id,p.title,p.name,p.date,p.description,p.file,p.owner 
				FROM photos p,users u WHERE p.owner = '".$this->login."' ;";

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
			return array('failed' => true, 'error' => 'this user has no photos.');
		}

		
	}

	public static function create($user)
	{

		if(Regex::validate(Regex::NAME,$user['login']) && $user['password'] != null)
		{

		 	$sql = "INSERT INTO users () VALUES (:login,:password)";

		 	$data = array(':login' => $user['login'], 'password' => sha1($user['password']));

		 	$output = Request::execute($sql,$data);

		 	return array('failed' => false, 'output' => $output, 'error' => '');

		}
		else
		{
			return array('failed' => true, 'error' => 'please check the format of your fields');
		} 

	}

	/*
	 * the structure of the array $user needs to go like this : 
	 *
	 * $user = [ 'login' => $login , 'new_login' => $new_login ]
	 */
	public static function update_login($user)
	{

		if(Regex::validate(Regex::NAME,$user['login']) && Regex::validate(Regex::NAME,$user['login']))
		{

			$sql = "UPDATE users SET login='".$user['new_login']."' WHERE login='".$user['login']."' ;";

			Request::query($sql);

			rename(self::PATH_TO_PHOTOS.$user['login'],self::PATH_TO_PHOTOS.$user['new_login']);

		}
		else
		{
			return array('failed' => true, 'error' => 'please enter a valid login or new login value');
		}
	}


	public static function update_password($user)
	{

		if(Regex::validate(Regex::NAME,$user['login']) && $user['new_password'] != null)
		{

			$new_password = sha1($user['new_password']);

			$sql = "UPDATE users SET password='".$new_password."' WHERE login='".$user['login']."' ;";

			$output = Request::query($sql);

			return array('failed' => false, 'error' => '');
		}
		else
		{
			return array('failed' => true, 'error' => 'please enter a valid password format.');
		}

	}
	
	public static function delete($login)
	{

		if(Regex::validate(Regex::NAME,$login))
		{

			$sql = "DELETE FROM users WHERE login='".$login."' ;";

			$output = Request::query($sql);

			return array('failed' => false, 'output' => $output, 'error' => '');
		}
		else
		{
			return array('failed' => true, 'error' => 'invalid login value');
		}
	}


	public function __toString()
	{
		return "User : [login] ".$this->login." [password] : ".$this->password." \n";
	}


}


?>