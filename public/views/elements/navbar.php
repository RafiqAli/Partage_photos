        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="?controller=pages&action=home">Photoshare!</a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-form navbar-nav navbar-right">
                <li class="navbar-form">
                     <form>
                    <div class="form-group">
                        <input type="text" class="input-sm" placeholder="Search">
                        <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                    </div>
                    </form>
                </li>        
                <li class="dropdown navbar-form">
                    <button class="btn btn-primary btn-sm" href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i>
                                <?php if(isset($_SESSION['user']['username'])) 
                                        {
                                            echo $_SESSION['user']['username'];  
                                        }else
                                        {
                                            echo "Invite";
                                        }
                                   ?>
                    <b class="caret"></b></button>
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
             
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li class="active">
                        <a href="?controller=pages&action=home"><i class="fa fa-fw fa-home"></i> Acceuil</a>
                    </li>
                    <li>
                        <a href="?controller=photos&action=mes_photos"><i class="fa fa-fw fa-camera"></i> Mes photos</a>
                    </li>
                    <li>
                        <a href="?controller=friends&action=showall"><i class="fa fa-fw fa-users"></i> Groupes d'amis</a>
                    </li>                                      
        </nav>
