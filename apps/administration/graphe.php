<?php
//réalisation du graphe avec gd
Header( "Content-type: image/png");
$lg1=$_GET["lg1"];
$lg2=$_GET["lg2"];
$max=$_GET["max"];
$col=$_GET["col"];
$rs=unserialize($_GET["rsql"]);
$mois=unserialize($_GET["rsql2"]);
//global $rsql;
//dimension
$haut=300;
$larg=500;
$l_col=($larg-36)/$col;
$l_barre=($l_col-2)/2;

$image = imagecreate($larg,$haut);
$rouge = ImageColorAllocate($image,255,0,0);
$vert = ImageColorAllocate($image,0,255,0);
$bleu = ImageColorAllocate($image,0,0,255);
$white = ImageColorAllocate($image,255,255,255);
$noir = ImageColorAllocate($image,0,0,0);
ImageFilledRectangle($image,0,0,$larg,$haut,$white);
imagerectangle($image,35,20,$larg-1,$haut-20,$noir);
$x=0; // origine des abscisses
 //traitement des ordonnées
 $max=(substr($max,0,2)+1).substr("000000000000",1,strlen($max)-2);
 imagestring($image,2,$x,20,$max,$noir);
 imagestring($image,2,$x,$haut/2,strval(intval($max)/2),$noir);
 imagestring($image,2,$x,$haut-30,"0",$noir);
 //légende
 ImageFilledRectangle($image, $x+10, 0, $x+30, 15, $bleu);
 imagestring($image,2,$x+34,4,$lg1,$noir);
 ImageFilledRectangle($image, $x+($larg/2), 0, $x+20+($larg/2), 15, $rouge);
 imagestring($image,2,$x+($larg/2)+33,4,$lg2,$noir);
 $x=35;$j=1;
 for ($n=0;$n<count($rs);$n++){
 	if ($col==12){
 		imagestring($image,2,$x,$haut-15,substr($mois[$n]["mois"],5,2),$noir);
 	}elseif ($col==31){
 		while ($j!=substr($mois[$n]["mois"],8,2)){
 			imagestring($image,2,$x,$haut-15,$j,$noir);
 			$x+= $l_col;$j++;
 		}
 		imagestring($image,2,$x,$haut-15,substr($mois[$n]["mois"],8,2),$noir);
 	}
 	$y1=1-($rs[$n]["nb_con"]/$max);
 	$y2=1-($rs[$n]["nb_page"]/$max);
 	ImageFilledRectangle($image, $x, $haut-20, $x+$l_barre, ($y1*($haut-40))+20, $bleu);
 	ImageFilledRectangle($image, $x+$l_barre, $haut-20, $x+($l_barre*2), ($y2*($haut-40))+20, $rouge);
 	$x+= $l_col;$j++;
}
ImagePNG($image);
ImageDestroy($image);

?>