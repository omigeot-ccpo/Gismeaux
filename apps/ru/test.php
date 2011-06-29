<?php
define('GIS_ROOT', '../..');
include_once(GIS_ROOT . '/inc/common.php');
$renforcer="deco.png";

$toto= "SELECT a.identifian,area(intersection(Transform(a.the_geom,$projection),Transform(b.the_geom,$projection))) as aire FROM cadastre.parcelle as a ,urba.pnrqad as b  where ((a.identifian='284000BI0707' and
Intersects(Transform(a.the_geom,310024149),Transform(b.the_geom,310024149))) or (a.identifian='284000BI0696'
and Intersects(Transform(a.the_geom,310024149),Transform(b.the_geom,310024149)))) and b.gid=1 ";
$result = $DB->tab_result($toto);
for ($i=0; $i<count($result); $i++){
	echo $result[$i]['identifian']."&".$result[$i]['aire']."< br>";
	if($result[$i]['aire']!=0)
	{
	$renforcer="okcoche.png";
	echo $renforcer;
	}	
}

?>