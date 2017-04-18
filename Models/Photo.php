<?php 

require_once("../core/Request.php");
require_once("Upload.php");
require_once("../core/Regex.php");
require_once("Comment.php");
require_once("Category.php");
require_once("Rating.php");
require_once("../core/Enumerations.php");


require_once("../Exceptions/InvalidFormatException.php");
require_once("../Exceptions/NotFoundException.php");
require_once("../Exceptions/NullOrUnsetException.php");


class Photo {


	  public $owner;
	  public $id;
	  public $name;
	  public $date;
	  public $file;
	  public $description;
	  public $visibility;
	  public $link;
	  public $local_area_id;



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

		  	return  $list;
	    }
	    else
	    {
	    	throw new  NotFoundException("coudn't find photos on database");
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

		  	return  $list_comments;

	  	}
	  	else
	  	{
	  		throw new NotFoundException('no comment has been posted on this with photo.');
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

		      		return $photo_instance;

	      		}
	      		else
	      		{
	      			throw new NotFoundException('we couldn\'t find a picture with this id value');
	      		}

	      	}
	      	else
	      	{
	      		throw new InvalidFormatException('please enter a numeric value for the id');
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

			return  $list_photos;

  		}
  		else
  		{
  			throw new NotFoundException('Aucune photo ne correspond a votre recherche');
  		}

  	}
  	else
  	{
  		throw new NotFoundException('Veillez entrez un texte de recherche valide');
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
					throw new NullOrUnsetException("file identifier not found or null");	
				} 

			}
			else
			{
				throw new NullOrUnsetException("some values are not set or have null values");
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
	  			
	  			throw new UploadException('could not delete picture from the server, try again later');
	  		}
	  }

	  public function update_title(string $photo_title)
	  {

	  	if(Regex::validate(Regex::TEXT,$photo_title))
	  	{
	  		$sql = "UPDATE photos SET title = '".$photo_title."' WHERE id = ".$this->id.";";

	  		Request::query($sql);

	  	}
	  	else
	  	{
	  		throw new InvalidFormatException('please make sure that you did enter a valid name');
	  	}

	  }

	  public function update_date(string $photo_date)
	  {

	  	if(!is_null($photo_date))
	  	{
	  		$sql = "UPDATE photos SET date = '".$photo_date."' WHERE id = ".$this->id.";";

	  		Request::query($sql);

	  	}
	  	else
	  	{
	  		throw new InvalidFormatException('please make sure that you did enter a valid date');
	  	}

	  }

	  public function update_description(string $photo_description)
	  {

	  	if(Regex::validate(Regex::RICHTEXT,$photo_description))
	  	{
	  		$sql = "UPDATE photos SET description='".$photo_description."' WHERE id=".$this->id;

	  		Request::query($sql);

	  	}
	  	else
	  	{
	  		throw new  InvalidFormatException('please make sure that you did enter a valid description');
	  	}

	  }


	  public static function delete($id)
	  {

		if(Regex::validate(Regex::DIGITS,$id))
		{

	  		$photo = self::find($id);

		  	$is_deleted = unlink(Upload::LOCAL_TARGET.$photo->owner.'/'.$photo->file);

		  		if($is_deleted)
		  		{
		  			$sql = "DELETE FROM photos WHERE id=".$photo->id;

		  			Request::query($sql);

		  		}
		  		else
		  		{
		  			throw new ServerFileOperationException("could not delete image");
		  		}

		}
		else
		{
			throw new InvalidFormatException('please enter a numeric value');
		}

	  }


	  public function __toString()
	  {

	  	return 'Photo : [id] : '.$this->id.' [title] : '.$this->title.' [name] : '.$this->name.' [date] : '.$this->date.' [description] : '.$this->description.' [file] : '.$this->file.'  [owner] : '.$this->owner;
	  } 


	/*
	 * Returns photos based on occurences with text and time
	 *
	 * @param $type : indicate the type of the search, see core/Enumeration
	 * @param $arg1 : the main argument that the function uses as key for occurences
	 *                search
	 * @param $arg2 : made specially for the DATE_BETWEEN case, null on other cases.
	 *
	 * @Returns array  : contains a boolean key 'failed' that indicates whether the function 
	 * 					 succeeded at finding occurences or not, case success the
	 * 					 array contains list of photos under the key 'objects' and
	 * 					 an empty value of the 'error' key, that contains generally
	 * 					 a message of the probable cause of the error.  
	 */
	public static function neo_search_date(int $type,$arg1,$arg2 = null)
	{

		switch ($type)
		{
			
			case Search::BETWEEN_DATES:

				if(true)//Regex::validate(Regex::DATE,$arg1) && Regex::validate(Regex::DATE,$arg2))
				{
					$sql = "SELECT * FROM photos p WHERE date BETWEEN :keyOne AND :keyTwo";

					$data = array(':keyOne' => $arg1,':keyTwo' => $arg2);

				}
				else
				{
					throw new InvalidFormatException("Argument format invalid");
				}

			break;
			
			case Search::DATE: 
				
				if(true)//Regex::validate(Regex::DATE,$arg1))
				{
					$sql = "SELECT * FROM photos p WHERE date = :key"; 
					$data = array(':key' => $arg1);

				}
				else
				{
					 throw new InvalidFormatException("Argument format invalid");
				}

			break;
			
			case Search::BEFORE_DATE: 
				
				if(true)//Regex::validate(Regex::DATE,$arg1))
				{
					$sql = "SELECT * FROM photos p WHERE date < :key"; 					
					$data = array(':key' => $arg1);

				}
				else
				{
					throw new InvalidFormatException("Argument format invalid");
				}

			break;
			
			case Search::AFTER_DATE: 

				if(true)//Regex::validate(Regex::DATE,$arg1))
				{
					$sql = "SELECT * FROM photos p WHERE date>:key"; 					
					$data = array(':key' => $arg1);

					$type_format['failed'] = false;
				}
				else
				{
					throw new InvalidFormatException("Argument format invalid");
				}

			break;
			

			default:
				
				throw new EnumerationException('please make sure the value that you entered is defined as a constant in the core/Enumeration/Search class.');

				break;
		}


			$photos = Request::execute($sql,$data,true);

	  		if($photos != null)
	  		{
	  			$list_photos = [];

				foreach ($photos as $photo)
				{
					$list_photos[] = new Photo($photo['id'],$photo['title'],$photo['name'],$photo['date'],
											   $photo['description'],$photo['file'],$photo['owner']);
				}

				return  $list_photos;
			}
			else
			{
				throw new  NotFoundException('Aucune photo ne correspond a votre recherche');
			}
		

	}


	public static function neo_search_text($key)
	{


		if(Regex::validate(Regex::TEXT,$key)) 
		{

			$sql = "SELECT
							p.id            AS photo_id,
							p.title         AS photo_title,
							p.name          AS photo_name,
							p.date          AS photo_date,
							p.link          AS photo_link,
							p.description   AS photo_description,
							p.file          AS photo_file,
							p.owner         AS photo_owner,
							p.visibility    AS photo_visibility,
							p.local_area_id AS photo_local_area_id,

							c.id            AS comment_id,
							c.content       AS comment_content,
							c.owner         AS comment_owner,

							t.id            AS category_id,
							t.name          AS category_name,
							t.description   AS category_description

							 FROM photos p LEFT OUTER JOIN comments       c  ON (c.photo_id     = p.id)
										   LEFT OUTER JOIN photo_category pc ON (pc.photo_id    = p.id)
										   LEFT OUTER JOIN categories     t  ON (pc.category_id = t.id)
										   LEFT OUTER JOIN ratings        r  ON (r.photo_id     = p.id)

							 WHERE              p.name         LIKE :key 
							 			   OR   p.title        LIKE :key
								   		   OR   p.description  LIKE :key
								   		   OR   p.owner        LIKE :key
								   		   OR   c.content      LIKE :key
								   		   OR   c.owner        LIKE :key
								   		   OR   t.name         LIKE :key
								   		   OR   t.description  LIKE :key
								   		   OR   r.owner        LIKE :key
								   		   OR   r.description  LIKE :key";

			
			$data = array(':key' => '%' . $arg1 . '%');	

			$photos = Request::execute($sql,$data,true);

	  		if($photos != null)
	  		{
	  			$list_photos = [];

	  			print_r($photos);

				foreach ($photos as $photo)
				{
					$list_photos[] = new Photo($photo['photo_id'],$photo['photo_title'],$photo['photo_name'],$photo['photo_date'],
											   $photo['photo_description'],$photo['photo_file'],$photo['photo_owner']);
				}

				return  $list_photos;
			}
			else
			{
				throw new NotFoundException('Aucune photo ne correspond a votre recherche');
			}

		}
		else
		{
			throw new InvalidFormatException("Argument format invalid");
		}		


	}


	public static function sort(int $type)
	{
		if(Regex::validate(Regex::DIGITS,$type))
		{
			switch ($type) {

				case Sort::NEWEST    : $sql = "SELECT * FROM photos ORDER BY date DESC";
				break;

				case Sort::OLDEST    : $sql = "SELECT * FROM photos ORDER BY date ASC"; 
				break;

				case Sort::TOP_RATED : $sql = "SELECT * FROM photos p  ORDER BY (SELECT AVG(r.value) FROM ratings r WHERE r.photo_id = p.id) DESC";

				break;

				case Sort::LOW_RATED : $sql = "SELECT * FROM photos p  ORDER BY (SELECT AVG(r.value) FROM ratings r WHERE r.photo_id = p.id) ASC";
				break;
				
				default:
					
					throw new EnumerationException('please make sure the value that you entered is defined as a constant in the core/Enumeration/Sort class.');

					break;
			}


			$sorted_photos = Request::execute($sql);

	  		if($sorted_photos != null)
	  		{
	  			$list_photos = [];

				foreach ($sorted_photos as $photo)
				{
					$list_photos[] = new Photo($photo['id'],$photo['title'],$photo['name'],$photo['date'],
											   $photo['description'],$photo['file'],$photo['owner']);
				}

				return  $list_photos;
			}
			else
			{
				throw new NotFoundException('No photo had been found on the database.');
			}

		}
		else
		{
			throw new InvalidFormatException('please make sure you entered a valid numeric value.');
		}

	}



	  public function categories()
	  {

		$list_categories = [];

		$sql = "SELECT c.id, c.name, c.description
				FROM categories c, photo_category pc WHERE pc.photo_id = '".$this->id."' AND c.id = pc.category_id ;";


		$categories = Request::execute($sql);

		if($categories != null)
		{

			foreach ($categories as $category)
			{
				$list_categories[] = new Category($category['id'],$category['name'],$category['description']);
			}

			return  $list_categories;
		}
		else
		{
			throw new NotFoundException('this photo has no categories.');
		}

	  }

	  public function add_categories($categories)
	  {

	  	if(is_array($categories))
	  	{
	  		foreach ($categories as $category) {
	  			
	  			$sql = "INSERT INTO photo_category (photo_id,category_id,date_created) VALUES (:photo_id,:category_id,Now())";
	  			$data = array(":photo_id" => $this->id,":category_id" => $category->id);

	  			Request::execute($sql,$data);

	  		}
	  	}
	  	else // one object
	  	{
	  		$category = $categories;
 	
			$sql = "INSERT INTO photo_category (photo_id,category_id,date_created) VALUES (:photo_id,:category_id,Now())";
  			$data = array(":photo_id" => $this->id,":category_id" => $category->id);

  			Request::execute($sql,$data);

	  	}


	  }

	  public function delete_categories($categories)
	  {


	  	if (is_array($categories))
	  	{
	  		foreach ($categories as $category) {
	  			
	  			Request::query("DELETE FROM photo_category WHERE photo_id=".$this->id." AND category_id=".$category->id);
	  		}

	  	}
	  	else
	  	{
	  		$category = $categories; // $categories contains one object

	  		Request::query("DELETE FROM photo_category WHERE photo_id=".$this->id." AND category_id=".$category->id);
	  	}

	  }

	  public function ratings()
	  {

		  	$list_ratings = [];

		  	$sql = "SELECT r.photo_id,r.owner,r.value,r.description,r.date_created FROM ratings r JOIN photos p ON (r.photo_id = p.id) WHERE r.photo_id = '".$this->id."';";

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
		  		throw new NotFoundException('no rating has been posted on this with photo.');
		  	}	  	

	  }

	  public function average_rating()
	  {

	  	$sql = "SELECT AVG(value) FROM ratings WHERE photo_id=".$this->id;

	  	$average_rating = Request::execute($sql);

	  	return $average_rating;
		  		  	
	  }


	  // under construction

	  public function add_local_area($local_area)
	  {
	  		LocalArea::create($local_area);


	  }
	  public function update_local_area($local_area){}
	  public function delete_local_area($local_area){}

	  // i gone confused because we can't  [..] the constructor
	  // with tons of attributes, so we have to define setters
	  // and setters need to have an object not an id which 
	  // creates a conflict between the object attribute and
	  // the id (database-oriented) attribute
	  public function set_local_area($local_area)
	  {

	  }

}


?>