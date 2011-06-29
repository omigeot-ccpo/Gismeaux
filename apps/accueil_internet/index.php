<?php
session_start();
define('GIS_ROOT', '../..');
include_once(GIS_ROOT . '/inc/common.php');
/*gis_init();

$insee = $_SESSION['profil']->insee;
$appli = $_SESSION['profil']->appli;

if ((!$_SESSION['profil']->idutilisateur)){
	die("Point d'entr&eacute;e r&eacute;glement&eacute;.<br> Accès interdit. <br>Veuillez vous connecter via <a href=\"https://".$_SERVER['HTTP_HOST']."\">serveur carto</a><SCRIPT language=javascript>setTimeout(\"window.location.replace('https://".$_SERVER['HTTP_HOST']."')\",3000)</SCRIPT>");
}*/

$code_insee='770284';
$_SESSION['insee']=$code_insee;
if (eregi('MSIE', $_SERVER['HTTP_USER_AGENT']))
{    
$nav="0";// Internet Explorer 
}
elseif (eregi('Opera', $_SERVER['HTTP_USER_AGENT']))
{ 
$nav="1";//opÃ©ra
}
else
{
//header("Content-type: image/svg+xml");
$nav="2";//mozilla
}
?>
<html>
<head>
<title>Document sans titre</title>
<STYLE type="text/css">
<!---@IMPORT url(./ru/styl.css);  --->
</STYLE>
<meta name="keywords" content="renseignement d'urbanisme,meaux,cerfat,SVG, Scalable Vector Graphic, SIG, GIS, Mapserver, Postgis, Postgresql, MapInfo, géographie, géomatique, carte, cartographie, map, XML">
<meta name="description" content="Site d&eacute;di&eacute; &agrave; la r&eacute;glementation et au renseignement d&acute;urbanisme.Cartographie et r&eacute;glement en ligne.">
<meta name="google-site-verification" content="3UOa0DyTES7yANUUDXeFkRyIiyieJdHfN0Ucu9zO1b8" />
<meta name="Author" content="sig-meaux">
<meta name="Identifier-URL" content="http://www.carto.meaux.fr">
<meta name="Date-Creation-yyyymmdd" content="20070424">
<meta name="Reply-to" content="sig@meaux.fr">
</head>

<body>
<table width="100%"  border="0">
  <tr> 
  <td colspan="2"><img src="../../logo/770284.png" ></td>
    <td>&nbsp;</td>
  </tr>
  <tr valign="top"> 
    <td width="10%"><?php include('menu.php')?></td>
	
<?php
    if($nav=="0")
	{
	echo "<td align=\"left\">";
	echo "<font color=\"#FF0000\" size=\"11px\">Important</font><br>";
	echo "Utilisateur d'Internet Explorer<br>";
	echo "Pour utiliser la cartographie en  svg sur ce site<br>";
	echo "Installez le plugin abode SvgViewer fourni ci-dessous<br>";
	echo "<a href=\"http://".$_SERVER['HTTP_HOST']."/addons/SVGView6.exe\">le plugin abode SvgViewer 3</a><br><br>";
	echo "Les documents d&acute;urbanisme sont au format PDF.<br>IE utilis&eacute; en conjonction avec le plug-in Acrobat souffre de tr&egrave;s nombreux bugs, quelles que soient les versions et votre document peut ne pas s&acute;ouvrir.<br> Pour &eacute;viter tous ces probl&egrave;mes de mani&egrave;re fiable, il faut d&eacute;sactiver le plug-in et utiliser Acrobat comme application externe.<br>Pour cela, lancez Acrobat (proc&eacute;dure pour la version 9):<br> - dans le menu Edition, Pr&eacute;f&eacute;rences, Internet <br> - d&eacute;sactivez l&acute;option \"Afficher dans le navigateur Web\" . <br>Puis, lorsque vous récupérez un PDF dans IE, ce dernier affiche la boîte \"Ouvrir ce fichier\" ou \"Enregistrer ce fichier\".<br> D&eacute;cochez la case \"Toujours demander avant d&acute;ouvrir ce type de fichier\" et choisissez Ouvrir.<br> Dorénavant les PDF s&acute;ouvriront automatiquement dans une fen&ecirc;tre Acrobat indépendante. ";
	echo "</td>";
	}
	elseif($nav=="1")
	{
	echo "<td align=\"left\">";
	echo "Utilisateur d'opera,<br>";
	echo "La cartographie en  svg sur ce site est compatible nativement avec votre navigateur .<br>";
	echo "Si le plugin abode SvgViewer est install&eacute; , veuillez le d&eacute;sinstaller .<br>";
	echo "</td>";
	}
	else
	{
	echo "<td align=\"left\">";
	echo "Utilisateur de Firefox<br>";
	echo "La cartographie en  svg sur ce site est compatible nativement avec votre navigateur .<br>";
	echo "Si le plugin abode SvgViewer est install&eacute; , veuillez le d&eacute;sinstaller .<br>";
	echo "</td>";
	}
?>
  </tr>
  <tr><td colspan="2">&nbsp;</td></tr>
  <tr><td>&nbsp;</td><td align="left" style="color:#FF0000;font-size:30px"></td></tr>
</table>

</body>
</html>
