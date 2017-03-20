<?php 

require_once("../core/Request.php");
require_once("Upload.php");
require_once("../core/Regex.php");
require_once("Comment.php");

class Photo {


	  public $owner;
	  public $id;
	  public $name;
	  public $date;
	  public $file;
	  public $description;



	  public function __construct($id,$title,$name,$date,$description,$file,$owner) {

	  		$this->id = $id;
	  		$this->title = $title;
	  		$this->name = $name;
	  		$this->date = $date;
	  		$this->description = $description;
	  		$this->file = $file;
	  		$this->owner = $owner;
	  }


	  public static function all() {

	  	$list = [];

		$sql = "SELECT * FROM photos";

		$output = Request::execute($sql);

		if($output != null)
		{

		  	foreach ($output as $photo) {
		  		
		  		$list[] = new Photo($photo['id'],$photo['title'],$photo['name'],$photo['date'],$photo['description'],$photo['file'],$photo['owner']);
		  	}

		  	return  array('failed' => false, 'objects' => $list, 'error' => '');
	    }
	    else
	    {
	    	return array('failed' => true, 'error' => 'coudn\'t find photos on database');
	    } 

	  }


	  public function comments() {

	  	$list_comments = [];

	  	$sql = "SELECT c.id,c.content,c.photo_id,c.owner FROM comments c  INNER JOIN photos p ON c.photo_id = p.id HAVING c.photo_id = '".$this->id."' ;";

	  	$comments = Request::execute($sql);

	  	if($comments != null)
	  	{

		  	foreach ($comments as $comment) {
		  	

		  		$list_comments[] = new Comment($comment['id'],$comment['content'],$comment['photo_id'],$comment['owner']);

		  	}

		  	return array('failed' => false, 'objects' => $list_comments, 'error' => '');

	  	}
	  	else
	  	{
	  		return array('failed' => true, 'error' => 'no comment has been posted on this with photo.');
	  	}

	  }

	 
	  public static function find($id) {

	  		
      		if(Regex::validate(Regex::DIGITS,$id))
      		{

	      		$sql = "SELECT * FROM photos WHERE id=".$id;

	      		$photo = Request::execute($sql);

	      		if($photo != null)
	      		{

	      			$photo = $photo[0];

		      		$photo_instance = new Photo($photo['id'],$photo['title'],$photo['name'],$photo['date'],$photo['description'],$photo['file'],$photo['owner']);

		      		return array('failed' => false, 'object' => $photo_instance, 'error' => '');

	      		}
	      		else
	      		{
	      			return array('failed' => true, 'error' => 'we couldn\'t find a picture with this id value');
	      		}

	      	}
	      	else
	      	{
	      		return array('failed' => true, 'error' => 'please enter a numeric value for the id');
	      	}
	  }

