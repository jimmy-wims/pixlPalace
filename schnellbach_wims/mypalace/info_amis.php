<?php
	/*
		crée par Schnellbach Tanguy et Wims Jimmy
	*/
	$xml ='<?xml version="1.0" encoding="utf-8"?>'."\n";
	$xml .='<!DOCTYPE personne SYSTEM "pix-L-palace.dtd">'."\n";
	$xml .='<?xml-stylesheet type="text/xsl" href="table.xsl"?>'."\n";
	if(isset($_POST["consultation"]))
	{
		echo '<a href="fichier_xml/mes_amis.xml" download="mes_amis.xml"><div class="consultation">Telecharger</div></a>';
	}
	else
		header("location:../connexion/accueil.php");

	include("../base_de_donne/accessql.php");

	$req="select Amis.Adresse_amis,profil.nom,profil.prenom,Amis.date_amis from profil,Amis where (Amis.Adresse_amis=profil.adresse_mail and Amis.adresse_mail='".$_POST["consultation"]."')";
	$presoquiconsulte="select profil.nom,profil.prenom from profil where ( profil.adresse_mail='".$_POST["consultation"]."')";
	$identiteconsulte=mysqli_fetch_array(mysqli_query($idcom, $presoquiconsulte));
	$listeamis=mysqli_query($idcom, $req);
	$xml .='<personne>'."\n";
	$xml .='<identitee>'.$identiteconsulte[0].' '.$identiteconsulte[1].'</identitee>'."\n";
	while($row=mysqli_fetch_array($listeamis))
	{
		$xml .='	<information>'."\n";
		$xml .='		<nom>'.$row["nom"].'</nom>'."\n";
		$xml .='		<prenom>'.$row["prenom"].'</prenom>'."\n";
		$xml .='		<adressemail>'.$row["Adresse_amis"].'</adressemail>'."\n";
		$xml .='		<date> vous êtes amis depuis le :'.$row["date_amis"].'</date>'."\n";
		$xml .='		<posts>'."\n";
		$reqsurpost="SELECT post.contenue,post.datepost FROM post WHERE (cercle=0 and post.adresse_mail=\"".$row["Adresse_amis"]."\")";
		$listepost=mysqli_query($idcom,$reqsurpost);
		while($case=mysqli_fetch_array($listepost))
		{
			$xml .='			<post type="public">le '.$case["datepost"].' à publié : '.$case["contenue"].'</post>'."\n";
		}
		$reqsurpost="SELECT post.contenue,post.datepost FROM post WHERE (cercle=1 and post.adresse_mail=\"".$row["Adresse_amis"]."\")";
		$listepost=mysqli_query($idcom,$reqsurpost);
		while($case=mysqli_fetch_array($listepost))
		{
			$xml .='			<post type="amis" >le '.$case["datepost"].' à publié : '.$case["contenue"].'</post>'."\n";
		}
		$xml .='		</posts>'."\n";
		$xml .='	</information>'."\n";
	}
	$xml .='</personne>'."\n";
	$monfichier = fopen("fichier_xml/mes_amis.xml", "w+");//ouvrir le fichier
	fputs($monfichier, $xml);
	fclose($monfichier);
	mysqli_close($idcom);
?>
