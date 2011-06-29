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
define('GIS_ROOT', '../..');
include_once(GIS_ROOT . '/inc/common.php');
gis_session_start();
function char($data)
{
$rast=str_replace("�","chr224",$data);
$rast=str_replace("�","chr233",$rast);
$rast=str_replace("�","chr232",$rast);
$rast=str_replace("�","chr234",$rast);
$rast=str_replace("�","chr226",$rast);
$rast=str_replace("�","chr231",$rast);
$rast=str_replace("�","chr244",$rast);
$rast=str_replace("�","chr238",$rast);
$rast=str_replace("�","chr251",$rast);

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