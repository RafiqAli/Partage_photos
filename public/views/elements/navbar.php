<nav class="navbar navbar-fixed-top navbar-inverse">
  <div class="container-fluid">

    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="?controller=pages&action=home">Photoshare</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        
        <li><a href="?controller=pages&action=home"><i class="fa fa-home"></i> Acceuil</a></li>

        <li><a href="?controller=photos&action=mes_photos"><i class="fa fa-camera"></i> Mes photos</a></li>

        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-users"></i> Groupes privés<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="?controller=groups&action=my_groups">Mes groupes</a></li>
            <li><a href="?controller=groups&action=show_all">Voir tous les groupes</a></li>
            <li><a href="?controller=groups&action=create">Créer votre groupe</a></li>
          </ul>
        </li>
      </ul>

<span class="divider-vertical"></span>
      <form class="navbar-form navbar-left" method="post" action="?controller=photos&action=cherche_photo">
        <div class="form-group">
          <input type="search" class="form-control" placeholder="Rechercher" name="mot_cle">
        </div>
        <input type="submit" name="submit_recherche" class="btn btn-primary btn-sm" value="chercher" />
        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal">chercher par date</button>

      </form>

      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> 
          <i class="fa fa-user"></i>
            <?php if(isset($_SESSION['user']['username'])) 
                    {
                        echo $_SESSION['user']['username'];  
                    }else
                    {
                        echo "Invite";
                    }
               ?> 
            <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li>
                <a href="#"><i class="fa fa-fw fa-user"></i> Profile</a>
            </li>
            <li>
                <a href="#"><i class="fa fa-fw fa-envelope"></i> Inbox</a>
            </li>
            <li>
                <a href="#"><i class="fa fa-fw fa-gear"></i> Paramètres</a>
            </li>
            <li class="divider"></li>
            <li>
                <a href="?controller=pages&action=logout"><i class="fa fa-fw fa-power-off"></i> Deconnexion</a>
            </li>
          </ul>
        </li>


      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->




<!--  Recherche par date -->

  <?php require_once($_SERVER['DOCUMENT_ROOT']."/core/Enumerations.php"); ?>


  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Recherche par date</h4>
        </div>
        <div class="modal-body">
          


      <div id="accordion">

        <h3>Avant une date</h3>
        <div>
          <div class="container-fluid">
            <div class="row">
             
              <!-- Before date form -->

              <form class="navbar-form navbar-left" method="post" action="?controller=photos&action=cherche_photo_par_date">
              
                <!-- Hidden input to identify the type of the sort -->
                <input type="hidden" name="search_date_type" value="<?= Search::BEFORE_DATE ?>" >
                
                <div class="col-md-8 col-sm-8">
                  <input type="date" class="form-control" name="before_date">
                </div>
                <div class="col-md-4 col-sm-4">
                  <input type="submit" name="submit_search_date" class="btn btn-info btn-sm" value="Valider">
                </div>
              </form>

              <!-- Before date form -->

            </div>
          </div>
        </div>

        <h3>Après une date</h3>

        <div>
          <div class="container-fluid">
            <div class="row">

              <!-- Before date form -->

              <form class="navbar-form navbar-left" method="post" action="?controller=photos&action=cherche_photo_par_date">
               
                  <!-- Hidden input to identify the type of the sort -->
                <input type="hidden" name="search_date_type" value="<?= Search::AFTER_DATE ?>" >

                <div class="col-md-8 col-sm-8">
                  <input type="date" class="form-control" name="after_date">
                </div>
                <div class="col-md-4 col-sm-4">
                  <input type="submit" name="submit_search_date" class="btn btn-info btn-sm" value="Valider">
                </div>
              
              </form>
              
              <!-- end after date form -->

            </div>
          </div>
        </div>

        <h3>Entre deux dates</h3>
        <div>


                     
          <div class="container-fluid">

              <!-- Before date form -->
   
              <div class="row">

                 <form class="navbar-form navbar-left" method="post" action="?controller=photos&action=cherche_photo_par_date">


                <table>
                <tr>
                    <!-- Hidden input to identify the type of the sort -->
                  <td><input type="hidden" name="search_date_type" value="<?= Search::BETWEEN_DATES ?>" ></td>
                  <td><label style="padding-top: 5px;" >Entre &nbsp;</label></td>
                  <td><input type="date" class="form-control" name="between_dates_one"></td>
                  <td><label style="padding-top: 5px;">&nbsp; &nbsp; et &nbsp; &nbsp; </label></td>
                  <td><input type="date" class="form-control" name="between_dates_two"></td>
                </tr>

                <tr>
                  <td colspan="5">
                    <center><input type="submit"  name="submit_search_date" class="btn btn-info btn-sm" value="Valider" style="margin-top: 10px;"></center>
                  </td>
                </tr>

              </table>

              </form>
              </div>

              <!-- end between dates form -->

            </div>

          </div>

         

        </div>

      </div>


        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>



    <script>
/*      $( function() {
        $( "#accordion" ).accordion();
      } );*/

    $(function() { $("#accordion").accordion({
     heightStyle: "content",
     autoHeight: false,
     clearStyle: true
      });
    });

      </script>


</nav>
