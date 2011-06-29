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
//$config_serveur_smtp="smtp.mydomain" ;
//phpinfo();
//echo $_SERVER["DOCUMENT_ROOT"];
//$db_params = "dbname=".$_GET["bd"]." host=".$_GET["serv"]." user=".$_GET["ident"]." password=".$_GET["psw"];
//echo $db_params;
if($_GET["bd"]!="")
	 {
$co=pg_connect("dbname=".$_GET["bd"]." host=".$_GET["serv"]." user=".$_GET["ident"]." password=".$_GET["psw"]);
$stat = pg_connection_status($co);
  if ($stat === PGSQL_CONNECTION_OK) {
  $test="ok";
  $filename = "./config.php";
$myFile = fopen($filename, "w");
fputs($myFile, "<?php
/*Copyright Ville de Meaux 2004-2007
contributeur: jean-luc Dechamp - robert Leguay 
sig@meaux.fr

Ce logiciel est un programme informatique fournissant une interface cartographique WEB communale. 

Ce logiciel est r�gi par la licence CeCILL-C soumise au droit fran�ais et
respectant les principes de diffusion des logiciels libres. Vous pouvez
utiliser, modifier et/ou redistribuer ce programme sous les conditions
de la licence CeCILL-C telle que diffus�e par le CEA, le CNRS et l'INRIA 
sur le site \"http://www.cecill.info\".

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
termes.*/\n");
fputs($myFile, "\$db_name=\"".$_GET["bd"]."\" ;\n");
fputs($myFile, "\$db_host=\"".$_GET["serv"]."\" ;\n");
fputs($myFile, "\$db_user=\"".$_GET["ident"]."\" ;\n");
fputs($myFile, "\$db_passwd=\"".$_GET["psw"]."\" ;\n");
fputs($myFile, "\$ms_dbg_line = 0 ;\n");
fputs($myFile, "\$config_serveur_smtp=\"".$_GET["smtp"]."\" ;\n");
fputs($myFile, "\$adresse_admin=\"".$_GET["email"]."\" ;\n");
fputs($myFile, "\$config_mail_sujet=\"- Probl�me interface -\" ;\n");
fputs($myFile, "\$config_mail_contenu=\" a rencontr� un probl�me avec l'interface cartographique.

Merci de consulter la base d'administration

-------------------------------------------------------------------------------------------------------
Ceci est un message automatique.\" ;\n");
fputs($myFile, "?>");
fclose($myFile);
    // echo 'Test de connexion ok';
  } else {
  $test="echec";
      
  } 
  }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Document sans nom</title>
<style type="text/css">
<!--
.Style4 {color: #000099}
.Style5 {font-size: x-small}
.Style6 {font-size: small}
-->
</style>
</head>

<body>

   
  <div align="center">
     <p><img src="./headsetup.JPG" width="650" height="43" />     </p>
     
     <?php
	 if($_GET["bd"]=="" || $test=="echec")
	 {
	 if($test=="echec")
	 {
	 echo 'Test de connexion erreur';
	 }
	 else
	 {
	 echo "<p>&nbsp; </p>";
	 }
	 ?>
	 <form id="form1" name="form1" method="get" action="./install.php">
	 <table width="352" border="0" cellspacing="2" cellpadding="0">
      <tr>
        <td width="195"><div align="center"> 
          <span class="Style4">Adresse IP du serveur SMTP</span> <span class="Style5">(laisser vide si pas de serveur SMTP)</span>
          </div></td>
        <td width="151" valign="top"><input name="smtp" type="text" id="smtp" value="<?php echo $_GET["smtp"];?>"/></td>
      </tr>
      
      <tr>
        <td width="195"><div align="center"><span class="Style4">Adresse Email administrateur(s)</span> <span class="Style6">(xxx@yyy.fr;www@zzzz.com)</span> </div></td>
        <td width="151" valign="top"><input name="email" type="text" id="email" value="<?php echo $_GET["email"];?>"/></td>
      </tr>
     
      <tr>
        <td width="195"><div align="center" class="Style4">Base de donn&eacute;e </div></td>
        <td width="151"><input name="bd" type="text" id="bd" value="<?php echo $_GET["bd"];?>"/></td>
      </tr>
      <tr>
        <td><div align="center"><span class="Style4">Serveur</span> (localhost par d&eacute;faut) </div></td>
        <td><input name="serv" type="text" id="serv" value="<?php echo $_GET["serv"];?>"/></td>
      </tr>
      <tr>
        <td><div align="center"><span class="Style4">Identifiant</span></div></td>
        <td><input name="ident" type="text" id="ident" value="<?php echo $_GET["ident"];?>"/></td>
      </tr>
      <tr>
        <td><div align="center" class="Style4">Password</div></td>
        <td><input name="psw" type="text" id="psw" value="<?php echo $_GET["psw"];?>"/></td>
      </tr>
    </table>
    
     <p>
       <input type="submit" name="Submit" value="valider" />
    </p>
  </div>
</form>
<?php
}
else
{
echo 'configuration termin&eacute;e';
}
?>
</body>
</html>