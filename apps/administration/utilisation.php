<?php
define('GIS_ROOT', '../..');
include_once(GIS_ROOT . '/inc/common.php');
gis_init();

$insee = $_SESSION['profil']->insee;
$appli = $_SESSION['profil']->appli;

if ((!$_SESSION['profil']->acces_ssl) || !in_array ("administration", $_SESSION['profil']->liste_appli)){//
	die("Point d'entrée réglementé.<br> Accès interdit. <br>Veuillez vous connecter via <a href=\"https://".$_SERVER['HTTP_HOST']."\">serveur carto</a><SCRIPT language=javascript>setTimeout(\"window.location.replace('https://".$_SERVER['HTTP_HOST']."')\",5000)</SCRIPT>");
}
$sql="select (select sinul(nom||' '||prenom,login) from admin_svg.utilisateur as b where a.idutilisateur=b.idutilisateur::integer) as util,
	count(distinct sessionid) as nb_con,
	count(distinct page||query) as nb_page  
from admin_svg.connexion as a
where date_trunc('month',date_a)=date_trunc('month',current_date)
group by a.idutilisateur 
order by nb_con desc";
$rsql=$DB->tab_result($sql);
$sql1="select page,count(distinct page||query) as nb_page  
from admin_svg.connexion as a
group by page
order by nb_page desc";
$rsql1=$DB->tab_result($sql1);

?>
<TABLE border="1">
  <tr><td>utilisateur</td><td>nombre de connexions</td><td>Nombre de page</td></tr>
 <?php 
  for ($p=0;$p<count($rsql);$p++){
  echo "<tr><td>".$rsql[$p]["util"]."</td><td>".$rsql[$p]["nb_con"]."</td><td>".$rsql[$p]["nb_page"]."</td></tr>";
  }
 ?>
</TABLE>