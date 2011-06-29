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
?>
<html>
<head>
<title>Insertion des fichiers cadastre</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="cadastre.css" rel="stylesheet" type="text/css">
</head>

<body>
<form action="../cadastre/test.php" method="post">
<center>Année de la base &nbsp;<input name="ann_ref" type="text" value="2000" maxlength="4"><br>
Traitement pour la commune de <input name="nom_comm" type="text" maxlength="50"></center>
<br><br>
<center>
	<table>
		<tr>
			<td>Fichier non batie</td>
			<td><input name="nbat" type="text" size="50" maxlength="100"></td>
		</tr>
  		<tr>
			<td>Fichier batie</td>
			<td><input name="bat" type="text" size="50" maxlength="100"></td>
		</tr>
  		<tr>
			<td>Fichier proprietaire</td>
			<td><input name="prop" type="text" size="50" maxlength="100"></td>
		</tr>
  		<tr>
			<td>Fichier PdL</td>
			<td><input name="pdl" type="hidden" size="50" maxlength="100"></td>
		</tr>
  		<tr>
			<td>Fichier Fantoir</td>
			<td><input name="fant" type="text" size="50" maxlength="100"></td>
		</tr>
  		<tr>
			<td>Fichier des erreurs</td>
			<td><input name="ferr" type="text" size="50" maxlength="100"></td>
		</tr>
	</table>
</center>
<br>
Création de la base pour (l'utilisateur doit avoir les droits d'administrations)<br>
<center>
	<table>
		<tr>
			<td><input name="vmysql" type="checkbox" value="mysql">&nbsp;MySQL&nbsp;</td>
			<td>Nom de la Bd&nbsp;<input name="bdmysql" type="text"></td>
			<td>Utilisateur&nbsp;<input name="umysql" type="text"></td>
			<td>Mot de passe&nbsp;<input name="pswmysql" type="text"></td>
		</tr>
		<tr>
			<td><input name="voracle" type="checkbox" value="oracle">&nbsp;ORACLE&nbsp;</td>
			<td>Nom de la Bd&nbsp;<input name="bdoracle" type="text"></td>
			<td>Utilisateur&nbsp;<input name="uoracle" type="text"></td>
			<td>Mot de passe&nbsp;<input name="psworacle" type="text"></td>
		</tr>
		<tr>
			<td><input name="vpg" type="checkbox" value="pgsql" checked>&nbsp;Postgresql&nbsp;</td>
			<td>Nom de la Bd&nbsp;<input name="bdpg" type="text"></td>
			<td>Utilisateur&nbsp;<input name="upg" type="text"></td>
			<td>Mot de passe&nbsp;<input name="pswpg" type="text"></td>
		</tr>
		<tr>
			<td><input name="nvl" type="radio" value="O" checked>&nbsp;Nouvelle&nbsp;</td>
			<td><input name="nvl" type="radio" value="N">&nbsp;Mise à jour&nbsp;</td>
			<td>Répertoire des fichiers<input name="rep_f" type="text"></td>
			<td>Extension des fichiers<input name="ext_f" type="text"></td>
		</tr>
	</table>
</center>
<br><br>
<center><input name="submit" type="submit" value="Lancer l'insertion"></center>
</form>
</body>
</html>
