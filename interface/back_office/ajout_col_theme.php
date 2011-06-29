<?php
/*Copyright Ville de Meaux 2004-2007
contributeur: jean-luc Dechamp - robert Leguay 
sig@meaux.fr

Ce logiciel est un programme informatique fournissant une interface cartographique WEB communale. 

Ce logiciel est r�gi par la licence CeCILL-C soumise au droit fran�ais et
respectant les principes de diffusion des logiciels libres. Vous pouvez
utiliser, modifier et/ou redistribuer ce programme sous les conditions
de la licence CeCILL-C telle que diffus�e par le CEA, le CNRS et l'INRIA 
sur le site "http://www.cecill.info".

En contrepartie de l'accessibilit� au code source et des droits de copie,
de modification et de redistribution accord�s par cette licence, il n'est
offert aux utilisateurs qu'une garantie limit�e.  Pour les m�mes raisons,
seule une responsabilit� restreinte p�se sur l'auteur du programme,  le
titulaire des droits patrimoniaux et les conc�dants successifs.

A cet �gard  l'attention de l'utilisateur est attir�e sur les risques
associ�s au chargement,  � l'utilisation,  � la modification et/ou au
d�veloppement et � la reproduction du logiciel par l'utilisateur �tant 
donn� sa sp�cificit� de logiciel libre, qui peut le rendre complexe � 
manipuler et qui le r�serve donc � des d�veloppeurs et des professionnels
avertis poss�dant  des connaissances  informatiques approfondies.  Les
utilisateurs sont donc invit�s � charger  et  tester  l'ad�quation  du
logiciel � leurs besoins dans des conditions permettant d'assurer la
s�curit� de leurs syst�mes et ou de leurs donn�es et, plus g�n�ralement, 
� l'utiliser et l'exploiter dans les m�mes conditions de s�curit�. 

Le fait que vous puissiez acc�der � cet en-t�te signifie que vous avez 
pris connaissance de la licence CeCILL-C, et que vous en avez accept� les 
termes.*/
define('GIS_ROOT', '../..');
include_once(GIS_ROOT . '/inc/common.php');
gis_session_start();
$coulfill='none';
$coulstroke='none';
//$requete="select idappthe from admin_svg.appthe where idtheme=".$_GET["idtheme"]." and idapplication=".$_GET["appli"];
//$co=tab_result($pgx,$requete);
$requete="select fill,stroke_rgb,font_size,symbole,id_symbole,opacity from admin_svg.style where idtheme='".$_GET["idtheme"]."'";
$col=$DB->tab_result($requete);
if($col[0]['fill']!='' && $col[0]['fill']!='none')
{
$coulfill=$_GET["couleur"];
}
if($col[0]['stroke_rgb']!='' && $col[0]['stroke_rgb']!='none')
{
	if($coulfill!="none")
	{ 
	$coulstroke="0,0,0";
	}
	else
	{
	$coulstroke=$_GET["couleur"];
	}
}
if($coulfill=='none' && $coulstroke='none')
{
$coulfill=$_GET["couleur"];
}
if($_GET["type"]=="fourchette")
{
$requete="insert into admin_svg.col_theme (idappthe,colonn,intitule_legende,valeur_mini,valeur_maxi,valeur_texte,fill,stroke_rgb,font_size,symbole,id_symbole,opacity,ordre) values('".$_GET["idappthe"]."','".$_GET["colonn"]."','".$_GET["legende"]."','".$_GET["valmini"]."','".$_GET["valmaxi"]."','','".$coulfill."','".$coulstroke."','".$col[0]['font_size']."','".$col[0]['symbole']."','".$col[0]['id_symbole']."','1',".$_GET["ordre"].")";
}
else
{
$requete="insert into admin_svg.col_theme (idappthe,colonn,intitule_legende,valeur_texte,fill,stroke_rgb,font_size,symbole,id_symbole,opacity,ordre) values('".$_GET["idappthe"]."','".$_GET["colonn"]."','".$_GET["legende"]."','".$_GET["valtexte"]."','".$coulfill."','".$coulstroke."','".$col[0]['font_size']."','".$col[0]['symbole']."','".$col[0]['id_symbole']."','1',".$_GET["ordre"].")";
}
//echo $requete;
$DB->exec($requete);

?>
