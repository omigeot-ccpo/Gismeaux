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
if($_GET['sansplug']=='true')
{

}
define('GIS_ROOT', '..');
include_once(GIS_ROOT . '/inc/common.php');
gis_session_start();

$sql="select * from admin_svg.preference where utilisateur=".$_SESSION['profil']->idutilisateur;

$col=$DB->tab_result($sql);
if($col[0]['utilisateur'])
{
$sql1="update admin_svg.preference set icone='".$_GET['icon']."',legende='".$_GET['legend']."',posix='".$_GET['legendx']."',posiy='".$_GET['legendy']."' where utilisateur=".$_SESSION['profil']->idutilisateur;
$DB->tab_result($sql1);
}
else
{
$sql1="insert into admin_svg.preference (utilisateur,icone,legende,posix,posiy) values (".$_SESSION['profil']->idutilisateur.",'".$_GET['icon']."','".$_GET['legend']."','".$_GET['legendx']."','".$_GET['legendy']."')";
$DB->tab_result($sql1);
}
print("<g id=\"preference\" xmlns=\"http://www.w3.org/2000/svg\"></g>");
?>
