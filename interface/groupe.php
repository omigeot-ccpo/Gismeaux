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
define('GIS_ROOT', '..');
include_once(GIS_ROOT . '/inc/common.php');
gis_session_start();

$insee = $_SESSION['profil']->insee;
$appli = $_SESSION['profil']->appli;
$_SESSION['refresh']=1;
if($_POST["act"]=="ajou")
{
$sql="insert into admin_svg.postit_group (idutilisateur,nomgroup) values (".$_SESSION['profil']->idutilisateur.",'".$_POST['nom_groupe']."')";
$DB->tab_result($sql);
$uti = explode(",", $_POST['a_utilisateur']);
//echo $sql;
//print_r($uti);
for($ii=0;$ii<count($uti);$ii++)
{
if($uti[$ii]<>'')
{
$sql="INSERT INTO admin_svg.postit_uti_group (idgroup,idutilisateur) VALUES (currval('admin_svg.postit_group_idgroup_seq'), '".$uti[$ii]."')";
$DB->tab_result($sql);
}
}
//$sql="INSERT INTO admin_svg.postit_uti_group (idgroup,idutilisateur) VALUES (currval('admin_svg.postit_group_idgroup_seq'), '".$_POST['a_utilisateur']."')";
//$DB->tab_result($sql);
echo "<html>";
echo "<body onload='close()'>";
echo "</body>";
echo "</html>";
//header("Location:./supp.php?gid=".$_GET["gid"]);
}
?>
<html>
<head>
<?php
echo "<SCRIPT LANGUAGE=\"JavaScript\">
	var sw=0;
	var app_a_install='';
	var app_invite='';
		
	function Deplacer(l1,l2,y) {
		if (l1.options.selectedIndex>=0) {
			o=new Option(l1.options[l1.options.selectedIndex].text,l1.options[l1.options.selectedIndex].value);
			l2.options[l2.options.length]=o;
		
		app_a_install+=l1.options[l1.options.selectedIndex].value+',';
		document.getElementById('a_instal').value=app_a_install;
		
			l1.options[l1.options.selectedIndex]=null;
			
			
		
		}else{
			alert(\"Selectionner un utilisateur\");
		}
		
		
	}

</SCRIPT>";
?>
</head>

<body>
<form method="post" action="groupe.php" enctype="multipart/form-data">
<input type="hidden" id="act" name="act" value="">
Nom du groupe:<input name="nom_groupe" type="text" />
<?php
echo "<br><br>&nbsp;&nbsp;&nbsp;Utilisateur:";
echo "<table><tr><td>Utilisateurs disponibles<BR><SELECT align=top name=\"liste1\" size=6  style=\"width:150px\" id=\"liste1\">";
	$invite_query="select idutilisateur,nom,prenom from admin_svg.utilisateur where idcommune like '".substr($insee,0,3)."%' and nom is not null";
$mn2=$DB->tab_result($invite_query);
	for ($y2=0;$y2<count($mn2);$y2++)
		{
	 echo "<OPTION value=\"".$mn2[$y2]['idutilisateur']."\">".$mn2[$y2]['nom']." ".$mn2[$y2]['prenom']."</OPTION>";
		}
		
	echo "</SELECT>";
	echo "</TD><TD align=\"center\">";
	echo "<BR>";
	echo "<INPUT type=\"button\" value=\"Ajouter >>>\" onClick=\"Deplacer(this.form.liste1,this.form.liste2,'liste2')\" id=\"bouton2\">";
	
	//echo "<INPUT type=\"button\" value=\"&lt;&lt;&lt; Enlever\" onClick=\"Deplacer(this.form.liste2,this.form.liste1)\">";
	echo "</TD><TD>Utilisateurs associes<BR>";
	echo "<SELECT align=top name=\"liste2\" size=6 style=\"width:150px\" id=\"liste2\">";

//echo "<OPTION value="10">----------------------</OPTION>";
	echo "</SELECT></td></tr></table>";
	echo "<input name=\"Ajouter\" type=\"button\" value=\"Ajouter\" onClick=\"document.getElementById('act').value='ajou';submit()\">";
?>
<input type="hidden" id="a_instal" name="a_utilisateur" value="">
</form>
</body>
</html>
