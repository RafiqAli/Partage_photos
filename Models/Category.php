<?php

require_once("../core/Request.php");
require_once("../core/Regex.php");
require_once("Photo.php");
require_once("../core/Enumerations.php");

require_once("../Exceptions/InvalidFormatException.php");
require_once("../Exceptions/NotFoundException.php");



class Category
{

	const ALL = 0;

	public $id;
	public $name;
	public $description;
	public $photo_id;

	public function __construct($id = null,$name,$description)
	{
		if(Regex::validate(Regex::NAME,$name) 
			&& Regex::validate(Regex::RICHTEXT,$description) 
				&& ($id == null|| Regex::validate(Regex::DIGITS,$id)))
		{
			 $this->id = $id;
			 $this->name = $name;
			 $this->description = $description;
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

	      		$category_instance = new Category($category['id'],$category['name'],$category['description']);

	      		return $category_instance;

      		}
      		else
      		{
      			throw new NotFoundException("we couldn't find a category with this id value");
      			  
      		}

      	}
      	else
      	{
      		throw new InvalidFormatException("please enter a numeric value for the id");
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
		  		
		  		$list[] = new category($category['id'],$category['name'],$category['description']);
		  	}

		  	return  $list;
	    }
	    else
	    {
	    	throw new NotFoundException("we coudn't find categories on database");
	    }

	}

	public static function create($category)
	{

		if(Regex::validate(Regex::NAME,$category['name']) 
			&& Regex::validate(Regex::RICHTEXT,$category['description']))
		{		

			$sql = "INSERT INTO categories (name,description) VALUES (:name,:description)";

		 	$data = array(':name' => $category['name'], 'description' => $category['description']);

		 	$output = Request::execute($sql,$data);

		 	$category = new Category(Request::lastInsertId(),$category['name'],$category['description']);

		 	return  $category;
		}
		else
		{
			throw new InvalidFormatException("please check the format of your fields");
		} 
	}

	public static function delete($id)
	{

		if(Regex::validate(Regex::DIGITS,$id))
		{

			$sql = "DELETE FROM categories WHERE id=$id";

			$output = Request::query($sql);

			return  $output;
		}
		else
		{
			throw new InvalidFormatException('please enter a numeric value for the id');
		}

	}
	
	public function update_name($name)
	{

	  	if(Regex::validate(Regex::NAME,$name))
	  	{
	  		$sql = "UPDATE categories SET name = '".$name."' WHERE id = ".$this->id.";";

	  		Request::query($sql);
	  	}
	  	else
	  	{
	  		throw new InvalidFormatException();
	  	}

	}

	  public function update_description(string $description)
	  {

	  	if(Regex::validate(Regex::RICHTEXT,$description))
	  	{
	  		$sql = "UPDATE categories SET description='".$description."' WHERE id=".$this->id;

	  		Request::query($sql);
	  	}
	  	else
	  	{
	  		throw new InvalidFormatException();
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

			return $list_photos;
		}
		else
		{
			throw new  NotFoundException("this category has no photos.");
		}


	}

	public function __toString()
	{
		return "Category : [id] : ".$this->id.", [name] : ".$this->name.", [description] : ".$this->description."\n";
	}
}



?>