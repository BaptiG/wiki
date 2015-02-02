<?php 
	// Connexion BDD
	mysql_connect('localhost:3306','root','root');
    mysql_select_db('wiki');
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
$('#publication').css('display', 'none');
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
			$('#publication').dialog({resizable: false , modal: true, draggable:false, show: 'fade', width: 'auto', height:'auto'});
})
	});

</script>


<body>
<?php
session_start();
echo '<div id="float2"><p>Bienvenu '.$_SESSION['pseudo'].'</p></div>';
	    ?>
<div id="content">
<div id="top"><h1><span style="color:#CDB785;">W</span>e. <span style="color:#CDB785;">K</span>ee.</h1><p>"Knowledge For Everyone"</p></div>
<div id="float">
<div id="login">
</div>
<div id="rechercher">
<form action="#" method="post">
         <label for="search">Rechercher : </label>
         <input type="text" name="search" value=""/>
	    <input type="submit" value="Envoyer" />
</form>

<?php
if(isset($_POST['search']))
{
   if(($_POST['search'] != NULL))
   {
   		$search = $_POST['search'];
		$query = mysql_query("SELECT * FROM articles WHERE tag_1 = '$search' OR tag_2 = '$search' OR tag_3 = '$search' ");
	 }
 }
 else 
 {$query = mysql_query("SELECT * FROM articles ");}




 ?>

</div>
<div id="publication" title="Publier article">
<form action="connecte.php" method="post" enctype="multipart/form-data">

		 <label for="title">Titre</label>
         <input type="text" name="title" value=""/><br/><br/>
         <label for="content">Contenu</label>
         <textarea name="content" value="" cols ="30" rows = "50" />Tapez votre contenu</textarea><br/><br/>
         <label for="image">Image (PNG, JPG, GIF // Max: 1 Mo)</label>
 		 <input type="hidden" name="MAX_FILE_SIZE" value="1048576" />
         <input type="file" name="image" id="image" /><br /><br/>
         <label for="tag_1">tag_1</label>
         <input type="text" name="tag_1" value=""/><br/><br/>
         <label for="tag_2">tag_2</label>
         <input type="text" name="tag_2" value=""/><br/><br/>
         <label for="tag_3">tag_3</label>
         <input type="text" name="tag_3" value=""/><br/><br/>
	    <input type="submit" value="Envoyer" />
</form> 
<?php
?>
</div>
	 

</div>
<?php 
	
$extensions_valides = array( 'jpg' , 'jpeg' , 'gif' , 'png' );
$extension_upload = strtolower(  substr(  strrchr($_FILES['image']['name'], '.')  ,1)  );


if(isset($_POST['title']) && isset($_POST['content']) && isset($_POST['tag_1']) && isset($_POST['tag_2']) && isset($_POST['tag_3']))
{
	if(!empty($image))
	{
		if ( in_array($extension_upload,$extensions_valides) )
			{
				if ($_FILES['image']['size'] > 100000000) 
				{
					echo '<p><img src="error.jpg" style="float:left;" width="25px"/>Le fichier est trop gros !</p>';
				}
				else 
				{
					$path_file = "images_articles/{$_FILES['image']['name']}";
					$resultat = move_uploaded_file($_FILES['image']['tmp_name'],$path_file);
				} 

			}
			else 
			{

				echo '<p><img src="error.jpg" style="float:left;" width="25px"/>Type de fichier non adapté !</p>';
				
			}    
	}
	else 
	{
		$resultat=true;
	}
	

	if ($resultat) 
	{
		echo '<p><img src="check.jpg" style="float:left;" width="25px"/>Transfert réussi !</p>';
						if(!empty($_POST['title']) && !empty($_POST['content']) )
	   					{	
	   						$sql = "INSERT INTO articles(id, author, title, path_image, content, dates, tag_1, tag_2, tag_3) VALUES('','$_SESSION[pseudo]','$_POST[title]','$path_file','$_POST[content]',NOW(),'$_POST[tag_1]','$_POST[tag_2]','$_POST[tag_3]')";
	    					mysql_query($sql) or die('Erreur SQL !'.$sql.'<br>'.mysql_error()); 
	    					unset($_POST);
	     				}	
	     				else
	     				{
	     					echo '<p><img src="error.jpg" style="float:left;" width="25px"/>Veuillez remplir tous les champs !</p>';
	     				}		
	}

}

 ?>
 <div id="body">

	<div id="menu">
	<ul><li><a href="connecte.php">Accueil</a></li><li><a href="#" id = "suscribe" >Publier un article</a></li><li><a href="#" id="search">Rechercher</a></li><li><a href="deco.php">Se déconnecter</a></li></ul></div>


<?php



if (mysql_num_rows($query) > 0)
{

while ($donnees = mysql_fetch_assoc($query))
{

echo '<h2>'.$donnees[title].'</h2>';
echo '<img class="article_image" src="'.$donnees[path_image].'" width="auto"/>';
echo '<p>'.$donnees[content].'</p>';
echo '<span class="details"> Publication : '.$donnees[dates].' par '.$donnees[author].' // '.' <a href="#">'.$donnees[tag_1].'</a>'.', '.' <a href="#">'.$donnees[tag_2].'</a>'.', '.' <a href="#">'.$donnees[tag_3].'</a> </span><br/><br/>';

}
					
}
 ?>

</div>
</div>
<div id="footer"><p>Designed By tOm et Baptou</p></div>
</body>
</html>
