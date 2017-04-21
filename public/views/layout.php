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

    <!-- Custom Fonts -->
    <link href="res/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- Tags -->
    <link href="res/css/tags.css" rel="stylesheet">

    <!-- jQuery UI CSS-->
    <link href="../public/res/css/jquery-ui.min.css" rel="stylesheet">

    <!-- my style -->
    <link href="res/css/style.css" rel="stylesheet" type="text/css">

    <!-- jQuery -->
    <script src="res/js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="res/js/bootstrap.min.js"></script>

    <!-- Tags -->
    <script src="res/js/tags.js"></script>

    <!-- jQuery UI-->
    <script src="../public/res/js/jquery-ui.min.js"></script>


    <!-- START : Added to fix a bootstrap modal problem  -->

    <style type="text/css">
        
        body.modal-open div.modal-backdrop { 
            z-index: 0; 
        }
    </style>

    <!--  see : https://goo.gl/f9eRjY -->

    <!-- END :  Added to fix a bootstrap modal problem -->
    
  </head>


  <body>

<br><br><br><br>

<div class="container-fluid">


 <div class="container-fluid">
    <?php require_once('../routes.php'); ?> 
</div>

<div class="col-md-6 col-md-offset-3 modal-fade" data-backdrop="static" style="z-index: 100; top: 12%; left:auto; width:50%; position: fixed;">
  <?php require_once('views/elements/messages.php'); ?>  
</div>

<?php  include_once("./views/elements/footer.php"); ?>

</div>

  <body>
<html>