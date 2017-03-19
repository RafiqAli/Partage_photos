<!DOCTYPE html>
<html lang="fr">

  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Page d'Acceuil </title>

    <!-- Bootstrap -->
    <link href="./ressources/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="./ressources/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">

    <!-- Custom styling plus plugins -->
    <link href="./ressources/build/css/custom.min.css" rel="stylesheet">
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">

          <?php include_once("./views/semantic_elements/navigation_gauche.php");  ?>

        <!-- top navigation -->
            <?php   include_once("./views/semantic_elements/top_navigation.php"); ?>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Groupe d'amis <small>liste de vos amis</small></h3>
              </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">

                  <div class="x_content">
                    <table id="datatable" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>Nom  </th>
                        </tr>
                      </thead>


                      <tbody>
                        <tr>
                          <td>Tiger Nixon</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->

        <!-- footer content -->
            <?php   include_once("./views/semantic_elements/footer.php"); ?>
        <!-- /footer content -->
      </div>
    </div>
    
    <!-- jQuery -->
    <script src="./ressources/vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="./ressources/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="./ressources/vendors/fastclick/lib/fastclick.js"></script>
    <!-- Custom Theme Scripts -->
    <script src="./ressources/build/js/custom.min.js"></script>



  </body>
</html>