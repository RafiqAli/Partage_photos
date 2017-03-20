<div id="page-wrapper">

<div class="well">
<div class="col-md-offset-10">
<!-- Example split danger button -->
<div class="btn-group">
  <button type="button" class="btn btn-sm btn-info">Tri par : </button>
  <button type="button" class="btn btn-sm btn-info dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <span class=""><span class="fa fa-caret-down"></span>
  </button>
  <div class="dropdown-menu">
    <button type="button" class="btn btn-block" href="#">Nom</button>
    <button type="button" class="btn btn-block" href="#">Propriétaire</button>
    <button type="button" class="btn btn-block" href="#">Date</button>
    <button type="button" class="btn btn-block" href="#">Description</button>
  </div>
</div>
</div>
</div>

<div class="well text-center">
    <div class="row">  
      <div class="col-md-8 col-md-offset-2"><button data-toggle="collapse" data-target="#afficher_form_ajout" type="button" class="btn btn-primary btn-lg btn-block">Ajouter une photo</button></div>
    </div>

   <div id="afficher_form_ajout" class="row collapse">
             <?php include_once("ajoute_photo.php");  ?>
    </div>

</div>

          <!-- Page Heading -->
<div class="well text-center">


    <div class="row">  
    <legend>Photos de <?php echo $_SESSION['user']['username']; ?></legend>
    </div>


<div class="row">

 <?php 


if (isset($images)) 
{
  foreach ($images as $image ) {
?>


  <div class="col-sm-6 col-md-4">
    <div class="thumbnail img-rounded">

      <img <?php echo 'src="../public/res/users/'.$image->owner.'/'.$image->file.'"';  ?>     <?php echo 'alt="../'.$image->title.'"';  ?>
      />

      <div class="caption">
        <h3><?php echo $image->title; ?></h3>
        <p><?php echo $image->description; ?></p>
        <p>

          <a <?php echo 'href="?controller=photos&action=affiche_photo&id='.$image->id.'"';  ?>class="btn btn-primary" role="button"><span class="fa fa-eye" aria-hidden="true"></span></a>
          <a <?php echo 'href="?controller=photos&action=modif_photo&id='.$image->id.'"';  ?>
           class="btn btn-default" role="button"><span class="glyphicon glyphicon-pencil"></span></a>

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
