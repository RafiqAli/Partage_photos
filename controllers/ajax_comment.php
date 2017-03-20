<?php

require_once('../Models/Photo.php');
require_once('../Models/Comment.php');
require_once('photos_controller.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
	//verifier le remplissage
	if( !empty($_POST['content_comment']) && !empty($_POST['photo_id']) && !empty($_POST['photo_owner'])) 
	{
        $id = 1;
        $content = $_POST['content_comment'];
        $photo_id = $_POST['photo_id'];
        $owner = $_POST['photo_owner'];

        $comment = new Comment($id, $content, $photo_id, $owner);
        $result = Comment::create($comment);

        if($result['failed'])
        {
            echo $photo_result['error'];
        }
        else
        {
          $_SESSION['success'] = "Commentaire ajoutee";

	      $photo_result = Photo::find($photo_id);


	      if ($photo_result['failed']) 
	      {
	            echo $photo_result['error'];
	      }
	      else
	      {
	            $photo = $photo_result['object'];
	            $comment_result = $photo->comments();
	            

	            if($comment_result['failed'])
	            {
	              echo $comment_result['error'];
	            }


	            else
	            {
	              $comments = $comment_result['objects'];	

	              foreach ($comments as $comment)
	              {
					  echo '<div class="well text-center">

					  <div class="row text-left">
					  <div class="col-md-1">
					  <div class="thumbnail">
					  <img class="img img-responsive " src="https://ssl.gstatic.com/accounts/ui/avatar_2x.png">
					  </div><!-- /thumbnail -->
					  </div><!-- /col-sm-1 -->

					  <div class="col-md-10">
					  <div class="panel panel-primary">
					  <div class="panel-heading">
					  <strong>'.$comment->owner.'</strong> | <em><span class="text-default">date: (En maintenance)</span></em>
					  </div>
					  <div class="panel-body">
					      '.$comment->content.'
					  </div><!-- /panel-body -->
					  </div><!-- /panel panel-default -->
					  </div><!-- /col-sm-5 -->

					  </div><!-- /row -->

					  </div>';
	              }
	            }
	      } 
        }
	}
}

?>
