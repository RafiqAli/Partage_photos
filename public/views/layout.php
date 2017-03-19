<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>
        PhotoShare -- Partagez vos photos
    </title>
    <!-- Bootstrap Core CSS -->
    <link href="res/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="res/css/sb-admin.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="res/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- my style -->
    <link href="res/css/style.css" rel="stylesheet" type="text/css">

  </head>


  <body>

<br><br>
<div class="container-fluid">

     <div class="container-fluid col-xs-offset-2">
        <?php require_once('../routes.php'); ?> 
    </div>
    <br>
    <div class="col-md-6 col-md-offset-4 modal-fade" data-backdrop="static" style="z-index: 100; top: 30%; left:auto; width:50%; position: fixed;">
      <?php require_once('views/elements/messages.php'); ?>  
    </div>

    <footer>
            <?php  include_once("./views/elements/footer.php"); ?>
    </footer>

</div>
      <!-- jQuery -->
    <script src="res/js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="res/js/bootstrap.min.js"></script>
  
  <body>
<html>