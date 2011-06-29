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

$insee = $_SESSION['profil']->insee;
$appli = $_SESSION['profil']->appli;

if ((!$_SESSION['profil']->acces_ssl) || !in_array ("Cadastre", $_SESSION['profil']->liste_appli)){
	die("Point d'entr�e r�glement�.<br> Acc�s interdit. <br>Veuillez vous connecter via <a href=\"https://".$_SERVER['HTTP_HOST']."\">serveur carto</a><SCRIPT language=javascript>setTimeout(\"window.location.replace('https://".$_SERVER['HTTP_HOST']."')\",5000)</SCRIPT>");
}
if ($_SESSION["profil"]->droit=='AD'){
//include("../connexion/deb.php");
if ($_GET["act"]=="sup"){
	$guer="delete from admin_svg.apputi where idutilisateur='".$_GET["ide"]."'";
	$DB->tab_result($guer);
	$quer="delete from admin_svg.utilisateur where idutilisateur='".$_GET["ide"]."'";
	$DB->tab_result($quer);
}elseif ($_GET["act"]=="ins"){
	$quer="insert into admin_svg.utilisateur (idutilisateur,login,psw,droit,idcommune,nom,prenom,email)
 values(nextval('admin_svg.util'),'".$_GET["log"]."','".$_GET["psw"]."','".$_GET["droitu"]."','".$_GET["commune"]."',".ivar($_GET["nomu"]).",".ivar($_GET["prenomu"]).",".ivar($_GET["emailu"]).")";
	$DB->tab_result($quer);
}elseif ($_GET["act"]=="mod"){
		$quer="update admin_svg.utilisateur set login='".$_GET["log"]."', psw='".$_GET["psw"]."', droit='".$_GET["droitu"]."', idcommune='".$_GET["commune"]."' where idutilisateur='".$_GET["ide"]."'";

	$DB->tab_result($quer);
}elseif ($_GET["act"]=="mail"){
    $headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= "From:".$adresse_admin. "\r\n";
    for ($p=0;$p<count($_GET["email"]);$p++){
       $sql="select * from admin_svg.utilisateur where idutilisateur='".$_GET["email"][$p]."'";
       $rsql=$DB->tab_result($sql);
    $corps="<CENTER>
<P><IMG id=ridImg height=102 src='http://www.pays.meaux.fr/logo/770284.png' width=355 align=middle>
</P></CENTER>
<P><FONT size=5><STRONG>Direction de l'urbanisme et du d�veloppement durable</STRONG></FONT></P>
<P>Syst�me d'informations g�ographique </P>
<P>&nbsp;</P>
<P>Veuillez trouver ci-joint les informations n�cessaires pour votre connexion au SIG</P>
<P>&nbsp;</P>
<P>adresse : https://www.pays.meaux.fr/    </P>
<P>login : ".$rsql[0]["login"]."     </P>
<P>mot de passe :  ".$rsql[0]["psw"]."   </P>
";
	   mail($rsql[0]["email"],"Acc�s SIG","<html><body>".$corps."</body></html>",$headers);
    }
}
if ($_SESSION["profil"]->user=='sig1'){
   $gg=$DB->tab_result("select * from admin_svg.utilisateur order by login");
	$list_commune=$DB->tab_result("select idcommune,nom from admin_svg.commune order by nom");
}else{
   $gg=$DB->tab_result("select * from admin_svg.utilisateur where idcommune like '".substr($insee,0,3)."%' order by login");
	$list_commune=$DB->tab_result("select idcommune,nom from admin_svg.commune where idagglo like '".substr($insee,0,3)."%' order by nom");
}
//$num=pg_num_rows($tab);
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Administration</title>
<script language="JavaScript" type="text/JavaScript">
function neo_util(){
	document.f1.act.value='ins';
	document.getElementById("Layer1").style.visibility = "visible";
}
function neo_aba(){
	document.getElementById("Layer1").style.visibility = "hidden";
}
function getRandomNum(lbound, ubound) {
    return (Math.floor(Math.random() * (ubound - lbound)) + lbound);
}
function getRandomChar(number, lower, upper, other, extra) {
    var numberChars = "0123456789";
    var lowerChars = "abcdefghjkmnopqrstuvwxyz";
    var upperChars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    var otherChars = "`~!@#$%^&*()-_=+[{]}\\|;:'\",<.>/? ";
    var charSet = extra;
    if (number == true)
        charSet += numberChars;
    if (lower == true)
        charSet += lowerChars;
    if (upper == true)
        charSet += upperChars;
    if (other == true)
        charSet += otherChars;
    return charSet.charAt(getRandomNum(0, charSet.length));
}
function getPassword(length, extraChars, firstNumber, firstLower, firstUpper, firstOther,
    latterNumber, latterLower, latterUpper, latterOther) {
    var rc = "";
    if (length > 0)
        rc = rc + getRandomChar(firstNumber, firstLower, firstUpper, firstOther, extraChars);
    for (var idx = 1; idx < length; ++idx) {
        rc = rc + getRandomChar(latterNumber, latterLower, latterUpper, latterOther, extraChars);
    }
    return rc;
}
</script>
<style type="text/css">
<!--
.layer1 {
	font-family: Arial, Helvetica, sans-serif; position:absolute;
	left:151px;	top:40px; width:269px; height:229px;
	visibility:hidden; z-index:1; background-color: #FFCC99;
}
-->
</style>
</head>

<body>
<form action="utilisateur.php" method="get" name="f1">
<input name="cre_util" type="button" onClick="neo_util()" value="Nouveau">
<input name="mail" type="button" onClick="document.f1.act.value='mail';submit();" value="Email">
<input name="act" type="hidden" value=""><input name="ide" type="hidden" value="">
<div id="Layer1" class="layer1" >
	<table><tr><td>Login</td><td><input name="log" type="text"></td></tr>
	<tr><td>Mot de passe</td><td><input name="psw" type="text">&nbsp<input type=button value="..." onclick="psw.value=getPassword(8, false, true, true, true, false,
true, true, true, false);"></td></tr>
	<tr><td>Commune</td>
	<!---<td><input name="commune" type="text"></td>--->
	<td><select name="commune">
