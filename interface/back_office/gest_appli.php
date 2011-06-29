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
if($_GET["gestion"]=="creation")
{
$req=stripslashes($_GET["requete"]);
$req=str_replace("c(plus)","+",$req);
$req=str_replace("c(2p)",":",$req);
$DB->exec($req);

$d="insert into admin_svg.apputi(idapplication,idutilisateur,droit,ordre) values (currval('admin_svg.appli')::character varying,'".$_SESSION['profil']->idutilisateur."','a',(select max(ordre)+1 from admin_svg.apputi where idutilisateur='".$_SESSION['profil']->idutilisateur."'))";
$DB->exec($d);
$ecri="";
$appl="select apputi.idapplication,application.type_appli,application.url,application.libelle_appli from admin_svg.apputi inner join admin_svg.application on admin_svg.apputi.idapplication=admin_svg.application.idapplication  where apputi.idutilisateur='".$_SESSION['profil']->idutilisateur."' order by application.type_appli asc";

$mn=$DB->tab_result($appl);
for ($c=0;$c<count($mn);$c++)
{

if($mn[$c]['idapplication']==$_SESSION["profil"]->appli && $mn[$c]['type_appli']!=1)
  {
  $ecri.= "<option value=\"".$mn[$c]['idapplication']."|".$mn[$c]['type_appli']."|".$mn[$c]['url']."\" selected>".$mn[$c]['libelle_appli']."</option>#";
   }
 else
  {
   $ecri.= "<option value=\"".$mn[$c]['idapplication']."|".$mn[$c]['type_appli']."|".$mn[$c]['url']."\" >".$mn[$c]['libelle_appli']."</option>#";
  }
}
echo substr($ecri,0,-1);
}
elseif($_GET["gestion"]=="appel")
{
$req=stripslashes($_GET["requete"]);
$req=str_replace("c(plus)","+",$req);
$req=str_replace("c(2p)",":",$req);
$mn=$DB->tab_result($req);
echo $mn[0]['idapplication']."|".$mn[0]['type_appli']."|".$mn[0]['url']."|".$mn[0]['libelle_appli']."|".$mn[0]['zoom_ouverture']."|".$mn[0]['zoom_min']."|".$mn[0]['zoom_max']."|".$mn[0]['btn_polygo']."|".$mn[0]['libelle_btn_polygo'];

}
elseif($_GET["gestion"]=="mod")
{
$req=stripslashes($_GET["requete"]);
$req=str_replace("c(plus)","+",$req);
$req=str_replace("c(2p)",":",$req);
$DB->exec($req);
}

elseif($_GET["gestion"]=="supp")
{
$sql1="delete from admin_svg.appthe where idapplication='".$_GET["idappli"]."'";

$DB->exec($sql1);
$sql2="delete from admin_svg.apputi where idapplication='".$_GET["idappli"]."'";

$DB->exec($sql2);
$sql3="delete from admin_svg.application where idapplication='".$_GET["idappli"]."'";

$DB->exec($sql3);

	if($_SESSION["profil"]->appli != $_GET["idappli"])
	{
	$ecri1="";
	$app="select apputi.idapplication,application.type_appli,application.url,application.libelle_appli from admin_svg.apputi inner join admin_svg.application on admin_svg.apputi.idapplication=admin_svg.application.idapplication  where apputi.idutilisateur='".$_SESSION['profil']->idutilisateur."' order by application.type_appli asc";
	$mn1=$DB->tab_result($app);
		for ($c=0;$c<count($mn1);$c++)
			{

				if($mn1[$c]['idapplication']==$_SESSION["profil"]->appli && $mn1[$c]['type_appli']!=1)
  					{
  					$ecri1.= "<option value=\"".$mn1[$c]['idapplication']."|".$mn1[$c]['type_appli']."|".$mn1[$c]['url']."\" selected>".$mn1[$c]['libelle_appli']."</option>#";
   					}
				 else
  					{
  					 $ecri1.= "<option value=\"".$mn1[$c]['idapplication']."|".$mn1[$c]['type_appli']."|".$mn1[$c]['url']."\" >".$mn1[$c]['libelle_appli']."</option>#";
  					}
			}
	echo substr($ecri1,0,-1);
	}
	else
	{
	echo "reboot#".$mn1[0]['idapplication'];
	}

}
?>
