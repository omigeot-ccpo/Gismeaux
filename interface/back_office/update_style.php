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
define('GIS_ROOT', '../..');
include_once(GIS_ROOT . '/inc/common.php');
gis_session_start();
if($_GET["appli"] && $_GET["idtheme"])
{
$requete="insert into admin_svg.appthe (idtheme,idapplication,ordre,partiel,vu_initial,zoommin,zoommax,zoommaxraster,force_chargement) values ('".$_GET["idtheme"]."','".$_GET["appli"]."',(select sinul((max(ordre)+1)::character varying,1::character varying)::integer from admin_svg.appthe where idapplication='".$_GET["appli"]."'),(select partiel from admin_svg.theme where idtheme='".$_GET["idtheme"]."'),(select vu_initial from admin_svg.theme where idtheme='".$_GET["idtheme"]."'),(select zoommin from admin_svg.theme where idtheme='".$_GET["idtheme"]."'),(select zoommax from admin_svg.theme where idtheme='".$_GET["idtheme"]."'),(select zoommax_raster::integer from admin_svg.theme where idtheme='".$_GET["idtheme"]."'),(select force_chargement from admin_svg.theme where idtheme='".$_GET["idtheme"]."'))";
$DB->exec($requete);
$d="select last_value from admin_svg.appth";
$col=$DB->tab_result($d);
echo $col[0]['last_value'];
//$_GET["requete"]=$requete;
}
if($_GET["choix"]=='supp' && $_GET["idappthe"])
{
$req="delete from admin_svg.col_theme where idappthe='".$_GET["idappthe"]."'";
$DB->exec($req);
//pg_exec($pgx,$req);
$requete="delete from admin_svg.appthe where idappthe='".$_GET["idappthe"]."'";
$DB->exec($requete);
//$_GET["requete"]=$requete;
}
//include("./execute_sql.php");
if($_GET["genere"]!="false")
{
include("./generemap.php");
}
?>
