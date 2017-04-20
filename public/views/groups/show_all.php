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
      <legend>Tous les groupes</legend>
    </div>

    <div class="col-md-2">

    <?php require_once('views/elements/sort_view.php'); ?>

    </div>


    </div>


<div class="row" id="gallerie">

 <?php 

if (isset($groups)) 
{
  foreach ($groups as $group ) {
?>


<div class="col-md-3 col-sm-6">
    <div class="thumbnail">
        <img src="res/imgs/groups.png" alt="" class="img-circle img-thumbnail img-responsive" width="150px">
        <div class="caption">
            <h3><?= $group->title ?></h3>
            <p><?= $group->description ?>.</p>
            <p>
                <a href="#" class="btn btn-primary"><i class="fa fa-eye" aria-hidden="true"></i> Consulter</a> <a href="#" class="btn btn-danger"><i class="fa fa-sign-out" aria-hidden="true"></i> Quitter</a>
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
