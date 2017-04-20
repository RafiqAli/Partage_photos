    <div class="dropdown">
      <button class="btn btn-info btn-sm dropdown-toggle" type="button" data-toggle="dropdown">Trier par:
      <span class="caret"></span></button>
      <ul class="dropdown-menu">
        <li><a href="#" onclick="AjaxFunction('newest', '<?= $_SESSION['user']['username'] ?>')">Les plus recents</a></li>
        <li><a href="#" onclick="AjaxFunction('oldest', '<?= $_SESSION['user']['username'] ?>')">Les plus anciens</a></li>
        <li><a href="#" onclick="AjaxFunction('best',   '<?= $_SESSION['user']['username'] ?>')">Les mieux notés</a></li>
        <li><a href="#" onclick="AjaxFunction('worst',  '<?= $_SESSION['user']['username'] ?>')">Les moins notés</a></li>
      </ul>
    </div>



<script>
function AjaxFunction(str, user) {

if(str != "")
{
	//le DOM qui va recevoir la requete
	var targetId = 'gallerie';
	//fichier php qui traite la requete
	var url = "/Partage_photos/controllers/ajax_sort.php";
	//parametres a envoyer
	var params = "type="+str+"&username="+user;

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