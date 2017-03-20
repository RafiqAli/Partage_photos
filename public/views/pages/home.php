<div id="page-wrapper">

<div class="well text-center">
    <div class="row">  
      <div class="col-md-8 col-md-offset-2"><button data-toggle="collapse" data-target="#afficher_form_ajout" type="button" class="btn btn-primary btn-lg btn-block">Ajouter une photo</button></div>
    </div>

   <div id="afficher_form_ajout" class="row collapse">
             <?php include_once("views/photos/ajoute_photo.php");  ?>
    </div>

</div>

          <!-- Page Heading -->
<div class="well text-center">


    <div class="row">  
    <div class="col-md-10">
      <legend>Gallerie de photos</legend>
    </div>

    <div class="col-md-2">

    <?php require_once('views/elements/sort_view.php'); ?>

    </div>


    </div>


<div class="row" id="gallerie">

 <?php 

if (isset($images)) 
{
  foreach ($images as $image ) {
?>


  <div class="col-sm-6 col-md-4" >
    <div class="thumbnail img-rounded">

      <img <?php echo 'src="../public/res/users/'.$image->owner.'/'.$image->file.'"';  ?>     <?php echo 'alt="../'.$image->title.'"';  ?>
      />

      <div class="caption">
        <h3><?php echo $image->title; ?></h3>
        <p><?php echo $image->description; ?></p>
        <p>

          <a 
           <?php echo 'href="?controller=photos&action=affiche_photo&id='.$image->id.'"';  ?>

          class="btn btn-primary" role="button"><span class="fa fa-eye" aria-hidden="true"></span></a>
          <?php if ($_SESSION['user']['username'] == $image->owner): ?>
            <a 
            <?php echo 'href="?controller=photos&action=modif_photo&id='.$image->id.'"';  ?>

             class="btn btn-default" role="button"><span class="glyphicon glyphicon-pencil"></span></a>
          <?php endif ?>

        </p>
      </div>

    </div>

  </div>


<?php

}
}
?>


</div>

</div>
</div>
