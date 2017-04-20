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
require_once('../Models/Comment.php');
require_once('photos_controller.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
 try
 {
  //verifier le remplissage
  if( !empty($_POST['content_comment']) && !empty($_POST['photo_id']) && !empty($_POST['photo_owner'])) 
  {
         $id = 1;
         $content = test_input($_POST['content_comment']);
         $photo_id = test_input($_POST['photo_id']);
         $owner = test_input($_POST['photo_owner']);

         $comment = new Comment($id, $content, $photo_id, $owner);
         $result = Comment::create($comment);

         $_SESSION['success'] = "Commentaire ajoutee";
      $photo = Photo::find($photo_id);
      $comments = $photo->comments();

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
 catch (Exception $e)
 {
   echo $e->getMessage();
 }
}

?>
