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
define('GIS_ROOT', '..');
include_once(GIS_ROOT . '/inc/common.php');
gis_session_start();
$insee = $_SESSION['profil']->insee;
$appli = $_SESSION['profil']->appli;

if($_POST["act"]=="mod")
{
$sql="update admin_svg.postit set contenu='".utf8_encode($_POST["observation"])."',definition='".$_POST['information']."' where gid=".$_POST["gid"]." ";
$DB->tab_result($sql);
$_GET['obj_keys']=$_POST['gid'];
}
if($_POST["act"]=="supp")
{
$sql="delete from admin_svg.postit where gid=".$_POST["gid"];
$DB->tab_result($sql);
echo "<html>";
echo "<body onload='close()'>";
echo "</body>";
echo "</html>";
//header("Location:./supp.php?gid=".$_GET["gid"]);
}
if($_POST["act"]=="ajou")
{
$sql="insert into admin_svg.postit (utilisateur,contenu,the_geom,definition) values ('".$_SESSION['profil']->idutilisateur.",".$_POST['a_utilisateur']."','".utf8_encode($_POST['observation'])."',GeometryFromtext('POINT(".$_POST['polygo'].")',$projection),'".$_POST['information']."')";
$DB->tab_result($sql);
echo "<html>";
echo "<body onload='close()'>";
echo "</body>";
echo "</html>";
//header("Location:./supp.php?gid=".$_GET["gid"]);
}
	
