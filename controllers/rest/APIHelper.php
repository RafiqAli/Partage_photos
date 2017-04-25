<?php

require_once("../Models/Photo.php");

class APIHelper
{


	public function create_photo($photo,$photo_name)
	{

			// generate unique identifier for photo_name

				// had not been done yet.

			$login = $photo['owner'];

			// the function will move the image with specified name to the appropriate 
			// location a.k.a public/res/users/{user}/

			$uploads_dir = "/public/res/users/$login/";

			if(move_uploaded_file($photo_name, "$uploads_dir/$name"))
			{
				// i dont know whether to modify the create function on Photo model
				// or to execut the insert SQL from here.
				
				//Photo::create($photo,null);

				$sql = "INSERT INTO photos (title,name,date,description,file,owner) VALUES (:title,:name,:date,:description,:file,:owner)";

				 $data = array(':title'        => $photo['title'],
	  						   ':name'         => $photo['name'],
		  					   ':date'         => $photo['date'],
		  					   ':description'  => $photo['description'],
		  					   ':file'         => Upload::get_generated_file_name(), // need to be replaced
		  					   ':owner'        => $photo['owner']);

			Request::execute($sql,$data); 
				
			}
			else
			{
				throw new FileOperationException("There were an internal error while inserting this picture on the model");
			}

			// if an error occured the function will launch an Exceptions/FileOperationException

	}


	public static function gain_access($login,$api_key)
	{
		$result = self::query("SELECT COUNT(login) AS 'Exists' FROM users WHERE login='$login' AND api_key='$api_key'");

		$exists = $result['Exists'];

		if($exists == 0)
		{
			throw UnAuthorizedException("this APIKey is invalid");
		}


	}

	public static function query($sql)
	{
		try
		{
			return Request::execute($sql)[0];
		}
		catch(PDOException $e)
		{

			echo $e->getMessage();
			return null;
		}

	}
}


?>