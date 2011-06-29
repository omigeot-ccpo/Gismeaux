<?php 
/*Copyright Ville de Meaux 2004-2007
contributeur: jean-luc Dechamp - robert Leguay 
sig@meaux.fr

Ce logiciel est un programme informatique fournissant une interface cartographique WEB communale. 

Ce logiciel est rÈgi par la licence CeCILL-C soumise au droit franÁais et
respectant les principes de diffusion des logiciels libres. Vous pouvez
utiliser, modifier et/ou redistribuer ce programme sous les conditions
de la licence CeCILL-C telle que diffusÈe par le CEA, le CNRS et l'INRIA 
sur le site "http://www.cecill.info".

En contrepartie de l'accessibilitÈ au code source et des droits de copie,
de modification et de redistribution accordÈs par cette licence, il n'est
offert aux utilisateurs qu'une garantie limitÈe.  Pour les mÍmes raisons,
seule une responsabilitÈ restreinte pËse sur l'auteur du programme,  le
titulaire des droits patrimoniaux et les concÈdants successifs.

A cet Ègard  l'attention de l'utilisateur est attirÈe sur les risques
associÈs au chargement,  ‡ l'utilisation,  ‡ la modification et/ou au
dÈveloppement et ‡ la reproduction du logiciel par l'utilisateur Ètant 
donnÈ sa spÈcificitÈ de logiciel libre, qui peut le rendre complexe ‡ 
manipuler et qui le rÈserve donc ‡ des dÈveloppeurs et des professionnels
avertis possÈdant  des connaissances  informatiques approfondies.  Les
utilisateurs sont donc invitÈs ‡ charger  et  tester  l'adÈquation  du
logiciel ‡ leurs besoins dans des conditions permettant d'assurer la
sÈcuritÈ de leurs systËmes et ou de leurs donnÈes et, plus gÈnÈralement, 
‡ l'utiliser et l'exploiter dans les mÍmes conditions de sÈcuritÈ. 

Le fait que vous puissiez accÈder ‡ cet en-tÍte signifie que vous avez 
pris connaissance de la licence CeCILL-C, et que vous en avez acceptÈ les 
termes.*/
define('GIS_ROOT', '../..');
include_once(GIS_ROOT . '/inc/common.php');
gis_session_start();

$insee = $_SESSION['profil']->insee;
$appli = $_SESSION['profil']->appli;

if ((!$_SESSION['profil']->acces_ssl) || !in_array ("Cadastre", $_SESSION['profil']->liste_appli)){
	die("Point d'entr√©e r√©glement√©.<br> Acc√®s interdit. <br>Veuillez vous connecter via <a href=\"https://".$_SERVER['HTTP_HOST']."\">serveur carto</a><SCRIPT language=javascript>setTimeout(\"window.location.replace('https://".$_SERVER['HTTP_HOST']."')\",5000)</SCRIPT>");
}
if ($_GET["util"]){
 	$q2="select idapplication from admin_svg.application";
	$r2=$DB->tab_result($q2);
	//$num=pg_numrows($r2);
	$ins="delete from admin_svg.apputi where idutilisateur='".$_GET["util"]."'";
	$aa=$DB->tab_result($ins);$j=1;
	for ($i=0; $i<count($r2); $i++){
		//$tes2 = pg_fetch_array($r2);
		if (array_key_exists("'".$r2[$i]["idapplication"]."'",$_GET["app"])){
			$odf="'".$r2[$i]["idapplication"]."'";
			$in2="insert into admin_svg.apputi (idutilisateur,idapplication,ordre,droit) values('".$_GET["util"]."','".$r2[$i]["idapplication"]."','".$j."','".$_GET["droitappli"][$odf]."')";
			$a2=$DB->tab_result($in2); $j++;
		}
	} 
	$ident=$_GET["util"]; 
}else{$ident=$_GET["ident"];}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Document sans titre</title>
</head>

<body>
<form name="f1" action="application.php" method="get">
<input name="util" type="hidden" value="<?php echo $ident ?>">
<table>
<?php 
//$quer="select * from admin_svg.application where idapplication in (select idapplication from admin_svg.apputi where idutilisateur='".$ident."')";
$quer="select * from admin_svg.application join admin_svg.apputi on application.idapplication = apputi.idapplication where idutilisateur='".$ident."'";
$que2="select * from admin_svg.application where idapplication not in (select idapplication from admin_svg.apputi where idutilisateur='".$ident."')";
$tab=$DB->tab_result($quer);
$ta2=$DB->tab_result($que2);
//$num2=pg_numrows($tab);
//$num3=pg_numrows($ta2);
for ($i=0; $i<count($tab); $i++){
	//$ff[$i]=pg_fetch_array($tab, $i);
   echo '<tr><td><input name="app[\''.$tab[$i]['idapplication'].'\']" type="checkbox" value="0" onchange="if(this.value==\'0\'){this.value=\'1\';}else{this.value=\'0\';}" checked></td><td>';
   echo '<select name="droitappli[\''.$tab[$i]['idapplication'].'\']"><option value="a"';
   if ($tab[$i]['droit']=="a"){echo 'selected';}
   echo '>administration</option><option value="e"';
   if ($tab[$i]['droit']=="e"){echo 'selected';}
   echo '>edition</option><option value="c"';
   if ($tab[$i]['droit']=="c"){echo 'selected';}
   echo '>consultation</option><option value="v"';
    if ($tab[$i]['droit']=="v"){echo 'selected';}
   echo '>validation</option>';
  echo '</select></td><td>'.$tab[$i]['libelle_appli'].'</td><td>'.$tab[$i]['url'].'</td><td>'.$tab[$i]['divers'].'</td></tr>';
 }
 for ($i=0; $i<count($ta2); $i++){
	//$ff[$i]=pg_fetch_array($ta2, $i);
   echo '<tr><td><input name="app[\''.$ta2[$i]['idapplication'].'\']" type="checkbox" value="1" onchange="if(this.value==\'0\'){this.value=\'1\';}else{this.value=\'0\';}"></td><td><select name="droitappli[\''.$ta2[$i]['idapplication'].'\']"><option value="a">administration</option><option value="e">edition</option><option value="c" selected>consultation</option></select></td><td>'.$ta2[$i]['libelle_appli'].'</td><td>'.$ta2[$i]['url'].'</td><td>'.$ta2[$i]['divers'].'</td></tr>'; 
 }
 ?>
</table>
<input name="btn_valid" type="button" onClick="document.f1.submit()" value="Enregistrer">
<input name="btn_annul" type="button" onClick="window.close()" value="Annuler">
</form>
</body>
</html>
