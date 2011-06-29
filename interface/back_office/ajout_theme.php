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
$requete="insert into admin_svg.theme (libelle_them,schema,tabl,raster,partiel,vu_initial,zoommin,zoommax,zoommax_raster,force_chargement) values('".$_GET["nomtheme"]."','".$_GET["schema"]."','".$_GET["table"]."','".$_GET["raster"]."','".$_GET["partiel"]."','".$_GET["initial"]."',".$_GET["zoommin"].",".$_GET["zoommax"].",'".$_GET["zoommaxr"]."','".$_GET["force"]."')";

$DB->exec($requete);
if($_GET["ref"])
{
$requete="insert into admin_svg.col_sel (idtheme,appel,nom_as) values(currval('admin_svg.them')::character varying,'".$_GET["ref"]."','ident')";
$DB->exec($requete);
}
if($_GET["libelle"])
{
$requete="insert into admin_svg.col_sel (idtheme,appel,nom_as) values(currval('admin_svg.them')::character varying,'".$_GET["libelle"]."','ad')";
$DB->exec($requete);
}
if($_GET["geom"])
{
$requete="insert into admin_svg.col_sel (idtheme,appel,nom_as) values(currval('admin_svg.them')::character varying,'".$_GET["geom"]."','geom')";
$DB->exec($requete);
}
if($_GET["clause"])
{
$requete="insert into admin_svg.col_where (idtheme,clause) values(currval('admin_svg.them')::character varying,'".$_GET["clause"]."')";
$DB->exec($requete);
}
$d="select * from admin_svg.col_sel where idtheme=currval('admin_svg.them')::character varying";
$col=$DB->tab_result($d);
for ($z=0;$z<count($col);$z++)
{
			if($col[$z]['nom_as']=='geom')
			{
			$geometrie=$col[$z]['appel'];
			}
}
$dd="select distinct geometrytype(".$geometrie.") as geome from ".$_GET["schema"].".".$_GET["table"];
$geo=$DB->tab_result($dd);

if(eregi("line", $geo[0]['geome']))
{
echo "line|".$col[0]['idtheme'];
}
elseif(eregi("polygon", $geo[0]['geome']))
{
$requete="insert into admin_svg.style (idtheme,fill,stroke_rgb,stroke_width,font_familly,font_size,font_weight,symbole,id_symbole,opacity,fill_rule,stroke_dasharray,stroke_dashoffset) values(currval('admin_svg.them')::character varying,'0,0,0','0,0,0','1','','','','','','1','','','')";
$DB->exec($requete);
echo "poly";
}
else
{
echo "point|".$col[0]['idtheme'];
}

?>
