<?php
define('GIS_ROOT', '../..');
include_once(GIS_ROOT . '/inc/common.php');
gis_init();

$insee = $_SESSION['profil']->insee;
$appli = $_SESSION['profil']->appli;

if ((!$_SESSION['profil']->acces_ssl) || !in_array ("administration", $_SESSION['profil']->liste_appli)){//
	die("Point d'entrée réglementé.<br> Accès interdit. <br>Veuillez vous connecter via <a href=\"https://".$_SERVER['HTTP_HOST']."\">serveur carto</a><SCRIPT language=javascript>setTimeout(\"window.location.replace('https://".$_SERVER['HTTP_HOST']."')\",5000)</SCRIPT>");
}
$sql="select count(distinct sessionid) as nb_con,
	count(distinct page||query) as nb_page  
	from admin_svg.connexion as a
	where date_trunc('month',date_a)>date_trunc('month',now())-interval '12 month'
	group by date_trunc('month',date_a) 
	order by date_trunc('month',date_a)";
$rsql=$DB->tab_result($sql);
$sql1="select count(distinct sessionid) as max_nb_con,
	count(distinct page||query) as max_nb_page  
	from admin_svg.connexion as a
	group by date_trunc('month',date_a)";
$rsql1=$DB->tab_result($sql1);
//$sql2="select distinct(lpad(EXTRACT(MONTH FROM date_a)::text,2,'0')) as mois from admin_svg.connexion";
$sql2="select distinct(date_trunc('month',date_a)) as mois from admin_svg.connexion 
	where date_trunc('month',date_a)>date_trunc('month',now())-interval '12 month'";
$rsql2=$DB->tab_result($sql2);
for ($p=0;$p<count($rsql1);$p++){
$max=max($max,$rsql1[$p]["max_nb_con"],$rsql1[$p]["max_nb_page"]);
}
//echo "<html><br><IMG src='".graphe($max,$rsql,$rsql2,"Nbre connexion","Nbre de page")."' align='left' border='1'>";
echo "<html><TABLE width=\"600px\" align=\"center\" bgcolor=\"lightGray\"><tr><th align=\"center\">Utilisation du serveur SIG<br>&nbsp;</th></tr>
     <tr><td align=\"center\"><IMG src='./graphe.php?max=".$max."&rsql=".serialize($rsql)."&rsql2=".serialize($rsql2)."&lg1=Nbre connexion&lg2=Nbre de page&col=12' align='center' border='0'></td></tr>";
echo "<tr><td align=\"center\">&nbsp;<br>Connexion mensuelle</td></tr>";
echo "<tr><td>";
echo "<table width='100%' border=1>";
echo "<tr><th></th><th>Nbre de connexion</th><th>Nbre de page</th></tr>";
for ($o=0;$o<count($rsql1);$o++){
	echo "<tr><td><a href='./utilisation_mensuel.php?mois=".$rsql2[$o]["mois"]."'>".moix(substr($rsql2[$o]["mois"],5,2))."</a></td><td align=\"center\">".$rsql[$o]["nb_con"]."</td><td align=\"center\">".$rsql[$o]["nb_page"]."</td></tr>";
	$conn_tot=$conn_tot+$rsql[$o]["nb_con"];
	$page_tot=$page_tot+$rsql[$o]["nb_page"];
}
echo "<tr><td>Totaux</td><td>$conn_tot</td><td>$page_tot</td></tr>";
echo "</table>";
echo "</td></tr>";
echo "</TABLE></html>";
?>
