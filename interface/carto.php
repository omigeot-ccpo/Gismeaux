<?php
define('GIS_ROOT', '..');
include_once(GIS_ROOT . '/inc/common.php');
gis_session_start();
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past 
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // always modified 
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0"); // HTTP/1.1 
header("Cache-Control: post-check=0, pre-check=0", false); 
header("Pragma: no-cache");
function color_rgb($color,$a)
{
$tab_color=explode(",", $color);

if($a)
{
$col_r=((1 - $a) * 255) + ($a * $tab_color[0]);
$col_g=((1 - $a) * 255) + ($a * $tab_color[1]);
$col_b=((1 - $a) * 255) + ($a * $tab_color[2]);
}
else
{
$col_r=$tab_color[0];
$col_g=$tab_color[1];
$col_b=$tab_color[2];
}
if($tab_color[0]==0 && $tab_color[1]==0 && $tab_color[2]==0 & $a==0)
{
$col_r=0;
$col_g=0;
$col_b=0;
}
$text=round($col_r).','.round($col_g).','.round($col_b);
return $text;
}

if (file_exists("./doc_commune/".$_SESSION["profil"]->insee."/skins/fond.png"))
{
$ref_rep=$_SESSION["profil"]->insee;
}
else
{
$ref_rep="default";
}
$protocol='https';
if($_SERVER['SERVER_PORT']!=443)
{
$protocol='http';
}
if ($_SESSION['profil']->protocol != "")
	$protocol = $_SESSION['profil']->protocol;
	 
if (eregi('MSIE', $_SERVER['HTTP_USER_AGENT']))
{    
$nav="0";// Internet Explorer 
}
elseif (eregi('Opera', $_SERVER['HTTP_USER_AGENT']))
{ 
$nav="1";//opéra
}
elseif (eregi('Firefox', $_SERVER['HTTP_USER_AGENT']))
{
$nav="2";//firefox
if(strpos($_SERVER['HTTP_USER_AGENT']," ",strpos($_SERVER['HTTP_USER_AGENT'],"Firefox/")+8))
{$vers=substr($_SERVER['HTTP_USER_AGENT'],strpos($_SERVER['HTTP_USER_AGENT'],"Firefox/")+8,strpos($_SERVER['HTTP_USER_AGENT']," ",strpos($_SERVER['HTTP_USER_AGENT'],"Firefox/")+8)-(strpos($_SERVER['HTTP_USER_AGENT'],"Firefox/")+8));}
else{$vers=substr($_SERVER['HTTP_USER_AGENT'],strpos($_SERVER['HTTP_USER_AGENT'],"Firefox/")+8);}

}
else
{
$nav="3";//autre
}
$os = "";
if (ereg("Linux", getenv("HTTP_USER_AGENT"))) 
  $os = "Linux"; 
$sessi=session_id();
if($_SESSION['profil']->idutilisateur)
{

$contenu_legende_query="select apputi.idapplication,utilisateur.nom,utilisateur.prenom,apputi.droit,application.type_appli,application.url,application.libelle_appli from admin_svg.apputi inner join admin_svg.application on admin_svg.apputi.idapplication=admin_svg.application.idapplication join admin_svg.utilisateur on admin_svg.apputi.idutilisateur=admin_svg.utilisateur.idutilisateur where apputi.idutilisateur='".$_SESSION['profil']->idutilisateur."' order by application.type_appli asc" ;
// ChoixAppli CCPO
$contenu_legende_query="select apputi.idapplication,utilisateur.nom,utilisateur.prenom,apputi.droit,application.type_appli,application.url,application.libelle_appli,apputi.ordre from admin_svg.apputi inner join admin_svg.application on admin_svg.apputi.idapplication=admin_svg.application.idapplication join admin_svg.utilisateur on admin_svg.apputi.idutilisateur=admin_svg.utilisateur.idutilisateur where apputi.idutilisateur='".$_SESSION['profil']->idutilisateur."' order by application.type_appli asc,apputi.ordre" ;



$mn=$DB->tab_result($contenu_legende_query);
/*script pour l'appli droit de cité qui peut être supprimé si on ne desire pas s'interfacer avec cette appli*/
$appia="false";
$office="false";
for ($c=0;$c<count($mn);$c++)
{
if($mn[$c]['libelle_appli']=="ADS")
{
$appia="true";
}
if($mn[$c]['libelle_appli']=="back_office")
{
$office="true";
}
/*fin script interfacage droit de cité*/
}
if($_SESSION["profil"]->appli=="")
{
$_SESSION["profil"]->appli=$mn[0]['idapplication'];
$_SESSION["profil"]->droit_appli=$mn[0]['droit'];
}
else
{
$sql_droit="select apputi.droit from admin_svg.apputi where apputi.idutilisateur='".$_SESSION["profil"]->idutilisateur."' and apputi.idapplication='".$_SESSION["profil"]->appli."'";
$mn_droit=$DB->tab_result($sql_droit);
$_SESSION["profil"]->droit_appli=$mn_droit[0]['droit'];
}
}
$sql_pref="select * from admin_svg.preference where utilisateur=".$_SESSION['profil']->idutilisateur;
$pref=$DB->tab_result($sql_pref);

$reqcom="select (Xmax(Transform(commune.the_geom,$projection))::real - Xmin(Transform(commune.the_geom,$projection))::real) as largeur,Xmin(Transform(commune.the_geom,$projection)) as xini, (Ymax(Transform(commune.the_geom,$projection))::real - Ymin(Transform(commune.the_geom,$projection))::real) as hauteur ,Ymax(Transform(commune.the_geom,$projection)) as yini, (Xmin(Transform(commune.the_geom,$projection))::real + (Xmax(Transform(commune.the_geom,$projection))::real - Xmin(Transform(commune.the_geom,$projection))::real)/2) as xcenter,(Ymin(Transform(commune.the_geom,$projection))::real + (Ymax(Transform(commune.the_geom,$projection))::real - Ymin(Transform(commune.the_geom,$projection))::real)/2) as ycentre,logo,idagglo,assvg(Translate(Transform(commune.the_geom,$projection),-Xmin(Transform(commune.the_geom,$projection)),-Ymax(Transform(commune.the_geom,$projection)),0),1,6) as geom from admin_svg.commune where commune.idcommune like '".$_SESSION["profil"]->insee."'";
		$vu=$DB->tab_result($reqcom);
$query_agglo="SELECT * FROM admin_svg.commune where idcommune like '".$vu[0]['idagglo']."'";
$row_agglo = $DB->tab_result($query_agglo);	
$taillecom = GetImageSize(substr($vu[0]['logo'],3));
$tailleaglo = GetImageSize(substr($row_agglo[0]['logo'],3));
		$_SESSION['large'] =$vu[0]['largeur'];
		$_SESSION['haute'] =$vu[0]['hauteur'];
		$_SESSION['xini'] =$vu[0]['xini'];
		$_SESSION['yini'] =$vu[0]['yini'];
		$_SESSION['xcenter'] =$vu[0]['xcenter'];
		$_SESSION['ycenter'] =$vu[0]['ycentre'];
		$_SESSION['geom_comm'] =$vu[0]['geom'];
		$_SESSION['image'] ="";
		$_SESSION['cotation'] ="";
		
$legende="";
$controle="";
$chaine="";
$symbol="";
$textsymbol="";
$extraction="chargeinit('";
$req="select appthe.zoommax,appthe.zoommin,appthe.idtheme from admin_svg.appthe join admin_svg.theme on appthe.idtheme=theme.idtheme where theme.groupe in(select theme.groupe from admin_svg.theme group by theme.groupe having count(theme.groupe)>1) and appthe.idapplication='".$_SESSION["profil"]->appli."' and theme.groupe<>'' order by appthe.idtheme asc";
$grou=$DB->tab_result($req);
$zoom_groupe_max=0;
$zoom_groupe_min=10000;
$id_groupe="";
if(count($grou)>1)
{
for ($c=0;$c<count($grou);$c++)
{
if($grou[$c]['zoommax']>$zoom_groupe_max)
{
$zoom_groupe_max=$grou[$c]['zoommax'];
}
if($zoom_groupe_min>$grou[$c]['zoommin'])
{
$zoom_groupe_min=$grou[$c]['zoommin'];
}
if($c==0)
{
$id_selec_groupe=$grou[$c]['idtheme'];
}
if($c>0)
{
$id_groupe.="'".$grou[$c]['idtheme']."',";
}
}

$id_groupe=substr($id_groupe,0,strlen($id_groupe)-1);
}
$req2="select theme.idtheme,theme.libelle_them as nom_theme,theme.schema,theme.tabl,appthe.idappthe,col_theme.colonn,admin_svg.v_fixe(col_theme.valeur_texte),appthe.raster,sinul(appthe.zoommin::character varying,theme.zoommin::character varying) as zoommin,sinul(appthe.zoommax::character varying,theme.zoommax::character varying) as zoommax,sinul(appthe.zoommaxraster::character varying,theme.zoommax_raster::character varying) as zoommax_raster,theme.raster as testraster,application.zoom_min as zoom_min_appli,application.zoom_max as zoom_max_appli,application.zoom_ouverture as zoom_ouverture_appli,sinul(appthe.partiel,theme.partiel) as partiel,sinul(appthe.vu_initial,theme.vu_initial) as vu_initial,style.idstyle,style.fill as style_fill,style.symbole as style_symbole,style.opacity  as style_opacity,style.font_size  as style_fontsize,style.stroke_rgb  as style_stroke,style.stroke_width  as style_strokewidth,application.btn_polygo,application.libelle_btn_polygo,theme.groupe,application.libelle_appli,appthe.force_chargement,appthe.mouseover,appthe.click,appthe.mouseout,appthe.objprincipal from admin_svg.appthe join admin_svg.theme on appthe.idtheme=theme.idtheme join admin_svg.application on appthe.idapplication=application.idapplication left outer join  admin_svg.col_theme on appthe.idappthe=col_theme.idappthe left outer join admin_svg.style on appthe.idtheme=style.idtheme where appthe.idapplication='".$_SESSION["profil"]->appli."'";
if($id_groupe!="")
{
$req2.=" and appthe.idtheme not in(".$id_groupe.")";
}
$req2.=" group by appthe.objprincipal,appthe.mouseover,appthe.click,appthe.mouseout,theme.idtheme,theme.libelle_them,appthe.ordre,theme.schema,theme.tabl,col_theme.colonn,admin_svg.v_fixe(col_theme.valeur_texte),appthe.raster,theme.zoommin,appthe.zoommin,theme.zoommax,appthe.zoommax,theme.zoommax_raster,appthe.zoommaxraster,theme.raster,application.zoom_min,application.zoom_max,application.zoom_ouverture,appthe.partiel,theme.partiel,appthe.vu_initial,theme.vu_initial,style.idstyle,style.fill,style.symbole,style.opacity,style.font_size,style.stroke_rgb,style.stroke_width,appthe.idappthe,application.btn_polygo,application.libelle_btn_polygo,theme.groupe,application.libelle_appli,appthe.force_chargement order by appthe.ordre asc";
$cou=$DB->tab_result($req2);
if($cou[0]['zoom_min_appli']=="")
{
$sqql="select zoom_min as zoom_min_appli,application.zoom_max as zoom_max_appli,application.zoom_ouverture as zoom_ouverture_appli from admin_svg.application where idapplication='".$_SESSION["profil"]->appli."'";
$cou1=$DB->tab_result($sqql);
$zoommin=$cou1[0]['zoom_min_appli'];
$zoommax=$cou1[0]['zoom_max_appli'];
}
else
{
$zoommin=$cou[0]['zoom_min_appli'];
$zoommax=$cou[0]['zoom_max_appli'];
}
$min=$zoommin;
$intervale=round(($zoommax-$zoommin)/18);
$zoommax=$zoommin+(18*$intervale);
if($_SESSION['zoommm'])
	{
	if($_SESSION['zoommm']>=$cou[0]['zoom_min_appli'])
	{ 
	$zo=$_SESSION['zoommm'];
	}
	else
	{
	$zo=$cou[0]['zoom_min_appli'];
	}
	if($_SESSION['zoommm']>=$cou[0]['zoom_max_appli'])
	{ 
	$zo=$cou[0]['zoom_min_appli'];
	}
	$xc=$_SESSION['cx'];
	$yc=$_SESSION['cy'];
	}
else
{
$zo=$cou[0]['zoom_ouverture_appli'];
	$xc=0;
	$yc=0;
}
if($zo!=$cou[0]['zoom_min_appli'])
{
$debut=$zoommin;
$debut1=$debut+$intervale;
		for ($i=0;$i<17;$i++)
		{
			if ($zo < $debut1 && $zo >= $debut) 
			{
			$zoomouv=$debut1;
			}
			$debut=$debut+$intervale;
			$debut1=$debut1+$intervale;
		}
}
else
{
$zoomouv=$zoommin;
}

$req_zoom_appli_com="select zoom_max,zoom_min,zoom_ouv,Y(Transform(the_geom,$projection)) as y,X(Transform(the_geom,$projection)) as x from admin_svg.zoom_appli_commune where code_insee='".$_SESSION["profil"]->insee."' and idappli=".$_SESSION["profil"]->appli;
$zoom_appli_com=$DB->tab_result($req_zoom_appli_com);
if($zoom_appli_com[0]['zoom_min'])
{
/*echo $zoom_appli_com[0]['x']-$_SESSION['xini']."|";
echo $_SESSION['yini']-$zoom_appli_com[0]['y']."|";
echo $xc."|";
echo $yc."|";*/
$zoommin=$zoom_appli_com[0]['zoom_min'];
$zoommax=$zoom_appli_com[0]['zoom_max'];
$zoomouv=$zoom_appli_com[0]['zoom_ouv'];
$xc=$zoom_appli_com[0]['x']-$_SESSION['xini'];
$yc=$_SESSION['yini']-$zoom_appli_com[0]['y'];
}


