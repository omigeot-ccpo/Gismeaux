<?php

define('GIS_ROOT', '.');
include_once(GIS_ROOT . '/inc/common.php');
gis_session_start();

if (!$_SESSION['profil']) {
	echo "No session, need to relog";
} else {
	echo "Session Ok, should work";
	var_dump($_SESSION['profil']);
}
die();

?>
