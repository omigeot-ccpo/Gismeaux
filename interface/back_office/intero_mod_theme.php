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
$requete="select libelle_them,schema,tabl,raster,partiel,vu_initial,zoommin,zoommax,zoommax_raster,groupe,force_chargement from admin_svg.theme where idtheme='".$_GET["idtheme"]."' order by libelle_them asc";
$col=$DB->tab_result($requete);
$req="select appel,nom_as from admin_svg.col_sel where idtheme='".$_GET["idtheme"]."'";
$col1=$DB->tab_result($req);
for ($z=0;$z<count($col1);$z++)
{
			if($col1[$z]['nom_as']=='geom')
			{
			$colonnegeom=$col1[$z]['appel'];
			}
			if($col1[$z]['nom_as']=='ident')
			{
			$colonneref=$col1[$z]['appel'];
			}
			if($col1[$z]['nom_as']=='ad')
			{
			$colonnelibelle=$col1[$z]['appel'];
			}
}
$requete="select clause from admin_svg.col_where where idtheme='".$_GET["idtheme"]."'";
$col2=$DB->tab_result($requete);
echo $col[0]['libelle_them']."#".$col[0]['schema']."#".$col[0]['tabl']."#".$col[0]['raster']."#".$col[0]['partiel']."#".$col[0]['vu_initial']."#".$col[0]['zoommin']."#".$col[0]['zoommax']."#".$col[0]['zoommax_raster']."#".$colonneref."#".$colonnegeom."#".$colonnelibelle."#".$col2[0]['clause']."#".$col[0]['groupe']."#".$col[0]['force_chargement'];
?>
