<?php 

/*

	logIn
	logOut
	SignIn
	getAllPhotos
	getUserPhotos
	getMyPhotos
	addPhoto
	modifyPhoto
	addToFavorite
	getInfosByImage
	getCommentsByImage
	search
	notePhoto

*/

//Fonction d'autentification
public function logIn()
{
	require_once('../Models/User.php');

	$username = test_input($_GET['username']);
	$password = test_input($_GET['password']);
	if(!empty($username) && !empty($password))
	{
		try
		{
			$userInstance = User::find($username);
			if($userInstance->password == $password)
			{
				$response = json_encode($userInstance);
			}
		}
		catch(APIException $e)
		{
			$message = $e->getMessage();
			$response = "{ 'exception': '$message' }";
		}
	}
	else
	{
		$response = " { 'error': 'Veuillez remplir tous les champs!' } ";
	}
	echo $response;
}
////////////////////////////////////////////////////////////////////////

//Fonction de deconnexion
public function logOut()
{
	//cette fonction sera impelementé directement dans Android
}
////////////////////////////////////////////////////////////////////////

//Fonction d'enregistrement
public function SignIn()
{
	require_once('../Models/User.php');

	$username = test_input($_GET['username']);
	$password = test_input($_GET['password']);
	if(!empty($username) && !empty($password))
	{
		try
		{
			$user = array('login' => $username, 'password' => $password);
			$result = User::create($user);
			$response = " { 'success': 'Bienvenue!' } ";

		}
		catch(APIException $e)
		{
			$message = $e->getMessage();
			$response = "{ 'exception': '$message' }";
		}
	}
	echo $response;
}
///////////////////////////////////////////////////////////////

//Retourne toutes les photos
public function getAllPhotos()
{
	require_once('../Models/Photo.php');	
	try
	{
		$photos_result = Photo::all();
		$images = $photos_result['objects'];
		$response = json_encode($images);
	}
	catch(APIException $e)
	{
		$message = $e->getMessage();
		$response = "{ 'exception': '$message' }";
	}
	echo $response;
}
/////////////////////////////////////////////////////////////

//Retourne photo par utilisateur
public function getPhotosByUser()
{
	require_once('../Models/User.php');

	$username = test_input($_GET['username']);
	
	if(!empty($username))
	{
		try 
		{
			$user_result = User::find($username);
			$photos_result = $user_result['object']->photos();
			$images = $photos_result['objects'];
			$response = json_encode($images);
		} 
		catch (APIException $e) 
		{
			$response = '{ "exception": "'.($e->getMessage()).'" } ';
		}
	}
	else
	{
		$response = ' { "error": "Veuillez indiquer un utilisateur valide!" } ';
	}
	echo $response;
}
/////////////////////////////////////////////////////////////////////

//Ajoute photo dans la base de donnees
public function addPhoto()
{

}
/////////////////////////////////////////////////////////////////////

//Modifie les informations de photo
public function modifyPhoto()
{

}
/////////////////////////////////////////////////////////////////

//Ajoute aux favoris
public function addToFavorite()
{

}
/////////////////////////////////////////////////////////////

//Renvoie les infos d'une image et ses commentaires
public function getInfosByImage()
{
	require_once('../Models/Photo.php');

	$photoID = test_input($_GET['photoID']);
	
	if(!empty($photoID))
	{
		try 
		{
			$photo_result = Photo::find($photoID);
			$photo = $photo_result['object'];

            $comment_result = $photo->comments();
            $comments = $comment_result['objects'];

            $infos = json_encode($photo);
			$comments = json_encode($comments);

			$response = " {'infos': '$infos', 'comments': '$comments'} "
		} 
		catch (APIException $e) 
		{
			$response = '{ "exception": "'.($e->getMessage()).'" } ';
		}
	}
	else
	{
		$response = ' { "error": "Veuillez indiquer un ID de photo valide!" } ';
	}
	echo $response;
}

public function search()
{
	require_once('../Models/Photo.php');

	$keywords = test_input($_GET['keywords']);
	
	if(!empty($keywords))
	{
		try 
		{
	        $photo_result = Photo::search($keywords);
			$images = $photo_result['objects'];
			$response = json_encode($images);
		} 
		catch (APIException $e) 
		{
			$response = '{ "exception": "'.($e->getMessage()).'" } ';
		}
	}
	else
	{
		$response = ' { "error": "Veuillez indiquer une valeur de recherche!" } ';
	}
	echo $response;
}

public function notePhoto()
{

}


?>