$tab_layer="var zlayer=new Array;";
$layer="var layer=new Array;";
$lay="var controllay=new Array;";
$j=0;
$t=0;
for ($c=0;$c<count($cou);$c++)
{
$req1="select distinct (col_theme.intitule_legende) as intitule_legende,col_theme.fill,col_theme.stroke_rgb,col_theme.symbole,col_theme.font_size,col_theme.font_familly,col_theme.opacity,col_theme.ordre,col_theme.stroke_width,col_theme.font_weight from admin_svg.appthe join admin_svg.col_theme on appthe.idappthe=col_theme.idappthe join admin_svg.theme on appthe.idtheme=theme.idtheme";
	if($cou[$c]['v_fixe']=='1' and $cou[$c]['colonn']<>'')
	{
	$req1.=" join ".$cou[$c]['schema'].".".$cou[$c]['tabl']." on col_theme.valeur_texte=".$cou[$c]['tabl'].".".$cou[$c]['colonn']." where 					appthe.idapplication='".$_SESSION["profil"]->appli."' and theme.libelle_them='".$cou[$c]['nom_theme']."'";
	if($cou[$c]['schema']!="bd_topo")
	{
		if(substr($_SESSION["profil"]->insee, -3)!='000' )
				{$req1.=" and (".$cou[$c]['tabl'].".code_insee like '".$_SESSION["profil"]->insee."'  or code_insee is null) ";}
		else{$req1.=" and (".$cou[$c]['tabl'].".code_insee like '".substr($_SESSION["profil"]->insee,0,3)."%'  or code_insee is null) ";}
	 }
	 $req1.=" order by col_theme.ordre asc";
	}
	else
	{
	$req1.=" where appthe.idapplication='".$_SESSION["profil"]->appli."' and theme.libelle_them='".$cou[$c]['nom_theme']."' order by col_theme.ordre asc";
	}
	$couch=$DB->tab_result($req1);
	$z=$c+1;
	$chaine.="<g id='control".$z."' visibility='hidden'>\n";
	$cous="";
	$leg="";
	
	$typ='';
	
	if(count($couch)>0)
		{
			for ($r=0;$r<count($couch);$r++)
			{
			$cous.=$z.codalpha($r+1).";";
			$leg.=$cou[$c]['idappthe'].".".$couch[$r]['intitule_legende']."|";
				if($cou[$c]['testraster']=='')
				{
				$typ='';
					if($cou[$c]['raster']=='f')
					{
					$zz=$cou[$c]['zoommin'];
					}
					else
					{
					$zz=$cou[$c]['zoommax_raster'];
					}
				$tab_layer.="zlayer['".$cou[$c]['idappthe'].".".$couch[$r]['intitule_legende']."']=new glayer('".$z.codalpha($r+1)."','FALSE','','',".$zz.",'".$cou[$c]['partiel']."','".$cou[$c]['force_chargement']."');";
				$layer.="layer[$j]='".$cou[$c]['idappthe'].".".$couch[$r]['intitule_legende']."';";
				$j=$j+1;
				}
				else
				{
				$typ='raster';
				}
			}
		$cous = substr($cous,0,strlen($cous)-1);
		$leg = substr($leg,0,strlen($leg)-1);
	}
	else
	{
	if($cou[$c]['idtheme']==$id_selec_groupe)
	{
	$leg=$cou[$c]['idappthe'].".".$cou[$c]['groupe'];
	}
	else
	{
	$leg=$cou[$c]['idappthe'].".".$cou[$c]['nom_theme'];
	}
	
		if($cou[$c]['testraster']=='')
		{
		$typ='';
				if($cou[$c]['zoommax']<$cou[$c]['zoommax_raster'])
					{
					$typ='raster';
					}
				if($cou[$c]['raster']=='f')
					{
					$zz=$cou[$c]['zoommin'];
					}
					else
					{
					$zz=$cou[$c]['zoommax_raster'];
					}
		
		}
		else
		{
		$typ='raster';
		$zz=$cou[$c]['zoommax_raster'];
		}
		$tab_layer.="zlayer['".$cou[$c]['idappthe'].".".$cou[$c]['nom_theme']."']=new glayer('".$z."','FALSE','','',".$zz.",'".$cou[$c]['partiel']."','".$cou[$c]['force_chargement']."');";
		$layer.="layer[$j]='".$cou[$c]['idappthe'].".".$cou[$c]['nom_theme']."';";
		$j=$j+1;
	$cous=$z;
	
	}
	if($cou[$c]['vu_initial']==1)
	{
	$extraction.=$leg.",".$cous.", ,".$typ."#";
	}

if(count($couch)>0)
{
$legende.="<tr id=\"leg".$z."\" so=\"".count($couch)."\"><td width=\"5px\"><img id=\"imleg".$z."\" d='1' src=\"./interface/expandbtn2.gif\" onclick=\"derou('leg".$z."',".count($couch).")\"/></td><td width=\"15px\"><input id=\"coche".$z."\" type=\"checkbox\" value=\"".$leg."\" onclick=\"svgWin.extracthtml('".$leg."','".$cous."','','".$typ."')\"/></td>";
}
else
{
$legende.="<tr id=\"leg".$z."\" ><td width=\"5px\"></td><td width=\"15px\"><input id=\"coche".$z."\" ind=\"".$t."\" type=\"checkbox\" value=\"".$leg."\" onclick=\"svgWin.extracthtml('".$leg."','".$cous."','','".$typ."')\"/></td>";
$t=$t+1;
}

$col="0";
if(count($couch)<1 && ($cou[$c]['style_fill']!="" || $cou[$c]['style_stroke']!=""))
{
		$col="1";
		if($cou[$c]['style_symbole']!="" || $couch[$w]['symbole']!="")
			{
				if(ereg("[^befghijnYZo]",$couch[$w]['symbole']) || ereg("[^abefghijlmnYZo]",$cou[$c]['style_symbole']))
					{
					$texte=fopen("./interface/police.svg","r");
					$contents = fread($texte, filesize ("./interface/police.svg"));
					$data=explode("<",$contents);
						for ($i=1;$i<count($data);$i++)
								{
								if(ereg('unicode="'.$cou[$c]['style_symbole'].'"',$data[$i]))
									{ 
									$symbol.="<symbol id=\"".$cou[$c]['style_symbole']."\" viewBox=\"0 0 2048 1700\" preserveAspectRatio=\"xMidYMid meet\">";
									$symbol.="<path d=\"".substr($data[$i], strpos($data[$i],'d="')+3,strripos($data[$i],'z"')-strpos($data[$i],'d="'))." />\n";
									$symbol.="</symbol>";
									}
								}
					fclose($texte);
					
					}
					if($office=='true')
					{
					$legende.="<td width=\"15px\" id=\"td".$z."\"  ><font id=\"font".$z."\" onclick=\"affiche_symbole('".$cou[$c]['style_fill']."','".$cou[$c]['style_opacity']."','style','".$cou[$c]['style_fontsize']."','".$cou[$c]['style_symbole']."','".$cou[$c]['idstyle']."','".$z."','".$cou[$c]['idtheme']."')\" style=\"color:rgb(".$cou[$c]['style_fill'].");font-family:svg\">".$cou[$c]['style_symbole']."</font></td>";
					}
					else
					{
					$legende.="<td width=\"15px\" ><font style=\"color:rgb(".$cou[$c]['style_fill'].");font-family:svg\">".$cou[$c]['style_symbole']."</font></td>";
					}
			}
		elseif($cou[$c]['style_fontsize']=="")
		{
			$opa=1;
			if($cou[$c]['style_opacity'])
			{
			$opa=$cou[$c]['style_opacity'];
			}
			if($cou[$c]['style_stroke']!="" && ($cou[$c]['style_fill']==""||$cou[$c]['style_fill']=="none"))
			{
				if($office=='true')
				{
				$legende.="<td width=\"15px\" id=\"td".$z."\"><font id=\"font".$z."\" onclick=\"affiche_gestion('".$cou[$c]['style_fill']."','".$cou[$c]['style_opacity']."','".$cou[$c]['style_stroke']."','".$cou[$c]['style_strokewidth']."','style','".$cou[$c]['idstyle']."','".$z."','".$cou[$c]['idtheme']."')\" style=\"color:rgb(".color_rgb($cou[$c]['style_stroke'],$opa).");font-family:svg\">q</font></td>";
				}
				else
				{
				$legende.="<td width=\"15px\" ><font style=\"color:rgb(".color_rgb($cou[$c]['style_stroke'],$opa).");font-family:svg\">q</font></td>";
				}
			}
			else
			{
				if($office=='true')
				{
	$legende.="<td width=\"15px\" id=\"td".$z."\"  ><font id=\"font".$z."\" onclick=\"affiche_gestion('".$cou[$c]['style_fill']."','".$cou[$c]['style_opacity']."','".$cou[$c]['style_stroke']."','".$cou[$c]['style_strokewidth']."','style','".$cou[$c]['idstyle']."','".$z."','".$cou[$c]['idtheme']."')\" style=\"color:rgb(".color_rgb($cou[$c]['style_fill'],$opa).");font-family:svg\">q</font></td>";
				}
				else
				{
				$legende.="<td width=\"15px\")\"><font  style=\"color:rgb(".color_rgb($cou[$c]['style_fill'],$opa).");font-family:svg\">q</font></td>";
				}
			}
		
		}
		else
		{
		if($office=='true')
		{
		$opa=1;
			if($cou[$c]['style_opacity'])
			{
			$opa=$cou[$c]['style_opacity'];
			}
		$legende.="<td width=\"15px\" id=\"td".$z."\"  ><font id=\"font".$z."\" onclick=\"affiche_symbole('".$cou[$c]['style_fill']."','".$cou[$c]['style_opacity']."','style','".$cou[$c]['style_fontsize']."','Abc','".$cou[$c]['idstyle']."','".$z."','".$cou[$c]['idtheme']."')\" style=\"color:rgb(".color_rgb($cou[$c]['style_fill'],$opa).");font-family:svg\">q</font></td>";
		}
		else
		{
		$legende.="<td width=\"15px\" ></td>";
		}
		}
	
}

if($col==0)
	{
	$legende.="<td></td>";
	}
if($cou[$c]['idtheme']==$id_selec_groupe)
	{
	if($office=='true')
		{
	$legende.="<td width=\"115\" align=\"left\" onmouseover=\"this.style.color='#ff0000'\" onmouseout=\"this.style.color=''\" onclick=\"proprie_couche('".$cou[$c]['idtheme']."','".$cou[$c]['idappthe']."','".$cou[$c]['partiel']."','".$cou[$c]['force_chargement']."','".$cou[$c]['zoommax']."','".$cou[$c]['zoommin']."','".$cou[$c]['zoommax_raster']."','".$cou[$c]['vu_initial']."','".str_replace("'","|",$cou[$c]['mouseover'])."','".str_replace("'","|",$cou[$c]['click'])."','".$cou[$c]['mouseout']."','".$cou[$c]['raster']."','".$cou[$c]['objprincipal']."','".$cou[$c]['schema']."','".$cou[$c]['tabl']."')\">".$cou[$c]['groupe']."</td></tr>\n";
		}
		else
		{
		$legende.="<td width=\"115\" align=\"left\" >".$cou[$c]['groupe']."</td></tr>\n";
		}
	$lay.="controllay[".$c."]=new ylayer(".$zoom_groupe_min.",".$zoom_groupe_max.",'".$typ."');";
	}
	else
	{
		if($cou[$c]['groupe']!="")
		{
			if($office=='true')
			{
			$legende.="<td width=\"115\" align=\"left\" onmouseover=\"this.style.color='#ff0000'\" onmouseout=\"this.style.color=''\" onclick=\"proprie_couche('".$cou[$c]['idtheme']."','".$cou[$c]['idappthe']."','".$cou[$c]['partiel']."','".$cou[$c]['force_chargement']."','".$cou[$c]['zoommax']."','".$cou[$c]['zoommin']."','".$cou[$c]['zoommax_raster']."','".$cou[$c]['vu_initial']."','".str_replace("'","|",$cou[$c]['mouseover'])."','".str_replace("'","|",$cou[$c]['click'])."','".$cou[$c]['mouseout']."','".$cou[$c]['raster']."','".$cou[$c]['objprincipal']."','".$cou[$c]['schema']."','".$cou[$c]['tabl']."')\">".$cou[$c]['groupe']."</td></tr>\n";
			}
			else
			{
			$legende.="<td width=\"115\" align=\"left\" >".$cou[$c]['groupe']."</td></tr>\n";
			}
		}
		else
		{
			if($office=='true')
				{
				$legende.="<td width=\"115\" align=\"left\" onmouseover=\"this.style.color='#ff0000'\" onmouseout=\"this.style.color=''\" onclick=\"proprie_couche('".$cou[$c]['idtheme']."','".$cou[$c]['idappthe']."','".$cou[$c]['partiel']."','".$cou[$c]['force_chargement']."','".$cou[$c]['zoommax']."','".$cou[$c]['zoommin']."','".$cou[$c]['zoommax_raster']."','".$cou[$c]['vu_initial']."','".str_replace("'","|",$cou[$c]['mouseover'])."','".str_replace("'","|",$cou[$c]['click'])."','".$cou[$c]['mouseout']."','".$cou[$c]['raster']."','".$cou[$c]['objprincipal']."','".$cou[$c]['schema']."','".$cou[$c]['tabl']."')\">".$cou[$c]['nom_theme']."</td></tr>\n";
				}
				else
				{
				$legende.="<td width=\"115\" align=\"left\" >".$cou[$c]['nom_theme']."</td></tr>\n";
				}
		}
	$lay.="controllay[".$c."]=new ylayer(".$cou[$c]['zoommin'].",".$cou[$c]['zoommax'].",'".$typ."');";
	}

$col=0;
	if(count($couch)>0)
	{
		for ($w=0;$w<count($couch);$w++)
		{
			
			if($couch[$w]['symbole']!="" and ereg("[^abefghijlmnYZo]",$couch[$w]['symbole']))
			{
			$texte=fopen("./interface/police.svg","r");
			$contents = fread($texte, filesize ("./interface/police.svg"));
			$data=explode("<",$contents);
				for ($i=1;$i<count($data);$i++)
				{
					if(ereg('unicode="'.$couch[$w]['symbole'].'"',$data[$i]))
					{ 
					$symbol.="<symbol id=\"".$couch[$w]['symbole']."\" viewBox=\"0 0 2048 1700\" preserveAspectRatio=\"xMidYMid meet\">";
					$symbol.="<path d=\"".substr($data[$i], strpos($data[$i],'d="')+3,strripos($data[$i],'z"')-strpos($data[$i],'d="'))." />\n";
					$symbol.="</symbol>";
					}
				}
			fclose($texte);
			} 
			
		$chaine.="<g id='control".$z.codalpha($w+1)."' visibility='hidden'></g>\n";
		$legende.="<tr id=\"lileg".$z.codalpha($w+1)."\" style=\"visibility:hidden; position:absolute\"><td></td><td></td><td><input id=\"coche".$z.codalpha($w+1)."\" ind=\"".$t."\" type=\"checkbox\" value=\"\" onclick=\"svgWin.extracthtml('".$cou[$c]['idappthe'].".".$couch[$w]['intitule_legende']."','".$z.codalpha($w+1)."','','".$typ."')\"/></td>";
		$t=$t+1;
    	if($couch[$w]['stroke_rgb']!="" && ($couch[$w]['fill']==""||$couch[$w]['fill']=="none"))
			{
			$coucoul=$couch[$w]['stroke_rgb'];
			}
			else
			{
			$coucoul=$couch[$w]['fill'];
			}
			if($coucoul=="")
			{
			$couch[$w]['fill']="0,0,0";
			}
			$opa=1;
			if($couch[$w]['opacity'])
			{
			$opa=$couch[$w]['opacity'];
			}
			if($couch[$w]['symbole']!="")
			{
				if($office=='true')
				{
				$legende.="<td align=\"left\" id=\"td".$z.codalpha($w+1)."\" ><font id=\"font".$z.codalpha($w+1)."\" onclick=\"affiche_symbole('".$couch[$w]['fill']."','".$couch[$w]['opacity']."','col_theme','".$couch[$w]['font_size']."','".$couch[$w]['symbole']."','".$cou[$c]['idappthe'].".".$couch[$w]['intitule_legende']."','".$z.codalpha($w+1)."','".$cou[$c]['idtheme']."')\" style=\"color:rgb(".color_rgb($coucoul,$opa).");font-family:svg;\">".$couch[$w]['symbole']."</font>&nbsp;".$couch[$w]['intitule_legende']."</td></tr>\n";			
				}
				else
				{
				$legende.="<td align=\"left\" ><font style=\"color:rgb(".color_rgb($coucoul,$opa).");font-family:svg;\">".$couch[$w]['symbole']."</font>&nbsp;".$couch[$w]['intitule_legende']."</td></tr>\n";	
				}		
			}
			else
			{
				if($office=='true')
					{
					$legende.="<td align=\"left\" id=\"td".$z.codalpha($w+1)."\"  ><font id=\"font".$z.codalpha($w+1)."\" onclick=\"affiche_gestion('".$couch[$w]['fill']."','".$couch[$w]['opacity']."','".$couch[$w]['stroke_rgb']."','".$couch[$w]['stroke_width']."','col_theme','".$cou[$c]['idappthe'].".".$couch[$w]['intitule_legende']."','".$z.codalpha($w+1)."','".$cou[$c]['idtheme']."')\" style=\"color:rgb(".color_rgb($coucoul,$opa).");font-family:svg;\">q</font>&nbsp;".$couch[$w]['intitule_legende']."</td></tr>\n";
					}
					else
					{
					$legende.="<td align=\"left\" ><font style=\"color:rgb(".color_rgb($coucoul,$opa).");font-family:svg;\">q</font>&nbsp;".$couch[$w]['intitule_legende']."</td></tr>\n";
					}
			}
			
    	}
		
	
	}
	
	$chaine.="</g>\n";
	$controle=$chaine.$controle;
	$chaine="";
	
}
$tab_layer.="zlayer['000.postit']=new glayer('".(count($cou)+1)."','FALSE','','',10,'1','1');";
$layer.="layer[".$j."]='000.postit';";
$lay.="controllay[".count($cou)."]=new ylayer(10,50000,'');";
$_SESSION['controle']= "<g id='controlraster' ></g>\n".$controle."<g id='control".(count($cou)+1)."' visibility='hidden' ></g>\n";
$_SESSION['extraction']= substr($extraction,0,strlen($extraction)-1)."');"; 
$_SESSION['taillecom']=$taillecom;
$_SESSION['tailleaglo']=$tailleaglo;
$_SESSION['row_agglo']=$row_agglo;
$_SESSION['logo_com']=$vu[0]['logo'];
$_SESSION['nb_couche']=count($cou)+1;
$_SESSION['tab_layer']=$tab_layer;
$_SESSION['layer']=$layer;
$_SESSION['lay']=$lay;
$_SESSION['xc']=$xc;
$_SESSION['yc']=$yc;
$_SESSION['zoommin']=$zoommin;
$_SESSION['zoommax']=$zoommax;
$_SESSION['zoomouv']=$zoomouv;
$_SESSION['protocol']=$protocol;
$_SESSION['intervale']=$intervale;
$_SESSION['va_appli']=count($mn);
$_SESSION['url_polygo']=$cou[0]['btn_polygo'];
$_SESSION['nav']=$nav;
$_SESSION['symbol']=$symbol;
$_SESSION['ref_rep']=$ref_rep;
$top_legende="90px";
$left_legende="10px";
$vision_icone="checked=\"true\"";
$div_icone="visible";
$div_legende="visible";
$vision_legende="checked=\"true\"";
$div_office="visible";
$vision_office="checked=\"true\"";

