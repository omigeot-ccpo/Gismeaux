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
//header('Content-type: application/pdf');
define('GIS_ROOT', '..');
include_once(GIS_ROOT . '/inc/common.php');
gis_init();

$valeur=explode("$",$_GET['var']);

if ((!$_SESSION['profil']->acces_ssl) || !in_array ($valeur[0], $_SESSION['profil']->liste_appli)){
	die("Point d'entr�e r�glement�.<br> Acc�s interdit. <br>Veuillez vous connecter via <a href=\"https://".$_SERVER['HTTP_HOST']."\">serveur carto</a><SCRIPT language=javascript>setTimeout(\"window.location.replace('https://".$_SERVER['HTTP_HOST']."')\",5000)</SCRIPT>");
}

$app="select idapplication from admin_svg.application where libelle_appli='".$valeur[0]."'";
$idappli=$DB->tab_result($app);

$reqcom="select Xmin(Transform(commune.the_geom,$projection)) as xini,Ymax(Transform(commune.the_geom,$projection)) as yini from admin_svg.commune where commune.idcommune like '".$_SESSION["profil"]->insee."'";
$vu=$DB->tab_result($reqcom);
$_SESSION['xini'] =$vu[0]['xini'];
$_SESSION['yini'] =$vu[0]['yini'];


$url_appel="./printpdf.php?format=".$valeur[6]."&legende=".$valeur[7]."&titre=".$valeur[8]."&raster=".$valeur[11]."&x=".$valeur[1]."&y=".$valeur[2]."&lar=".$valeur[3]."&hau=".$valeur[4]."&zoom=".$valeur[5]."&xini=".$_SESSION['xini']."&yini=".$_SESSION['yini']."&parce=".$valeur[10]."&echelle=".$valeur[9]."&idappli=".$idappli[0]['idapplication'];
header('Location: '.$url_appel);
?>
