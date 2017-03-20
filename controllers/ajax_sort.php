<?php


if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
	//verifier le remplissage
	if( !empty($_POST['type'])) 
	{
		$type = $_POST['type'];
		echo " Trier par: ".$type.". La fonctionnalité de tri est en cours de maintenance";
	}

}

?>