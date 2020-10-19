<?php
	/*
		crée par Schnellbach Tanguy et Wims Jimmy
	*/
	function remplir_lame($idimg,$couleur)
	{
		$j=6;
		for($i=2;$i<=14;$i=$i+2)
		{
			imagefilledrectangle($idimg,$i,$i,$j,$j,$couleur);
			$j=$j+2;
		}
	}
	
	function lame($couleur,$idimg)
	{
		imagefilledrectangle($idimg,0,0,2,6,$couleur);
		imagefilledrectangle($idimg,0,0,6,2,$couleur);
		$x2=4;
		for($i=2;$i<=12;$i=$i+2)
		{
			$y=$i+4;
			$y2=$x2+4;
			imagefilledrectangle($idimg,$i,$y,$x2,$y2,$couleur);
			$x2=$x2+2;
		}
		$x2=8;
		for($i=6;$i<=16;$i=$i+2)
		{	
			$y=$i-4;
			$y2=$x2-4;
			imagefilledrectangle($idimg,$i,$y,$x2,$y2,$couleur);
			$x2=$x2+2;
		}
	}
	
	function dessine_garde($idimg,$couleur,$garde)
	{
		imagefilledrectangle($idimg,12,23,14,25,$couleur);
		imagefilledrectangle($idimg,14,19,18,23,$couleur);
		imagefilledrectangle($idimg,19,19,21,21,$couleur);
		imagefilledrectangle($idimg,21,14,23,19,$couleur);
		imagefilledrectangle($idimg,23,12,25,14,$couleur);
		
		imagefilledrectangle($idimg,14,19,18,21,$garde);
		imagefilledrectangle($idimg,19,14,21,19,$garde);
		imagefilledrectangle($idimg,21,12,23,14,$garde);
		imagefilledrectangle($idimg,23,14,25,19,$garde);
		imagefilledrectangle($idimg,21,19,23,21,$garde);
		imagefilledrectangle($idimg,19,21,21,23,$garde);
		imagefilledrectangle($idimg,14,23,18,24,$garde);
		imagefilledrectangle($idimg,12,21,14,23,$garde);
		imagefilledrectangle($idimg,10,23,12,27,$garde);
		imagefilledrectangle($idimg,10,25,14,27,$garde);
		imagefilledrectangle($idimg,23,10,27,12,$garde);
		imagefilledrectangle($idimg,25,10,27,14,$garde);
	}
	
	function dessine_poigne($idimg,$remplissage,$poigne)
	{
		imagefilledrectangle($idimg,21,21,23,23,$remplissage);
		imagefilledrectangle($idimg,23,23,25,25,$remplissage);
		imagefilledrectangle($idimg,25,25,27,27,$remplissage);
		
		imagefilledrectangle($idimg,21,23,23,25,$poigne);
		imagefilledrectangle($idimg,23,25,25,27,$poigne);
		imagefilledrectangle($idimg,23,21,25,23,$poigne);
		imagefilledrectangle($idimg,25,23,27,25,$poigne);
		
	}
	
	function dessine_pommeau($idimg,$remplissage,$garde)
	{
		imagefilledrectangle($idimg,28,28,29,29,$remplissage);
		
		imagefilledrectangle($idimg,25,28,27,31,$garde);
		imagefilledrectangle($idimg,25,29,31,31,$garde);
		imagefilledrectangle($idimg,29,25,31,29,$garde);
		imagefilledrectangle($idimg,28,25,29,27,$garde);
	}
	
	header ("Content-type: image/png");
	$idimg=imagecreate(32,32);
	$fond=imagecolorallocate($idimg,92,92,93);
	imagecolortransparent($idimg,$fond);
	$couleur=imagecolorallocate($idimg,63,65,65);
	$couleur2=imagecolorallocate($idimg,79,79,79);
	$garde=imagecolorallocate($idimg,20,20,20);
	$poigne=imagecolorallocate($idimg,108,79,49);
	$remplissage=imagecolorallocate($idimg,169,143,86);
	remplir_lame($idimg,$couleur2);
	lame($couleur,$idimg);
	dessine_poigne($idimg,$remplissage,$poigne,$garde);
	dessine_garde($idimg,$couleur2,$garde);
	$remplissage=imagecolorallocate($idimg,252,103,3);
	dessine_pommeau($idimg,$remplissage,$garde);
	imagepng($idimg,"epee.png");
	imagepng($idimg);
	imagedestroy($idimg);
?>