<?php

require_once("../core/Request.php");
require_once("../core/Regex.php");
require_once("Photo.php");
require_once("core/Enumeration.php");



class LocalArea
{

	const COUNTRY = 1;
	const CITY    = 2;
	const STREET  = 3;

	public $id;
	public $street;
	public $city;
	public $country;

	public function __construct($id = null,$street,$city,$country)
	{
		if(Regex::validate(Regex::RICHTEXT,$street) 
			&& Regex::validate(Regex::NAME,$city) 
				&& Regex::validate(Regex::NAME,$country)
					&& ($id == null || Regex::validate(Regex::DIGITS,$id)))
		{
			 $this->id = $id;
			 $this->street = $street;
			 $this->city = $city;
			 $this->country = $country;
		}

	}





	public static function find($id)
	{

  		if(Regex::validate(Regex::DIGITS,$id))
  		{

      		$sql = "SELECT * FROM local_areas WHERE id=".$id;

      		$local_area = Request::execute($sql);

      		if($local_area != null)
      		{

      			$local_area = $local_area[0];

	      		$local_area_instance = new local_area($local_area['id'],$local_area['street'],$local_area['city'],$local_area['country']);

	      		return $local_area_instance;

      		}
      		else
      		{
      			throw new NotFoundException("we couldn't find a local area with this id value");
      			  
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

		$sql = "SELECT * FROM local_areas";

		$output = Request::execute($sql);

		if($output != null)
		{

		  	foreach ($output as $local_area) {
		  		
		  		$list[] = new local_area($local_area['id'],$local_area['street'],$local_area['city'],$local_area['country']);
		  	}

		  	return  $list;
	    }
	    else
	    {
	    	throw new NotFoundException("we coudn't find local areas on database");
	    }

	}


	public static function search($type,$key)
	{

		if(Regex::validate(Regex::DIGITS,$type)
			&& Regex::validate(Regex::RICHTEXT,$key))
		{
			switch ($type) {

				case LocalArea::COUNTRY : $sql = "SELECT * FROM photos p JOIN local_area la ON (p.local_area_id = la.id) WHERE la.country LIKE :key ";
					$data = array(':key' => "%" . $key . "%");
				break;

				case LocalArea::CITY    : $sql = "SELECT * FROM photos p JOIN local_area la ON (p.local_area_id = la.id) WHERE la.city LIKE :key "; 	
					$data = array(':key' => "%" . $key . "%");
				break;

				case LocalArea::STREET  : $sql = "SELECT * FROM photos p JOIN local_area la ON (p.local_area_id = la.id) WHERE la.street LIKE :key ";
					$data = array(':key' => "%" . $key . "%");

				break;
				
				default:
					
					throw new EnumerationException('please make sure the value that you entered is defined as a constant in the core/Enumeration/Sort class.');

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
				throw new NotFoundException('No photo had been found on the database.');
			}

		}
		else
		{
			throw new InvalidFormatException('please make sure you entered a valid numeric value.');
		}
	}

	public static function create($local_area)
	{
		if(Regex::validate(Regex::RICHTEXT,$local_area['street']) 
			&& Regex::validate(Regex::NAME,$local_area['city'])
				&& Regex::validate(Regex::NAME,$local_area['country']))
		{		

			$sql = "INSERT INTO categories (street,city) VALUES (:street,:city)";

		 	$data = array(':street' => $local_area['street'], 'city' => $local_area['city'], 'country' => $local_area['country']);

		 	$output = Request::execute($sql,$data);

		 	$local_area = new LocalArea(Request::lastInsertId(),$local_area['street'],$local_area['city'],$local_area['country']);

		 	return  $local_area;
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

			$sql = "DELETE FROM local_areas WHERE id=$id";

			$output = Request::query($sql);

			return  $output;
		}
		else
		{
			throw new InvalidFormatException('please enter a numeric value for the id');
		}

	}
	
	public function update_street($street)
	{

	  	if(Regex::validate(Regex::RICHTEXT,$street))
	  	{
	  		$sql = "UPDATE local_areas SET street = '".$street."' WHERE id = ".$this->id.";";

	  		Request::query($sql);
	  	}
	  	else
	  	{
	  		throw new InvalidFormatException();
	  	}

	}

	  public function update_city(string $city)
	  {

	  	if(Regex::validate(Regex::NAME,$city))
	  	{
	  		$sql = "UPDATE local_areas SET city='".$city."' WHERE id=".$this->id;

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