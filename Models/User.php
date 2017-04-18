<?php 

require_once("../core/enable_errors.php");
require_once("../core/Request.php");
require_once("../core/Regex.php");
require_once("Upload.php");
require_once("Photo.php");
require_once("Club.php");
require_once("Rating.php");


require_once("../Exceptions/InvalidFormatException.php");
require_once("../Exceptions/NotFoundException.php");
require_once("../Exceptions/NullOrUnsetException.php");
require_once("../Exceptions/ServerFileOperationException.php");
require_once("../Exceptions/UploadException.php");
require_once("../Exceptions/EnumerationException.php");

class User {

	public $login;

	public $password;

	//const PATH_TO_PHOTOS = "/media/ali/New Volume/Study/4iéme année/S1/PHP/Partage_photos/public/ressources/users/";

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

		  	return  $list;
	    }
	    else
	    {
	    	throw new NotFoundException('coudn\'t find users on database');
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
			throw new InvalidFormatException('The format of login is invalid');
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

				 return  $user_instance;
			}
			else
			{
				 throw new NotFoundException('wrong credentials or this user doesnt exist.');
			}

		}
		else
		{
			throw new InvalidFormatException('the format of your input is not valid');
		}
	}



	public function photos()
	{

		$list_photos = [];

		$sql = "SELECT id, title, name, date, description, file, owner 
				FROM photos WHERE owner = '".$this->login."' ;";


		$photos = Request::execute($sql);

		if($photos != null)
		{

			foreach ($photos as $photo)
			{
				$list_photos[] = new Photo($photo['id'],$photo['title'],$photo['name'],$photo['date'],$photo['description'],$photo['file'],$photo['owner']);
			}

			return  $list_photos;
		}
		else
		{
			throw new NotFoundException('this user has no photos.');
		}

		
	}


	public static function create($user)
	{

		if(Regex::validate(Regex::NAME,$user['login']) && $user['password'] != null)
		{

		 	$sql = "INSERT INTO users () VALUES (:login,:password)";

		 	$data = array(':login' => $user['login'], 'password' => sha1($user['password']));

		 	$output = Request::execute($sql,$data);

		 	return  $output;

		}
		else
		{
			throw new InvalidFormatException('please check the format of your fields');
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
			throw new InvalidFormatException('please enter a valid login or new login value');
		}
	}


	public static function update_password($user)
	{

		if(Regex::validate(Regex::NAME,$user['login']) && $user['new_password'] != null)
		{

			$new_password = sha1($user['new_password']);

			$sql = "UPDATE users SET password='".$new_password."' WHERE login='".$user['login']."' ;";

			$output = Request::query($sql);

		}
		else
		{
			throw new InvalidFormatException('please enter a valid password format.');
		}

	}


	public function clubs()
	{

		$list_clubs = [];

		$sql = "SELECT c.id, c.title, c.description,c.admin
				FROM clubs c, user_club uc WHERE uc.user_login = '".$this->login."' ;";


		$clubs = Request::execute($sql);

		if($clubs != null)
		{

			foreach ($clubs as $club)
			{
				$list_clubs[] = new Club($club['id'],$club['title'],$club['description'],$club['admin']);
			}

			return array('failed' => false,'objects' => $list_clubs, 'error' => '');
		}
		else
		{
			throw new NotFoundException('this user has no clubs.');
		}

	}


	public function get_club($id)
	{

		if(Regex::validate(Regex::DIGITS,$id))
		{

      		$sql = "SELECT * FROM clubs WHERE id='".$id."' ;";

      		$club = Request::execute($sql);

      		if($club != null)
      		{
      			$club = $club[0];
      			$club_instance = new Club($club['id'],$club['title'],$club['description'],$club['admin'],$this);

      			return $club_instance;	
      		} 
			else
			{
				throw new NotFoundException('This club does not exist.');
			}
		}
		else
		{
			throw new InvalidFormatException('The format of id is invalid');
		}

	}
	
	public static function delete($login)
	{

		if(Regex::validate(Regex::NAME,$login))
		{

			$sql = "DELETE FROM users WHERE login='".$login."' ;";

			$output = Request::query($sql);

			return  $output;
		}
		else
		{
			throw new InvalidFormatException('invalid login value');
		}
	}


	public function __toString()
	{
		return "User : [login] :".$this->login." [password] : ".$this->password." \n";
	}


// untested functions



	  public function ratings()
	  {

		  	$list_ratings = [];

		  	$sql = "SELECT r.photo_id,r.owner,r.value,r.description,r.date_created FROM ratings r JOIN users u ON (r.owner = u.login) WHERE r.owner = '".$this->login."' ;";

		  	$ratings = Request::execute($sql);

		  	if($ratings != null)
		  	{

			  	foreach ($ratings as $rating) {
			  	

			  		$list_ratings[] = new Rating($rating['photo_id'],$rating['owner'],$rating['value'],$rating['description'],$rating['date_created']);
			  	}

			  	return  $list_ratings;

		  	}
		  	else
		  	{
		  		throw new NotFoundException('no rating has been found for that user.');
		  	}	  	

	  }



}


?>