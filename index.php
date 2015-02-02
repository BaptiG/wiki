	<?php 
	// Connexion BDD

	mysql_connect('localhost:3306','root','root');
    mysql_select_db('wiki');
    

    //Traitement identification

    if(isset($_GET['error']) && ($_GET['error'] == 1)){echo '<div id="dialog" title="Erreur"><img src="error.jpg" style="margin-top:20px;" align="left" width="25px"/><p align="right">Espace reservé aux membres !</p></div>'; echo '<meta http-equiv="refresh" content="3; URL=index.php">';}
    
    if(isset($_POST['pseudo']) && isset($_POST['pwd'])){
    		if(($_POST['pseudo'] != NULL) && ($_POST['pwd'] != NULL)){
  
   				 $pseudo =  $_POST['pseudo'];
				 $mdp =  $_POST['pwd'];
	   			 $query = mysql_query("SELECT login, password FROM users WHERE login = '$pseudo' AND password = '$mdp'");

    			if(mysql_num_rows($query) > 0){
					
    				
 					session_start();
    				$_SESSION['pseudo'] = $pseudo;

    				echo '<div id="dialog" title="Checkpoint"><img src="check.jpg" style="margin-top:20px;" align="left" width="25px"/><p align="right">Vous vous êtes loggué avec succès ! </p></div>'; 
    				echo '<meta http-equiv="refresh" content="3; URL=connecte.php">';
    				
    				//echo '<div id="dialog" title="Checkpoint"><img src="check.jpg" style="margin-top:20px;" align="left" width="25px"/><p align="right">Vous vous êtes loggué avec succès !'.$_SESSION['pseudo'].' </p></div>'; 
       
 				}
   				else{echo '<div id="dialog" title="Erreur"><img src="error.jpg" style="margin-top:20px;" align="left" width="25px"/><p align="right">Erreur d\'identifiants !</p></div>';}
			}
			else{echo '<div id="dialog" title="Erreur"><img src="error.jpg" style="margin-top:20px;" align="left" width="25px"/><p align="right">Les champs doivent être remplis !</p></div>';}
		}


?>
<!DOCTYPE html PUBLIC "-//ETF//DTD HTML 2.0//EN">
<html>
<head>
<title>Wiki ESIEE</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link href='http://fonts.googleapis.com/css?family=Open+Sans|Oswald|PT+Sans+Narrow' rel='stylesheet' type='text/css'>
<script src="jquery.js"></script>
<script src="jquery-ui-1.9.2.custom.js"></script>
<link href='style.css' rel='stylesheet' type='text/css'>
<link href='css/smoothness/jquery-ui-1.9.2.custom.css' rel='stylesheet' type='text/css'>

<script type="text/javascript">

	$(document).ready(function(){ 
	$("#dialog").dialog({ resizable: false , modal: true, draggable:false });
		$('#float').css('display', 'none');
$('#inscription').css('display', 'none');
		$('#login').css('display', 'none');
		$('#rechercher').css('display', 'none');
		$('#connexion').click(function(){
				$('#login').fadeIn();
				$('#rechercher').hide();
				$('#float').toggle("fast");
			})
		$('#search').click(function(){
			$('#rechercher').fadeIn();
			$('#login').hide();
			$('#float').toggle("fast");
		})
$('#suscribe').click(function(){
			$('#inscription').dialog({resizable: false , modal: true, draggable:false, show: 'fade', width: 'auto', height:'auto'});
})
	});

</script>


<body>
<div id="inscription" title="Inscription">
<form action="index.php" method="post">
         <label for="login_suscribe">Pseudo : </label>
         <input type="text" name="login_suscribe" value=""/><br/><br/>
         <label for="pwd_suscribe">Mot de passe : </label>
         <input type="password" name="pwd_suscribe" value=""/><br/><br/>
         <label for="nom_suscribe">Nom : </label>
         <input type="text" name="nom_suscribe" value=""/><br/><br/>
         <label for="prenom_suscribe">Prénom : </label>
         <input type="text" name="prenom_suscribe" value=""/><br/><br/>
         <label for="mail_suscribe">Adresse mail : </label>
         <input type="text" name="mail_suscribe" value=""/><br/><br/>
	    <input type="submit" value="Envoyer" />
	    <?php 
	//Inscription

	     if(isset($_POST['login_suscribe']) && isset($_POST['pwd_suscribe']) && isset($_POST['nom_suscribe']) && isset($_POST['prenom_suscribe']) && isset($_POST['mail_suscribe'])){

	     	 if(!empty($_POST['login_suscribe']) && !empty($_POST['pwd_suscribe']) && !empty($_POST['nom_suscribe']) && !empty($_POST['prenom_suscribe']) && !empty($_POST['mail_suscribe'])){
    
   $sql = "INSERT INTO users(id, login, password, nom, prenom, mail) VALUES('','$_POST[login_suscribe]','$_POST[pwd_suscribe]','$_POST[nom_suscribe]','$_POST[prenom_suscribe]','$_POST[mail_suscribe]')";
    	mysql_query($sql) or die('Erreur SQL !'.$sql.'<br>'.mysql_error()); 
    	unset($_POST);

   }
   else{echo '<p><img src="error.jpg" style="float:left;" width="25px"/>Veuillez remplir tous les champs !</p>';}

    }
   
  

	mysql_close();

	    ?>

</form>
</div>
<div id="content">
<div id="top"><h1><span style="color:#CDB785;">W</span>e. <span style="color:#CDB785;">K</span>ee.</h1><p>"Knowledge For Everyone"</p></div>
	<div id="float">
<div id="login">
<form action="index.php" method="post">
         <label for="pseudo">Login : </label>
         <input type="text" name="pseudo" value=""/>
         <label for="pwd">Mot de passe : </label>
         <input type="password" name="pwd" value=""/>
	    <input type="submit" value="Envoyer" />
</form>
</div>
<div id="rechercher">
<form action="#" method="post">
         <label for="search">Rechercher : </label>
         <input type="text" name="search" value=""/>
	    <input type="submit" value="Envoyer" />
</form>
</div>
</div>

<div id="body">
	<div id="menu">
	<ul><li><a href="index.php">Accueil</a></li><li><a href="#">Publier un article</a></li><li><a href="#" id="search">Rechercher</a></li><li><a href="#" id="connexion">Se connecter</a></li><li><a href="#" id="suscribe">Inscription</a></li></ul></div>
	<h2>Bienvenu sur notre Wiki ! </h2>
	<p>Bienvenu sur notre wiki, celui ci a été créé lors de notre cours d'initiation aux outils du web. L'objectif étant de créer un site regroupant des articles avec une interface de gestion, et une interface utilisateur.</p>
	<span class="details">Publié le 01/01/2013 par <b>Baptiste</b> // <a href="#">chaton</a> , <a href="#">chaudard</a></span><br/><br/>
	<h2>Articles</h2>
	<p> Pour voir les différents articles, nous vous invitons à vous connecter.</p>
	<span class="details">Publié le 01/04/2013 par <b>Baptiste</b> // <a href="#">chaton</a> , <a href="#">chaudard</a></span><br/><br/>
</div>
</div>
<div id="footer"><p>Designed By tOm et Baptou</p></div>
</body>
</html>
