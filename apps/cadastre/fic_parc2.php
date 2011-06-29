<?php 
/*Copyright Ville de Meaux 2004-2007
contributeur: jean-luc Dechamp - robert Leguay 
sig@meaux.fr

Ce logiciel est un programme informatique fournissant une interface cartographique WEB communale. 

Ce logiciel est rÃ©gi par la licence CeCILL-C soumise au droit franÃ§ais et
respectant les principes de diffusion des logiciels libres. Vous pouvez
utiliser, modifier et/ou redistribuer ce programme sous les conditions
de la licence CeCILL-C telle que diffusÃ©e par le CEA, le CNRS et l'INRIA 
sur le site "http://www.cecill.info".

En contrepartie de l'accessibilitÃ© au code source et des droits de copie,
de modification et de redistribution accordÃ©s par cette licence, il n'est
offert aux utilisateurs qu'une garantie limitÃ©e.  Pour les mÃªmes raisons,
seule une responsabilitÃ© restreinte pÃ¨se sur l'auteur du programme,  le
titulaire des droits patrimoniaux et les concÃ©dants successifs.

A cet Ã©gard  l'attention de l'utilisateur est attirÃ©e sur les risques
associÃ©s au chargement,  Ã  l'utilisation,  Ã  la modification et/ou au
dÃ©veloppement et Ã  la reproduction du logiciel par l'utilisateur Ã©tant 
donnÃ© sa spÃ©cificitÃ© de logiciel libre, qui peut le rendre complexe Ã  
manipuler et qui le rÃ©serve donc Ã  des dÃ©veloppeurs et des professionnels
avertis possÃ©dant  des connaissances  informatiques approfondies.  Les
utilisateurs sont donc invitÃ©s Ã  charger  et  tester  l'adÃ©quation  du
logiciel Ã  leurs besoins dans des conditions permettant d'assurer la
sÃ©curitÃ© de leurs systÃ¨mes et ou de leurs donnÃ©es et, plus gÃ©nÃ©ralement, 
Ã  l'utiliser et l'exploiter dans les mÃªmes conditions de sÃ©curitÃ©. 

Le fait que vous puissiez accÃ©der Ã  cet en-tÃªte signifie que vous avez 
pris connaissance de la licence CeCILL-C, et que vous en avez acceptÃ© les 
termes.*/
define('GIS_ROOT', '../..');
include_once(GIS_ROOT . '/inc/common.php');
gis_session_start();

$insee = $_SESSION['profil']->insee;
$cominsee = substr($insee,3,3); // Les 3 derniers caractères du code INSEE, pour éviter de les extraire à chaque fois.
$appli = $_SESSION['profil']->appli;

if ((!$_SESSION['profil']->acces_ssl) || !in_array ("Cadastre", $_SESSION['profil']->liste_appli)){
  die("Point d'entr&eacute;e r&eacute;glement&eacute;.<br> Accès interdit. <br>Veuillez vous connecter via <a href=\"https://".$_SERVER['HTTP_HOST']."\">serveur carto</a><SCRIPT language=javascript>setTimeout(\"window.location.replace('https://".$_SERVER['HTTP_HOST']."')\",3000)</SCRIPT>");
 }

$commune=$insee;
$titre='Recherche cadastrale - Fiche parcelle';
if (isset($_GET["par1"]))
  {
    $ind=$cominsee."000".substr($par1,0,2).str_pad(substr($_GET["par1"],2),4,'0',STR_PAD_LEFT);
  }
include("./head.php");
/* Lecture de la fiche parcelle */
if (isset($_GET["ind"]))
  {
    if ($cominsee != '000')
      $ind=$cominsee . substr($_GET["ind"],3); // On se protège contre les incursions extra-communales.
    else
      $ind = $_GET["ind"];
  }
$query_Recordset1 = "SELECT cadastre.gm_desc_parcelle('$ind','".$_SESSION['profil']->droit_appli."') ";
$row_Recordset1 = $DB->tab_result($query_Recordset1);
echo '<table width="100%"  align="center">';
echo $row_Recordset1[0][0];
echo '</table>';
include('pied_cad.php');

?>


