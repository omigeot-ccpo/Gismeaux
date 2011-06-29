<?php
session_start();
$_SESSION['rewriting']='true';
$_SESSION['com']=$_GET['commune'];
$_SESSION['app']=$_GET['appli'];
header('Location: http://www.pays.meaux.fr');
?>