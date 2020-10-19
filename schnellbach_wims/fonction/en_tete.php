<!--crée par Schnellbach Tanguy et Wims Jimmy-->
<div class='menue'>
	<div class='offre_groupee'>
		<?php
			//on va chercher le nom et prenom de l'utilisateur et on l'affiche
			if(isset($_SESSION['mail']))
			{
				$resultat=mysqli_query($idcom, "SELECT prenom,nom FROM profil where adresse_mail=\"".$mail."\""); //on cherche le nom et prenom de la personne
				$row=mysqli_fetch_array($resultat);
			}		
			$requette="SELECT images.img_blob FROM `images` WHERE images.profil_img=1 and images.adresse_mail=\"".$mail."\"";
			$img=mysqli_fetch_array(mysqli_query($idcom,$requette));
			echo '<div class="menue1"><form method="post" action="../mypalace/mypalace.php">';	//creation du bouton image
			echo '<input type="hidden" name="photo" value="'.$mail.'" /><input class="minimoi" type="image" src="data:image/jpeg;base64,'.base64_encode($img['img_blob']).'" >'."\n";
			echo '</form></div>';
		?>		
		<!--5 bouton permettant d'aller sur une autre page-->
		<a href="../palacewall/post.php">
			<div class='menue1'>palace-wall</div>
		</a>
		<a href="../notification/notification.php">
			<div class='menue1'>notifications</div>
		</a>
		<a href="../message/frame.php">
			<div class='menue1'>message</div>
		</a>
		<div class='menue1'>
			<form method="post" action="../recherche/recherche.php">
				<input type="search" id="Recherche" name="recherche">
				<button>Rechercher</button>
			</form>
		</div>
		<a href="../connexion/deconnexion.php">
			<div class='menue1'>se deconnecter</div>
		</a>
	</div>
</div>
