<?php
	/*
		crée par Schnellbach Tanguy et Wims Jimmy
	*/
	$xml ='<?xml version="1.0" encoding="utf-8"?>'."\n";
	$xml .='<!DOCTYPE personne SYSTEM "pix-L-palace.dtd">'."\n";
	$xml .='<?xml-stylesheet type="text/xsl" href="liste.xsl"?>'."\n";
	if(isset($_POST["consultation"]))
	{
		echo '<a href="fichier_xml/mes_infos.xml" download="mes_infos.xml"><div class="consultation">Telecharger</div></a>';
	}
	else
		header("location:../connexion/accueil.php");

	include("../base_de_donne/accessql.php");

	$row=mysqli_fetch_array(mysqli_query($idcom,"select prenom,nom,adresse_mail,date_naissance from profil where adresse_mail=\"$_POST[consultation]\""));	
	$info=mysqli_fetch_array(mysqli_query($idcom,"select mana,xp,pv,niveau from stats_perso where adresse_mail=\"$_POST[consultation]\""));	
	$xml .='<personne>'."\n";
	$xml .='<identitee>'.$row["prenom"].' '.$row["nom"].'</identitee>'."\n";
		$xml .='	<information>'."\n";
		$xml .='		<adressemail>'.$row["adresse_mail"].'</adressemail>'."\n";
		$xml .='		<date> date de naissance:'.$row["date_naissance"].'</date>'."\n";
		$xml .='		<mana> mana :'.$info["mana"].'</mana>'."\n";
		$xml .='		<vie> vie :'.$info["pv"].'</vie>'."\n";
		$xml .='		<xp> XP :'.$info["xp"].'</xp>'."\n";
		$xml .='		<niveau> niveau :'.$info["niveau"].'</niveau>'."\n";
		$xml .='		<posts>'."\n";
		$reqsurpost="SELECT post.contenue,post.datepost FROM post WHERE (cercle=0 and post.adresse_mail=\"".$row["adresse_mail"]."\")";
		$listepost=mysqli_query($idcom,$reqsurpost);
		while($case=mysqli_fetch_array($listepost))
		{
			$xml .='			<post type="public">le '.$case["datepost"].' à publié : '.$case["contenue"].'</post>'."\n";
		}
		$reqsurpost="SELECT post.contenue,post.datepost FROM post WHERE (cercle=1 and post.adresse_mail=\"".$row["adresse_mail"]."\")";
		$listepost=mysqli_query($idcom,$reqsurpost);
		while($case=mysqli_fetch_array($listepost))
		{
			$xml .='			<post type="amis" >le '.$case["datepost"].' à publié : '.$case["contenue"].'</post>'."\n";
		}
		$reqsurpost="SELECT post.contenue,post.datepost FROM post WHERE (cercle=2 and post.adresse_mail=\"".$row["adresse_mail"]."\")";
		$listepost=mysqli_query($idcom,$reqsurpost);
		while($case=mysqli_fetch_array($listepost))
		{
			$xml .='			<post type="prive" >le '.$case["datepost"].' à publié : '.$case["contenue"].'</post>'."\n";
		}
		$xml .='		</posts>'."\n";
		$xml .='	</information>'."\n";
	$xml .='</personne>'."\n";
	$monfichier = fopen("fichier_xml/mes_infos.xml", "w+");//ouvrir le fichier
	fputs($monfichier, $xml);
	fclose($monfichier);
	mysqli_close($idcom);
?>
