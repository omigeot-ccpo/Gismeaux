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
?>

<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Cartographie - Contactez-nous...</title>
</head>

<body bgcolor='#FFFFFF' LIEN='ORANGE' VLIEN='RED'>

<CENTER><table border="0" cellpadding="0" cellspacing="0">

<?php

//include("../../connexion/deb.php");
$sql="insert into admin_svg.incident (date_entrer,email,incident) values('".date("d").'/'.date("m").'/'.date("Y")."','".$_POST['EMAIL']."','".$_POST['REMARQUE']."')";
$DB->exec($sql);
print("<tr>
	<td colspan='2'><P><IMG SRC=\"../../logo/headmail.PNG\" WIDTH=\"620\" HEIGHT=\"40\"></P></td></tr>");
print("<tr>
	<td colspan='2'>&nbsp;</td></tr>");

print("<tr>
	<td WIDTH=\"30%\"><IMG SRC='../../logo/etoile2.JPG'></td>\n");

require_once("./phpmailer/class.phpmailer.php");	// ajout de la classe phpmailer
	//require_once($path_to_racine."INCLUDE.PHP/fonction.php");			// pour la cnx à la base de données
	//include("../config.php");						// pour les paramètres généraux...

	// init du mail
	$mail = new PHPMailer();
	if($config_serveur_smtp=="")
		$mail->IsMail();
	else
	{
		$mail->IsSMTP();
		$mail->Host = $config_serveur_smtp;
	}
	
	// initialisation du langage utilisé par php_mailer
	$mail->SetLanguage("fr", "./phpmailer/language/");
	
	$mail->FromName = "Serveur cartographique";
	$mail->From = $EMAIL;     
	$adresse_mail=explode(";",$adresse_admin);
	for($i=0;$i<count($adresse_mail);$i++)
	{
	$mail->AddAddress($adresse_mail[$i]);
	}
	//$mail->AddAddress("jean-luc.dechamp@meaux.fr");
	//$mail->AddAddress("robert.leguay@meaux.fr");	
	// construction du corps du mail
	$mail->Subject  =  $config_mail_sujet;
	$mail->Body     =  $mail->From." ".$config_mail_contenu;
	if(!$mail->Send())
	{
		echo "erreur de messagerie: " . $mail->ErrorInfo;
	}
else
{
print("<td WIDTH=\"70%\">Votre message a &eacute;t&eacute; correctement envoy&eacute;</td></tr>");
	   }
print("<tr><td colspan='2' align=\"center\"><input name=\"Fermer\" value=\"Fermer\" type=\"button\" onClick=\"window.close()\"></td></tr>");	   
?>

</table></CENTER>

</body>
</html>