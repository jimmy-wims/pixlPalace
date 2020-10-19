<?php
	/*
		crée par Schnellbach Tanguy et Wims Jimmy
	*/
	$width=1800;
	$height=600;
	$idimg=imagecreate($width,$height);
	$trans=imagecolorallocate($idimg,0,0,0);
	$white=imagecolorallocate($idimg,255, 255, 255);
	$noir=imagecolorallocate($idimg,0, 0,0);
	// On rend l'arrière-plan transparent
	imagecolortransparent($idimg, $trans);

	$boolean=0;
	$x=1;
	for($i=0;$i<8000;$i++){
		$x=1;$y=1;
		while(($x%10)!=0)
		{
			$x=rand( 0 , $width);
		}
		while(($y%10)!=0)
		{
			$y=rand( 0 ,$height);
		}
		$taille=rand( 0 ,20);

		imagefilledrectangle($idimg, $x, $y, $x+10,$y+10, $noir);
		imagerectangle($idimg, $x, $y, $x+10,$y+10, $white);

	}

	for($i=0;$i<1;$i++)
	{
		$x=rand( 0 , $width);
		$y=rand( 0 ,$height);
		$taille=rand( 0 ,20);
		imagerectangle($idimg, $x, $y, $x+$taille,$y+$taille, $noir);
	}

	imagegif($idimg);
	imagedestroy($idimg);
?>

