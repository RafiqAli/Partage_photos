<div id="page-wrapper">
          <!-- Page Heading -->
<div class="well text-center">



<div class="row">  
<legend>Resultats de recherche</legend>
</div>


 <?php 
if (isset($images)) 
{
  foreach ($images as $image ) {
?>

<div class="row">

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
