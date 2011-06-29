<?php
define('GIS_ROOT', '../..');
include_once(GIS_ROOT . '/inc/common.php');
gis_session_start();
$insee = $_SESSION['profil']->insee;
$cominsee = substr($insee,3,3); // Les 3 derniers caractères du code INSEE, pour éviter de les extraire à chaque fois.
$appli = $_SESSION['profil']->appli;
if ((!$_SESSION['profil']->acces_ssl) || !in_array ("cadastre", $_SESSION['profil']->liste_appli)){
  die("Point d'entr&eacute;e r&eacute;glement&eacute;.<br> Accès interdit. <br>Veuillez vous connecter via <a href=\"https://".$_SERVER['HTTP_HOST']."\">serveur carto</a><SCRIPT language=javascript>setTimeout(\"window.location.replace('https://".$_SERVER['HTTP_HOST']."')\",3000)</SCRIPT>");
 }
if (isset($_GET["par1"]))
  {
    $ind=$cominsee."000".substr($par1,0,2).str_pad(substr($_GET["par1"],2),4,'0',STR_PAD_LEFT);
  }
if (isset($_GET["ind"]))
  {
    if ($cominsee != '000')
      $ind=$cominsee . substr($_GET["ind"],3); // On se protège contre les incursions extra-communales.
    else
      $ind = $_GET["ind"];
  }
header("Content-type: text/xml"); 
echo '<?xml version="1.0" encoding="utf-8"?>';
//echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
//   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">';
//tester ie
if (eregi('MSIE', $_SERVER['HTTP_USER_AGENT'])){    
  echo '<?xml-stylesheet type="text/xsl" href="test_cad.xsl"?>';
}else{
  echo '<?xml-stylesheet type="application/xml" href="test_cad.xsl"?>';
}
echo '<park>';
$filename='../../tmp/'.session_id().'.xml';
//echo $filename;
if (!file_exists($filename)){
   $f=fopen($filename,'w');
   $rw1=$DB->tab_result("select admin_svg.header('".$_SESSION['profil']->insee."')");
   fwrite($f,$rw1[0][0]);
   fclose($f);
   echo $rw1[0][0];
}else{
   $f=fopen($filename,'r');
   echo fgets($f);
   fclose($f);
}
$row = $DB->tab_result("select cadastre.desc_parcelle('$ind')");
echo $row[0][0];
echo '<droit>'.$_SESSION['profil']->droit_appli.'</droit>';
echo '<session>'.session_id().'</session>';
echo '</park>';
?>