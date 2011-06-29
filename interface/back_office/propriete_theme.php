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
if($_GET['indice']=='propri')
{
//$result ="select appthe.mouseover,appthe.click,appthe.mouseout,appthe.raster,appthe.zoommin,appthe.zoommax,appthe.zoommaxraster,appthe.objselection,appthe.objprincipal,appthe.partiel,appthe.vu_initial,appthe.idtheme,theme.schema,theme.tabl,appthe.idappthe,appthe.force_chargement from admin_svg.appthe join admin_svg.theme on appthe.idtheme=theme.idtheme where appthe.idappthe='".$_GET['objkey']."'";
	//$cou=$DB->tab_result($result);
	
$d="select * from admin_svg.col_sel where idtheme='".$_GET['objkey']."'";
		$col=$DB->tab_result($d);
			for ($z=0;$z<count($col);$z++){
		
		if($col[$z]['nom_as']=='ident')
		{
		$ident=$col[$z]['appel'];
		}
		if($col[$z]['nom_as']=='ad')
		{
		$ad=$col[$z]['appel'];
		}
		}	
echo $ident."#".$ad;		
//echo $cou[0]['mouseover']."#".$cou[0]['click']."#".$cou[0]['mouseout']."#".$cou[0]['raster']."#".$cou[0]['zoommin']."#".$cou[0]['zoommax']."#".$cou[0]['zoommaxraster']."#".$cou[0]['objselection']."#".$cou[0]['objprincipal']."#".$cou[0]['partiel']."#".$cou[0]['vu_initial']."#".$ident."#".$ad."#".$cou[0]['schema']."#".$cou[0]['tabl']."#".$cou[0]['idtheme']."#".$cou[0]['idappthe']."#".$cou[0]['force_chargement']."#";
}
if($_GET['indice']=='raster')
{
$res="select admin_svg.v_fixe(raster) from admin_svg.theme where idtheme='".$_GET['objkey']."'";
$col=$DB->tab_result($res);
$d1="select schema,tabl from admin_svg.theme where idtheme='".$_GET['objkey']."'";
$col1=$DB->tab_result($d1);
$retour="true";
if($col[0]['v_fixe']==0)
{
$retour="false";
}

echo $retour."#".$col1[0]['schema']."#".$col1[0]['tabl'];

}
?>