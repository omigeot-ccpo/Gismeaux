<?php
/*Copyright Ville de Meaux 2004-2007
contributeur: jean-luc Dechamp - robert Leguay 
sig@meaux.fr

Ce logiciel est un programme informatique fournissant une interface cartographique WEB communale. 

Ce logiciel est régi par la licence CeCILL-C soumise au droit français et
respectant les principes de diffusion des logiciels libres. Vous pouvez
utiliser, modifier et/ou redistribuer ce programme sous les conditions
de la licence CeCILL-C telle que diffusée par le CEA, le CNRS et l'INRIA 
sur le site "http://www.cecill.info".

En contrepartie de l'accessibilité au code source et des droits de copie,
de modification et de redistribution accordés par cette licence, il n'est
offert aux utilisateurs qu'une garantie limitée.  Pour les mêmes raisons,
seule une responsabilité restreinte pèse sur l'auteur du programme,  le
titulaire des droits patrimoniaux et les concédants successifs.

A cet égard  l'attention de l'utilisateur est attirée sur les risques
associés au chargement,  à l'utilisation,  à la modification et/ou au
développement et à la reproduction du logiciel par l'utilisateur étant 
donné sa spécificité de logiciel libre, qui peut le rendre complexe à 
manipuler et qui le réserve donc à des développeurs et des professionnels
avertis possédant  des connaissances  informatiques approfondies.  Les
utilisateurs sont donc invités à charger  et  tester  l'adéquation  du
logiciel à leurs besoins dans des conditions permettant d'assurer la
sécurité de leurs systèmes et ou de leurs données et, plus généralement, 
à l'utiliser et l'exploiter dans les mêmes conditions de sécurité. 

Le fait que vous puissiez accéder à cet en-tête signifie que vous avez 
pris connaissance de la licence CeCILL-C, et que vous en avez accepté les 
termes.*/
//header('Content-type: application/pdf');
define('GIS_ROOT', '..');
include_once(GIS_ROOT . '/inc/common.php');
gis_init();

$valeur=explode("$",$_GET['var']);

if ((!$_SESSION['profil']->acces_ssl) || !in_array ($valeur[0], $_SESSION['profil']->liste_appli)){
	die("Point d'entrée réglementé.<br> Accès interdit. <br>Veuillez vous connecter via <a href=\"https://".$_SERVER['HTTP_HOST']."\">serveur carto</a><SCRIPT language=javascript>setTimeout(\"window.location.replace('https://".$_SERVER['HTTP_HOST']."')\",5000)</SCRIPT>");
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
