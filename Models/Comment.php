<?php 

require_once("enable_errors.php");
require_once("Request.php");

class Comment {

	public $id;
	public $contenu;
	public $photo_id;
	public $owner;


	private function __construct($id,$contenu,$photo_id,$user_login) {

		$this->id = $id;
		$this->contenu = $contenu;
		$this->photo_id = $photo_id;
		$this->owner = $user_login;
	}

	public static function all() {

		$list = [];

		$sql = "SELECT * FROM commentaires;";

		$comments = Request::execute($sql);

		foreach ($comments as $comment) {
			
			$list[] = new Comment($comment['id'],$comment['contenu'],$comment['photo_id'],$comment['user_login']);
		}
	}

	public static function find($id) {

			// we make sure $id is an integer
      		$id = intval($id);

      		$sql = "SELECT * FROM commentaires WHERE id=".$id;

      		$comment = Request::execute($sql);

      		return new Comment($comment['id'],$comment['contenu'],$comment['photo_id'],$comment['user_login']);
	}

	public static function create($comment)
	{

		$sql = "INSERT INTO commentaires (contenu,photo_id,user_login) VALUES (:contenu,:photo_id,:owner)";

		$data = array('contenu'  => $comment['contenu'],
					  'photo_id' => $comment['photo_id'],
					  'owner'    => $comment['owner']);

		Request::execute($sql,$data);

	}


	public static function update(string $content,$id)
	{

		$id = intval($id);

		$sql = "UPDATE commentaires SET contenu=$content WHERE id=$id";

		Request::execute($sql);
	}
	public static function delete($id) {

		$sql = "DELETE FROM commentaires WHERE id=$id";

		Request::execute($sql);
	}



}