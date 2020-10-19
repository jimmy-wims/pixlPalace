<?php
	/*
		crée par Schnellbach Tanguy et Wims Jimmy
	*/
	session_start();
	if(!isset($_SESSION["mail"]))
	{
		header("location:../connexion/accueil.php");
	}
	include("../base_de_donne/accessql.php");
	$mail=$_SESSION["mail"];
	if(isset($_POST["recherche"])){
		//on selectionne les personnes dont au moins des parametres resemble au texte saisie
		$recherche=mysqli_query($idcom, "SELECT profil.adresse_mail,profil.prenom,profil.nom FROM profil WHERE( (profil.adresse_mail LIKE\"%".$_POST["recherche"]."%\") or (profil.nom  LIKE \"%".$_POST["recherche"]."%\") or (profil.prenom  LIKE\"%".$_POST["recherche"]."%\"))");
	}
	include("../fonction/function.php");
?>
<html>
	<head>
		<title>Ma recherche</title>
		<link rel="icon" type="image/png" href="../image/logo.png"/>
		<?php 
			$back=1;
			include("../fonction/couleur.php"); 
			include("../css/style.php");
		?>
	</head>
	<body class="fond">
		<?php include("../fonction/en_tete.php"); ?>
		<br/><br/><br/>
		<br/><br/><br/><br/><br/><br/>
		<?php
			echo '<div class=stat>';
			echo '<div id="stat1" >';
			echo "<span class=\"texte_blanc\">Vous avez chercher:".$_POST["recherche"]."</span>";
			echo '<div class=statinterieur>';
			while($row=mysqli_fetch_array($recherche))
			{
				//on affiche les personne on pourra clique sur leur photo pour voir leur mur personnelle
				$photo=mysqli_fetch_array(mysqli_query($idcom, "SELECT img_blob FROM images WHERE(adresse_mail=\"$row[0]\" )"));
				echo '<table class="stats" ><th>photo</th><th>prenom </th><th>nom </th><th>adresse</th><tr>';
				echo '<td><form method="post" action="../mypalace/mypalace.php"><input type="hidden" name="photo" value="'.$row["adresse_mail"].'" /><input class="minimoi" type="image" src="data:image/jpeg;base64,'.base64_encode($photo['img_blob']).'" ></form>'."\n</td>";
				echo "<td>".$row[1]."</td><td>".$row[2]."</td><td>".$row[0]."</td>";
				echo '</tr></table>';
			}
			echo '</div></div></div>';
			mysqli_close($idcom);
		?>
		</div>
	</body>
</html>
