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

$insee = $_SESSION['profil']->insee;
$appli = $_SESSION['profil']->appli;

if ((!$_SESSION['profil']->idutilisateur) ){	//|| !in_array ("RU", $_SESSION['profil']->liste_appli)
	die("Point d'entr&eacute;e r&eacute;glement&eacute;.<br> Acc�s interdit. <br>Veuillez vous connecter via <a href=\"https://".$_SERVER['HTTP_HOST']."\">serveur carto</a><SCRIPT language=javascript>setTimeout(\"window.location.replace('https://".$_SERVER['HTTP_HOST']."')\",3000)</SCRIPT>");
}
//include("../../connexion/deb.php");
$nter=substr('000'.$_POST['nter'],-4);
print("<form name='form1' method='post' action='rech_adresse.php'>
<table><tr><td colspan='4'>S�lectionner la rue souhait�e:</td><tr>
<td valign='top'>
<input name='nter' type='text' id='nter' size='4' maxlength='4' value='$nter' valign='top'> &nbsp;</td>
<td valign='top'>
<input name='cpter' type='text' id='cpter' size='4' maxlength='4' value='".$_POST['cpter']."'> &nbsp;</td>
<td valign='top'>
<select name='code' size='4'>");
 
  
$sql = "SELECT code_voie,nom_voie FROM cadastre.voies WHERE nom_voie LIKE '%".strtoupper($_POST['libelleter'])."%' ;";
print ($sql);
$result = $DB->tab_result($sql) ;
for ($n=0;$n<count($result);$n++){
	if($n==0){
	   print("<option value='".$result[$n]['code_voie']."' selected>".$result[$n]['nom_voie']."</option>");
	}else{
	   print("<option value='".$result[$n]['code_voie']."'>".$result[$n]['nom_voie']."</option>");
	}
}
print("</select></td>");
if(count($result)==0){
	die('<meta http-equiv="refresh" content="0;url=./message.php">');
}

print("<td valign='top'><input type='submit' name='Submit' value='Envoyer'></td></tr>");

print("</table></form>");
//}

?>
