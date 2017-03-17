<?php 

//require_once("../core/enable_errors.php");
require_once("core/Request.php");
//require_once("../core/boite_outils.php");
require_once("Upload.php");

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


	  public static function create($photo,$file)
	  {

	  	if(isset($photo['nom'])         &&  $photo['nom']         != null 
		&& isset($photo['date'])        &&  $photo['date']        != null
		&& isset($photo['description']) &&  $photo['description'] != null
		&& isset($photo['owner'])	    &&  $photo['owner']       != null)
	  	{

	  			if(isset($file['file_upload']) && $file['file_upload'] != null)
	  			{

				  		$output = Upload::upload_file($file['file_upload'],$photo['owner']);

				  		if($output['failed'] == false)
				  		{

				  			$sql = "INSERT INTO photos (nom,date,description,fichier,user_login) VALUES (:nom,:date,:description,:fichier,:owner)";

				  			$data = array(':nom'         => Upload::get_user_file_name(),
					  					  ':date'        => $photo['date'],
					  					  ':description' => $photo['description'],
					  					  ':fichier'     => Upload::get_generated_file_name(),
					  					  ':owner'       => $photo['owner']);

				  			Request::execute($sql,$data);

				  			return array('output' => $output, 'target' => Upload::get_target_name());

				  		} else return array('output' => $output, 'target' => Upload::get_target_name());


				} else return "file identifier not found or null";

			} else {

				return "some values are not set or have null values";
			}
		 
	  }

}

?>