<?php for ($o=0; $o<count($list_commune); $o++){
	//$lcom[$o]=pg_fetch_array($list_commune,$o);
	echo "<option value=".$list_commune[$o]['idcommune'].">".$list_commune[$o]['nom']."</option>";
}?>
	</select></td>
	</tr>
    <tr><td>Droit</td><td><input name="droitu" type="text"></td></tr>
    <tr><td>Nom</td><td><input name="nomu" type="text"></td></tr>
    <tr><td>Pr�nom</td><td><input name="prenomu" type="text"></td></tr>
    <tr><td>Email</td><td><input name="emailu" type="text"></td></tr>
    </table>
	<input name="ins_util" type="button" value="Ins�rer" onclick="document.f1.submit();">
	<input name="anu_util" type="button" value="Annuler" onclick="neo_aba()">
</div>
<table width="200" height="15" border="1">
  <tr>
    <th scope="col">Identifiant</th>
    <th scope="col">Login</th>
    <th scope="col">Commune</th>
    <th scope="col">Droit</th>
    <th scope="col">&nbsp;</th>
    <th scope="col">&nbsp;</th>
    <th scope="col">&nbsp;</th>
    <th scope="col">&nbsp;</th>
    <th scope="col">&nbsp;</th><!---séparateur vertical --->
    <th scope="col">Identifiant</th>
    <th scope="col">Login</th>
    <th scope="col">Commune</th>
    <th scope="col">Droit</th>
    <th scope="col">&nbsp;</th>
    <th scope="col">&nbsp;</th>
    <th scope="col">&nbsp;</th>
    <th scope="col">&nbsp;</th>
    <th scope="col">&nbsp;</th><!---séparateur vertical --->
    <th scope="col">Identifiant</th>
    <th scope="col">Login</th>
    <th scope="col">Commune</th>
    <th scope="col">Droit</th>
    <th scope="col">&nbsp;</th>
    <th scope="col">&nbsp;</th>
    <th scope="col">&nbsp;</th>
    <th scope="col">&nbsp;</th>
  </tr>
