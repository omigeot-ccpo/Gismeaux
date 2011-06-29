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
function char($data)
{
$rast=str_replace("à","chr224",$data);
$rast=str_replace("é","chr233",$rast);
$rast=str_replace("è","chr232",$rast);
$rast=str_replace("ê","chr234",$rast);
$rast=str_replace("â","chr226",$rast);
$rast=str_replace("ç","chr231",$rast);
$rast=str_replace("ô","chr244",$rast);
$rast=str_replace("î","chr238",$rast);
$rast=str_replace("û","chr251",$rast);

return $rast;
}
if($_GET['objkey']=="schema")
{
$result="SELECT pn.nspname as col FROM pg_catalog.pg_namespace pn WHERE nspname NOT LIKE 'pg_%' AND nspname != 'information_schema' ORDER BY nspname";
}
else if($_GET['objkey']=="contenu")
{
$result="SELECT libelle_them||'.'||idtheme as col FROM admin_svg.theme order by libelle_them asc";
}
else
{
$test_table=explode("|",$_GET['objkey']);
if($test_table[0]=="table")
{
$result="SELECT c.relname as col FROM pg_catalog.pg_class c LEFT JOIN pg_catalog.pg_namespace n ON n.oid = c.relnamespace WHERE (c.relkind = 'r' or (c.relkind = 'v')) AND nspname='".$test_table[1]."' ORDER BY c.relname";
}
else
{
$result="SELECT a.attname as col FROM pg_catalog.pg_attribute a LEFT JOIN pg_catalog.pg_attrdef adef ON a.attrelid=adef.adrelid AND a.attnum=adef.adnum LEFT JOIN pg_catalog.pg_type t ON a.atttypid=t.oid WHERE a.attrelid = (SELECT oid FROM pg_catalog.pg_class WHERE relname='".$test_table[0]."' AND relnamespace = (SELECT oid FROM pg_catalog.pg_namespace WHERE nspname = '".$test_table[1]."')) AND a.attnum > 0 AND NOT a.attisdropped ORDER BY a.attnum";
}
}

$col=$DB->tab_result($result);
for ($z=0;$z<count($col);$z++)
{
$retour.=char($col[$z]['col'])."#";
}
echo $retour;
?>