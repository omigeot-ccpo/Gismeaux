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
//phpinfo();
define('GIS_ROOT', '../..');
include_once(GIS_ROOT . '/inc/common.php');
gis_session_start();

$insee = $_SESSION['profil']->insee;
$appli = $_SESSION['profil']->appli;
//print_r ($_SESSION['profil']->liste_appli);
/*if ((!$_SESSION['profil']->acces_ssl) || !in_array ("Plan geometre", $_SESSION['profil']->liste_appli)){
	die("Point d'entr&eacute;e r&eacute;glement&eacute;.<br> Acc&egrave;s interdit. <br>Veuillez vous connecter via <a href=\"https://".$_SERVER['HTTP_HOST']."\">serveur carto</a><SCRIPT language=javascript>setTimeout(\"window.location.replace('https://".$_SERVER['HTTP_HOST']."')\",5000)</SCRIPT>");
}*/
//session_start();
//include('../connexion/deb.php');
if ($_GET['obj_keys']){
   $q1="select * from public.geomet where id ='".$_GET['obj_keys']."'";
   $r1=$DB->tab_result($q1);
   $dess="../../doc_commune/".$r1[0]['code_insee']."/dwf/".strtolower($r1[0]['local1'])."/".strtolower($r1[0]['fichier']);
   $dess1="../doc_commune/".$r1[0]['code_insee']."/dwf/".strtolower($r1[0]['local1'])."/".strtolower($r1[0]['fichier']);
  
}

if ($_GET['dess']){$dess=$_GET['dess'];}
 ?>
<html>

	<head>
		<meta http-equiv="content-type" content="text/html;charset=iso-8859-1">
		<title>Plan topographique</title>
	</head>

	<body>
 		<p onClick="window.open('./charge_topo.php?dess=<?php echo $dess.'.dwg' ?>','','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbar=no,resizable=no,copyhistory=no,width=250,height=250,left=100,top=100,screenX=0,screenY=0');">Charger le fichier DWG </p> <br> <br>
<div>
<?php
if (eregi('MSIE', $_SERVER['HTTP_USER_AGENT']))
{ 
?>
<object id = "viewer"

classid = "clsid:A662DA7E-CCB7-4743-B71A-D817F6D575DF"

CODEBASE="https://<?php echo $_SERVER['HTTP_HOST'];?>/addons/DwfViewerSetup.cab"
border = "1"
width = "90%"
height = "90%">

<param name = "Src" value="<?php echo $dess.'.dwf' ?>">

</object>
<?php
}
else
{
?>
<OBJECT ID="ADR" TYPE="application/x-Autodesk-DWF" WIDTH="90%" HEIGHT="90%">
<PARAM NAME="dwffilename" VALUE="https://www.pays.meaux.fr/topo/<?php echo $dess1 ?>.dwf"/>
</OBJECT>
<?php
}
?>
<!---<iframe scrolling="no" width="800" height="600"
src="http://dwfit.com/dwf.aspx?path=http://www.pays.meaux.fr/topo/<?php echo $dess1 ?>.dwf">
</iframe>   --->
</div>

	</body>

</html>
