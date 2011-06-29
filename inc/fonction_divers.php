<?php
/*Copyright Pays de l'Ourcq 2008
contributeur: jean-luc Dechamp - robert Leguay - olivier Migeot
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

if (!defined('GIS_ROOT')){
	die("Interdit. Forbidden. Verboten.");
}

function album_foto($colz){
    if (count($colz)>0){
	echo '<style type="text/css">.div_photo {
	position:absolute;
	left:50px;
	top:50px;
	width:auto;
	height:auto;
	visibility:hidden;
	z-index:2;
	background-color: #C1FDFF;
	}
	</style><script language="JavaScript">
	function affiche_album(){
		document.getElementById("div_photo").style.visibility = "visible";
	}
	function ferme_album(){
		document.getElementById("div_photo").style.visibility = "hidden";
	}
	</script>';
	echo '<br><INPUT type="button" name="album" value="Album photo('.count($colz).')" onclick="affiche_album()">';
	echo '<DIV id="div_photo" class="div_photo">';
	$nbcol=ceil(sqrt(count($colz)));$n=1;
	echo "<TABLE><tr>";
	for($i=0;$i<count($colz);$i++){
	if($colz[$i]['appli']!="")
	{$chemin="../".$colz[$i]['appli'];}else{$chemin=".";}
		echo "<td>";
		echo "<a href=\"".$chemin."/photo/".$colz[$i]['id_photo'].".JPG\" target=\"_blank\"><img name='photo".$i."' src='".$chemin."/photo/vignette/".$colz[$i]['id_photo'].".JPG' alt=''></a><br><input name=\"suppho\" type=\"button\" value=\"supprimer\" onClick=\"document.getElementById('pho').value='".$colz[$i]['id_photo']."';document.getElementById('act').value='suppphoto';submit()\">";
		echo "</td>";
		if (($i+1)==($nbcol*$n)){ echo "</tr><tr>";$n++;}
	}
	echo "</tr></TABLE>";
	echo '<INPUT type="button" name="ferme" value="Fermer" onclick="ferme_album()"></DIV>';
      }
}
function album_foto2($colz){
    if (count($colz)>0){
	echo '<style type="text/css">.div_photo {
	position:absolute;
	left:50px;
	top:50px;
	width:auto;
	height:auto;
	visibility:hidden;
	z-index:2;
	background-color: #C1FDFF;
	}
	</style><script language="JavaScript">
	function affiche_album(){
		document.getElementById("div_photo").style.visibility = "visible";
	}
	function ferme_album(){
		document.getElementById("div_photo").style.visibility = "hidden";
	}
	</script>';
	echo '<br><INPUT type="button" name="album" value="Album photo('.count($colz).')" onclick="affiche_album()">';
	echo '<DIV id="div_photo" class="div_photo">';
	$nbcol=ceil(sqrt(count($colz)));$n=1;
	echo "<TABLE><tr>";
	for($i=0;$i<count($colz);$i++){
	//if($colz[$i]['appli']!="")
	//{
	$chemin="../phototeck";//}else{$chemin=".";}
		echo "<td>";
		echo "<a href=\"".$chemin."/photo/".$colz[$i]['fichier']."\" target=\"_blank\"><img name='photo".$i."' src='".$chemin."/photo/vignette/".$colz[$i]['fichier']."' alt=''></a>";
		echo "</td>";
		if (($i+1)==($nbcol*$n)){ echo "</tr><tr>";$n++;}
	}
	echo "</tr></TABLE>";
	echo '<INPUT type="button" name="ferme" value="Fermer" onclick="ferme_album()"></DIV>';
      }
}
function insert_foto($i,$lastvaleur,$schema,$tabl,$champID,$width,$height,$width_vignette,$height_vignette,$DB,$gid){
	if( is_uploaded_file($_FILES['phot']['tmp_name'][$i]) ){
		$lastvaleur=$lastvaleur+1;
		$sql="insert into ".$schema.".".$tabl." (".$champID.") values (".$gid.")";
		$DB->tab_result($sql);
		$extention=explode(".",$_FILES['phot']['name'][$i]);
		move_uploaded_file($_FILES['phot']['tmp_name'][$i], "./photo/".$lastvaleur.".".$extention[1]);
		$tableau = GetImageSize("./photo/".$lastvaleur.".".$extention[1]);
		$ratio_orig = $tableau[0]/$tableau[1];
		if ($width_vignette/$height_vignette > $ratio_orig) {
   			$width_vignette = $height_vignette*$ratio_orig;
		} else {
   			$height_vignette = $width_vignette/$ratio_orig;
		}
		if ($width/$height > $ratio_orig) {
   			$width = $height*$ratio_orig;
		} else {
   			$height = $width/$ratio_orig;
		}
		$image_p = imagecreatetruecolor($width, $height);
		$image_p_vignette = imagecreatetruecolor($width_vignette, $height_vignette);
		if($extention[1]=="jpg" ||$extention[1]=="JPG" ){
			$image = imagecreatefromjpeg("./photo/".$lastvaleur.".".$extention[1]);
		}elseif($extention[1]=="png" || $extention[1]=="PNG"){
			$image = imagecreatefrompng("./photo/".$lastvaleur.".".$extention[1]);
		}
		imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $tableau[0], $tableau[1]);
		imagejpeg($image_p,"./photo/".$lastvaleur.".JPG", 100);
		imagecopyresampled($image_p_vignette, $image, 0, 0, 0, 0, $width_vignette, $height_vignette, $tableau[0], $tableau[1]);
		imagejpeg($image_p_vignette,"./photo/vignette/".$lastvaleur.".JPG", 100);
		if($extention[1]=="jpg"){
			unlink("./photo/".$lastvaleur.".jpg");
		}elseif($extention[1]=="png"){
			unlink("./photo/".$lastvaleur.".png");
		}
    	}
}
function supp_foto($DB,$idfot,$schema,$tabl,$champID,$rept,$f_root){
	$sql="delete from ".$schema.".".$tabl." where ".$champID."=".$idfot;
	$DB->tab_result($sql);
	exec("rm ".$f_root."apps/".$rept."/photo/".$idfot.".JPG ");
	exec("rm ".$f_root."apps/".$rept."/photo/vignette/".$idfot.".JPG ");
}
function proxy_context(){
// Define a context for HTTP.
$auth = base64_encode($GLOBALS['http_proxy_user'].":".$GLOBALS['http_proxy_password']);
$header = "Proxy-Authorization: Basic $auth";
$aContext = array(
    'http' => array(
        'proxy' => $GLOBALS['http_proxy_url'], // This needs to be the server and the port of the NTLM Authentication Proxy Server.
        'method' => "GET",
        'header' => $header,
        'request_fulluri' => True,
        ),
    );
return stream_context_create($aContext);
}

function appel_wfs($url,$typename,$filter,$recherche_multi,$recherche_uniq)
{
$donnees = array(
'typename' => $typename,
'Filter' => $filter
);
//$url = 'http://cartorisque.prim.net/wfs/77?SERVICE=WFS&VERSION=1.0.0&REQUEST=getfeature';

$contenu = http_build_query( $donnees );

// Encodage de l'autentification
$authProxy = base64_encode($GLOBALS['http_proxy_user'].":".$GLOBALS['http_proxy_password']);
// Création des options de la requête
$opts = array(
	'http' => array (
		'method'=>'POST',
		'proxy'=> $GLOBALS['http_proxy_url'],
		'content' => $contenu,
		'request_fulluri' => true,
		'header'=>"Proxy-Authorization: Basic $authProxy"
	),
	'https' => array (
		'method'=>'POST',
		'proxy'=> $GLOBALS['http_proxy_url'],
		'content' => $contenu,
		'request_fulluri' => true,
		'header'=>"Proxy-Authorization: Basic $authProxy"
	)
);
// Création du contexte de transaction
$ctx = stream_context_create($opts);
// Récupération des données
$page = file_get_contents($url,false,$ctx);
//echo $content;

$page=str_replace('xmlns:ms="http://mapserver.gis.umn.edu/mapserver"','',$page);
$page=str_replace('xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"','',$page);
$page=str_replace('xmlns:ogc="http://www.opengis.net/ogc"','',$page);
$page=str_replace('xmlns:gml="http://www.opengis.net/gml"','',$page);
$page=str_replace('xmlns:wfs="http://www.opengis.net/wfs"','',$page);
$xml = simplexml_load_string($page);

$rep="";
if($recherche_multi)
{ 
$recherche=explode('|',$recherche_multi);
for($n=0;$n<count($recherche);$n++)
{
$tas= $xml->xpath($recherche[$n]);
$i=0;
	/*while(list( , $node) = each($tas)) {
   $rep[$i][$$recherche[$n]]=$node;
}*/
foreach ($tas as $ta){
		$rep[$i][$recherche[$n]]=utf8_decode($ta);
		$i=$i+1;
	}
}
	/*foreach ($tas as $ta){
		$rep.=$ta.",";
	}*/
}
if($recherche_uniq)
{
	$tas1=$xml->xpath($recherche_uniq);
}
	
	return array($rep,$tas1[0]);
	//return substr(utf8_decode($rep),0,-1).' '.$tas1[0];
	
}

$tab_proj= array('nom','EPSG','IGNF');
$tab_proj['nom']=array('LAMB1','LAMB1C','LAMB2','LAMB2C','LAMB2C','LAMB3','LAMB3C','LAMB4','LAMB4C','LAMB93','RGF93CC50','RGF93CC49','RGF93CC48','RGF93CC47','RGF93CC46','RGF93CC45','RGF93CC44','RGF93CC43','RGF93CC42');
$tab_proj['EPSG']=array('27561','27571','27562','27572','27582','27563','27573','27564','27574','2154','3950','3949','3948','3947','3946','3945','3944','3943','3942');
$tab_proj['IGNF']=array('320002101','320002131','320002102','320002132','320002132','320002103','320002133','320002104','320002134','310024140','310024150','310024149','310024148','310024147','310024146','310024145','310024144','310024143','310024142');
?>