?>
<html>
<head>
<?php
echo "<SCRIPT LANGUAGE=\"JavaScript\">
	var sw=0;
	var app_a_install='';
	var app_invite='';
	var refresh='0';
	
	function Deplacer(l1,l2,y) {
		if (l1.options.selectedIndex>=0) {
			o=new Option(l1.options[l1.options.selectedIndex].text,l1.options[l1.options.selectedIndex].value);
			l2.options[l2.options.length]=o;
		
		app_a_install+=l1.options[l1.options.selectedIndex].value+',';
		
		document.getElementById('a_instal').value=app_a_install;
		
			l1.options[l1.options.selectedIndex]=null;
			
			
		
		}else{
			alert(\"Selectionner un utilisateur\");
		}
		
		
	}
	function check(x,y) {
var valdepart='';
	if (x.checked==true) {
	app_a_install+=y+',';
	document.getElementById('a_instal').value=app_a_install;
	}

	else {
	var reg=new RegExp('('+y+',)', \"g\");
	app_a_install=app_a_install.replace(reg,\"\");
	document.getElementById('a_instal').value=app_a_install;
	}

}

function force_refresh()
{
refresh='1';
}
function verif_refresh()
{
if(refresh=='1')
{
window.location.reload();
}
}
function choix_util(x)
{
if(x.checked==true)
{
document.getElementById('menu_util').style.display='block';
}
else
{
document.getElementById('menu_util').style.display='none';
}
}
</SCRIPT>";
?>
</head>
<body onFocus="verif_refresh();">
<form method="post" action="postit.php" enctype="multipart/form-data">
<?php
if($_GET['obj_keys'])
{
$sql="SELECT * from admin_svg.postit where gid IN(".$_GET['obj_keys'].")";
$col=$DB->tab_result($sql);}
?> 

Note<br>
<textarea name="observation" cols="30" rows="5" style="background-color:#FFFF99"><?php echo utf8_decode($col[0]["contenu"]); ?></textarea>
<br>Type d'information&nbsp;<select name="information">
      <option value="information" <?php if($col[0]["definition"]=="information"){echo "selected";}?> >simple information</option>
      <option value="haute" <?php if($col[0]["definition"]=="haute"){echo "selected";}?> >Haute</option>
       </select>
<br>
<input type="hidden" id="act" name="act" value="">
<input name="gid" type="hidden" value="<?php echo $_GET['obj_keys'];?>">
<input name="polygo" type="hidden" value="<?php echo $_GET['polygo'];?>">
<?php 
if($_GET['polygo'])
{
if($_SESSION['refresh']==1)
{
$visible='block';
$_SESSION['refresh']=0;
$check="checked";
}
else
{
$visible='none';
$_SESSION['refresh']=0;
$check="";
}
echo "<br>Associer d'autres utilisateurs &agrave; votre note&nbsp;<INPUT TYPE=\"checkbox\" id=\"ajout_util\" NAME=\"ajout_util\" onclick=\"choix_util(this)\" ".$check."><br><br>
<div id=\"menu_util\" style=\"display:".$visible."\">
&nbsp;&nbsp;&nbsp;Groupe pr&eacute;d&eacute;fini:&nbsp;&nbsp;<a href=\"groupe.php\" target=\"_blank\" onclick=\"force_refresh()\">cr&eacute;er un groupe</a><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
$group="SELECT * from admin_svg.postit_group where idutilisateur=".$_SESSION['profil']->idutilisateur;
$res_group=$DB->tab_result($group);
if(count($res_group)==0)
{
echo "Aucun groupe de pr&eacute;d&eacute;fini";
}
else
{
for ($i=0;$i<count($res_group);$i++)
		{
		$util_group="SELECT * from admin_svg.postit_uti_group where idgroup=".$res_group[$i]['idgroup'];
		$res_util_group=$DB->tab_result($util_group);
		$util_g="";
		for ($j=0;$j<count($res_util_group);$j++)
		{
		$util_g.=$res_util_group[$j]['idutilisateur'].",";
		}
		echo "&nbsp;".$res_group[$i]['nomgroup']."<INPUT TYPE=\"checkbox\" NAME=\"Group".$i."\" onclick=\"check(this,'".substr($util_g,0,strlen($util_g)-1)."')\">";
		$util_g="";
		}
}
echo "<br><br>&nbsp;&nbsp;&nbsp;Utilisateurs";
echo "<table><tr><td>Utilisateurs disponibles<BR><SELECT align=top name=\"liste1\" size=6  style=\"width:150px\" id=\"liste1\">";
	$invite_query="select idutilisateur,nom,prenom from admin_svg.utilisateur where idcommune like'".substr($insee,0,3)."%' and nom is not null";
$mn2=$DB->tab_result($invite_query);
	for ($y2=0;$y2<count($mn2);$y2++)
		{
	 echo "<OPTION value=\"".$mn2[$y2]['idutilisateur']."\">".$mn2[$y2]['nom']." ".$mn2[$y2]['prenom']."</OPTION>";
		}
		
	echo "</SELECT>";
	echo "</TD><TD align=\"center\">";
	echo "<BR>";
	echo "<INPUT type=\"button\" value=\"Ajouter >>>\" onClick=\"Deplacer(this.form.liste1,this.form.liste2,'liste2')\" id=\"bouton2\">";
	
	//echo "<INPUT type=\"button\" value=\"&lt;&lt;&lt; Enlever\" onClick=\"Deplacer(this.form.liste2,this.form.liste1)\">";
	echo "</TD><TD>Utilisateurs associes<BR>";
	echo "<SELECT align=top name=\"liste2\" size=6 style=\"width:150px\" id=\"liste2\">";

//echo "<OPTION value="10">----------------------</OPTION>";
	echo "</SELECT></td></tr></table><br></div>";

echo "<input name=\"Ajouter\" type=\"button\" value=\"Ajouter\" onClick=\"document.getElementById('act').value='ajou';submit()\">";
}
if($_GET['obj_keys'])
{
echo "<input name=\"supp\" type=\"button\" value=\"supprimer\" onClick=\"document.getElementById('act').value='supp';submit()\"><input name=\"mod\" type=\"button\" value=\"modifier\" onClick=\"document.getElementById('act').value='mod';submit()\">";
}	
?>
<input type="hidden" id="a_instal" name="a_utilisateur" value="">
</form>
</body>
</html>
