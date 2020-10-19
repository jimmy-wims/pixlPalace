<?php
	/*
		crée par Schnellbach Tanguy et Wims Jimmy
	*/
	session_start();
	session_unset();	// on detruit la session
	session_destroy();
	header("location:accueil.php"); //on redirige vers la page d'accueil
?>