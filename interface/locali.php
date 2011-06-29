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
//if($_SESSION['nav']==0)
//{
header("Content-type: image/svg+xml");//}
define('GIS_ROOT', '..');
include_once(GIS_ROOT . '/inc/common.php');
gis_session_start();
$parcelle=$_GET['parcelle'];
if($parcelle=='')
{
$numero1=$_GET['numero'];
$numero='0000'.$_GET['numero'];
$numero=substr($numero,-4);
$cod_insee=substr($_GET['code'],0,6);
$ccoriv=substr($_GET['code'],6);
$code_voie=substr($cod_insee,0,2).substr($cod_insee,-3).$ccoriv;
//$ccoriv=substr($_SESSION['profil']->insee,6);
//$cod_insee=substr($_SESSION['profil']->insee,0,6);
$q= "SELECT ccosec,dnupla FROM cadastre.parcel WHERE dnuvoi='$numero' AND ccoriv='$ccoriv' AND commune='$cod_insee'";
$cou=$DB->tab_result($q);
$section1=ltrim($cou[0]['ccosec']);
$section1=str_pad($section1, 2, "0", STR_PAD_LEFT);
$parcelle1=$cou[0]['dnupla'];

$parcelle=substr($cod_insee,3).'000'.$section1.$parcelle1;

	if(count($cou)==0)
	{
	$result ="SELECT X(centroid(Translate(Transform(the_geom,".$projection."),-".$_SESSION['xini'].",-".$_SESSION['yini']."))) as x,Y(centroid(Translate(Transform(the_geom,".$projection."),-".$_SESSION['xini'].",-".$_SESSION['yini']."))) as y FROM eco.adresse WHERE numero='$numero1' AND rivoli='$ccoriv' AND code_insee='$cod_insee'";
	$cou1=$DB->tab_result($result);
	$xmin=$cou1[0]['x'];
	$ymin=$cou1[0]['y'];

		if(count($cou1)>0)
		{
		$parcelle='point';
		}
		else
		{
		$result ="SELECT ccosec,dnupla FROM cadastre.parcel WHERE ccoriv='$ccoriv' AND commune='$cod_insee' order by dnuvoi asc";
		$cou2=$DB->tab_result($result);
		$nb=round(count($cou2)/2);
		$section1=ltrim($cou2[$nb]['ccosec']);
		$section1=str_pad($section1, 2, "0", STR_PAD_LEFT);
		$parcelle1=$cou2[$nb]['dnupla'];
		$parcelle=substr($cod_insee,3).'000'.$section1.$parcelle1;
			if(count($cou2)>0)
			{
			$parcelle=strtoupper($parcelle);
			$qs1="select X(centroid(Translate(Transform(the_geom,".$projection."),-".$_SESSION['xini'].",-".$_SESSION['yini']."))) as x,Y(centroid(Translate(Transform(the_geom,".$projection."),-".$_SESSION['xini'].",-".$_SESSION['yini']."))) as y from 			cadastre.parcelle where identifian='$parcelle'";
			$cou4=$DB->tab_result($qs1);
			$xmin=$cou4[0]['x'];
			$ymin=$cou4[0]['y'];
			$parcelle='point';
			}
			else
			{
			$parcelle='nonok';
			
			}
		}
	}

}
if($parcelle!='point' && strlen($parcelle)!=6)
{
$parcelle=strtoupper($parcelle);
$qs="select X(centroid(Translate(Transform(the_geom,".$projection."),-".$_SESSION['xini'].",-".$_SESSION['yini']."))) as x,Y(centroid(Translate(Transform(the_geom,".$projection."),-".$_SESSION['xini'].",-".$_SESSION['yini']."))) as y from cadastre.parcelle where identifian='$parcelle'";
$cou3=$DB->tab_result($qs);
	$xmin=$cou3[0]['x'];
	$ymin=$cou3[0]['y'];
}
if(count($cou3)<1)
{
$qs1="select X(centroid(Translate(Transform(the_geom,".$projection."),-".$_SESSION['xini'].",-".$_SESSION['yini']."))) as x,Y(centroid(Translate(Transform(the_geom,".$projection."),-".$_SESSION['xini'].",-".$_SESSION['yini']."))) as y from voirie.route where \"CODEVOIE_D\"='".$code_voie."' or \"CODEVOIE_G\"='".$code_voie."'";
			//echo $qs1;
			$cou4=$DB->tab_result($qs1);
			$xmin=$cou4[0]['x'];
			$ymin=$cou4[0]['y'];
}
if($parcelle!='nonok')
{
$_SESSION['parcelle_select']=$parcelle;
}
print("<g id=\"locali\" xmlns=\"http://www.w3.org/2000/svg\" n=\"$parcelle|$xmin|$ymin|$zoom|$xm|$ym|\"></g>");


?>

