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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Impression</title>
<script>
function init()
{
window.resizeTo(440,500);

 }
 
 function modif(form) {
 //document.forms[0].elements[1].options.length=0;
 var indexfo=document.forms[0].elements[0].options.selectedIndex
 
 if(document.forms[0].elements[0].options[indexfo].value!="A4" && document.forms[0].elements[0].options[indexfo].value!="A3" )
	{
	var indexfo1=document.forms[0].elements[1].options.selectedIndex
	
	if(indexfo1>1)
	{
	alert(document.forms[0].elements[1].options[indexfo1].text+" n'est pas diponible pour le format "+document.forms[0].elements[0].options[indexfo].value)
	}
	document.forms[0].elements[1].options[2].text="";
	document.forms[0].elements[1].options[3].text="";
	document.forms[0].elements[1].options[0].selected="selected";
	prev()
 	}
	else
	{
	document.forms[0].elements[1].options[2].text="Portrait avec l�gende";
	document.forms[0].elements[1].options[3].text="Portrait sans l�gende";
	}
	
	
	}
	
function modif_echelle(form)
{
var indexfo=document.forms[0].elements[0].options.selectedIndex;
var indexfo1=document.forms[0].elements[1].options.selectedIndex;
var ech=<?php echo round($_GET['echini']);?>;
if(document.forms[0].elements[0].options[indexfo].value=="A4" && document.forms[0].elements[1].options[indexfo1].value<2)
{
document.getElementById("echelle").value=ech;
}
if(document.forms[0].elements[0].options[indexfo].value=="A3" && document.forms[0].elements[1].options[indexfo1].value<2)
{
document.getElementById("echelle").value=Math.round(ech/(29.7/21));
}
if(document.forms[0].elements[0].options[indexfo].value=="A2")
{
document.getElementById("echelle").value=ech/2;
}
if(document.forms[0].elements[0].options[indexfo].value=="A1")
{
document.getElementById("echelle").value=Math.round(ech/(2*(29.7/21)));
}
if(document.forms[0].elements[0].options[indexfo].value=="A0")
{
document.getElementById("echelle").value=ech/4;
}
if(document.forms[0].elements[0].options[indexfo].value=="A4" && document.forms[0].elements[1].options[indexfo1].value>2)
{
document.getElementById("echelle").value=ech*(184.5/146.77);
}
if(document.forms[0].elements[0].options[indexfo].value=="A3" && document.forms[0].elements[1].options[indexfo1].value>2)
{
document.getElementById("echelle").value=Math.round((ech*((184.5*(29.7/21))/207.57)/(29.7/21)));
}

}	
 
function prev()
{
var indexfo=document.forms[0].elements[1].options.selectedIndex;
	if(document.forms[0].elements[1].options[indexfo].value==1)
	{
	document.getElementById( "vignette1" ).style.visibility ="visible";
	document.getElementById( "vignette2" ).style.visibility ="hidden";
	document.getElementById( "vignette3" ).style.visibility ="hidden";
	document.getElementById( "vignette4" ).style.visibility ="hidden";
	}
	else if(document.forms[0].elements[1].options[indexfo].value==2)
	{
	document.getElementById( "vignette2" ).style.visibility ="visible";
	document.getElementById( "vignette1" ).style.visibility ="hidden";
	document.getElementById( "vignette3" ).style.visibility ="hidden";
	document.getElementById( "vignette4" ).style.visibility ="hidden";
	}
	else if(document.forms[0].elements[1].options[indexfo].value==3)
	{
	document.getElementById( "vignette3" ).style.visibility ="visible";
	document.getElementById( "vignette1" ).style.visibility ="hidden";
	document.getElementById( "vignette2" ).style.visibility ="hidden";
	document.getElementById( "vignette4" ).style.visibility ="hidden";
	}
	else
	{
	document.getElementById( "vignette4" ).style.visibility ="visible";
	document.getElementById( "vignette1" ).style.visibility ="hidden";
	document.getElementById( "vignette2" ).style.visibility ="hidden";
	document.getElementById( "vignette3" ).style.visibility ="hidden";
	}
}
</script>
</head>
<?php
if($_GET['nav']==0)
{
echo "<body onload='init();prev();'>";
}
else
{
echo "<body onload='prev();'>";
}

