<?php 

require_once("enable_errors.php");
require_once("Request.php");

class User {

	public $login;

	public $password;

	private function __construct($login,$password) {

		$this->login = $login;
		$this->login = $password;
	}

	public static function all() {

		$list = [];

		$sql = "SELECT * FROM utilisateurs;";

		$photos = Request::execute($sql);

		foreach ($photos as $user) {
			
			$list[] = new User($user['login'],$user['password']);
		}
	}

	public static function find($id) {

			// we make sure $id is an integer
      		$id = intval($id);

      		$sql = "SELECT * FROM utilisateurs WHERE id=".$id;

      		$user = Request::execute($sql);

      		return new User($user['login'],$user['password']);
	}


	public function photos() {

		$list_photos = [];

		$sql = "SELECT * FROM photos p,utilisateurs u where p.user_login = u.login";

		$photos = Request::execute($sql);

		foreach ($photos as $photo) {
			
			$list_photos[] = new Photo($photo['id'],$photo['nom'],$photo['date'],$photo['description'],$photo['user_login']);	

		}

		return $list_photos;
	}


}


?>