<?php for ($i=0; $i<count($gg); $i=$i+3){
$nh++;
$vh=40+($nh*27);
//$gg[$i]=pg_fetch_array($tab,$i);?>
  <tr>
    <td><?php echo $gg[$i]['idutilisateur']; ?></td>
    <td><?php echo $gg[$i]['login']; ?></td>
    <td><?php echo $gg[$i]['idcommune']; ?></td>
    <td><?php echo $gg[$i]['droit']; ?></td>
    <td><?php echo '<input name="mod_util" type="button" onclick="ide.value=\''.$gg[$i]['idutilisateur'].'\';log.value=\''.$gg[$i]['login'].'\';droitu.value=\''.$gg[$i]['droit'].'\';commune.value=\''.$gg[$i]['idcommune'].'\';act.value=\'mod\';document.getElementById(\'Layer1\').style.top = \''.$vh.'\' ;document.getElementById(\'Layer1\').style.visibility = \'visible\';" value="Modifier">'; ?></td>
    <td><?php echo '<input name="sup_util" type="button" onclick="act.value=\'sup\';ide.value=\''.$gg[$i]['idutilisateur'].'\';document.f1.submit();" value="Supprimer">'; ?></td>
    <td><?php echo '<input name="aut_util" type="button" onclick="window.open(\'application.php?ident='.$gg[$i]['idutilisateur'].'\')" value="Autoriser">'; ?></td>
    <td><?php if ($gg[$i]['email']!=''){echo '<input type="checkbox" name="email[]" value="'.$gg[$i]['idutilisateur'].'">';}?></td>
    <td>&nbsp;</td>
    <td><?php echo $gg[$i+1]['idutilisateur']; ?></td>
    <td><?php echo $gg[$i+1]['login']; ?></td>
    <td><?php echo $gg[$i+1]['idcommune']; ?></td>
    <td><?php echo $gg[$i+1]['droit']; ?></td>
    <td><?php echo '<input name="mod_util" type="button" onclick="ide.value=\''.$gg[$i+1]['idutilisateur'].'\';log.value=\''.$gg[$i+1]['login'].'\';droitu.value=\''.$gg[$i+1]['droit'].'\';commune.value=\''.$gg[$i+1]['idcommune'].'\';act.value=\'mod\';document.getElementById(\'Layer1\').style.top = \''.$vh.'\' ;document.getElementById(\'Layer1\').style.visibility = \'visible\';" value="Modifier">'; ?></td>
    <td><?php echo '<input name="sup_util" type="button" onclick="act.value=\'sup\';ide.value=\''.$gg[$i+1]['idutilisateur'].'\';document.f1.submit();" value="Supprimer">'; ?></td>
    <td><?php echo '<input name="aut_util" type="button" onclick="window.open(\'application.php?ident='.$gg[$i+1]['idutilisateur'].'\')" value="Autoriser">'; ?></td>
    <td><?php if ($gg[$i+1]['email']!=''){echo '<input type="checkbox" name="email[]" value="'.$gg[$i+1]['idutilisateur'].'">';}?></td>
    <td>&nbsp;</td>
    <td><?php echo $gg[$i+2]['idutilisateur']; ?></td>
    <td><?php echo $gg[$i+2]['login']; ?></td>
    <td><?php echo $gg[$i+2]['idcommune']; ?></td>
    <td><?php echo $gg[$i+2]['droit']; ?></td>
    <td><?php echo '<input name="mod_util" type="button" onclick="ide.value=\''.$gg[$i+2]['idutilisateur'].'\';log.value=\''.$gg[$i+2]['login'].'\';droitu.value=\''.$gg[$i+2]['droit'].'\';commune.value=\''.$gg[$i+2]['idcommune'].'\';act.value=\'mod\';document.getElementById(\'Layer1\').style.top = \''.$vh.'\' ;document.getElementById(\'Layer1\').style.visibility = \'visible\';" value="Modifier">'; ?></td>
    <td><?php echo '<input name="sup_util" type="button" onclick="act.value=\'sup\';ide.value=\''.$gg[$i+2]['idutilisateur'].'\';document.f1.submit();" value="Supprimer">'; ?></td>
    <td><?php echo '<input name="aut_util" type="button" onclick="window.open(\'application.php?ident='.$gg[$i+2]['idutilisateur'].'\')" value="Autoriser">'; ?></td>
    <td><?php if ($gg[$i+2]['email']!=''){echo '<input type="checkbox" name="email[]" value="'.$gg[$i+2]['idutilisateur'].'">';}?></td>
<?php }
 ?>
</table>
</form>

</body>
</html>
<?php }
 ?>
