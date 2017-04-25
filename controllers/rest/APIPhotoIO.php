<?php

require_once("APIHelper.php");

class APIPhotoIO
{


public static function insert_photo()
{

	try
	{
		// get the post request headers
		$headers = getallheaders();

		// make sure the attributes login and api_key exists
		if(!(isset($headers['login']) || isset($headers['api_key']))) 
					throw new UnauthorizedAccessException("undefined login and api_key attributes");

		// making sure they contains a not empty value
		if(empty($headers['login']) || empty($headers['api_key'])) 
					throw new UnauthorizedAccessException("empty login or api_key field");

		// try to gain access
		$login    = $headers['login'];
		$password = $headers['api_key'];

		APIHelper::gain_access($login,$password);

		//get json from php input stream
		$json = file_get_contents('php://input');
		// parse it
		$photo = json_decode($json);

		// select count(photos) related to user to use it
		// in order to differenciate between photos within
		// the same directory.
	 
		//returns array	
		$user_photo_count = APIHelper::query("SELECT SUM(p.id) AS 'photo_count' FROM photos p WHERE owner='$login'");
		
		// get sum value
		$user_photo_count = $user_photo_count['photo_count'];

		$user_photo_count++;

		// get the type of the photo
			$photo_name = $photo->name;
			$photo_portions = explode('.', $photo_name); 
			$photo_type = $photo_portions[1];

		// [ not sure about this method ]

		// write file-name following the scheme user_photos_count 
		$photo_name = $login . '_' . $user_photo_count. '.' . $photo_type;
		// add the direcotory as a prefix 
		$path_photo_name = "photo_tmp/" . $photo_name;
		// decode the photo  
		$base64data = $photo->base64_photo;
		$decoded_photo = base64_decode($base64data);
		// create it to photo_tmp directory

		file_put_contents($photo_name,$decoded_photo);
				// make sure the photo is valid (optional)
				// exclude base64 from photo json (optional)
		// generate unique identifier for photo_name

		$unique_photo_name = uniqid() . '.' . $photo_type;

		// the function will move the image with specified name to the appropriate 
		// location a.k.a public/res/users/{user}/

		$uploads_dir = $_SERVER['DOCUMENT_ROOT']."/public/res/users/$login/";

		Upload::upload_dir($login);

		$next_photo_location = $uploads_dir . $unique_photo_name;

		//echo "next location : " . $next_photo_location . "\n";
		//echo "photo_name : " . $photo_name . "\n";



		if(rename($photo_name, $next_photo_location))
		{

			$sql = "INSERT INTO photos (title,name,date,description,file,owner) VALUES (:title,:name,:date,:description,:file,:owner)";

			 $data = array(':title'        => $photo->title,
	  					   ':name'         => $photo->name,
		  				   ':date'         => $photo->date,
		  				   ':description'  => $photo->description,
		  				   ':file'         => $unique_photo_name, // the new unique name, in order to avoid conflict issues
		  				   ':owner'        => $photo->owner);

			Request::execute($sql,$data);


			} else throw new ServerFileOperationException("could not move file to the appropriate place.");


		$message = 'your photo is now on our server';
		return json_encode("{ state: 'success',message: '$message'}");

	}
	catch (UnauthorizedAccessException $uae)
	{
		$exception = $uae->simpleError();
		return json_encode("{ 'exception': '$exception' }");	
	}
	catch(JSONException $je)
	{
		$exception = $uae->simpleError();
		return json_encode("{ 'exception': '$exception' }");		
	}
	catch(SQLExcption $sql_e)
	{
		$exception = $uae->simpleError();
		return json_encode("{ 'exception': '$exception' }");
	}
	catch(ServerFileOperationException $foe)
	{
		$exception = $foe->simpleError();
		return json_encode("{ 'exception': '$exception' }");
	}
	catch (PDOException $pdoe)
	{	 
		$exception = "There were an internal error while inserting this picture on the model";
		return json_encode("{ 'exception': '$exception' }");
	}
	catch(Exception $e)
	{
		$exception = $e->simpleError();
		return json_encode("{ 'exception': '$exception' }");
	}

}

//print_r(getallheaders());





public static function get_photo($id)
{

	try
	{


		// make sure the attributes login and api_key exists
		if(!(isset($_GET['login']) || isset($_GET['api_key']))) 
					throw new UnauthorizedAccessException("undefined login and api_key attributes");

		// making sure they contains a not empty value
		if(empty($_GET['login']) || empty($_GET['api_key'])) 
					throw new UnauthorizedAccessException("empty login or api_key field");

		// try to gain access
		$login    = $_GET['login'];
		$password = $_GET['api_key'];

		APIHelper::gain_access($login,$password);

		// call the find method to get photos attributes
		$photo = Photo::find($id);

		// get the path of the image
		
		$path_to_photo =  $_SERVER['DOCUMENT_ROOT']."/public/res/users/". $photo->owner . '/' . $photo->file;

		// get the data from the file
		
		$photo_data = file_get_contents($path_to_photo);

		if ($photo_data == false) throw new ServerFileOperationException("could not read from photo file.");

		// encode it in base64
		$encoded_photo = base64_encode($photo_data);
		
		// cast photo object into an associative array
		 
		$photo_array = (array) $photo;

		//inject it in photo array
		$photo_array['base64_photo'] = $encoded_photo;

		// transform the associative array to JSON with the json_encode function
		return json_encode($photo_array);
	
	}
	catch (UnauthorizedAccessException $uae)
	{
		$exception = $uae->simpleError();
		return json_encode("{ 'exception': '$exception' }");	
	}
	catch (NotFoundException $nfe)
	{
		$exception = $nfe->simpleError();

		return json_encode("{ 'exception': '$exception' }");
	}
	catch(ServerFileOperationException $foe)
	{
		$exception = $foe->simpleError();
		return json_encode("{ 'exception': '$exception' }");
	}
	catch (PDOException $pdoe)
	{	 
		$exception = "There were an internal error while fetching data from database";
		return json_encode("{ 'exception': '$exception' }");
	}


}

}



//file_put_contents('image.jpg',base64_decode(json_decode(file_get_contents('php://input'))->base64_photo));


?>
