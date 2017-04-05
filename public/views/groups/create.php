<div class="well ">

<form class="form-horizontal" method="post" action="#">
<fieldset>

<!-- Form Name -->
<legend>Créer un nouveau groupe</legend>
<center><img class="im1" src="res/imgs/groups.png" class="img img-responsive" width="200px" /></center>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">Nom du groupe:</label>  
  <div class="col-md-4">
  <input id="textinput" name="nom_grp" type="text" placeholder="Nom groupe" class="form-control input-md">
  </div>
</div>

<!-- Textarea -->
<div class="form-group">
  <label class="col-md-4 control-label" for="textarea">Décriver votre groupe:</label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="textarea" name="desc_grp" placeholder="Description" style="resize:none"></textarea>
  </div>
</div>


<!-- Button -->
<div class="form-group">
  <div class="col-md-4">
    <button type="submit" name="submit_create_grp" class="btn btn-primary pull-right">Créer le groupe</button>
  </div>
</div>

</fieldset>
</form>


</div>