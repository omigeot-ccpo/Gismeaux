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
define('GIS_ROOT', '..');
include_once(GIS_ROOT . '/inc/common.php');
gis_session_start();
//if($_SESSION['nav']!=0)
//{
header("Content-type: image/svg+xml");//}
$q="select area(GeometryFromtext('POLYGON((".$_GET['polygo']."))',".$projection.")) as aire";
$resultat = $DB->tab_result($q);
/*$q2="SELECT count(*) AS nombre_logement
   FROM cadastre.parcelle c
   JOIN (cadastre.batidgi a
   JOIN cadastre.b_desdgi b ON a.invar::text = b.invar::text) ON ('770'::text || substr(c.identifian::text, 1, 3)) = a.commune::text AND substr(c.identifian::text, 7, 2) = a.ccosec::text AND substr(c.identifian::text, 9) = a.dnupla::text
  WHERE b.cconlc::text = ANY (ARRAY['MA'::character varying, 'AP'::character varying]::text[])
  and
  contains(GeometryFromtext('POLYGON((".$_GET['polygo']."))',".$projection."),c.the_geom)";
$resultat2 = $DB->tab_result($q2);*/
echo "<g id=\"retour_surface\" xmlns=\"http://www.w3.org/2000/svg\" n=\"".$resultat[0]['aire']."\"></g>";
//echo $resultat[0]['aire'];
?>
