<?php

require_once('../Models/Photo.php');
require_once('photos_controller.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
	//verifier le remplissage
	if( !empty($_POST['type'])) 
	{
		$type = $_POST['type'];

		if($type == "newest")
		{
			$result = Photo::sort(Sort::NEWEST);

			if ($result['failed']) 
	        {
	          $_SESSION['error'] = $result['error'];
	          echo "Erreur lors de la manipulation ".$result['error'];
	        }
	        else
	        {
				$images = $result['objects'];
				foreach ($images as $image ) 
				$string = "";
				{

				$string .= '<div class="col-sm-6 col-md-4">
				    <div class="thumbnail img-rounded">
				      <img src="../public/res/users/'.$image->owner.'/'.$image->file.'" alt="../'.$image->title.'" />
				      <div class="caption">
				        <h3>'.$image->title.'</h3>
				        <p>'.$image->description.'</p>
				        <p>
				          <a href="?controller=photos&action=affiche_photo&id='.$image->id.'" class="btn btn-primary" role="button"><span class="fa fa-eye" aria-hidden="true"></span></a>
				          <a href="?controller=photos&action=modif_photo&id='.$image->id.'" class="btn btn-default" role="button"><span class="glyphicon glyphicon-pencil"></span></a>
				        </p>
				      </div>

				    </div>

				  </div>';

				}

				echo $string;	               
	        }
		}
		else if($type == "oldest")
		{
			echo "old";
		}
		else if($type == "best")
		{
			echo "Cette fonctionnalité sera ajouté dans la prochaine mise à jour";
		}
		else if($type == "worst")
		{
			echo "Cette fonctionnalité sera ajouté dans la prochaine mise à jour";
		}

	}

}

?>