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
$req="select schema,tabl from admin_svg.theme where idtheme='".$_GET["idtheme"]."'";
$re=$DB->tab_result($req);
$req1="select clause from admin_svg.col_where where idtheme='".$_GET["idtheme"]."'";
$re1=$DB->tab_result($req1);

if($_GET["type"]=="fixe")
{
$req="select distinct ".$_GET["appel"]." as retour from ".$re[0]['schema'].".".$re[0]['tabl']." where ".$re1[0]['clause'];
$col=$DB->tab_result($req);
$d="";
for ($z=0;$z<count($col);$z++)
{
if($col[$z]['retour']!="")
{
$d=$d.$col[$z]['retour'].'#';
}
}
echo substr($d,0,-1);
}
else
{
if(eregi("area", $_GET["appel"]))
{
$_GET["appel"]="abs(".$_GET["appel"].")";
}
$req="select min(".$_GET["appel"].") as val1,AVG(".$_GET["appel"].") as val2,max(".$_GET["appel"].") as val3 from ".$re[0]['schema'].".".$re[0]['tabl']." where ".$re1[0]['clause'];
$col=$DB->tab_result($req);
$d="";
echo $col[0]['val1'].'#'.$col[0]['val2'].'#'.$col[0]['val3'];
}
?>
