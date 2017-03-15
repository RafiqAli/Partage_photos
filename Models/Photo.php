<?php 

require_once("../enable_errors.php");
require_once("../Request.php");

class Photo {


	  public $owner;
	  public $id;
	  public $nom;
	  public $date;
	  public $description;



	  private function __construct($id,$nom,$date,$description,$owner) {

	  		$this->id = $id;
	  		$this->nom = $nom;
	  		$this->date = $date;
	  		$this->description = $description;
	  		$this->owner = $owner;

	  }


	  public static function all() {

	  	$list = [];

	  	$sql = "SELECT * FROM photos";

	  	foreach (Request::execute($sql) as $photo) {
	  		
	  		$list[] = new Photo($photo['id'],$photo['nom'],$photo['date'],$photo['description'],$photo['user_login']);
	  	}

	  	return $list;
	  }


	  public function comments() {

	  	$list_comments = [];

	  	$sql = "SELECT c.id,c.contenu,c.photo_id,c.user_login FROM commentaires c,photos p WHERE c.photo_id = p.id";

	  	$comments = Request::execute($sql);


	  	foreach ($comments as $comment) {
	  	

	  		$list_comments = new Comment($comment['id'],$comment['contenu'],$comment['photo_id'],$comment['user_login']);

	  	}

	  	return $list_comments;

	  }

	  

	  public static function find($id) {

	  		// we make sure $id is an integer
      		$id = intval($id);

      		$sql = "SELECT * FROM photos WHERE id=".$id;

      		$photo = Request::execute($sql);

      		return new Photo($photo['id'],$photo['nom'],$photo['date'],$photo['description'],$photo['user_login']);
	  }
}

?>