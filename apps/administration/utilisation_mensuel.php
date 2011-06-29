<?php
define('GIS_ROOT', '../..');
include_once(GIS_ROOT . '/inc/common.php');
gis_init();

$insee = $_SESSION['profil']->insee;
$appli = $_SESSION['profil']->appli;

if ((!$_SESSION['profil']->acces_ssl) || !in_array ("administration", $_SESSION['profil']->liste_appli)){//
	die("Point d'entrée réglementé.<br> Accès interdit. <br>Veuillez vous connecter via <a href=\"https://".$_SERVER['HTTP_HOST']."\">serveur carto</a><SCRIPT language=javascript>setTimeout(\"window.location.replace('https://".$_SERVER['HTTP_HOST']."')\",5000)</SCRIPT>");
}
$mois=$_GET["mois"];
$sql="select (select sinul(nom||' '||prenom,login) from admin_svg.utilisateur as b where a.idutilisateur=b.idutilisateur::integer) as util,
	count(distinct sessionid) as nb_con,
	count(distinct page||query) as nb_page  
	from admin_svg.connexion as a
	where date_trunc('month',date_a)='".$mois."'
	group by a.idutilisateur 
	order by nb_con desc";
$rsql=$DB->tab_result($sql);
$sql1="select page,count(distinct page||query) as nb_page  
	from admin_svg.connexion as a
	where date_trunc('month',date_a)='".$mois."'
	group by page
	order by nb_page desc";
$rsql1=$DB->tab_result($sql1);
$sql2="select count(distinct sessionid) as nb_con,
	count(distinct page||query) as nb_page  
	from admin_svg.connexion as a
	where date_trunc('month',date_a)='".$mois."'
	group by date_trunc('day',date_a) 
	order by date_trunc('day',date_a)";
$rsql2=$DB->tab_result($sql2);
$sql3="select distinct(date_trunc('day',date_a)) as mois from admin_svg.connexion where date_trunc('month',date_a)='".$mois."'";
$rsql3=$DB->tab_result($sql3);
$sql4="select count(distinct sessionid) as max_nb_con,
	count(distinct page||query) as max_nb_page  
	from admin_svg.connexion as a
	where date_trunc('month',date_a)='".$mois."'
	group by date_trunc('day',date_a)";
$rsql4=$DB->tab_result($sql4);
for ($p=0;$p<count($rsql4);$p++){
	$max=max($max,$rsql4[$p]["max_nb_con"],$rsql4[$p]["max_nb_page"]);
}

echo "<html><TABLE width=\"600px\" align=\"center\" bgcolor=\"lightGray\"><tr><th align=\"center\">Utilisation du serveur SIG<br>&nbsp;</th></tr>
     <tr><td align=\"center\"><IMG src='./graphe.php?max=".$max."&rsql=".serialize($rsql2)."&rsql2=".serialize($rsql3)."&lg1=Nbre connexion&lg2=Nbre de page&col=31' align='center' border='0'></td></tr>";
echo "<tr><td align=\"center\">&nbsp;<br>Connexion mensuelle</td></tr>";
echo "<tr><td>";
echo "<table width='100%' border=1>";
echo "<tr><th></th><th>Nbre de connexion</th><th>Nbre de page</th></tr>";
for ($o=0;$o<count($rsql2);$o++){
	echo "<tr><td>".substr($rsql3[$o]["mois"],8,2)."</td><td align=\"center\">".$rsql2[$o]["nb_con"]."</td><td align=\"center\">".$rsql2[$o]["nb_page"]."</td></tr>";
}
echo "</table>";
echo "</td></tr>";
//utilisation des pages
$sql5="select page,count(distinct page||query) as nb_page  
	from admin_svg.connexion as a
	where date_trunc('month',date_a)='".$mois."'
	group by page
	order by nb_page desc limit 30";
$rsql5=$DB->tab_result($sql5);
echo "<tr><td>&nbsp;</td></tr>";
echo "<tr><td><TABLE align=\"center\" border=1>";
echo "         <tr><th>Page</th><th>Nbre d'utilisation</th></tr>";
for ($i=0;$i<count($rsql5);$i++){
	echo "<tr><td>".$rsql5[$i]["page"]."</td><td align=\"center\">".$rsql5[$i]["nb_page"]."</td></tr>";
}
echo "</TABLE></td></tr>";
echo "<tr><td>&nbsp;</td></tr>";
echo "<tr><td>";
echo "<TABLE align=\"center\" border=1>";
echo "  <tr><th>Utilisateur</th><th>Nbre de connexions</th><th>Nbre de pages</th></tr>";
for ($p=0;$p<count($rsql);$p++){  
  echo "<tr><td>".$rsql[$p]["util"]."</td><td>".$rsql[$p]["nb_con"]."</td><td>".$rsql[$p]["nb_page"]."</td></tr>";
}
echo "</TABLE></td></tr>";
echo "</TABLE></html>";
?>
