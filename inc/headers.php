<?php
/*Copyright Pays de l'Ourcq 2008
contributeur: jean-luc Dechamp - robert Leguay - olivier Migeot
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

if (!defined('GIS_ROOT')){
	die("Interdit. Forbidden. Verboten.");
}

function basicHeader()
{
  echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">";
  echo "<html>";
  echo "<head>";
  echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf8\">";
}

function basicFooter()
{
  echo "</body>";
  echo "</html>";
}

function errorHeader($type,$where)
{
  basicHeader();
  echo "<title>GISMeaux :: Erreur $type</title>";
  echo "</head>";
  echo "<body>";
}

function errorFooter($type,$where)
{
  echo "<p>Erreur survenue dans $where. Merci de contacter le support.</p>";
  basicFooter();

  die();
}

function cartoHeader($title, $mail="sig@meaux.fr", $author="sig-meaux")
{
  echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.0 Transitional//EN\">";
  echo "<!---->";
  echo "<html><head>";
  echo "<script type=\"text/javascript\" src=\"".GIS_ROOT."/connexion/media.js\"></script>";
  echo "<title>Cartographie :: $title</title>";
  echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">";
  echo "<meta name=\"keywords\" content=\"SVG, Scalable Vector Graphic, SIG, GIS, Mapserver, Postgis, Postgresql, MapInfo, geographie, geomatique, carte, cartographie, map, XML\">";
  echo "<meta name=\"description\" content=\"Carte SVG :: $title\">";
  echo "<meta name=\"Author\" content=\"$author\">";
  echo "<meta name=\"Identifier-URL\" content=\""."http://test.geo/interface/carto.php"."\">";
  echo "<meta name=\"Date-Creation-yyyymmdd\" content=\"20070424\">";
  echo "<meta name=\"Reply-to\" content=\"$mail\">";
  echo "</head>";
  echo "<body>";
  echo "<div style=\"font-size:0.8em;\">".$_SESSION['profil']->getUserName();
  echo "&nbsp;<a href=\"/logout.php\">Se déconnecter</a>";
  echo "</div>";
  echo "<div style=\"position:absolute;left:300px;top:290px;width:200px;height:200px;\">";
}

function cartoFooter()
{
  echo "</div>";
  echo "</boby>";
  echo "</html>";
}

?>
