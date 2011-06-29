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
//session_start();
  //require_once("connexion/deb.php");
define('GIS_ROOT', '../..');
include_once(GIS_ROOT . '/inc/common.php');
gis_session_start();

$insee = $_SESSION['profil']->insee;
$appli = $_SESSION['profil']->appli;

if (!$_SESSION['profil']->ok($insee = $insee, $appli = $appli))
  {
    die("Interdit.");
    //TODO: Trouver une sortie plus élégante et informative.
  }

$query_commune="SELECT admin_svg.gm_header('".$insee."')";
$row_commune = $DB->tab_result($query_commune);
echo '<html><head><title>'.$titre.'</title>';
echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8">';
if (file_exists("../../doc_commune/".$_SESSION["profil"]->insee."/css_extranet/general.css"))
{
echo "<link href='../../doc_commune/".$_SESSION["profil"]->insee."/css_extranet/general.css' rel='stylesheet' type='text/css'>";
}else{
echo '<link href="./cadastre.css" rel="stylesheet" type="text/css">';
}
echo '</head><body class="body"><table width="100%" align="center"><tr>';
echo utf8_decode($row_commune[0][0]);
echo '</td></tr><tr><td colspan=2>';
echo '</table>';
?>
