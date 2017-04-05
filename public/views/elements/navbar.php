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
</nav>
