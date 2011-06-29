<?php
/*Copyright Ville de Meaux 2004-2007
contributeur: jean-luc Dechamp - robert Leguay 
sig@meaux.fr

Ce logiciel est un programme informatique fournissant une interface cartographique WEB communale. 

Ce logiciel est r�gi par la licence CeCILL-C soumise au droit fran�ais et
respectant les principes de diffusion des logiciels libres. Vous pouvez
utiliser, modifier et/ou redistribuer ce programme sous les conditions
de la licence CeCILL-C telle que diffus�e par le CEA, le CNRS et l'INRIA 
sur le site "http://www.cecill.info".

En contrepartie de l'accessibilit� au code source et des droits de copie,
de modification et de redistribution accord�s par cette licence, il n'est
offert aux utilisateurs qu'une garantie limit�e.  Pour les m�mes raisons,
seule une responsabilit� restreinte p�se sur l'auteur du programme,  le
titulaire des droits patrimoniaux et les conc�dants successifs.

A cet �gard  l'attention de l'utilisateur est attir�e sur les risques
associ�s au chargement,  � l'utilisation,  � la modification et/ou au
d�veloppement et � la reproduction du logiciel par l'utilisateur �tant 
donn� sa sp�cificit� de logiciel libre, qui peut le rendre complexe � 
manipuler et qui le r�serve donc � des d�veloppeurs et des professionnels
avertis poss�dant  des connaissances  informatiques approfondies.  Les
utilisateurs sont donc invit�s � charger  et  tester  l'ad�quation  du
logiciel � leurs besoins dans des conditions permettant d'assurer la
s�curit� de leurs syst�mes et ou de leurs donn�es et, plus g�n�ralement, 
� l'utiliser et l'exploiter dans les m�mes conditions de s�curit�. 

Le fait que vous puissiez acc�der � cet en-t�te signifie que vous avez 
pris connaissance de la licence CeCILL-C, et que vous en avez accept� les 
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
	//require_once($path_to_racine."INCLUDE.PHP/fonction.php");			// pour la cnx � la base de donn�es
	//include("../config.php");						// pour les param�tres g�n�raux...

	// init du mail
	$mail = new PHPMailer();
	if($config_serveur_smtp=="")
		$mail->IsMail();
	else
	{
		$mail->IsSMTP();
		$mail->Host = $config_serveur_smtp;
	}
	
	// initialisation du langage utilis� par php_mailer
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