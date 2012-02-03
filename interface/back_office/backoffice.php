<?php
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
?>