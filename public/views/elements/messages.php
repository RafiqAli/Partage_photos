<?php 

if (isset($_SESSION['error'])) {
?>

	<div class="alert alert-danger alert-dismissible text-center" role="alert">
	  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  <strong>Erreur ! </strong> <?php echo $_SESSION['error']; ?>.
	</div>


<?php

	unset($_SESSION['error']);

}
else if (isset($_SESSION['success'])) {
?>

	<div class="alert alert-success alert-dismissible text-center" role="alert">
	  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  <strong>Succes ! </strong> <?php echo $_SESSION['success']; ?>.
	</div>


<?php

	unset($_SESSION['success']);
}


?>