	  public static function search($mot_cle) {

		$list_photos = [];

		if(Regex::validate(Regex::RICHTEXT,$mot_cle))
		{

  		$sql = "SELECT * FROM photos WHERE title LIKE '%".$mot_cle."%' OR description LIKE '%".$mot_cle."%' ORDER BY title ASC";

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
  			return array('failed' => true, 'error' => 'Aucune photo ne correspond a votre recherche');
  		}

  	}
  	else
  	{
  		return array('failed' => true, 'error' => 'Veillez entrez un texte de recherche valide');
  	}
		
	}

	  public static function create($photo,$file)
	  {

	  	if(isset($photo['title'])       &&  $photo['title']       != null 
		&& isset($photo['date'])        &&  $photo['date']        != null
		&& isset($photo['description']) &&  $photo['description'] != null
		&& isset($photo['owner'])	    &&  $photo['owner']       != null)
	  	{

	  			if(isset($file['file_upload']) && $file['file_upload'] != null)
	  			{

				  		$upload_output = Upload::upload_file($file['file_upload'],$photo['owner']);

				  		if($upload_output['failed'] == false)
				  		{

				  			$sql = "INSERT INTO photos (title,name,date,description,file,owner) VALUES (:title,:name,:date,:description,:file,:owner)";

				  			$data = array(':title'        => $photo['title'],
				  						  ':name'         => Upload::get_user_file_name(),
					  					  ':date'         => $photo['date'],
					  					  ':description'  => $photo['description'],
					  					  ':file'         => Upload::get_generated_file_name(),
					  					  ':owner'        => $photo['owner']);

				  			Request::execute($sql,$data);

				  			$target = Upload::get_target_name();

				  			Upload::close();

				  			$upload_output += array( 'target' => $target);

				  			return $upload_output;

				  		} 
				  		else
				  		{
				  			return $upload_output;	
				  		} 


				}
				else
				{
					return array('failed' => true, 'error' =>"file identifier not found or null");	
				} 

			}
			else
			{
				return array('failed' => true, 'error' => "some values are not set or have null values");
			}
		 
	  }

	  public static function update_photo($photo)
	  {

	  		$output = Upload::upload_file($photo['file'],$photo['owner']);

	  		if($output['failed'] == false)
	  		{
	  			$sql = "UPDATE photos SET name=".Upload::get_user_file_name()." file=".Upload::get_generated_file_name()."WHERE id=".$this->id;
	  			Request::execute($sql);

	  			Upload::close();

	  			return array('failed' => false, 'error' => "");
	  		}
	  		else
	  		{
	  			Upload::close();
	  			return array('failed' => true, 'error' => 'could not delete picture from the server, try again later');
	  		}
	  }

	  public function update_title(string $photo_title)
	  {

	  	if(Regex::validate(Regex::TEXT,$photo_title))
	  	{
	  		$sql = "UPDATE photos SET title = '".$photo_title."' WHERE id = ".$this->id.";";

	  		Request::query($sql);

	  		return array('failed' => false, 'error' => '');
	  	}
	  	else
	  	{
	  		return array('failed' => true, 'error' => 'please make sure that you did enter a valid name');
	  	}

	  }

	  public function update_date(string $photo_date)
	  {

	  	if(!is_null($photo_date))
	  	{
	  		$sql = "UPDATE photos SET date = '".$photo_date."' WHERE id = ".$this->id.";";

	  		Request::query($sql);

	  		return array('failed' => false, 'error' => '');
	  	}
	  	else
	  	{
	  		return array('failed' => true, 'error' => 'please make sure that you did enter a valid date');
	  	}

	  }

	  public function update_description(string $photo_description)
	  {

	  	if(Regex::validate(Regex::RICHTEXT,$photo_description))
	  	{
	  		$sql = "UPDATE photos SET description='".$photo_description."' WHERE id=".$this->id;

	  		Request::query($sql);

	  		return array('failed' => false, 'error' => '');
	  	}
	  	else
	  	{
	  		return array('failed' => true, 'error' => 'please make sure that you did enter a valid description');
	  	}

	  }


	  public static function delete($id)
	  {

	  		$photo = self::find($id);

	  		if(!$photo['failed'])
	  		{
		  		$is_deleted = unlink(Upload::LOCAL_TARGET.$photo->owner.'/'.$photo->file);

		  		if($is_deleted)
		  		{
		  			$sql = "DELETE FROM photos WHERE id=".$photo->id;

		  			Request::query($sql);

		  			return array('failed' => false, 'error' => '');

		  		}
		  		else
		  		{
		  			return array('failed' => true, 'error' => "could not delete image");
		  		}
		  	}
		  	else
		  	{
		  		return $photo;
		  	}

	  }


	  public function __toString()
	  {

	  	return 'Photo : [id] : '.$this->id.' [title] : '.$this->title.' [name] : '.$this->name.' [date] : '.$this->date.' [description] : '.$this->description.' [file] : '.$this->file.'  [owner] : '.$this->owner;
	  } 

}

?>