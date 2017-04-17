
                  <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Formulaire d'ajout</h2>
  
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">


                    <form class="form-horizontal form-label-left" method="post" action="?controller=photos&action=ajout_photo" enctype="multipart/form-data">
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Titre de photo <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">

                          <input id="title" class="form-control col-md-7 col-xs-12" name="title" required="required" type="text">


                        </div>
                      </div>

                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="date">Date de prise<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">


                        <input type="date" id="date" name="date" required="required" class="form-control col-md-7 col-xs-12">


                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">Description <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">


                          <textarea id="description" required="required" name="description" class="form-control col-md-7 col-xs-12"></textarea>


                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="date">Selectionner<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">


                        <input type="file" id="file" name="file_upload" required="required" class="form-control col-md-7 col-xs-12">

                        <input type="hidden" name="owner" value="<?php echo $_SESSION['user']['username']; ?>">

                        </div>
                      </div>  


                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tags">Categorie(Tags) <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">

                          <input id="tags" data-role="tagsinput" class="form-control col-md-7 col-xs-12" name="tags" required="required" type="text">


                        </div>
                      </div>


                                          
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-md-offset-3">
                          <input type="submit" name="submit_addphoto" value="Ajouter" class="btn btn-success">
                          <input type="reset" name="reset_photo" value="Vider les champs" class="btn btn-primary">
                        </div>
                      </div>
                    </form>


                  </div>
                </div>
              </div>