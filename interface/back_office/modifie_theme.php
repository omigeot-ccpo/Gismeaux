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
$requete="UPDATE admin_svg.theme SET libelle_them='".$_GET["nomtheme"]."',schema='".$_GET["schema"]."',tabl='".$_GET["table"]."',raster='".$_GET["raster"]."',partiel='".$_GET["partiel"]."',vu_initial='".$_GET["initial"]."',zoommin=".$_GET["zoommin"].",zoommax=".$_GET["zoommax"].",zoommax_raster='".$_GET["zoommaxr"]."',force_chargement='".$_GET["force"]."' where idtheme='".$_GET["idtheme"]."'";
$DB->exec($requete);
$req="select appel,nom_as from admin_svg.col_sel where idtheme='".$_GET["idtheme"]."'";
$col1=$DB->tab_result($req);
for ($z=0;$z<count($col1);$z++)
{
			if($col1[$z]['nom_as']=='geom')
			{
			$colonnegeom="true";
			}
			if($col1[$z]['nom_as']=='ident')
			{
			$colonneref="true";
			}
			if($col1[$z]['nom_as']=='ad')
			{
			$colonnelibelle="true";
			}
}
if($colonnegeom=="true")
{
	if($_GET["geom"])
	{
	$requete="update admin_svg.col_sel set appel='".$_GET["geom"]."' where idtheme='".$_GET["idtheme"]."' and nom_as='geom'";
	$DB->exec($requete);
	}
	else
	{
	$requete="delete from admin_svg.col_sel where idtheme='".$_GET["idtheme"]."' and nom_as='geom'";
	$DB->exec($requete);
	}
	
}
else
{
	if($_GET["geom"])
	{
	$requete="insert into admin_svg.col_sel (idtheme,appel,nom_as) values('".$_GET["idtheme"]."','".$_GET["geom"]."','geom')";
	$DB->exec($requete);
	}
}

if($colonneref=="true")
{
	if($_GET["ref"])
	{
	$requete="update admin_svg.col_sel set appel='".$_GET["ref"]."' where idtheme='".$_GET["idtheme"]."' and nom_as='ident'";
	$DB->exec($requete);
	}
	else
	{
	$requete="delete from admin_svg.col_sel where idtheme='".$_GET["idtheme"]."' and nom_as='ident'";
	$DB->exec($requete);
	}
	
}
else
{
	if($_GET["ref"])
	{
	$requete="insert into admin_svg.col_sel (idtheme,appel,nom_as) values('".$_GET["idtheme"]."','".$_GET["ref"]."','ident')";
	$DB->exec($requete);
	}
}

if($colonnelibelle=="true")
{
	if($_GET["libelle"])
	{
	$requete="update admin_svg.col_sel set appel='".$_GET["libelle"]."' where idtheme='".$_GET["idtheme"]."' and nom_as='ad'";
	$DB->exec($requete);
	}
	else
	{
	$requete="delete from admin_svg.col_sel where idtheme='".$_GET["idtheme"]."' and nom_as='ad'";
	$DB->exec($requete);
	}
	
}
else
{
	if($_GET["libelle"])
	{
	$requete="insert into admin_svg.col_sel (idtheme,appel,nom_as) values('".$_GET["idtheme"]."','".$_GET["libelle"]."','ad')";
	$DB->exec($requete);
	}
}

$req="select clause from admin_svg.col_where where idtheme='".$_GET["idtheme"]."'";
$col1=$DB->tab_result($req);

if($col1[0]['clause'])
{
	if($_GET["clause"])
	{
	$requete="update admin_svg.col_where set clause='".$_GET["clause"]."' where idtheme='".$_GET["idtheme"]."'";
	$DB->exec($requete);
	}
	else
	{
	$requete="delete from admin_svg.col_where where idtheme='".$_GET["idtheme"]."'";
	$DB->exec($requete);
	}
	
}
else
{
	if($_GET["clause"])
	{
	$requete="insert into admin_svg.col_where (idtheme,clause) values('".$_GET["idtheme"]."','".$_GET["clause"]."')";
	$DB->exec($requete);
	}
}
?>
