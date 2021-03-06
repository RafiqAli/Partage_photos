<?php 


require_once("../core/Request.php");
require_once("../core/Regex.php");
require_once("Photo.php");
require_once("../core/Enumerations.php");

class Rating
{

	const ONE_STAR    = 1;
	const TWO_STARS   = 2;
	const THREE_STARS = 3;
	const FOUR_STARS  = 4;
	const FIVE_STARS  = 5;

	public $photo_id;
	public $owner;
	public $value;
	public $description;
	public $date_created;

	public function __construct($photo_id,$owner,$value,$description,$date_created)
	{

		if(Regex::validate(Regex::DIGITS,$photo_id) 
			&& Regex::validate(Regex::NAME,$owner) 
				&& Regex::validate(Regex::DIGITS,$value)
					&& ( $description == null || Regex::validate(Regex::RICHTEXT,$description)))
		{

			 $this->photo_id      = $photo_id;
			 $this->owner         = $owner;
			 $this->value         = $value;
			 $this->description   = $description;
			 $this->date_created  = $date_created;
		
		}
		else
		{
			return array('failed' => true, 'error' => "some values are not set or have null values");
		}


	}


	public static function all()
	{

	  	$list = [];

		$sql = "SELECT * FROM ratings";

		$output = Request::execute($sql);

		if($output != null)
		{

		  	foreach ($output as $rating) {
		  		
		  		$list[] = new Rating($rating['photo_id'],$rating['owner'],$rating['value'],$rating['description']);
		  	}

		  	return  array('failed' => false, 'objects' => $list, 'error' => '');
	    }
	    else
	    {
	    	return array('failed' => true, 'error' => 'coudn\'t find ratings on database');
	    }

	}


	public static function find($photo_id,$owner)
	{

  		if(Regex::validate(Regex::DIGITS,$photo_id)
  			&& Regex::validate(Regex::NAME,$owner))
  		{

      		$sql = "SELECT * FROM ratings WHERE photo_id=".$photo_id." AND owner='".$owner."'";

      		$rating = Request::execute($sql);

      		if($rating != null)
      		{

      			$rating = $rating[0];

	      		$rating_instance = new Rating($rating['photo_id'],$rating['owner'],$rating['value'],$rating['description']);

	      		return array('failed' => false, 'object' => $rating_instance, 'error' => '');

      		}
      		else
      		{
      			return array('failed' => true, 'error' => 'we couldn\'t find a rating with this id value');
      		}

      	}
      	else
      	{
      		return array('failed' => true, 'error' => 'please enter a numeric value for the id');
      	}

	}

	public static function create($rating)
	{

		if(Regex::validate(Regex::DIGITS,$rating['photo_id']) 
			&& Regex::validate(Regex::NAME,$rating['owner']) 
				&& Regex::validate(Regex::DIGITS,$rating['value'])
					&& Regex::validate(Regex::RICHTEXT,$rating['description']))
		{	

			$sql = "INSERT INTO ratings (photo_id,owner,value,description,date_created) VALUES (:photo_id,:owner,:value,:description,Now())";

		 	$data = array(':photo_id' => $rating['photo_id'], ':owner' => $rating['owner'],':value' => $rating['value'], ':description' => $rating['description']);

		 	$output = Request::execute($sql,$data);

		 	$rating = new Rating($rating['photo_id'],$rating['owner'],$rating['value'],$rating['description']);

		 	return array('failed' => false, 'object' => $rating, 'error' => '');


		}
		else
		{
			return array('failed' => true, 'error' => 'please check the format of your fields');
		}	

	}

	public function update_value($value)
	{
		if(Regex::validate(Regex::DIGITS,$value))
	  	{
	  		$sql = "UPDATE ratings SET value = '".$value."' WHERE photo_id = ".$this->photo_id." AND owner='".$this->owner."';";

	  		Request::query($sql);

	  		return array('failed' => false, 'error' => '');
	  	}
	  	else
	  	{
	  		return array('failed' => true, 'error' => 'please make sure that you did enter a valid value');
	  	}

	} 

	public function update_description($description)
	{
		if(Regex::validate(Regex::RICHTEXT,$description))
	  	{
	  		$sql = "UPDATE ratings SET description = '".$description."' WHERE photo_id = ".$this->photo_id." AND owner='".$this->owner."';";

	  		Request::query($sql);

	  		return array('failed' => false, 'error' => '');
	  	}
	  	else
	  	{
	  		return array('failed' => true, 'error' => 'please make sure that you did enter a valid description');
	  	}

	} 

	public static function delete($photo_id,$owner)
	{

		if(Regex::validate(Regex::DIGITS,$photo_id)
			&& Regex::validate(Regex::NAME,$owner))
		{

			$sql = "DELETE FROM ratings WHERE photo_id=".$photo_id." AND owner='".$owner."';";

			$output = Request::query($sql);

			return array('failed' => false, 'output' => $output, 'error' => '');
		}
		else
		{
			return array('failed' => true, 'error' => 'please enter a numeric value');
		}		

	}

	public function __toString()
	{

	}
}


?>