if($pref[0]['utilisateur'])
{
$top_legende=$pref[0]['posiy'];
$left_legende=$pref[0]['posix'];
	if($pref[0]['icone']=='hidden')
	{
	$vision_icone="";
	$div_icone="hidden";
	}
	if($pref[0]['legende']=='hidden')
	{
	$vision_legende="";
	$div_legende="hidden";
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<!--<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7"/>-->
<style type="text/css" media="screen, print">
@font-face {
      font-family:'svg';
     /* src:local("svg") url("https://www.pays.meaux.fr/capm/fonts/Font1.ttf") format("truetype");*/
	 src: url("./capm/fonts/Font1.eot");
    }
@font-face {
      font-family:'svg';
     /* src:local("svg") url("https://www.pays.meaux.fr/capm/fonts/Font1.ttf") format("truetype");*/
	 src: url("./capm/fonts/Font1.ttf");
    }	
</style>

 <link rel="stylesheet" type="text/css" href="./interface/menu.css">
<script language="JavaScript" type="text/javascript">
nav=<?php echo $nav;?>;
vers=<?php echo floatval($vers);?>;
index_appli='';
//preChargement();
function relecture(x)
{
var sepa=new RegExp("[|]", "g");
var vale=x.split(sepa);
<?php if ($_SESSION['profil']->serveur == "")
$serveur=$_SERVER['HTTP_HOST'];
else
	$serveur=$_SESSION['profil']->serveur;
	?>
var url=<?php echo "\"".$_SESSION['protocol']."://".$serveur."/interface/reload.php?appli=\"";?>+vale[0]+<?php echo"\"&sessionname=" . session_name() . "&sessionid=" . session_id() . "&code_insee=" .$_SESSION["profil"]->insee."\";";?>
//
								
if(vale[1]!=1)
{
window.location.replace(url);
}
else
{
var url="https://<?php echo $serveur;?>/"+vale[2];
window.open(url);
document.getElementById( "choixappli" ).options.selectedIndex=index_appli;
}
}

</script>
<script language="javascript" src="./interface/html_script.js"></script>
<?php
if($office=="true")
{
echo "<script language=\"javascript\" src=\"./interface/backoffice_script.js\"></script>";
}
?>
<script type="text/javascript" src="../connexion/media.js"></script>
<?php 
/*ajout de page javascript pour l'appli droit de cité qui peut être supprimé si on ne desire pas s'interfacer avec cette appli*/
if($appia=="true") { ?>
<script src="../APPIA/client/AC_OETags.js" language="javascript"></script>
<script src="../APPIA/client/AppiaConnect.js" language="javascript"></script>
<script src="../APPIA/client/ACJsTest.js" language="javascript"></script>
<script src="../APPIA/client/history/history.js" language="javascript"></script>
<script language="JavaScript" type="text/javascript">
// Globals
// Major version of Flash required
var requiredMajorVersion = 9;
// Minor version of Flash required
var requiredMinorVersion = 0;
// Minor version of Flash required
var requiredRevision = 124;
</script><?php }
/*fin ajout de page javascript pour droit de cité*/
?>
<title>Cartographie</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="keywords" content="SVG, Scalable Vector Graphic, SIG, GIS, Mapserver, Postgis, Postgresql, MapInfo, géographie, géomatique, carte, cartographie, map, XML">
<meta name="description" content="Carte SVG - renseignement d'urbanisme.">
<meta name="Author" content="sig-meaux">
<meta name="Identifier-URL" content="http://www.carto.meaux.fr">
<meta name="Date-Creation-yyyymmdd" content="20070424">
<meta name="Reply-to" content="sig@meaux.fr">
<?php 
/*ajout d'un css pour l'appli droit de cité qui peut être supprimé si on ne desire pas s'interfacer avec cette appli*/
if($appia=="true") { ?>
<link rel="stylesheet" type="text/css" href="../APPIA/client/history/history.css" />
<?php }
/*fin de l'ajout css*/
?>
</head>
<body onLoad="init_svg();determinehauteur();verifVersion(vers);" onKeyUp="direction(event)" onkeyPress="quelle_touche(event)" onResize="determinehauteur();" dir="#LANG_DIR" oncontextmenu="return false" ondragstart="return false" onselectstart="return false" style="-moz-user-select:none;margin-right:none;" >
<?php if($nav==0){
echo "<div style=\"position:absolute;left:300px;top:300px;width:200px;height:200px;z-index:2;\">
<p align=\"center\">Pour utiliser la cartographie</p>
<p align=\"center\"> Vous devez installer le plugin <a href=\"https://".$_SERVER['HTTP_HOST']."/addons/SVGView303.exe\">Adobe SVGviewer</a></p>
</div>";}
/*ajout du div pour l'appli droit de cité qui peut être supprimé si on ne desire pas s'interfacer avec cette appli*/
if($appia=="true") { ?>
<div style="position:absolute;left:4000px;top:100px;width:10px;height:10px;">

<script>


var hasProductInstall = DetectFlashVer(6, 0, 65);

// Version check based upon the values defined in globals
var hasRequestedVersion = DetectFlashVer(requiredMajorVersion, requiredMinorVersion, requiredRevision);

if ( hasProductInstall && !hasRequestedVersion ) {
    // DO NOT MODIFY THE FOLLOWING FOUR LINES
    // Location visited after installation is complete if installation is required
    var MMPlayerType = (isIE == true) ? "ActiveX" : "PlugIn";
    var MMredirectURL = window.location;
    document.title = document.title.slice(0, 47) + " - Flash Player Installation";
    var MMdoctitle = document.title;

    AC_FL_RunContent(
        "src", "playerProductInstall",
        "FlashVars", "MMredirectURL="+MMredirectURL+'&MMplayerType='+MMPlayerType+'&MMdoctitle='+MMdoctitle+"",
        "width", "0",
        "height", "0",
        "align", "middle",
        "id", "AppiaConnect",
        "quality", "high",
        "bgcolor", "#869ca7",
        "name", "AppiaConnect",
        "allowScriptAccess","always",
        "type", "application/x-shockwave-flash",
        "pluginspage", "http://www.adobe.com/go/getflashplayer"
    );
} else if (hasRequestedVersion) {
    // if we've detected an acceptable version
    // embed the Flash Content SWF when all tests are passed
    AC_FL_RunContent(
            "src", "../APPIA/client/AppiaConnect",
            "width", "0",
            "height", "0",
            "align", "middle",
            "id", "AppiaConnect",
            "quality", "high",
            "bgcolor", "#869ca7",
            "name", "AppiaConnect",
            "allowScriptAccess","always",
            "type", "application/x-shockwave-flash",
            "pluginspage", "http://www.adobe.com/go/getflashplayer"
    );
  } else {  // flash is too old or we can't detect the plugin
    var alternateContent = 'Alternate HTML content should be placed here. '
    + 'This content requires the Adobe Flash Player. '
    + '<a href=http://www.adobe.com/go/getflash/>Get Flash</a>';
    document.write(alternateContent);  // insert non-flash content
  }
  </script>
  <!--<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"
			id="AppiaConnect" width="100%" height="100%"
			codebase="http://fpdownload.macromedia.com/get/flashplayer/current/swflash.cab">
			<param name="movie" value="../APPIA/client/AppiaConnect.swf" />
			<param name="quality" value="high" />
			<param name="bgcolor" value="#869ca7" />
			<param name="allowScriptAccess" value="always" />
			<embed src="AppiaConnect.swf" quality="high" bgcolor="#869ca7"
				width="100%" height="100%" name="AppiaConnect" align="middle"
				play="true"
				loop="false"
				quality="high"
				allowScriptAccess="always"
				type="application/x-shockwave-flash"
				pluginspage="http://www.adobe.com/go/getflashplayer">
			</embed>
	</object> -->
</div>
<?php }
/*fin ajout du div*/
?>



<!--début du bloc légende -->

<div id="legende" style="top:<?php echo $top_legende;?>; left:<?php echo $left_legende;?>; position:absolute; z-index:100; width: 200px;visibility:<?php echo $div_legende;?>">
<div id="titrelegende" style="font-size:18px;text-align:center"  onMouseDown="setD(1,'legende',event);" onMouseMove="drag('legende',event);" onMouseUp="setD(0,'legende',event);" onMouseOut="setD(0,'legende',event);">
L&eacute;gende</div>
<div id="contenu_legende">
<?php
if($office=="true")
{
echo "<div style=\"position:absolute;top:5px;left:158px;width:20px;height:20px;background-color: #ffffff;\" onclick=\"svgWin.affiche_div('ordre_legende');\"><img src=\"../doc_commune/".$ref_rep."/skins/ordre_legende.png\" width=\"20px\" height=\"20px\"/></div>";
}
?>
   <table id="legend">
   
 <?php
 echo $legende;
 ?>  
	
</table>
</div>
</div>
<!--fin du bloc légende -->

<!--début du bloc cartographie -->
<div id="carto" style="position:absolute;top:70px;width:100%;height:800px;z-index:5;" onKeyUp="direction(event)">
<script>
var stringEmbedsvg='<embed id="embed" AllowScriptAccess="always" wmode="transparent" src="./interface/interface.php?<?php echo session_name()."=".session_id(); ?>" width="100%" height="100%" type="image/svg+xml" />';
Writeembedsvg(stringEmbedsvg);
</script>

</div>
<!--fin du bloc cartograplie -->

<!--début du bloc entête -->
<div id="header" style="top:0px;left:0px;position:absolute;width:100%; height:60px;z-index:50;" align="center">
<!--début du bloc conteneur pour centrer l'entête -->
<div id="conteneur" style="position:relative;top:0px;width:1024px; height:60px;" align="center">
<!--début du bloc du logo gauche -->
<div id="logo_ville" style="position:absolute;top:0px;left:0px;width:120px; height:60px;vertical-align:middle;display:table;" ><span style="display:table-cell;vertical-align:middle;">
<?php 

$width = 120;
$height= 60;
$width_comm=120;
$width_aglo=120;
$height_comm=60;
$height_aglo=60;
$ratio_comm = $taillecom[0]/$taillecom[1];
$ratio_aglo = $tailleaglo[0]/$tailleaglo[1];
if ($width/$height> $ratio_comm) {
    		$width_comm = $height/$ratio_comm;
	} else {
   		$height_comm = $width/$ratio_comm;
		}
if ($width/$height>$ratio_aglo) {
    		$width_aglo = $height/$ratio_aglo;
	} else {
   		$height_aglo = $width/$ratio_aglo;
		}

 ?>

	   
<img src="<?php echo $vu[0]['logo'];?>" width="<?php echo $width_comm;?>px" height="<?php echo $height_comm;?>px"  style="vertical-align:middle;"/>
</span>
</div>
<!--fin du bloc du logo gauche -->
<!--début du bloc du logo droite -->
<div id="logo_communaute" style="position:absolute;top:0px;left:904px;width:120px; height:60px;vertical-align:middle;display:table;" ><span style="display:table-cell;vertical-align:middle;"><img src="<?php echo $row_agglo[0]['logo'];?>" width="<?php echo $width_aglo;?>px" height="<?php echo $height_aglo;?>px"  style="vertical-align:middle;"/></span></div>
<!--fin du bloc du logo droite -->

<!--début du bloc fond -->
<div style="position:absolute;top:0px;left:95px;width:844px; height:70px;vertical-align:middle;display:table;" >
<img src="../doc_commune/<?php echo $ref_rep;?>/skins/fond.png" width="844px" height="70px"/>
</div>
<!--fin du bloc fond -->

<!--début bloc icone-->
<div id="outils" style="visibility:<?php echo $div_icone;?>; z-index:60;">
<div id="boiteoutils">
<table>
<tr style="width:100%" >
<td align="center" id="fond0" onClick="svgWin.impression();" onMouseOver="mod_color_fond(0,this,'#ddd');toolTip('Imprimer',event)"  onMouseOut="mod_color_fond(0,this,'none');toolTip()"><img src="../doc_commune/<?php echo $ref_rep;?>/skins/print.png" /></td>
<?php
if($_SESSION["profil"]->droit_appli!='v')
	{echo "

<td align=\"center\" id=\"fond1\" onClick=\"svgWin.enregistre();\" onMouseOver=\"mod_color_fond(1,this,'#ddd');toolTip('Enregistrer',event)\" onMouseOut=\"mod_color_fond(1,this,'none');toolTip()\"><img src=\"../doc_commune/".$ref_rep."/skins/save.png\"/></td>";
}
?>
<td align="center" lab='Séléction unique' id="fond2" onClick="change_color_fond(2);svgWin.selectunique();toolTip(this,event)" onMouseOver="mod_color_fond(2,this,'#ddd');toolTip(this,event)" onMouseOut="mod_color_fond(2,this,'none');toolTip()" style="background:#ccc"><img id="selection" src="../doc_commune/<?php echo $ref_rep;?>/skins/simple.png"/></td>
<!--<td align="center"><img src="../doc_commune/770284/skins/test_selec_multi.png" title="Sélection multiple"/></td>-->
<?php if($_SESSION["profil"]->droit_appli!='v')
{ echo "<td align=\"center\" lab='Mesurer une distance' id=\"fond3\" onClick=\"change_color_fond(3);svgWin.activetrait();toolTip(this,event)\" onMouseOver=\"mod_color_fond(3,this,'#ddd');toolTip(this,event)\" onMouseOut=\"mod_color_fond(3,this,'none');toolTip()\"><img id=\"image_outil\" src=\"../doc_commune/".$ref_rep."/skins/mesure.png\" /></td>";

echo "<td align=\"center\" id=\"fond4\" onClick=\"svgWin.postit();\" onMouseOver=\"mod_color_fond(4,this,'#ddd');toolTip('Ajouter une note',event)\" onMouseOut=\"mod_color_fond(4,this,'none');toolTip()\" ><img src=\"../doc_commune/".$ref_rep."/skins/note.png\" /></td>";
 }

			if($cou[0]['btn_polygo']!="" && ($_SESSION["profil"]->droit_appli!='v' || $_SESSION["profil"]->droit_appli!='c'))
			{ 
 
echo "<td align=\"center\" id=\"fond5\" onClick=\"change_color_fond(5);svgWin.activpoly();\" onMouseOver=\"mod_color_fond(5,this,'#ddd');toolTip('Insérer un objet',event)\" onMouseOut=\"mod_color_fond(5,this,'none');toolTip()\"><img src=\"../doc_commune/".$ref_rep."/skins/insertion.png\"/></td>";
}

?>
<td align="center" id="fond6" onClick="svgWin.Zoomin();" onMouseOver="mod_color_fond(6,this,'#ddd');toolTip('Zoomer dans la carte',event)" onMouseOut="mod_color_fond(6,this,'none');toolTip()" ><img src="../doc_commune/<?php echo $ref_rep;?>/skins/search.png"/></td>
<td align="center" id="fond7" onClick="svgWin.contacte();" onMouseOver="mod_color_fond(7,this,'#ddd');toolTip('Nous écrire',event)" onMouseOut="mod_color_fond(7,this,'none');toolTip()"><img src="../doc_commune/<?php echo $ref_rep;?>/skins/mail.png"/></td>
</tr ></table>
</div>

</div>

<!--fin du bloc icone-->
<?php
if($office=="true")
{
//<!-- debut du bloc du menu back office -->
echo "<div id=\"outils_office\" style=\"visibility:visible;z-index:60;\">
<div id=\"boiteoutils_office\">
<table>
<tr style=\"width:100%\" >
<td align=\"center\" id=\"fond10\" onClick=\"svgWin.affiche_div('ajou_theme');\" onMouseOver=\"mod_color_fond(10,this,'#ddd');toolTip('Ajouter un th&egrave;me &agrave; l&acute;application',event)\"  onMouseOut=\"mod_color_fond(10,this,'none');toolTip()\"><img src=\"../doc_commune/".$ref_rep."/skins/ajou_theme.png\" /></td>
<td align=\"center\" id=\"fond11\" onClick=\"svgWin.affiche_div('crea_theme');\" onMouseOver=\"mod_color_fond(11,this,'#ddd');toolTip('Cr&eacute;er un nouveau th&egrave;me ',event)\"  onMouseOut=\"mod_color_fond(11,this,'none');toolTip()\"><img src=\"../doc_commune/".$ref_rep."/skins/creer_theme.png\" /></td>

<td align=\"center\" id=\"fond13\" onClick=\"svgWin.affiche_div('crea_appli');\" onMouseOver=\"mod_color_fond(13,this,'#ddd');toolTip('Cr&eacute;er une nouvelle application',event)\"  onMouseOut=\"mod_color_fond(13,this,'none');toolTip()\"><img src=\"../doc_commune/".$ref_rep."/skins/new_appli.png\" /></td>
<td align=\"center\" id=\"fond14\" onClick=\"svgWin.affiche_div('mod_appli');\" onMouseOver=\"mod_color_fond(14,this,'#ddd');toolTip('Configurer ou supprimer une application',event)\"  onMouseOut=\"mod_color_fond(14,this,'none');toolTip()\"><img src=\"../doc_commune/".$ref_rep."/skins/conf_appli.png\" /></td>
<td align=\"center\" id=\"fond15\" onMouseOver=\"mod_color_fond(15,this,'#ddd');toolTip('Administration ',event)\"  onMouseOut=\"mod_color_fond(15,this,'none');toolTip()\"><a href=\"../apps/administration/utilisateur.php\" target=\"_blank\"><img style=\"border-width: 0px;\" src=\"../doc_commune/".$ref_rep."/skins/utilisateur.png\" /></a></td>
</tr></table></div></div>";

//<!-- debut du bloc du menu back office -->
}
?>

<!--début du bloc menu -->
<div class="nav-container-outer" style="z-index:300;text-align:left;position:absolute; left:135px; width:280px; height:20px;top:4px;">
     <ul class="nav-container" id="nav-container" name="nav-container" >
     
      <li ><a class="item-primary" href="#">Fichier</a>
   
         <ul style="width:150px;">
         <li onClick="svgWin.impression();"><a href="#">Imprimer</a></li>
		 <?php		
	if($_SESSION["profil"]->droit_appli!='v')
	{echo "<li onClick=\"svgWin.enregistre();\">

		<a href=\"#\">Enregistrer</a>	</li>
		
         
         <li onClick=\"svgWin.enregPref();\"><a href=\"#\">Enregistrer mes pr&eacute;f&eacute;rences</a></li>";}
       ?>
         </ul></li>
   
      <li><span class="divider divider-vert" ></span></li>
      <li><a class="item-primary" href="#">Outils</a>
   
         <ul style="width:150px;">
		 <li><span class="item-secondary-title" >S&eacute;lection</span></li>
         <li onClick="change_color_fond(2);svgWin.menu_select(1);"><a href="#">Simple</a></li>
         <li onClick="change_color_fond(2);svgWin.menu_select(0);"><a href="#">Multiple</a></li>
		 
		<?php
	if($_SESSION["profil"]->droit_appli!='v')
	{
	echo "<li><span class=\"divider divider-horiz\" ></span></li>
         <li><span class=\"item-secondary-title\" >Mesure</span></li>
         <li onClick=\"svgWin.menu_outil(0);\"><a href=\"#\">Distance</a></li>
         <li onClick=\"svgWin.menu_outil(1);\"><a href=\"#\">Cotaion</a></li>
         <li onClick=\"svgWin.menu_outil(2);\"><a href=\"#\">Surface</a></li>";
		}
	?> 
		 
		 <li><span class="divider divider-horiz" ></span></li>
         <li><span class="item-secondary-title" >Zoom</span></li>
         <li><a href="#">Zoommer dans la carte</a></li>
		 
	<?php 
   /*ajout du lien pour l'appli droit de cité qui peut être supprimé si on ne desire pas s'interfacer avec cette appli*/
   if($appia=="true") {  
	echo " <li><span class=\"divider divider-horiz\" ></span></li>
         <li><span class=\"item-secondary-title\" >Interfa&ccedil;age</span></li>
         <li onClick=\"svgWin.parcelle_dossier();\"><a href=\"#;\">Parcelle->Droit de cit&eacute;</a></li>";}
	/*fin ajout lien*/	
		?>	 
		
         
         </ul></li>
   
      <li><span class="divider divider-vert" ></span></li>
      <li><a class="item-primary" href="#">Affichage</a>
   
         <ul style="width:150px;">
         <li><a href="#"><input onClick="svgWin.affiche_div('legende');" type="checkbox" value="" style="width:14px; height:14px;" <?php echo $vision_legende;?>/>&nbsp;La l&eacute;gende</a></li>
         <li><a href="#"><input onClick="svgWin.affiche_div('outils');" type="checkbox" value="" style="width:14px; height:14px;" <?php echo $vision_icone;?>/>&nbsp;La barre d&acute;icones</a></li>
		 <?php if($_SESSION["profil"]->droit_appli!='v')
				{
				echo "<li><a href=\"#\"><input id=\"coche_masque\" type=\"checkbox\" value=\"\" style=\"width:14px; height:14px;\" onclick=\"svgWin.masque();\"/>&nbsp;Masquage du contour</a></li>";
				echo "<li id=\"leg".(count($cou)+1)."\"><a href=\"#\"><input id=\"coche".(count($cou)+1)."\" ind=\"".($t)."\" type=\"checkbox\" value=\"\" style=\"width:14px; height:14px;\" onclick=\"svgWin.extracthtml('000.postit','".(count($cou)+1)."','','')\"/>&nbsp;Les notes</a></li>";
				}
				if($office=="true") 
				{
	echo "<li><a href=\"#\"><input type=\"checkbox\" value=\"\" style=\"width:14px; height:14px;\" onclick=\"svgWin.affiche_div('outils_office');\"   ".$vision_office."/>&nbsp;La barre back-office</a></li>";
	}
	?>
		</ul></li>
   
   <?php
	if($_SESSION["profil"]->droit_appli!='v')
	{
	
     echo "<li><span class=\"divider divider-vert\" ></span></li>
      <li><a class=\"item-primary\" href=\"#;\">Insertion</a>
   
         <ul style=\"width:150px;\">
         <li onClick=\"svgWin.postit();\"><a href=\"#\">Une note</a></li>";
		
		 if($cou[0]['btn_polygo']!="" && ($_SESSION["profil"]->droit_appli!='v' || $_SESSION["profil"]->droit_appli!='c'))
			{ 
			
        echo " <li onClick=\"change_color_fond(5);svgWin.activpoly();\"><a href=\"#\">Une g&eacute;om&eacute;trie</a></li>";
		 
			}
		
         echo "</ul></li>";
    
	}
	?>     
       <li><span class="divider divider-vert" ></span></li>
      <li><a class="item-primary" href="#;">Aide</a>
   
         <ul style="width:150px;">
         <li onClick="svgWin.aide();"><a href="#">Aide en ligne</a></li>
         <li onClick="svgWin.contacte();"><a href="#">Nous contacter</a></li>
        
         </ul></li>
  <li class="clear">&nbsp;</li></ul>
</div>

<!--fin du bloc menu -->

<!--début du bloc application -->
<div style="position: absolute; left:420px; top:5px; width:120; height:20; z-index: 1000;" align="center" > 
  <select id="choixappli" size="1" onclick="index_appli=this.options.selectedIndex" onChange="relecture(this.options[this.options.selectedIndex].value);">
<?php
for ($c=0;$c<count($mn);$c++)
{
   if($mn[$c]['idapplication']==$_SESSION["profil"]->appli && $mn[$c]['type_appli']!=1)
  {echo "<option value=\"".$mn[$c]['idapplication']."|".$mn[$c]['type_appli']."|".$mn[$c]['url']."\" selected>".$mn[$c]['libelle_appli']."</option>";
   }
 elseif($mn[$c]['libelle_appli']!="administration" && $mn[$c]['libelle_appli']!="back_office" )
  {
  echo "<option value=\"".$mn[$c]['idapplication']."|".$mn[$c]['type_appli']."|".$mn[$c]['url']."\" >".$mn[$c]['libelle_appli']."</option>";
  }
}
 ?>
</select></div>

<!--fin du bloc application -->

<!--début du bloc recherche -->
<div style="position:absolute; left: 740px; top:30px; width:120px">
<input id="recherche" name="" type="text" value="Rechercher" size="15" onClick="this.value=''" onKeyPress="if (event.keyCode == 13){svgWin.recherche();}" />
</div>
<div style="position:absolute;top:30px;left:860px;width:20px; height:20px;" onClick="svgWin.recherche();">
<img src="../doc_commune/<?php echo $ref_rep;?>/skins/symbol_recherche.png"  style="width:20px;"/>
</div>
<!--fin du bloc recherche -->

<!--début du bloc connexion-->
<div style="position: absolute; height:20px;left:680px; top:5px;width:200px;font-size:15px" align="right">
<?php
if($_SESSION["profil"]->droit_appli!='v')
	{
	echo "<img src=\"../doc_commune/".$ref_rep."/skins/user.png\" width=\"20px\" height=\"20px\"
 onmouseover=\"toolTip('Se déconnecter',event);\" onmouseout=\"toolTip();\" onclick=\"window.location.replace('".$protocol."://".$_SERVER['HTTP_HOST']."/logout.php')\" />";
	}
	else
	{
	echo "<img src=\"../doc_commune/".$ref_rep."/skins/user.png\" width=\"20px\" height=\"20px\"/>";
	}	
	echo "<sup>&nbsp;".utf8_decode($mn[0]['nom'])." ".utf8_decode($mn[0]['prenom'])."</sup>";
?>
</div>
<!--fin du bloc connexion -->
</div>
<!--fin du bloc conteneur pour centrer l'entête -->
</div>
<!--fin du bloc entête -->

<div id="toolTipLayer"  style="position:absolute; visibility:hidden; z-index:250;top:0px;left:0px"></div>
<div id="inforecherche"  style="position:absolute; visibility:hidden; height:500px; width:300px; background-color:#FFFFFF;border:solid;border-width:1px;left:100%;margin-left:-150px;top:50%;margin-top:-250px; z-index:10" >
<div style="position:absolute;top:0px;left:0px;height:20px;width:100%; border-bottom:#008; border-bottom:solid;background-color: #dff0ff;border-bottom-width:1px;text-align:center" >Résultat de la recherche</div>
<div id="resultat_recherche"  style="overflow:auto;position:absolute;top:20px;left:0px;height:430px; width:100%;"></div>
<div style="position:absolute;top:470px;left:120px;height:20px;width:60px; border:#008; border:solid;background-color: #dff0ff;border-width:1px;text-align:center" onClick="svgWin.affiche_div('inforecherche');">Fermer</div>
</div>
<div id="choix_adresse"  style="position:absolute; visibility:hidden; height:500px; width:300px; background-color:#FFFFFF;border:double;left:100%;margin-left:-150px;top:50%;margin-top:-250px;z-index:10" >
<div style="position:absolute;top:0px;left:0px;height:20px;width:300px; border-bottom:#008; border-bottom:solid;background-color: #dff0ff;border-bottom-width:1px;text-align:center" >Résultat de la recherche</div>
<div id="resultat_choix"  style="position:absolute;top:20px;left:0px;height:480px; width:300px;" onKeyPress="if (event.keyCode == 13){svgWin.recher();}" ></div>
<div style="position:absolute;top:80px;left:120px;height:20px;width:60px; border:#008; border:solid;background-color: #dff0ff;border-width:1px;text-align:center" onClick="svgWin.recher();">valider</div>
<div style="position:absolute;top:470px;left:120px;height:20px;width:60px; border:#008; border:solid;background-color: #dff0ff;border-width:1px;text-align:center" onClick="svgWin.affiche_div('choix_adresse');">Fermer</div>
</div>

<div id="message"  style="position:absolute; visibility:hidden; height:200px; width:500px; background-color:#FFFFFF;border:solid;border-width:1px;left:100%;margin-left:-250px;top:50%;margin-top:-100px;z-index:100" >
<div style="position:absolute;top:0px;left:0px;height:20px;width:100%; border-bottom:#008; border-bottom:solid;background-color: #dff0ff;border-bottom-width:1px;text-align:center" >Information</div>
<div id="resultat_message"  style="overflow:auto;position:absolute;top:20px;left:0px;height:130px; width:100%;"></div>
<div style="position:absolute;top:170px;left:220px;height:20px;width:60px; border:#008; border:solid;background-color: #dff0ff;border-width:1px;text-align:center" onClick="svgWin.affiche_div('message');">Fermer</div>
</div>
<div id="message_box"  style="position:absolute; visibility:hidden; height:30px; width:200px; background-color:#dff0ff;border:solid;border-width:1px;left:100%;margin-left:-100px;top:50%;margin-top:-10px;z-index:300" >
<div style="position:absolute;top:5px; left:5px;font-size:18px">Veuillez Patienter</div><div style="position:absolute;top:5px; left:150px;"><img src="../doc_commune/<?php echo $ref_rep;?>/skins/attente.gif" width="20px" height="20px"/></div>
</div>
<!-- Début des blocs back-office-->

<!-- Début du bloc ordre de la légende -->
<?php
if($office=="true")
{
echo "<div id=\"ordre_legende\"  style=\"position:absolute; visibility:hidden; height:400px; width:500px; background-color:#FFFFFF;border:solid;border-width:1px;left:100%;margin-left:-250px;top:50%;margin-top:-200px;z-index:100\" >
<div style=\"position:absolute;top:0px;left:0px;height:20px;width:100%; border-bottom:#008; border-bottom:solid;background-color: #dff0ff;border-bottom-width:1px;text-align:center\" >Back-office ---Ordre de la l&eacute;gende---</div>
<div id=\"resultat_ordre_legende\"  style=\"overflow:auto;position:absolute;top:20px;left:0px;height:330px; width:100%;text-align:center\">
<br>
<form name=\"mod_legende\">
<select name=\"liste\" size=\"17\" >
";

for ($c=0;$c<count($cou);$c++)
{
if($cou[$c]['groupe']!="")
		{
		$sel=$cou[$c]['groupe'];
		}
		else
		{
		$sel=$cou[$c]['nom_theme'];
		}
echo "<option value=\"".$cou[$c]['idappthe']."\" >".$sel."</option>";
}
echo "</select>
<div style=\"position:absolute;top:70px;left:420px;height:20px;width:20px;text-align:center\" onclick=\"tjs_haut(document.forms[0].elements[0])\"><img src=\"../doc_commune/".$ref_rep."/skins/up.png\" width=\"20px\" height=\"20px\"/></div>
<div style=\"position:absolute;top:250px;left:420px;height:20px;width:20px;text-align:center\" onclick=\"tjs_bas(document.forms[0].elements[0])\"><img src=\"../doc_commune/".$ref_rep."/skins/down.png\" width=\"20px\" height=\"20px\"/></div>
</form></div>
<div style=\"position:absolute;top:370px;left:220px;height:20px;width:60px; border:#008; border:solid;background-color: #dff0ff;border-width:1px;text-align:center\" onClick=\"ordre_legende();\">Valider</div>
</div>";
//<!-- fin du bloc ordre de la légende -->
//<!-- Debut du bloc style du theme -->
echo "<div id=\"style_theme\"  style=\"position:absolute; visibility:hidden; height:300px; width:500px; background-color:#FFFFFF;border:solid;border-width:1px;left:100%;margin-left:-250px;top:50%;margin-top:-200px;z-index:100\" >
<div style=\"position:absolute;top:0px;left:0px;height:20px;width:100%; border-bottom:#008; border-bottom:solid;background-color: #dff0ff;border-bottom-width:1px;text-align:center\" >Back-office ---Gestion du style---</div>

<div style=\"position:absolute;top:50px;left:30px;height:150px;width:200px; border:#008; border:solid;border-width:1px;text-align:center\" >
Remplissage
<div style=\"position:absolute;top:30px;left:10px;height:20px;width:180px;text-align:center\">
R<input id=\"fill_r\" type=\"text\" value=\"0\" onClick=\"this.value=''\" size=\"1\">
G<input id=\"fill_g\" type=\"text\" value=\"0\" onClick=\"this.value=''\" size=\"1\">
B<input id=\"fill_b\" type=\"text\" value=\"0\" onClick=\"this.value=''\" size=\"1\"></div>
<div style=\"position:absolute;top:70px;left:10px;height:20px;width:180px;text-align:center\">Transparence<input id=\"fill_opa\" type=\"text\" value=\"1\" size=\"1\"></div>
<div style=\"cursor: pointer;position:absolute;top:110px;left:70px;height:20px;width:60px; border:#008; border:solid;background-color: #dff0ff;border-width:1px;text-align:center\" onClick=\"svgWin.affiche_div('palette');palette('fill');\">palette</div>
</div>
<div id=\"cache_fill\" style=\"visibility:hidden;position:absolute;top:50px;left:30px;height:150px;width:200px; border:#008; border:solid;border-width:1px;text-align:center;zoom:1;filter:alpha(opacity=80);opacity:0.8;background-color:rgb(182,178,146)\"></div>
<div style=\"position:absolute;top:50px;left:270px;height:150px;width:200px; border:#008; border:solid;border-width:1px;text-align:center\" >
Contour
<div style=\"position:absolute;top:30px;left:10px;height:20px;width:180px;text-align:center\">
R<input id=\"stroke_r\" type=\"text\" value=\"0\" onClick=\"this.value=''\" size=\"1\">
G<input id=\"stroke_g\" type=\"text\" value=\"0\" onClick=\"this.value=''\" size=\"1\">
B<input id=\"stroke_b\" type=\"text\" value=\"0\" onClick=\"this.value=''\" size=\"1\"></div>
<div style=\"position:absolute;top:70px;left:10px;height:20px;width:180px;text-align:center\">Largeur<input id=\"stroke_lar\" type=\"text\" value=\"1\" size=\"1\"></div>
<div style=\"cursor: pointer;position:absolute;top:110px;left:70px;height:20px;width:60px; border:#008; border:solid;background-color: #dff0ff;border-width:1px;text-align:center\" onClick=\"svgWin.affiche_div('palette');palette('stroke');\">palette</div>
</div>
<div id=\"cache_stroke\" style=\"visibility:hidden;position:absolute;top:50px;left:270px;height:150px;width:200px; border:#008; border:solid;border-width:1px;text-align:center;zoom:1;filter:alpha(opacity=80);opacity:0.8;background-color:rgb(182,178,146)\"></div>
<div style=\"position:absolute;top:220px;left:40px;height:20px;width:180px;text-align:center\">
Pas de remplissage<input id=\"fill\" type=\"checkbox\" onClick=\"svgWin.affiche_div('cache_fill');\"></div>
<div style=\"position:absolute;top:220px;left:280px;height:20px;width:180px;text-align:center\">
Pas de contour<input id=\"stroke\" type=\"checkbox\" onClick=\"svgWin.affiche_div('cache_stroke');\"></div>
<div style=\"cursor: pointer;position:absolute;top:260px;left:440px;height:20px;width:20px;\" onClick=\"svgWin.affiche_div('style_theme');document.getElementById('cache_fill').style.visibility='hidden';document.getElementById('cache_stroke').style.visibility='hidden';\"><img src=\"../doc_commune/".$ref_rep."/skins/delete.png\" width=\"20px\" height=\"20px\"/></div>
<div style=\"cursor: pointer;position:absolute;top:260px;left:470px;height:20px;width:20px;\" onClick=\"valide_style();\"><img src=\"../doc_commune/".$ref_rep."/skins/valide.png\" width=\"20px\" height=\"20px\"/></div>
</div>";
//<!-- fin du bloc style du theme -->

//<!-- Debut du bloc gestion du symbole -->
echo "<div id=\"style_symbole\"  style=\"position:absolute; visibility:hidden; height:300px; width:500px; background-color:#FFFFFF;border:solid;border-width:1px;left:100%;margin-left:-250px;top:50%;margin-top:-200px;z-index:100\" >
<div style=\"position:absolute;top:0px;left:0px;height:20px;width:100%; border-bottom:#008; border-bottom:solid;background-color: #dff0ff;border-bottom-width:1px;text-align:center\" >Back-office ---Gestion du symbole---</div>

<div style=\"position:absolute;top:50px;left:30px;height:150px;width:200px; border:#008; border:solid;border-width:1px;text-align:center\" >
Couleur
<div style=\"position:absolute;top:30px;left:10px;height:20px;width:180px;text-align:center\">
R<input id=\"symbo_r\" type=\"text\" value=\"0\" onClick=\"this.value=''\" size=\"1\">
G<input id=\"symbo_g\" type=\"text\" value=\"0\" onClick=\"this.value=''\" size=\"1\">
B<input id=\"symbo_b\" type=\"text\" value=\"0\" onClick=\"this.value=''\" size=\"1\"></div>
<div style=\"position:absolute;top:70px;left:10px;height:20px;width:180px;text-align:center\">Transparence<input id=\"symbo_opa\" type=\"text\" value=\"1\" size=\"1\"></div>
<div style=\"cursor: pointer;position:absolute;top:110px;left:70px;height:20px;width:60px; border:#008; border:solid;background-color: #dff0ff;border-width:1px;text-align:center\" onClick=\"svgWin.affiche_div('palette');palette('symbo');\">palette</div>
</div>
<div style=\"position:absolute;top:50px;left:270px;height:150px;width:200px; border:#008; border:solid;border-width:1px;text-align:center\" ><span id=\"titre_symbo\">
Symbole</span>
<div id=\"symbo\" style=\"position:absolute;top:30px;left:10px;height:20px;width:180px;text-align:center;font-family:svg; font-size:20px;\" onclick=\"appel_symbol()\"></div>
<div style=\"position:absolute;top:70px;left:10px;height:20px;width:180px;text-align:center\">Taille<input id=\"symbo_size\" type=\"text\" value=\"1\" size=\"1\"></div>

</div>
<div style=\"cursor: pointer;position:absolute;top:260px;left:440px;height:20px;width:20px;\" onClick=\"svgWin.affiche_div('style_symbole');\"><img src=\"../doc_commune/".$ref_rep."/skins/delete.png\" width=\"20px\" height=\"20px\"/></div>
<div style=\"cursor: pointer;position:absolute;top:260px;left:470px;height:20px;width:20px;\" onClick=\"valide_symbole();\"><img src=\"../doc_commune/".$ref_rep."/skins/valide.png\" width=\"20px\" height=\"20px\"/></div>
</div>";
//<!-- fin du bloc gestion du symbole -->
//<!-- Debut du bloc choix du symbole -->
echo "<div id=\"choix_symbol\"  style=\"position:absolute; visibility:hidden; height:300px; width:500px; background-color:#FFFFFF;border:solid;border-width:1px;left:100%;margin-left:-250px;top:50%;margin-top:-200px;z-index:100\" >
<div style=\"position:absolute;top:0px;left:0px;height:20px;width:100%; border-bottom:#008; border-bottom:solid;background-color: #dff0ff;border-bottom-width:1px;text-align:center\" >Back-office ---Choix du symbole---</div>

<div id=\"contenu_choix_symbol\" style=\"position:absolute;top:40px;left:35px;height:220px;width:430px; border:#008; border:solid;border-width:1px;text-align:center;font-family:svg;\" >

</div>

</div>";
//<!-- fin du bloc choix du symbole -->

//<!-- Debut du bloc propriete de la couche -->
echo "<div id=\"propriete_couche\"  style=\"position:absolute; visibility:hidden; height:400px; width:500px; background-color:#FFFFFF;border:solid;border-width:1px;left:100%;margin-left:-250px;top:50%;margin-top:-200px;z-index:100\" >
<div style=\"position:absolute;top:0px;left:0px;height:20px;width:100%; border-bottom:#008; border-bottom:solid;background-color: #dff0ff;border-bottom-width:1px;text-align:center\" >Back-office ---Propri&eacute;t&eacute; de la couche---</div>
<div style=\"position:absolute;top:30px;left:10px;height:10px;width:480px;text-align:center\">
Uniquement vectoriel<input id=\"vector\" type=\"checkbox\">
Vu partielle<input id=\"partiel\" type=\"checkbox\">
Force le rechargement<input id=\"force\" type=\"checkbox\"></div>
<div style=\"position:absolute;top:60px;left:10px;height:10px;width:480px;text-align:center\">
Vu initiale<input id=\"initiale\" type=\"checkbox\">
Objet principal<input id=\"principal\" type=\"checkbox\">
</div>
<div style=\"position:absolute;top:90px;left:10px;height:10px;width:480px;text-align:center\">
Zoom min<input id=\"zmin\" type=\"text\" value=\"0\" onClick=\"this.value=''\" size=\"3\">
Zoom max<input id=\"zmax\" type=\"text\" value=\"0\" onClick=\"this.value=''\" size=\"3\">
Zoom max raster<input id=\"zoomraster\" type=\"text\" onClick=\"this.value=''\" value=\"0\" size=\"3\">
</div>
<div style=\"position:absolute;top:120px;left:40px;height:100px;width:400px;text-align:center\">
<span onmouseover=\"this.style.color='#ff0000'\" onmouseout=\"this.style.color=''\" onClick=\"svgWin.affiche_div('script_over');\">Mouseover</span><textarea id=\"over\"  rows=\"2\" cols=\"50\" onClick=\"this.value=''\" ></textarea>
<span onmouseover=\"this.style.color='#ff0000'\" onmouseout=\"this.style.color=''\" onClick=\"svgWin.affiche_div('script_click');\">Onclick</span><textarea id=\"clik\"  rows=\"2\" cols=\"50\" onClick=\"this.value=''\" ></textarea>
Mouseout<textarea id=\"out\" rows=\"2\" cols=\"50\" onClick=\"this.value=''\" ></textarea></div>
<div style=\"cursor: pointer;position:absolute;top:360px;left:370px;height:20px;width:60px;\" onmouseover=\"toolTip('Supprimer cette couche',event)\" onmouseout=\"toolTip()\" onClick=\"supp_couche();\"><img src=\"../doc_commune/".$ref_rep."/skins/supp.png\" width=\"60px\" height=\"20px\"/></div>
<div style=\"cursor: pointer;position:absolute;top:360px;left:440px;height:20px;width:20px;\" onmouseover=\"toolTip('Quitter',event)\" onmouseout=\"toolTip()\" onClick=\"svgWin.affiche_div('propriete_couche');\"><img src=\"../doc_commune/".$ref_rep."/skins/delete.png\" width=\"20px\" height=\"20px\"/></div>
<div style=\"cursor: pointer;position:absolute;top:360px;left:470px;height:20px;width:20px;\" onmouseover=\"toolTip('Valider',event)\" onmouseout=\"toolTip()\" onClick=\"valide_propriete();\"><img src=\"../doc_commune/".$ref_rep."/skins/valide.png\" width=\"20px\" height=\"20px\"/></div>
</div>

";
//<!-- fin du bloc propriete de la couche -->

//<!-- Debut du bloc generation script mouseover -->
echo "<div id=\"script_over\"  style=\"position:absolute; visibility:hidden; height:400px; width:500px; background-color:#FFFFFF;border:solid;border-width:1px;left:100%;margin-left:-250px;top:50%;margin-top:-200px;z-index:100\" >
<div style=\"position:absolute;top:0px;left:0px;height:20px;width:100%; border-bottom:#008; border-bottom:solid;background-color: #dff0ff;border-bottom-width:1px;text-align:center\" >Back-office ---G&eacute;n&eacute;ration du script sur le OnMouseOver---</div>
<div style=\"position:absolute;top:30px;left:10px;height:10px;width:480px;text-align:center\">
<span onmouseover=\"this.style.color='#ff0000'\" onmouseout=\"this.style.color=''\" onClick=\"svgWin.affiche_div('palette');palette('survol');\">La couleur du survol&nbsp;</span><input id=\"sur_coul\" type=\"text\" value=\"\" size=\"14\"><br><br>
Messsage a affich&eacute; sur la s&eacute;lection unique<textarea id=\"sur_uniq\"  rows=\"2\" cols=\"50\" onClick=\"this.value=''\" ></textarea><br><br>
Messsage a affich&eacute; sur la s&eacute;lection multiple<textarea id=\"sur_multi\"  rows=\"2\" cols=\"50\" onClick=\"this.value=''\" ></textarea></div>
<div style=\"cursor: pointer;position:absolute;top:360px;left:440px;height:20px;width:20px;\" onmouseover=\"toolTip('Quitter',event)\" onmouseout=\"toolTip()\" onClick=\"svgWin.affiche_div('script_over');\"><img src=\"../doc_commune/".$ref_rep."/skins/delete.png\" width=\"20px\" height=\"20px\"/></div>
<div style=\"cursor: pointer;position:absolute;top:360px;left:470px;height:20px;width:20px;\" onmouseover=\"toolTip('Valider',event)\" onmouseout=\"toolTip()\" onClick=\"valide_over();\"><img src=\"../doc_commune/".$ref_rep."/skins/valide.png\" width=\"20px\" height=\"20px\"/></div>
</div>

";
//<!-- fin du bloc generation script mouseover  -->

//<!-- Debut du bloc generation script onclick -->
echo "<div id=\"script_click\"  style=\"position:absolute; visibility:hidden; height:400px; width:500px; background-color:#FFFFFF;border:solid;border-width:1px;left:100%;margin-left:-250px;top:50%;margin-top:-200px;z-index:100\" >
<div style=\"position:absolute;top:0px;left:0px;height:20px;width:100%; border-bottom:#008; border-bottom:solid;background-color: #dff0ff;border-bottom-width:1px;text-align:center\" >Back-office ---G&eacute;n&eacute;ration du script sur le Onclick---</div>
<div style=\"position:absolute;top:30px;left:10px;height:10px;width:480px;text-align:center\">
Nom de l'objet <input id=\"click_objet\" type=\"text\" value=\"\" size=\"14\"><br><br>
Page s&eacute;curis&eacute;e <input id=\"click_secu\" type=\"checkbox\"><br><br>
Serveur <input id=\"click_serveur\" type=\"text\" value=\"serveur\" size=\"14\" onClick=\"this.value=''\" ><br><br>
Url <input id=\"click_url\" type=\"text\" value=\"\" size=\"50\"><br><br>
Variable <input id=\"click_variable\" type=\"text\" value=\"obj_keys\" size=\"14\" onClick=\"this.value=''\" ><br><br>
s&eacute;lection multiple <input id=\"click_multi\" type=\"checkbox\">
 limit&eacute; &agrave; <input id=\"click_limit\" type=\"text\" value=\"\" size=\"1\"></div>
<div style=\"cursor: pointer;position:absolute;top:360px;left:440px;height:20px;width:20px;\" onmouseover=\"toolTip('Quitter',event)\" onmouseout=\"toolTip()\" onClick=\"svgWin.affiche_div('script_click');\"><img src=\"../doc_commune/".$ref_rep."/skins/delete.png\" width=\"20px\" height=\"20px\"/></div>
<div style=\"cursor: pointer;position:absolute;top:360px;left:470px;height:20px;width:20px;\" onmouseover=\"toolTip('Valider',event)\" onmouseout=\"toolTip()\" onClick=\"valide_click();\"><img src=\"../doc_commune/".$ref_rep."/skins/valide.png\" width=\"20px\" height=\"20px\"/></div>
</div>

";
//<!-- fin du bloc generation script onclick  -->

//<!-- Debut du bloc ajout colonne libelle et reference -->
echo "<div id=\"ad_id\"  style=\"position:absolute; visibility:hidden; height:200px; width:500px; background-color:#FFFFFF;border:solid;border-width:1px;left:100%;margin-left:-250px;top:50%;margin-top:-100px;z-index:100\" >
<div style=\"position:absolute;top:0px;left:0px;height:20px;width:100%; border-bottom:#008; border-bottom:solid;background-color: #dff0ff;border-bottom-width:1px;text-align:center\" >Back-office ---Ajout de la colonne libell&eacute; et r&eacute;f&eacute;rence---</div>
<div style=\"position:absolute;top:30px;left:10px;height:10px;width:480px;text-align:center\">
La colonne libell&eacute; et ou r&eacute;f&eacute;rence optionnelles lors de cr&eacute;ation du th&egrave;me sont obligatoires pour affecter le script de survol et de click<br><br>
Colonne r&eacute;f&eacute;rence <select id=\"col_id\"  size=\"1\"></select><br><br>
Colonne libell&eacute; <select id=\"col_ad\"  size=\"1\"></select></div>
<div style=\"cursor: pointer;position:absolute;top:160px;left:470px;height:20px;width:20px;\" onmouseover=\"toolTip('Valider',event)\" onmouseout=\"toolTip()\" onClick=\"valide_adid();\"><img src=\"../doc_commune/".$ref_rep."/skins/valide.png\" width=\"20px\" height=\"20px\"/></div>
</div>

";
//<!-- fin du bloc ajout colonne libelle et reference -->


//<!-- Debut du bloc ajout thème -->
echo "<div id=\"ajou_theme\"  style=\"position:absolute; visibility:hidden; height:400px; width:500px; background-color:#FFFFFF;border:solid;border-width:1px;left:100%;margin-left:-250px;top:50%;margin-top:-200px;z-index:100\" >
<div style=\"position:absolute;top:0px;left:0px;height:20px;width:100%; border-bottom:#008; border-bottom:solid;background-color: #dff0ff;border-bottom-width:1px;text-align:center\" >Back-office ---Ajouter un th&egrave;me---</div>
<div style=\"position:absolute;top:30px;left:10px;height:10px;width:480px;text-align:center\">
Th&egrave;me <select id=\"ajout_theme\" size=\"1\" onChange=\"verif_theme(this.options[this.options.selectedIndex].value);\">";
$result_theme="SELECT libelle_them,idtheme FROM admin_svg.theme order by libelle_them asc";
$the=$DB->tab_result($result_theme);
 echo "<option value=\"\" ></option>";
for ($c=0;$c<count($the);$c++)
{
 
  echo "<option value=\"".$the[$c]['idtheme']."\" >".$the[$c]['libelle_them']."</option>";
  
}

echo "</select></div>

<div id=\"choix_style\" style=\"position:absolute;top:60px;left:10px;height:10px;width:480px;text-align:center\">
 </div>

<div style=\"cursor: pointer;position:absolute;top:360px;left:440px;height:20px;width:20px;\" onmouseover=\"toolTip('Quitter',event)\" onmouseout=\"toolTip()\" onClick=\"svgWin.affiche_div('ajou_theme');\"><img src=\"../doc_commune/".$ref_rep."/skins/delete.png\" width=\"20px\" height=\"20px\"/></div>
<div style=\"cursor: pointer;position:absolute;top:360px;left:470px;height:20px;width:20px;\" onmouseover=\"toolTip('Valider',event)\" onmouseout=\"toolTip()\" onClick=\"valide_ajout_theme();\"><img src=\"../doc_commune/".$ref_rep."/skins/valide.png\" width=\"20px\" height=\"20px\"/></div>
</div>

";
//<!-- fin du bloc ajout thème  -->


//<!-- Debut du bloc création theme -->
echo "<div id=\"crea_theme\"  style=\"position:absolute; visibility:hidden; height:400px; width:500px; background-color:#FFFFFF;border:solid;border-width:1px;left:100%;margin-left:-250px;top:50%;margin-top:-200px;z-index:100\" >
<div style=\"position:absolute;top:0px;left:0px;height:20px;width:100%; border-bottom:#008; border-bottom:solid;background-color: #dff0ff;border-bottom-width:1px;text-align:center\" >Back-office ---Cr&eacute;ation d&acute;un th&egrave;me---</div>
<div style=\"position:absolute;top:30px;left:10px;height:10px;width:480px;text-align:center\">
Nom du th&egrave;me <input id=\"crea_nom\" type=\"text\" value=\"\" onClick=\"this.value=''\" size=\"30\">
</div>
<div style=\"position:absolute;top:60px;left:10px;height:10px;width:480px;text-align:center\">
Vu partielle <input id=\"crea_partiel\" type=\"checkbox\">
Vu initiale <input id=\"crea_initiale\" type=\"checkbox\">
Force le rechargement <input id=\"crea_force\" type=\"checkbox\"></div>
<div style=\"position:absolute;top:90px;left:10px;height:10px;width:480px;text-align:center\">
Zoom min <input id=\"crea_zmin\" type=\"text\" value=\"0\" onClick=\"this.value=''\" size=\"3\">
Zoom max <input id=\"crea_zmax\" type=\"text\" value=\"0\" onClick=\"this.value=''\" size=\"3\">
Zoom max raster <input id=\"crea_zoomraster\" type=\"text\" onClick=\"this.value=''\" value=\"0\" size=\"3\">
</div>
<div style=\"position:absolute;top:120px;left:10px;height:10px;width:480px;text-align:center\">
Type <select id=\"crea_type\" size=\"1\" onChange=\"type_theme();\">
<option value=\"\"></option>
<option value=\"0\" >Postgis</option>
<option value=\"1\" >Raster</option>
<option value=\"2\" >WMS</option>
</select>
</div>
<div id=\"postgis\" style=\"visibility:hidden;position:absolute;top:150px;left:10px;height:10px;width:480px;text-align:center\">
<div style=\"position:absolute;top:10px;left:10px;height:10px;width:480px;text-align:center\">
sch&eacute;ma <select id=\"crea_schema\" size=\"1\" onChange=\"appel_table()\">
</select>
table <select id=\"crea_table\" size=\"1\" onChange=\"table=document.getElementById('crea_table').options[document.getElementById('crea_table').options.selectedIndex].value;\">
</select>
</div>
<div style=\"position:absolute;top:40px;left:10px;height:50px;width:440px;text-align:right\">
colonne r&eacute;f&eacute;rence <input id=\"crea_ref\" type=\"text\" value=\"\"  size=\"40\" onclick=\"appel_colonne('crea_ref');svgWin.affiche_div('requeteur')\"><br>
colonne g&eacute;ographique <input id=\"crea_geom\" type=\"text\" value=\"\"  size=\"40\" onclick=\"appel_colonne('crea_geom');svgWin.affiche_div('requeteur')\"><br>
colonne libell&eacute; <input id=\"crea_libel\" type=\"text\" value=\"\"  size=\"40\" onclick=\"appel_colonne('crea_libel');svgWin.affiche_div('requeteur')\"><br>
clause <input id=\"crea_clause\" type=\"text\" value=\"\"  size=\"60\" onclick=\"appel_colonne('crea_clause');svgWin.affiche_div('requeteur')\">
</div>
</div>
<div id=\"raster\" style=\"visibility:hidden;position:absolute;top:150px;left:10px;height:10px;width:480px;text-align:center\">
Chemin du shp <input id=\"crea_shp\" type=\"text\" value=\"\"  size=\"40\" ><br>
Groupe(option) <input id=\"crea_group\" type=\"text\" value=\"\"  size=\"10\" >

</div>
<div id=\"wms\" style=\"visibility:hidden;position:absolute;top:150px;left:10px;height:10px;width:480px;text-align:center\">
wms
</div>
<div style=\"cursor: pointer;position:absolute;top:360px;left:440px;height:20px;width:20px;\" onmouseover=\"toolTip('Quitter',event)\" onmouseout=\"toolTip()\" onClick=\"svgWin.affiche_div('crea_theme');document.getElementById('postgis').style.visibility='hidden';document.getElementById('raster').style.visibility='hidden';document.getElementById('wms').style.visibility='hidden'\"><img src=\"../doc_commune/".$ref_rep."/skins/delete.png\" width=\"20px\" height=\"20px\"/></div>
<div style=\"cursor: pointer;position:absolute;top:360px;left:470px;height:20px;width:20px;\" onmouseover=\"toolTip('Valider',event)\" onmouseout=\"toolTip()\" onClick=\"creer_theme();\"><img src=\"../doc_commune/".$ref_rep."/skins/valide.png\" width=\"20px\" height=\"20px\"/></div>
</div>

";
//<!-- fin du bloc création theme -->


echo "<div id=\"choix_pt\"  style=\"position:absolute; visibility:hidden; height:100px; width:500px; background-color:#FFFFFF;border:solid;border-width:1px;left:100%;margin-left:-250px;top:50%;margin-top:-200px;z-index:100\" >
<div style=\"position:absolute;top:0px;left:0px;height:20px;width:100%; border-bottom:#008; border-bottom:solid;background-color: #dff0ff;border-bottom-width:1px;text-align:center\" >Back-office ---Cr&eacute;ation d&acute;un th&egrave;me---</div>
<div style=\"position:absolute;top:30px;left:10px;height:10px;width:480px;text-align:center\">
Appliquer un texte ou un symbole<br>
choix <select id=\"c_pt\" size=\"1\" >
<option value=\"Symbole\">symbole</option>
<option value=\"Texte\">texte</option>
</select>
</div>
<div style=\"cursor: pointer;position:absolute;top:60px;left:440px;height:20px;width:20px;\" onmouseover=\"toolTip('Quitter',event)\" onmouseout=\"toolTip()\" onClick=\"svgWin.affiche_div('choix_pt');\"><img src=\"../doc_commune/".$ref_rep."/skins/delete.png\" width=\"20px\" height=\"20px\"/></div>
<div style=\"cursor: pointer;position:absolute;top:60px;left:470px;height:20px;width:20px;\" onmouseover=\"toolTip('Valider',event)\" onmouseout=\"toolTip()\" onClick=\"valid_pt();\"><img src=\"../doc_commune/".$ref_rep."/skins/valide.png\" width=\"20px\" height=\"20px\"/></div>
</div>";
//<!-- fin du bloc création theme choix point-->

//<!-- Debut du bloc création theme choix ligne -->
echo "<div id=\"choix_lg\"  style=\"position:absolute; visibility:hidden; height:100px; width:500px; background-color:#FFFFFF;border:solid;border-width:1px;left:100%;margin-left:-250px;top:50%;margin-top:-200px;z-index:100\" >
<div style=\"position:absolute;top:0px;left:0px;height:20px;width:100%; border-bottom:#008; border-bottom:solid;background-color: #dff0ff;border-bottom-width:1px;text-align:center\" >Back-office ---Cr&eacute;ation d&acute;un th&egrave;me---</div>
<div style=\"position:absolute;top:30px;left:10px;height:10px;width:480px;text-align:center\">
Appliquer un trac&eacute; ou un liblell&eacute; au chemin<br>
choix <select id=\"c_lg\" size=\"1\" >
<option value=\"trace\">trac&eacute;</option>
<option value=\"libelle\">liblell&eacute;</option>
</select>
</div>
<div style=\"cursor: pointer;position:absolute;top:60px;left:440px;height:20px;width:20px;\" onmouseover=\"toolTip('Quitter',event)\" onmouseout=\"toolTip()\" onClick=\"svgWin.affiche_div('choix_pt');\"><img src=\"../doc_commune/".$ref_rep."/skins/delete.png\" width=\"20px\" height=\"20px\"/></div>
<div style=\"cursor: pointer;position:absolute;top:60px;left:470px;height:20px;width:20px;\" onmouseover=\"toolTip('Valider',event)\" onmouseout=\"toolTip()\" onClick=\"valid_lg();\"><img src=\"../doc_commune/".$ref_rep."/skins/valide.png\" width=\"20px\" height=\"20px\"/></div>
</div>";
//<!-- fin du bloc création theme choix ligne-->



//<!-- Debut du bloc création thematique -->
echo "<div id=\"crea_thematique\"  style=\"position:absolute; visibility:hidden; height:400px; width:500px; background-color:#FFFFFF;border:solid;border-width:1px;left:100%;margin-left:-250px;top:50%;margin-top:-200px;z-index:100\" >
<div style=\"position:absolute;top:0px;left:0px;height:20px;width:100%; border-bottom:#008; border-bottom:solid;background-color: #dff0ff;border-bottom-width:1px;text-align:center\" >Back-office ---Cr&eacute;ation d&acute;une th&eacute;matique---</div>
<div style=\"position:absolute;top:30px;left:10px;height:10px;width:480px;text-align:center\" >
<div style=\"position:absolute;top:0px;left:10px;height:10px;width:200px;text-align:center\" ><span onmouseover=\"this.style.color='#ff0000'\" onmouseout=\"this.style.color=''\" onclick=\"svgWin.affiche_div('requeteur')\" >S&eacute;lectionner un champ</span><br></div>
<div style=\"position:absolute;top:30px;left:0px;height:10px;width:480px;text-align:center\" ><textarea id=\"select_thema\"  rows=\"2\" cols=\"50\" onClick=\"this.value=''\" ></textarea>
<select id=\"type_thema\" size=\"1\" onChange=\"sousmettre_thematique();\">
<option value=\"\" ></option>
<option value=\"0\" >Valeur fixe</option>
<option value=\"1\" >Fourchette</option>
</select></div>
<div id=\"contenu_thema\" style=\"position:absolute;top:120px;left:10px;height:200px;width:470px;text-align:center;overflow:auto\" ></div></div>


<div style=\"cursor: pointer;position:absolute;top:360px;left:440px;height:20px;width:20px;\" onmouseover=\"toolTip('Quitter',event)\" onmouseout=\"toolTip()\" onClick=\"svgWin.affiche_div('crea_thematique');\"><img src=\"../doc_commune/".$ref_rep."/skins/delete.png\" width=\"20px\" height=\"20px\"/></div>
<div style=\"cursor: pointer;position:absolute;top:360px;left:470px;height:20px;width:20px;\" onmouseover=\"toolTip('Valider',event)\" onmouseout=\"toolTip()\" onClick=\"creer_thematique();\"><img src=\"../doc_commune/".$ref_rep."/skins/valide.png\" width=\"20px\" height=\"20px\"/></div>
</div>

";
//<!-- fin du bloc creation thematique  -->
//<!-- Debut du bloc création application -->
echo "<div id=\"crea_appli\"  style=\"position:absolute; visibility:hidden; height:220px; width:500px; background-color:#FFFFFF;border:solid;border-width:1px;left:100%;margin-left:-250px;top:50%;margin-top:-200px;z-index:100\" >
<div style=\"position:absolute;top:0px;left:0px;height:20px;width:100%; border-bottom:#008; border-bottom:solid;background-color: #dff0ff;border-bottom-width:1px;text-align:center\" >Back-office ---Cr&eacute;ation d&acute;une application---</div>
<div style=\"position:absolute;top:30px;left:10px;height:10px;width:480px;text-align:center\" >
<div style=\"position:absolute;top:0px;left:10px;height:10px;width:480px;text-align:center\" >Nom de l&acute;application <input id=\"appli_nom\" type=\"text\" value=\"\"  size=\"20\" ></div>
<div style=\"position:absolute;top:30px;left:0px;height:10px;width:480px;text-align:center\" >
Application cartographique?<select id=\"type_appli\" size=\"1\" onChange=\"type_appli();\">
<option value=\"\" ></option>
<option value=\"0\" >oui</option>
<option value=\"1\" >non</option>
</select></div>
<div id=\"appli_non_carto\" style=\"visibility:hidden;position:absolute;top:70px;left:10px;height:200px;width:470px;text-align:center;overflow:auto\" >
Chemin de l&acute;application<input id=\"appli_url\" type=\"text\" value=\"\"  size=\"40\" >
</div>

<div id=\"appli_carto\" style=\"visibility:hidden;position:absolute;top:70px;left:10px;height:200px;width:470px;text-align:center;overflow:auto\" >
Zoom d&acute;ouverture<input id=\"appli_ouv\" type=\"text\" value=\"\"  size=\"5\" >
Zoom mini<input id=\"appli_mini\" type=\"text\" value=\"\"  size=\"5\" >
Zoom max<input id=\"appli_max\" type=\"text\" value=\"\"  size=\"5\" ><br>
Texte du bouton d&acute;insertion<input id=\"texte_insert\" type=\"text\" value=\"\"  size=\"40\" >
Url de validation d&acute;insertion<input id=\"url_insert\" type=\"text\" value=\"\"  size=\"40\" >

</div>

</div>


<div style=\"cursor: pointer;position:absolute;top:180px;left:440px;height:20px;width:20px;\" onmouseover=\"toolTip('Quitter',event)\" onmouseout=\"toolTip()\" onClick=\"document.getElementById('appli_non_carto').style.visibility='hidden';document.getElementById('appli_carto').style.visibility='hidden';svgWin.affiche_div('crea_appli');\"><img src=\"../doc_commune/".$ref_rep."/skins/delete.png\" width=\"20px\" height=\"20px\"/></div>
<div style=\"cursor: pointer;position:absolute;top:180px;left:470px;height:20px;width:20px;\" onmouseover=\"toolTip('Valider',event)\" onmouseout=\"toolTip()\" onClick=\"creer_appli();\"><img src=\"../doc_commune/".$ref_rep."/skins/valide.png\" width=\"20px\" height=\"20px\"/></div>
</div>

";
//<!-- fin du bloc creation application  -->

//<!-- Debut du bloc mofif supp application -->
echo "<div id=\"mod_appli\"  style=\"position:absolute; visibility:hidden; height:220px; width:500px; background-color:#FFFFFF;border:solid;border-width:1px;left:100%;margin-left:-250px;top:50%;margin-top:-200px;z-index:100\" >
<div style=\"position:absolute;top:0px;left:0px;height:20px;width:100%; border-bottom:#008; border-bottom:solid;background-color: #dff0ff;border-bottom-width:1px;text-align:center\" >Back-office ---Modification ou suppression d&acute;une application---</div>
<div style=\"position:absolute;top:30px;left:10px;height:10px;width:480px;text-align:center\" >
<div style=\"position:absolute;top:0px;left:10px;height:10px;width:480px;text-align:center\" >
Application<select id=\"mod_choixappli\" size=\"1\" onChange=\"control_mod_appli(this.options[this.options.selectedIndex].value);\">
<option value=\"\"></option>";
for ($c=0;$c<count($mn);$c++)
{

  echo "<option value=\"".$mn[$c]['idapplication']."|".$mn[$c]['type_appli']."|".$mn[$c]['url']."\" >".$mn[$c]['libelle_appli']."</option>";

}

echo "</select>


</div>
<div id=\"mod_appli_non_carto\" style=\"visibility:hidden;position:absolute;top:30px;left:10px;height:200px;width:470px;text-align:center;overflow:auto\" >
Chemin de l&acute;application<input id=\"mod_appli_url\" type=\"text\" value=\"\"  size=\"40\" >
</div>

<div id=\"mod_appli_carto\" style=\"visibility:hidden;position:absolute;top:30px;left:10px;height:200px;width:470px;text-align:center;overflow:auto\" >
Zoom d&acute;ouverture<input id=\"mod_appli_ouv\" type=\"text\" value=\"\"  size=\"5\" >
Zoom mini<input id=\"mod_appli_mini\" type=\"text\" value=\"\"  size=\"5\" >
Zoom max<input id=\"mod_appli_max\" type=\"text\" value=\"\"  size=\"5\" ><br>
Texte du bouton d&acute;insertion<input id=\"mod_texte_insert\" type=\"text\" value=\"\"  size=\"40\" >
Url de validation d&acute;insertion<input id=\"mod_url_insert\" type=\"text\" value=\"\"  size=\"40\" >

</div>

</div>

<div style=\"cursor: pointer;position:absolute;top:180px;left:370px;height:20px;width:60px;\" onmouseover=\"toolTip('Supprimer cette application',event)\" onmouseout=\"toolTip()\" onClick=\"supp_appli();\"><img src=\"../doc_commune/".$ref_rep."/skins/supp.png\" width=\"60px\" height=\"20px\"/></div>
<div style=\"cursor: pointer;position:absolute;top:180px;left:440px;height:20px;width:20px;\" onmouseover=\"toolTip('Quitter',event)\" onmouseout=\"toolTip()\" onClick=\"document.getElementById('mod_appli_non_carto').style.visibility='hidden';document.getElementById('mod_appli_carto').style.visibility='hidden';svgWin.affiche_div('mod_appli');\"><img src=\"../doc_commune/".$ref_rep."/skins/delete.png\" width=\"20px\" height=\"20px\"/></div>
<div style=\"cursor: pointer;position:absolute;top:180px;left:470px;height:20px;width:20px;\" onmouseover=\"toolTip('Valider',event)\" onmouseout=\"toolTip()\" onClick=\"mod_appli();\"><img src=\"../doc_commune/".$ref_rep."/skins/valide.png\" width=\"20px\" height=\"20px\"/></div>
</div>

";
//<!-- fin du bloc modif supp application  -->

//<!-- Debut du bloc requeteur -->
echo "<div id=\"requeteur\"  style=\"position:absolute; visibility:hidden; height:400px; width:500px; background-color:#FFFFFF;border:solid;border-width:1px;left:100%;margin-left:-250px;top:50%;margin-top:-200px;z-index:100\" >
<div style=\"position:absolute;top:0px;left:0px;height:20px;width:100%; border-bottom:#008; border-bottom:solid;background-color: #dff0ff;border-bottom-width:1px;text-align:center\" >Back-office ---Requ&ecirc;teur---</div>


<div style=\"border:solid;border-width:1px;position:absolute;top:40px;left:10px;height:210px;width:150px;text-align:center\">
<br><select id=\"requete_champ\"  size=\"11\" style=\"width:140px\"></select>
</div>
<div style=\"background-color:#FFFFFF;position:absolute;top:30px;left:15px;height:15px;width:60px;text-align:left\">
Champs
</div>
<div style=\"border:solid;border-width:1px;position:absolute;top:40px;left:340px;height:210px;width:150px;text-align:center\">
<br><textarea id=\"requete_valeur\"  rows=\"10\" cols=\"15\"></textarea>
</div>
<div style=\"background-color:#FFFFFF;position:absolute;top:30px;left:345px;height:15px;width:55px;text-align:left\">
Valeur
</div>
<div style=\"position:absolute;top:45px;left:170px;height:210px;width:160px;text-align:center\">
<div style=\"background-color:#dff0ff;position:absolute;top:10px;height:20px;width:60px;left:50%;margin-left:-30px;text-align:center\" onclick=\"ajout_valeur()\">
Valeur
</div>
<div style=\"background-color:#dff0ff;position:absolute;top:40px;height:20px;width:60px;text-align:center;left:50%;margin-left:-30px;\" onclick=\"centre_valeur()\">
Centre
</div>
<div style=\"background-color:#dff0ff;position:absolute;top:70px;height:20px;width:60px;text-align:center;left:50%;margin-left:-30px;\" onclick=\"surface_valeur()\">
Surface
</div>
<div style=\"background-color:#dff0ff;position:absolute;top:100px;height:20px;width:70px;text-align:center;left:50%;margin-left:-35px;\" onclick=\"longueur_valeur()\">
Longueur
</div>
<div style=\"background-color:#dff0ff;position:absolute;top:130px;height:20px;width:90px;text-align:center;left:50%;margin-left:-45px;\" onclick=\"chaine_valeur()\">
Sous chaine
</div>
<div style=\"position:absolute;top:150px;height:20px;width:160px;text-align:center;left:50%;margin-left:-80px;\">
d&eacute;b<input id=\"debut\" type=\"text\" size=\"1\">&nbsp;long<input id=\"longueur\" type=\"text\" size=\"1\">
</div>
<div style=\"background-color:#dff0ff;position:absolute;top:180px;height:20px;width:20px;text-align:center;left:50px\" onclick=\"x_valeur()\">
X
</div>
<div style=\"background-color:#dff0ff;position:absolute;top:180px;height:20px;width:20px;text-align:center;left:90px;\" onclick=\"y_valeur()\">
Y
</div>


</div>
<div style=\"border:solid;border-width:1px;position:absolute;top:280px;left:50px;height:60px;width:400px;text-align:center\">
<div style=\"background-color:#dff0ff;position:absolute;top:20px;height:20px;width:20px;text-align:center;left:10px;\" onclick=\"op1_valeur()\">
+
</div>
<div style=\"background-color:#dff0ff;position:absolute;top:20px;height:20px;width:20px;text-align:center;left:40px;\" onclick=\"op2_valeur()\">
-
</div>
<div style=\"background-color:#dff0ff;position:absolute;top:20px;height:20px;width:20px;text-align:center;left:70px;\" onclick=\"op3_valeur()\">
*
</div>
<div style=\"background-color:#dff0ff;position:absolute;top:20px;height:20px;width:20px;text-align:center;left:100px;\" onclick=\"op4_valeur()\">
/
</div>
<div style=\"background-color:#dff0ff;position:absolute;top:20px;height:20px;width:20px;text-align:center;left:130px;\" onclick=\"op5_valeur()\">
||
</div>
</div>
<div style=\"background-color:#FFFFFF;position:absolute;top:270px;left:60px;height:15px;width:80px;text-align:left\">
Op&eacute;rateurs
</div>
<div style=\"cursor: pointer;position:absolute;top:360px;left:440px;height:20px;width:20px;\" onmouseover=\"toolTip('Quitter',event)\" onmouseout=\"toolTip()\" onClick=\"svgWin.affiche_div('requeteur');\"><img src=\"../doc_commune/".$ref_rep."/skins/delete.png\" width=\"20px\" height=\"20px\"/></div>
<div style=\"cursor: pointer;position:absolute;top:360px;left:470px;height:20px;width:20px;\" onmouseover=\"toolTip('Valider',event)\" onmouseout=\"toolTip()\" onClick=\"valide_requete();\"><img src=\"../doc_commune/".$ref_rep."/skins/valide.png\" width=\"20px\" height=\"20px\"/></div>


</div>

";
//<!-- fin du bloc requeteur  -->

//<!-- Debut du bloc palette de couleur -->
echo "<div id=\"palette\"  style=\"position:absolute; visibility:hidden; height:300px; width:400px; background-color:#FFFFFF;border:solid;border-width:1px;left:100%;margin-left:-200px;top:50%;margin-top:-150px;z-index:110\" >
<div style=\"position:absolute;top:0px;left:0px;height:20px;width:100%; border-bottom:#008; border-bottom:solid;background-color: #dff0ff;border-bottom-width:1px;text-align:center\" >Back-office ---Palette de couleur---</div>
<div id=\"couleur\" style=\"position:absolute;top:50px;left:30px;height:150px;width:300px\"><img id=\"color_picker\" style=\"cursor: crosshair;\" onmouseout=\"is_mouse_over = false;\" onmouseover=\"is_mouse_over = true;\" onmousemove=\"if (is_mouse_down && is_mouse_over) compute_color(event); return false;\" onmouseup=\"is_mouse_down = false;\" onmousedown=\"is_mouse_down = true; return false;\" onclick=\"compute_color(event)\" src=\"./interface/back_office/image/colpick.jpg\"/></div>
<div style=\"position:absolute;top:50px;left:350px;height:150px;width:20px\">
<table cellspacing=\"0\" cellpadding=\"0\" border=\"1\" style=\"cursor: crosshair;\">
<script type=\"text/javascript\">
for(i = 0; i < detail; i++)
{
document.write('<tr><td id=\"gs'+i+'\" style=\"background-color:#000000; width:20px; height:3px; border-style:none; border-width:0px;\"'
+ ' onclick=\"changeFinalColor(this.style.backgroundColor)\"'
+ ' onmousedown=\"is_mouse_down = true; return false;\"'
+ ' onmouseup=\"is_mouse_down = false;\"'
+ ' onmousemove=\"if (is_mouse_down && is_mouse_over) changeFinalColor(this.style.backgroundColor); return false;\"'
+ ' onmouseover=\"is_mouse_over = true;\"'
+ ' onmouseout=\"is_mouse_over = false;\"'
+ '></td></tr>');
}
</script>
</table>
</div>
<div id=\"result_color\" style=\"position:absolute;top:230px;left:170px;height:20px;width:60px;background-color:#000000;\"></div>


<div style=\"cursor: pointer;position:absolute;top:270px;left:340px;height:20px;width:20px;\" onClick=\"svgWin.affiche_div('palette');\"><img src=\"../doc_commune/".$ref_rep."/skins/delete.png\" width=\"20px\" height=\"20px\"/></div>
<div style=\"cursor: pointer;position:absolute;top:270px;left:370px;height:20px;width:20px;\" onClick=\"send_color();\"><img src=\"../doc_commune/".$ref_rep."/skins/valide.png\" width=\"20px\" height=\"20px\"/></div>
</div>";
//<!-- fin du bloc palette de couleur -->
}
?>


<!-- fin des blocs back-office-->
</body>
</html>


