<div id="page-wrapper">

<div class="well text-center">
            <!-- page content -->
        <div class="right_col" role="main">
        
        <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_content">

                    <div class="col-md-7 col-sm-7 col-xs-12">
                      <div class="product-image">

                        <img <?php echo 'src="../public/res/users/'.$photo->owner.'/'.$photo->file.'"';  ?>     <?php echo 'alt="'.$photo->title.'"';  ?>

                            class="img img-responsive" />

                      </div>
                    </div>

                    <div class="col-md-5 col-sm-5 col-xs-12" style="border:0px solid #e5e5e5;">

                      <h3 class="prod_title">Modifier votre photo</h3>
 
                   <div class="x_content">
                    <br />

                    <form class="form-horizontal form-label-left" method="post">
                      
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="titre">Titre <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="titre" class="form-control col-md-7 col-xs-12" name="title" required="required" type="text" value="<?php echo $photo->title; ?>">
                        </div>
                      </div>


                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="date">Date<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="date" id="date" name="date" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $photo->date; ?>">
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">Description <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <textarea id="textarea" required="required" name="desc" class="form-control col-md-7 col-xs-12"><?php echo $photo->description; ?></textarea>
                        </div>
                      </div>        
                      <input type="hidden" name="photo_id" value="<?php echo $_GET['id']; ?>">              
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-md-offset-3">
                          <input type="submit" name="submit_modif" class="btn btn-success" value="Valider"/>
                          <input type="reset" class="btn btn-primary" value="Effacer"/>
                        </div>
                      </div>
                    </form>
                  </div>
                    </div>

                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->


</div>

</div>