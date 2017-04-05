<div id="page-wrapper">

<div class="well text-center">

        <!-- page content -->
        <div class="right_col" role="main">
            <div class="page-title">

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

                      <h3 class="prod_title"><?php echo $photo->title; ?></h3>
 
                   <div class="x_content">
                    <br />
                    <form class="form-horizontal form-label-left">

                      <div class="item form-group">
                        <strong class="col-md-3 col-sm-3 col-xs-12" for="date">Date:
                        </strong>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <span> <?php echo $photo->date; ?> </span>
                        </div>
                      </div>

                      <div class="item form-group">
                        <strong class="col-md-3 col-sm-3 col-xs-12" for="date">Description:
                        </strong>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <span> <?php echo $photo->description; ?> </span>
                        </div>
                      </div>


                      <?php if ($_SESSION['user']['username'] == $photo->owner): ?>

                      <div class="form-group">
                        <div class="col-md-6 col-md-offset-3">
                          <a <?php echo 'href="?controller=photos&action=modif_photo&id='.$photo->id.'"';  ?>
                           class="btn btn-success">Modifier la photo</a>
                        </div>
                      </div>   

                      <?php endif ?>
 


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

          <!-- User comment -->
<div class="well text-center">

<legend>Ajouter un commentaire</legend>
  <div class="row text-left">
  <div class="col-md-1">
  <div class="thumbnail">
  <img class="img-responsive user-photo" src="https://ssl.gstatic.com/accounts/ui/avatar_2x.png">
  </div><!-- /thumbnail -->
  </div><!-- /col-sm-1 -->

  <form method="post">

  <div class="col-md-10">
  <div class="panel panel-info">
  <div class="panel-heading">
  <strong><?php echo $_SESSION['user']['username']; ?></strong> <span class="text-muted"></span>
  </div>

  <textarea class="panel-body responsive col-md-12" placeholder="Ajouter un commentaire..." id="content_comment"></textarea><!-- /panel-body -->

  <div class="clearfix"></div>

  <input type="hidden" id="photo_id" value="<?php echo $photo->id; ?>">
  <input type="hidden" id="photo_owner" value="<?php echo $photo->owner; ?>">


  </div><!-- /panel panel-default -->

  <div class="form-group pull-left">
    <div class="col-md-6">
      <button type="button" onclick="AjaxFunction2()" class="btn btn-success">Ajouter</button>
    </div>
  </div> 

  </div><!-- /col-sm-5 -->

  </form>

  </div><!-- /row -->

  </div>


<!-- All comments -->

<div id="all_comments">

<?php if (isset($comments)): ?>

<?php foreach ($comments as $comment): ?>
  
  <div class="well text-center">

  <div class="row text-left">
  <div class="col-md-1">
  <div class="thumbnail">
  <img class="img img-responsive " src="https://ssl.gstatic.com/accounts/ui/avatar_2x.png">
  </div><!-- /thumbnail -->
  </div><!-- /col-sm-1 -->

  <div class="col-md-10">
  <div class="panel panel-primary">
  <div class="panel-heading">
  <strong><?php echo $comment->owner; ?></strong> | <em><span class="text-default">date: (En maintenance)</span></em>
  </div>
  <div class="panel-body">
      <?php echo $comment->content; ?>
  </div><!-- /panel-body -->
  </div><!-- /panel panel-default -->
  </div><!-- /col-sm-5 -->

  </div><!-- /row -->

  </div>
<?php endforeach ?>

<?php endif ?>


</div>

</div>




<script>
function AjaxFunction2() {

  var content_comment = document.getElementById("content_comment").value;
  var photo_id = document.getElementById("photo_id").value;
  var photo_owner = document.getElementById("photo_owner").value;

  
if(content_comment != "")
{

  //le DOM qui va recevoir la requete
  var targetId = 'all_comments';
  //fichier php qui traite la requete
  var url = "/Partage_photos/controllers/ajax_comment.php";
  //parametres a envoyer

  var params = "content_comment="+content_comment+"&photo_id="+photo_id+"&photo_owner="+photo_owner;

    if (window.XMLHttpRequest) {
      // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }


    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
                document.getElementById(targetId).innerHTML = this.responseText;
        }
    };

    //for get you put the params inside the url and call send() empty;
    xmlhttp.open("POST", url, true);
    //Send the proper header information along with the request
  xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send(params);
}

}

</script>