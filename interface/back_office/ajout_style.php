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
if($_GET["mod_theme"]=="creation")
{
	if($_GET["type"]=="point")
	{
		if($_GET["affecte"]=="Texte")
		{
		$requete="insert into admin_svg.style (idtheme,fill,stroke_rgb,stroke_width,font_familly,font_size,font_weight,symbole,id_symbole,opacity,fill_rule,stroke_dasharray,stroke_dashoffset) values('".$_GET["idtheme"]."','0,0,0','0,0,0','','arial','10','','','','1','','','')";
$DB->exec($requete);
		}
		else
		{
		$requete="insert into admin_svg.style (idtheme,fill,stroke_rgb,stroke_width,font_familly,font_size,font_weight,symbole,id_symbole,opacity,fill_rule,stroke_dasharray,stroke_dashoffset) values('".$_GET["idtheme"]."','0,0,0','','','','10','','y','y','1','','','')";
$DB->exec($requete);
		}
	}
	else //ligne
	{
	if($_GET["affecte"]=="libelle")
		{
		$requete="insert into admin_svg.style (idtheme,fill,stroke_rgb,stroke_width,font_familly,font_size,font_weight,symbole,id_symbole,opacity,fill_rule,stroke_dasharray,stroke_dashoffset) values('".$_GET["idtheme"]."','0,0,0','0,0,0','','arial','10','','','','1','','','')";
$DB->exec($requete);
		}
		else
		{
		$requete="insert into admin_svg.style (idtheme,fill,stroke_rgb,stroke_width,font_familly,font_size,font_weight,symbole,id_symbole,opacity,fill_rule,stroke_dasharray,stroke_dashoffset) values('".$_GET["idtheme"]."','','0,0,0','1','','','','','','1','','','')";
$DB->exec($requete);
		}
	
	}
}
?>
