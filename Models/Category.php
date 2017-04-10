<?php

require_once("../core/Request.php");
require_once("../core/Regex.php");
require_once("Photo.php");
require_once("core/Enumeration.php");



class Category
{

	const ALL = 0;

	public $id;
	public $name;
	public $description;
	public $photo_id;

	public function __construct($id = null,$name,$description,$photo_id)
	{
		if(Regex::validate(Regex::NAME,$name) 
			&& Regex::validate(Regex::RICHTEXT,$description) 
				&& Regex::validate(Regex::DIGITS,$photo_id)
					&& ($id == null || Regex::validate(Regex::DIGITS,$id)))
		{
			 $this->id = $id;
			 $this->name = $name;
			 $this->description = $description;
			 $this->photo_id = $photo_id;
		}

	}

	public static function find($id)
	{

  		if(Regex::validate(Regex::DIGITS,$id))
  		{

      		$sql = "SELECT * FROM categories WHERE id=".$id;

      		$category = Request::execute($sql);

      		if($category != null)
      		{

      			$category = $category[0];

	      		$category_instance = new Category($category['id'],$category['name'],$category['description'],$category['photo_id']);

	      		return array('failed' => false, 'object' => $category_instance, 'error' => '');

      		}
      		else
      		{
      			return array('failed' => true, 'error' => 'we couldn\'t find a category with this id value');
      		}

      	}
      	else
      	{
      		return array('failed' => true, 'error' => 'please enter a numeric value for the id');
      	}


	}

	public static function all()
	{

	  	$list = [];

		$sql = "SELECT * FROM categories";

		$output = Request::execute($sql);

		if($output != null)
		{

		  	foreach ($output as $category) {
		  		
		  		$list[] = new category($category['id'],$category['name'],$category['description'],$category['photo_id']);
		  	}

		  	return  array('failed' => false, 'objects' => $list, 'error' => '');
	    }
	    else
	    {
	    	return array('failed' => true, 'error' => 'coudn\'t find categories on database');
	    }

	}

	public static function create($category)
	{

		if(Regex::validate(Regex::NAME,$name) 
			&& Regex::validate(Regex::RICHTEXT,$description) 
				&& Regex::validate(Regex::DIGITS,$photo_id)
					&& ($id == null || Regex::validate(Regex::DIGITS,$id)))
		{		

			$sql = "INSERT INTO categories (name,description,photo_id) VALUES (:name,:description,:photo_id)";

		 	$data = array(':name' => $category['name'], 'description' => $category['description'], 'photo_id' => $category['photo_id']);

		 	$output = Request::execute($sql,$data);

		 	$category = new Category(Request::lastInsertId(),$category['name'],$category['description'],$category['photo_id']);

		 	return array('failed' => false, 'object' => $category, 'error' => '');
		}
		else
		{
			return array('failed' => true, 'error' => 'please check the format of your fields');
		} 


	}

	public static function delete($id)
	{

		if(Regex::validate(Regex::DIGITS,$id))
		{

			$sql = "DELETE FROM categories WHERE id=$id";

			$output = Request::query($sql);

			return array('failed' => false, 'output' => $output, 'error' => '');
		}
		else
		{
			return array('failed' => true, 'error' => 'please enter a numeric value');
		}

	}
	
	public function update_name($name)
	{

	  	if(Regex::validate(Regex::NAME,$name))
	  	{
	  		$sql = "UPDATE categories SET name = '".$name."' WHERE id = ".$this->id.";";

	  		Request::query($sql);

	  		return array('failed' => false, 'error' => '');
	  	}
	  	else
	  	{
	  		return array('failed' => true, 'error' => 'please make sure that you did enter a valid name');
	  	}

	}

	  public function update_description(string $description)
	  {

	  	if(Regex::validate(Regex::RICHTEXT,$description))
	  	{
	  		$sql = "UPDATE categories SET description='".$description."' WHERE id=".$this->id;

	  		Request::query($sql);

	  		return array('failed' => false, 'error' => '');
	  	}
	  	else
	  	{
	  		return array('failed' => true, 'error' => 'please make sure that you did enter a valid description');
	  	}

	  }	

	public  function photos()
	{

		$list_photos = [];

		$sql = "SELECT id, title, name, date, description, file, owner 
				FROM photos p JOIN photo_category pc ON (p.id = pc.photo_id) WHERE pc.category_id = '".$this->id."' ;";


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
			return array('failed' => true, 'error' => 'this category has no photos.');
		}


	}

	public function __toString()
	{
		return "Category : [id] : ".$this->id."[name] : ".$this->name." [description] : ".$this->description." [photo_id]".$this->photo_id."\n";
	}
}



?>