if($_GET['nav']!="0")
{
$raster=str_replace("chr(224)","�",$_GET['raster']);
$raster=str_replace("chr(233)","�",$raster);
$raster=str_replace("chr(232)","�",$raster);
$raster=str_replace("chr(234)","�",$raster);
$raster=str_replace("chr(226)","�",$raster);
$raster=str_replace("chr(231)","�",$raster);
$raster=str_replace("chr(244)","�",$raster);
$raster=str_replace("chr(238)","�",$raster);
$raster=str_replace("chr(251)","�",$raster);
$raster=str_replace("chr(95)","_",$raster);
}
else
{
$raster=$_GET['raster'];
}
print("<form id=\"form1\" name=\"form1\" target=\"_parent\" method=\"GET\" action=\"./printpdf.php\" onload=\"modif(this.form)\">");
?>

  <div style="position:absolute;left:50px;top:15px">
  Format d'impression
    <select name="format" onchange="modif(this.form);modif_echelle(this.form)">
        <option selected="selected" value="A4">A4</option>
        <option value="A3">A3</option>
        <option value="A2">A2</option>
        <option value="A1">A1</option>
        <option value="A0">A0</option>
    </select>
  </div>
   <div style="position:absolute;left:50px;top:45px">
    Mod&egrave;le
    <select name="legende" onchange="prev();modif_echelle(this.form)">
	<option value=1 selected="selected">Paysage avec l&eacute;gende</option>
      <option value=2>Paysage sans l&eacute;gende</option>
      <option value=3>Portrait avec l&eacute;gende</option>
      <option value=4>Portrait sans l&eacute;gende</option>
      
    </select>
</div> 
  <div id="vignette3" style="border:ridge;position:absolute;left:90px;top:75px;visibility:visible"><img src="./vignette3.JPG" width="118" height="160" /></div>
  <div id="vignette4" style="border:ridge;position:absolute;left:90px;top:75px;visibility:hidden"><img src="./vignette4.JPG" width="118" height="160" /></div>
  <div id="vignette1" style="border:ridge;position:absolute;left:70px;top:95px;visibility:hidden"><img src="./vignette1.JPG" width="160" height="118" /></div>
  <div id="vignette2" style="border:ridge;position:absolute;left:70px;top:95px;visibility:hidden"><img src="./vignette2.JPG" width="160" height="118" /></div>
    <div style="position:absolute;left:50px;top:250px">
    Titre
    <input name="titre" type="text" size="30" maxlength="40" />
	<input name="raster" type="hidden" value="<?php echo $raster;?>" />
	<input name="x" type="hidden" value="<?php echo $_GET['x'];?>" />
	<input name="y" type="hidden" value="<?php echo $_GET['y'];?>" />
	<input name="lar" type="hidden" value="<?php echo $_GET['lar'];?>" />
	<input name="hau" type="hidden" value="<?php echo $_GET['hau'];?>" />
	<input name="zoom" type="hidden" value="<?php echo $_GET['zoom'];?>" />
	<input name="xini" type="hidden" value="<?php echo $_GET['xini'];?>" />
	<input name="yini" type="hidden" value="<?php echo $_GET['yini'];?>" />
	<input name="parce" type="hidden" value="<?php echo stripslashes($_GET['parce']);?>" />
  </div>
  <!--<div style="position:absolute;left:50px;top:280px">
    Vous &ecirc;tes &agrave; une &eacute;chelle:1/<?php //echo round($_GET['echini']);?>
  </div>-->
	<div style="position:absolute;left:50px;top:310px">
    Echelle:1/
    <input id="echelle" name="echelle" type="text" value="<?php echo round($_GET['echini']);?>" size="4" maxlength="5" />*Laissez la valeur si pas de mise &agrave; l'echelle
  </div>
  </div>
	<div style="position:absolute;left:120px;top:340px"><input name="Valider" type="submit" value="Valider" /></div>
</form>
</body>
</html>
