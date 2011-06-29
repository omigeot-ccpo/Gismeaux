<?php
//phpinfo();
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
//if($_SERVER['SERVER_PORT']!=443)
//{
//ini_set('session.gc_maxlifetime', 3600);
//session_start();
/*ob_start('ob_gzhandler');
ini_set('session.gc_maxlifetime', 3600);
session_start();
header('Cache-Control: public');
header("Pragma:");*/
define('GIS_ROOT', '../..');
include_once(GIS_ROOT . '/inc/common.php');
gis_session_start();
$extra_url = "&user=".$DB->db_user."&password=".$DB->db_passwd."&dbname=".$DB->db_name."&host=".$DB->db_host;
//}else
/*{
$_SESSION['xini']= $_GET["xini"];
$_SESSION['yini']= $_GET["yini"];
$_SESSION['profil']->insee= $_GET["code_insee"];
}*/

$_SESSION['zoommm'] =$_GET['zoom'];
$_SESSION['cx'] =round($_GET["x"]+($_GET["lar"]/2));
$_SESSION['cy'] =round( $_GET["y"]+( $_GET["hau"]/2));
$_SESSION['boitelarg'] =$_GET["lar"];
$_SESSION['boitehaut'] =$_GET["hau"];
$_SESSION['prace'] =$_GET["placid"];
//include("../connexion/deb.php");
$xm= $_GET["x"]+  $_GET["xini"];
$xma=($_GET["x"]+ $_GET["lar"]) +  $_GET["xini"];
$yma=  $_GET["yini"] -  $_GET["y"];
$ym=  $_GET["yini"] - ($_GET["y"] +  $_GET["hau"]);
$textq="";
$sql_app="select supp_chr_spec(libelle_appli) as libelle_appli from admin_svg.application where idapplication='".$_SESSION["appli"]."'";
$app=$DB->tab_result($sql_app);
$application=$app[0]['libelle_appli'];

	if ( $_GET["type"]=='raster'){
	$rastx=explode(";", $_GET["raster"]);
	$raster="";
	for($i=0;$i<count($rastx);$i++)
	{
	$ras=explode(".",$rastx[$i]);
	$raster.=$ras[1].";";
	}
	$raster=substr($raster,0,strlen($raster)-1);
	$raster=str_replace(";","&layer=",$raster);
	
	$erreur=error_reporting ();
	error_reporting (1);

//$serv=$_SERVER["SERVER_NAME"];
$serv="127.0.0.1";
	if(substr($_SESSION['profil']->insee, -3)=='000')
	{

	$url="http://".$serv."/cgi-bin/mapserv?map=".$fs_root."capm/".$application.".map&insee=".substr($_SESSION['profil']->insee,0,3)."&layer=".$raster."&minx=".$xm."&miny=".$ym."&maxx=".$xma."&maxy=".$yma."&mapsize=1240%201040&parce=('')".$extra_url;
	}
	else
	{
	$url="http://".$serv."/cgi-bin/mapserv?map=".$fs_root."capm/".$application.".map&insee=".$_SESSION['profil']->insee."&layer=".$raster."&minx=".$xm."&miny=".$ym."&maxx=".$xma."&maxy=".$yma."&mapsize=1240%201040&parce=('')".$extra_url;
	}
$contenu=file($url);
//echo $contenu[0];
       		while (list($ligne,$cont)=each($contenu)){
			$numligne[$ligne]=$cont;
		}
		$texte=$contenu[$ms_dbg_line];
		$image=explode('/',$texte);
		$conte1=explode('.',$image[4]);
		$image=$conte1[0];
		
		$textq.="<g id='".$_GET['layer']."'>\n";
		$textq.="<image id='ima' x='". $_GET["x"]."' y='". $_GET["y"]."' width='". $_GET["lar"]."' height='". $_GET["hau"]."'  visibility='visible' xlink:href='../../tmp/".$image.".jpeg'></image>";
		
		error_reporting ($erreur);
$textq.="</g>\n";
}
else
{
$rast= $_GET["raster"];
if($nav=="2")
{
$rast=utf8_decode( $_GET["raster"]);
}
if($nav=="1")
{
$rast=str_replace("chr(224)","à",$_GET["raster"]);
$rast=str_replace("chr(233)","é",$rast);
$rast=str_replace("chr(232)","è",$rast);
$rast=str_replace("chr(234)","ê",$rast);
$rast=str_replace("chr(226)","â",$rast);
$rast=str_replace("chr(231)","ç",$rast);
$rast=str_replace("chr(244)","ô",$rast);
$rast=str_replace("chr(238)","î",$rast);
$rast=str_replace("chr(251)","û",$rast);
$rast=str_replace("chr(60)","<",$rast);
$rast=str_replace("chr(62)",">",$rast);
$rast=str_replace("chr(63)","?",$rast);
$rast=str_replace("chr(34)",'"',$rast);
$rast=str_replace("chr(39)","'",$rast);
$rast=str_replace("chr(35)","#",$rast);
$rast=str_replace("chr(33)","!",$rast);
$rast=str_replace("chr(95)","_",$rast);
}
$ras=explode(".",$rast);
	$rast=$ras[1];
	$id=$ras[0];
//$sql="select theme.schema,theme.tabl,col_theme.colonn,col_theme.valeur_mini,col_theme.valeur_maxi,col_theme.valeur_texte,sinul(col_theme.fill, style.fill) as fill,sinul(col_theme.stroke_rgb, style.stroke_rgb) as stroke_rgb,sinul(col_theme.symbole,style.symbole) as symbole,sinul(col_theme.opacity,style.opacity) as opacity,sinul(col_theme.font_familly,style.font_familly) as font_familly,sinul(col_theme.font_size,style.font_size) as font_size,appthe.mouseover,appthe.mouseout,appthe.click,appthe.idtheme,theme.partiel,sinul(col_theme.stroke_width,style.stroke_width) as stroke_width,appthe.pointer_events from admin_svg.appthe join admin_svg.theme on appthe.idtheme=theme.idtheme left outer join  admin_svg.col_theme on appthe.idappthe=col_theme.idappthe left outer join  admin_svg.style on appthe.idtheme=style.idtheme where appthe.idapplication=".$_SESSION["appli"]." and (col_theme.intitule_legende='".$rast."' or theme.libelle_them='".$rast."') and appthe.idappthe=".$id;
$sql="select theme.schema,theme.tabl,col_theme.colonn,col_theme.valeur_mini,col_theme.valeur_maxi,col_theme.valeur_texte,sinul(col_theme.fill, style.fill) as fill,sinul(col_theme.stroke_rgb, style.stroke_rgb) as stroke_rgb,sinul(col_theme.symbole,style.symbole) as symbole,sinul(col_theme.opacity,style.opacity) as opacity,sinul(col_theme.font_familly,style.font_familly) as font_familly,sinul(col_theme.font_size,style.font_size) as font_size,appthe.mouseover,appthe.mouseout,appthe.click,appthe.idtheme,sinul(appthe.partiel,theme.partiel) as partiel,sinul(col_theme.stroke_width,style.stroke_width) as stroke_width,appthe.pointer_events from admin_svg.appthe join admin_svg.theme on appthe.idtheme=theme.idtheme left outer join  admin_svg.col_theme on appthe.idappthe=col_theme.idappthe left outer join  admin_svg.style on appthe.idtheme=style.idtheme where appthe.idapplication='".$_SESSION["appli"]."' and (col_theme.intitule_legende='".$rast."' or theme.libelle_them='".$rast."') and appthe.idappthe='".$id."'";
$cou=$DB->tab_result($sql);
$rotation='false';
$d="select * from admin_svg.col_sel where idtheme='".$cou[0]['idtheme']."'";
		$col=$DB->tab_result($d);
		$f="select ";
		$geometrie="";
		
		for ($z=0;$z<count($col);$z++){
		
		if($col[$z]['nom_as']=='rotation')
		{
		$rotation='true';
		}
			if($col[$z]['nom_as']=='geom')
			{
			$geometrie=$col[$z]['appel'];
			$f.="assvg(Translate(Transform(".$col[$z]['appel'].",$projection),-".$_SESSION['xini'].",-".$_SESSION['yini'].",0),1,6) as ".$col[$z]['nom_as'].",";}
			else
			{
			$f.="(".$col[$z]['appel'].") as ".$col[$z]['nom_as'].",";
			}
		}
		$f=substr($f,0,-1)." from ".$cou[0]['schema'].".".$cou[0]['tabl'];
		if ($cou[0]['partiel']==1)
		{
            if($cou[0]['schema']!="bd_topo")
			{
				if (substr($_SESSION['profil']->insee, -3) == "000")
					{
					
                	$f.=" where (code_insee like '".substr($_SESSION['profil']->insee,0,3)."%' or code_insee is null) and Transform(".$geometrie.",".$projection.") && box'($xm,$ym,$xma,$yma)'";
            		}
				else
					{
					
                	$f.=" where (code_insee like '".$_SESSION['profil']->insee."%' or code_insee is null) and Transform(".$geometrie.",".$projection.") && box'($xm,$ym,$xma,$yma)'";
            		}
			}
			else
			{
			
			$f.=" where Transform(".$geometrie.",".$projection.") && box'($xm,$ym,$xma,$yma)'";
			}
				
        }
		else
		{
		 
		 	if($cou[0]['schema']!="bd_topo")
				{
		 		if (substr($_SESSION['profil']->insee, -3) == "000")
		 			{
					
                	$f.=" where (code_insee like '".substr($_SESSION['profil']->insee,0,3)."%' or code_insee is null) ";
            		}
				else
					{
					
                	$f.=" where (code_insee = '".$_SESSION['profil']->insee."' or code_insee is null) ";
            		}
				}
				else
				{
				$f.=" where 1=1";
				}
		}
		
		$j="select * from admin_svg.col_where where idtheme='".$cou[0]['idtheme']."'";
		$whr=$DB->tab_result($j);
		if (count($whr)>0){
			
			$f.=" and ".str_replace("VALEUR","'".$_SESSION['profil']->insee."'",$whr[0]['clause']);
						
			}
		
		if($geometrie!="")
		{
		$dd="select distinct geometrytype(".$geometrie.") as geome from ".$cou[0]['schema'].".".$cou[0]['tabl'];
		$geo=$DB->tab_result($dd);
		if($geo[0]['geome']=="POINT" AND $cou[0]['symbole']!="") //si symbole
		{
			$type_geo="symbole";
		}
		else if($geo[0]['geome']=="POINT") //si texte
		{
		$type_geo="texte";
		}
		}
	
		if($cou[0]['valeur_mini']!='')
		{
			
			$f.=" and ".$cou[0]['colonn'].">=".$cou[0]['valeur_mini']." and ".$cou[0]['colonn']."<=".$cou[0]['valeur_maxi'];
			
		}
		else
		{
			if($cou[0]['colonn']!='')
			{
			
			$f.=" and ".$cou[0]['colonn']."='".$cou[0]['valeur_texte']."'";
			
			}
		}
		$res=$DB->tab_result($f);
		
$styl="";
if($cou[0]['fill']!=''&&$cou[0]['fill']!='none')
{$styl="fill:rgb(".$cou[0]['fill'].");";}else{$styl="fill:none;";}
if($cou[0]['stroke_rgb']!=''&&$cou[0]['stroke_rgb']!='none')
{$styl.="stroke:rgb(".$cou[0]['stroke_rgb'].");";}else{$styl.="stroke:none;";}
if($cou[0]['opacity']!='')
{$styl.="fill-opacity:".$cou[0]['opacity'].";";}
if($cou[0]['font_size']!='')
{$styl.="font-size:".$cou[0]['font_size'].";";}
if($cou[0]['stroke_width']!='')
{$styl.="stroke-width:".$cou[0]['stroke_width'].";";}else{$styl.="stroke-width:1;";}
if($type_geo=="texte" && $rotation=="false")
{
$styl.="text-anchor:middle;";
}
$textq.="<g id=\"".$_GET['layer']."\" style=\"".$styl."\" ";
if($cou[0]['mouseover']!='')
{
$textq.="onmouseover=\"".$cou[0]['mouseover']."\" onmouseout=\"".$cou[0]['mouseout']."\" ";
}
if($cou[0]['click']!='')
{
$textq.="onclick=\"".$cou[0]['click']."\" ";
}
if($cou[0]['pointer_events']=='visible')
{$textq.="pointer-events=\"visible\" ";}else{$textq.="pointer-events=\"none\" ";}
if($cou[0]['font_familly']!='')
{$textq.="font-familly=\"".$cou[0]['font_familly']."\"";}
$textq.=">\n";
if($cou[0]['mouseover']!=''||$cou[0]['click']!='')
{
	if($type_geo=="symbole")
				{
				for ($e=0;$e<count($res);$e++)
					{
					$textq.="<a id='li".$res[$e]['ident']."'><text ".$res[$e]['geom']." id='".$res[$e]['ident']."' font-family='fontsvg' ";
					if($res[$e]['ad']!="")
					{
					$textq.="n='".$res[$e]['ad']."' ";
					}
					if($res[$e]['relation']!="")
					{
					$textq.="rel='".$res[$e]['relation']."' ";
					}
					$textq.=">".$cou[0]['symbole']."</text></a>\n";
										
					}
				}
	elseif($type_geo=="texte")
				{
				for ($e=0;$e<count($res);$e++)
					{
					if($rotation=="true")
					{
					$posi=explode(" ",$res[$e]['geom']);
				$textq.="<a id='li".$res[$e]['ident']."'><text ".$res[$e]['geom']." transform='rotate(-".$res[$e]['rotation'].",".substr($posi[0],3,-1).",".substr($posi[1],3,-1).")' id='".$res[$e]['ident']."' ";
				if($res[$e]['ad']!="")
					{
					$textq.="n='".$res[$e]['ad']."' ";
					}
					if($res[$e]['relation']!="")
					{
					$textq.="rel='".$res[$e]['relation']."' ";
					}
				$textq.=">".$res[$e]['ad']."</text></a>\n";
					}
					else
					{
					$textq.="<a id='li".$res[$e]['ident']."'><text ".$res[$e]['geom']." id='".$res[$e]['ident']."' ";
					if($res[$e]['ad']!="")
					{
					$textq.="n='".$res[$e]['ad']."' ";
					}
					if($res[$e]['relation']!="")
					{
					$textq.="rel='".$res[$e]['relation']."' ";
					}
					$textq.=">".$res[$e]['ad']."</text></a>\n";
					}
					}
				}
	else
				{
				for ($e=0;$e<count($res);$e++)
					{
					if($res[$e]['ident']==$_GET['placid'])
					{
					$textq.="<a id='li".$res[$e]['ident']."'><path id='".$res[$e]['ident']."' ";
					if($res[$e]['ad']!="")
					{
					$textq.="n='".$res[$e]['ad']."' ";
					}
					if($res[$e]['relation']!="")
					{
					$textq.="rel='".$res[$e]['relation']."' ";
					}
					$textq.="fill-opacity='0.7' fill='rgb(150,254,150)' d='".$res[$e]['geom']."'/></a>\n";
					}
					else
					{
					$textq.="<a id='li".$res[$e]['ident']."'><path id='".$res[$e]['ident']."' ";
					if($res[$e]['ad']!="")
					{
					$textq.="n='".$res[$e]['ad']."' ";
					}
					if($res[$e]['relation']!="")
					{
					$textq.="rel='".$res[$e]['relation']."' ";
					}
					$textq.="d='".$res[$e]['geom']."'/></a>\n";
					}
					}
				}

}	
else
{	
	if($type_geo=="symbole")
				{
				for ($e=0;$e<count($res);$e++)
					{
					$textq.="<text ".$res[$e]['geom']." id='".$res[$e]['ident']."' font-family='fontsvg' ";
					$textq.=">".$cou[0]['symbole']."</text>\n";
					}
				}
	elseif($type_geo=="texte")
				{
				for ($e=0;$e<count($res);$e++)
					{
					if($rotation=="true")
					{
					$posi=explode(" ",$res[$e]['geom']);
				$textq.="<text ".$res[$e]['geom']." transform='rotate(-".$res[$e]['rotation'].",".substr($posi[0],3,-1).",".substr($posi[1],3,-1).")'>".$res[$e]['ad']."</text>\n";
					}
					else
					{
					$textq.="<text ".$res[$e]['geom']." id='".$res[$e]['ident']."'>".$res[$e]['ad']."</text>\n";
					}
					}
				}
	else
				{
				for ($e=0;$e<count($res);$e++)
					{
					if($res[$e]['ident']==$_GET['placid'] && $res[$e]['ident']!='')
					{
					$textq.="<path id='".$res[$e]['ident']."' fill='rgb(150,254,150)' fill-opacity='0.7' d='".$res[$e]['geom']."'/>\n";
					}
					else if($res[$e]['ident']!='')
					{
					$textq.="<path id='".$res[$e]['ident']."' d='".$res[$e]['geom']."'/>\n";
					}
					else
					{
					$textq.="<path d='".$res[$e]['geom']."'/>\n";
					}
					}
				}
}
	$textq.="</g>";
}
//$data=gzcompress("$textq",9);
//echo $data;
echo $textq;
?>
