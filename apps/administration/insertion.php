<?php
/*Copyright Ville de Meaux 2004-2008
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
//define('GIS_ROOT', '../..');
//include_once(GIS_ROOT . '/inc/common.php');
//gis_init();

//$insee = $_SESSION['profil']->insee;
//$appli = $_SESSION['profil']->appli;

//if ((!$_SESSION['profil']->acces_ssl) || !in_array ("administration", $_SESSION['profil']->liste_appli)){//
//	die("Point d'entrée réglementé.<br> Accès interdit. <br>Veuillez vous connecter via <a href=\"https://".$_SERVER['HTTP_HOST']."\">serveur carto</a><SCRIPT language=javascript>setTimeout(\"window.location.replace('https://".$_SERVER['HTTP_HOST']."')\",5000)</SCRIPT>");
//}
if ((isset($_POST['rep_edigeo'])) & ($_POST['rep_edigeo']!='')){
	$chemin=$_SERVER['DOCUMENT_ROOT'];
	$chem=substr($chemin,0,strrpos($chemin,'/'));
	//$chem=substr($chem,0,strrpos($chem,'/'));
	exec("/tmp/edigeo.sh ".$_POST['rep_edigeo']." ".$_POST['cod_dep'].$_POST['cod_agglo']." ".$_POST['rep_decompo']." ".$projection." ".$DB->db_user);
	//exec($chem."/edigeo.sh ".$_POST['rep_edigeo']." ".$_POST['cod_dep'].$_POST['cod_agglo']." ".$_POST['rep_decompo']." ".$projection." ".$DB->db_user." ".$chem);
}else{
	echo '<FORM action="insertion.php" method="POST">
		<TABLE width="700px"><tr><Th colspan="2">Insertion plan cadastre EDIGEO</Th><TD rowspan="4">Copier les fichiers dans un répertoire du serveur, chaque commune est dans un répertoire dont le nom est de la forme "com-284" qui contient un répertoire par feuille cadastrale dans lequel est fourni un fichier compressé ayant le même nom que le répertoire</TD></tr>
		<TR><TD>Répertoire contenant les fichiers EDIGEO</TD><TD><INPUT type="text" name="rep_edigeo"></TD></TR>
		<TR><TD>Répertoire pour les fichiers SQL</TD><TD><INPUT type="text" name="rep_decompo"></TD></TR>
		<tr><td>Code Département</td><td><INPUT type="text" name="cod_dep"></td></tr>
		<tr><td>Identifiant d\'agglomération</td><td><INPUT type="text" name="cod_agglo" value="0"></td></tr>
	</TABLE>
	<INPUT type="submit" name="cadastre">
	</FORM>';
include("../cadastre/insert_cadastre.php");
}
?>
