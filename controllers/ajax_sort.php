<?php

//function for removing special chars
function test_input($data)
{
  $data=trim($data);//remove extra space
  $data=stripslashes($data);//remove backslash
  $data=htmlspecialchars($data);//remove special char

  return $data;
}


require_once('../Models/Photo.php');
require_once('photos_controller.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
	//verifier le remplissage
	if( !empty($_POST['type'])) 
	{

		$type = test_input($_POST['type']);
		$username = test_input($_POST['username']);

		if($type == "newest")
		{
			try
			{

				$images = Photo::sort(Sort::NEWEST);
				$string = "";
				foreach ($images as $image )	
				{
					$string .= '<div class="col-sm-6 col-md-4">
					    <div class="thumbnail img-rounded">
					      <img src="../public/res/users/'.$image->owner.'/'.$image->file.'" alt="../'.$image->title.'" />
					      <div class="caption">
					        <h3>'.$image->title.'</h3>
					        <p>'.$image->description.'</p>
					        <p>
					          <a href="?controller=photos&action=affiche_photo&id='.$image->id.'" class="btn btn-primary" role="button"><span class="fa fa-eye" aria-hidden="true"></span></a>';

					if( $image->owner == $username )
					{
						$string .= '<a href="?controller=photos&action=modif_photo&id='.$image->id.'" class="btn btn-default" role="button"><span class="glyphicon glyphicon-pencil"></span></a>';
					}

					$string .='</p>
					      </div>

					    </div>

					  </div>';
				}

				echo $string;
			}
			catch (Exception $e)
			{
				echo $e->getMessage();
			}
		}

		else if($type == "oldest")
		{
			try
			{
				$images = Photo::sort(Sort::OLDEST);
				$string = "";
				foreach ($images as $image )	
				{
					$string .= '<div class="col-sm-6 col-md-4">
					    <div class="thumbnail img-rounded">
					      <img src="../public/res/users/'.$image->owner.'/'.$image->file.'" alt="../'.$image->title.'" />
					      <div class="caption">
					        <h3>'.$image->title.'</h3>
					        <p>'.$image->description.'</p>
					        <p>
					          <a href="?controller=photos&action=affiche_photo&id='.$image->id.'" class="btn btn-primary" role="button"><span class="fa fa-eye" aria-hidden="true"></span></a>';

					if($image->owner == $username)
					{
						$string .= '<a href="?controller=photos&action=modif_photo&id='.$image->id.'" class="btn btn-default" role="button"><span class="glyphicon glyphicon-pencil"></span></a>';
					}

					$string .='</p>
					      </div>

					    </div>

					  </div>';
				}
				echo $string;
			}
			catch (Exception $e)
			{
				echo $e->getMessage();
			}
		}
		else if($type == "best")
		{
			try
			{
				$images = Photo::sort(Sort::TOP_RATED);
				$string = "";
				foreach ($images as $image )	
				{
					$string .= '<div class="col-sm-6 col-md-4">
					    <div class="thumbnail img-rounded">
					      <img src="../public/res/users/'.$image->owner.'/'.$image->file.'" alt="../'.$image->title.'" />
					      <div class="caption">
					        <h3>'.$image->title.'</h3>
					        <p>'.$image->description.'</p>
					        <p>
					          <a href="?controller=photos&action=affiche_photo&id='.$image->id.'" class="btn btn-primary" role="button"><span class="fa fa-eye" aria-hidden="true"></span></a>';

					if($image->owner == $username)
					{
						$string .= '<a href="?controller=photos&action=modif_photo&id='.$image->id.'" class="btn btn-default" role="button"><span class="glyphicon glyphicon-pencil"></span></a>';
					}

					$string .='</p>
					      </div>

					    </div>

					  </div>';
				}
				echo $string;
			}
			catch (Exception $e)
			{
				echo $e->getMessage();
			}
		}
		else if($type == "worst")
		{
			try
			{
				$images = Photo::sort(Sort::LOW_RATED);
				$string = "";
				foreach ($images as $image )	
				{
					$string .= '<div class="col-sm-6 col-md-4">
					    <div class="thumbnail img-rounded">
					      <img src="../public/res/users/'.$image->owner.'/'.$image->file.'" alt="../'.$image->title.'" />
					      <div class="caption">
					        <h3>'.$image->title.'</h3>
					        <p>'.$image->description.'</p>
					        <p>
					          <a href="?controller=photos&action=affiche_photo&id='.$image->id.'" class="btn btn-primary" role="button"><span class="fa fa-eye" aria-hidden="true"></span></a>';

					if($image->owner == $username)
					{
						$string .= '<a href="?controller=photos&action=modif_photo&id='.$image->id.'" class="btn btn-default" role="button"><span class="glyphicon glyphicon-pencil"></span></a>';
					}

					$string .='</p>
					      </div>

					    </div>

					  </div>';
				}
				echo $string;
			}
			catch (Exception $e)
			{
				echo $e->getMessage();
			}
		}
	}
}
?>

