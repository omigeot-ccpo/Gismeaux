<?php
class DB extends DBpg {
var $db_host    = "localhost";
var $db_user    = "sig";
var $db_passwd  = "sig";
var $db_name    = "sig";
}
$projection="3949";
$maj="2010";//annee mise a jour cadastre
$config_serveur_smtp="127.0.0.1" ;
$adresse_admin="sig@meaux.fr";
$config_mail_sujet="- Probleme interface -" ;
$config_mail_contenu=" a rencontre un probleme avec l'interface cartographique.
		Merci de consulter la base d'administration
		
		-------------------------------------------------------------------------------------------------------
		Ceci est un message automatique." ;
?>
