  <form method="post"> 
          <div id="page-wrapper">
          <!-- Page Heading -->
        <div class="row">
            <div class="col-md-4 col-md-offset-4 text-center">
                <h1 class="page-header">
                    Inscription
                </h1>
                <ol class="breadcrumb">
                    <li class="active">
                         Entrez vos informations pour s'enregistrer
                    </li>
                </ol>
                </div>
        </div>
        
        <!-- /.row -->
        <div class="row">
                        <div class="col-md-4 col-md-offset-4">
            <div id="login">
                <div id="img_compte"><img class="im1" src="res/imgs/compte.png"/></div>
                <input class="i1" type="text" name="pseudo" placeholder="User" class="cmpt" required="">
            </div>

            <div id="login">
                <div id="img_compte"><img class="im1" src="res/imgs/mail.png"/></div>
                <input class="i1" type="emqil" name="mail" placeholder="Email (Disabled for maintenance)" class="cmpt" required disabled="">
            </div>

            <div id="login">
                <div id="img_compte"><img class="im1" src="res/imgs/password.png"/></div>
                <input class="i1" type="password" name="pass" placeholder="Mot de passe" required>
            </div>

            <div id="login">
                <div id="ok"><input class="i1" name="register_submit" type="submit" value="S'enregistrer"></div>
            </div>

        </div>
          </div>
          <center><a href="?controller=pages&action=login">Deja membre?</a></center>
        </div>
</form>

