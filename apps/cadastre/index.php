<?php 
/*Copyright Ville de Meaux 2004-2007
contributeur: jean-luc Dechamp - robert Leguay 
sig@meaux.fr

Ce logiciel est un programme informatique fournissant une interface cartographique WEB communale. 

Ce logiciel est r?gi par la licence CeCILL-C soumise au droit fran?ais et
respectant les principes de diffusion des logiciels libres. Vous pouvez
utiliser, modifier et/ou redistribuer ce programme sous les conditions
de la licence CeCILL-C telle que diffus?e par le CEA, le CNRS et l'INRIA 
sur le site "http://www.cecill.info".

En contrepartie de l'accessibilit? au code source et des droits de copie,
de modification et de redistribution accord?s par cette licence, il n'est
offert aux utilisateurs qu'une garantie limit?e.  Pour les m?mes raisons,
seule une responsabilit? restreinte p?se sur l'auteur du programme,  le
titulaire des droits patrimoniaux et les conc?dants successifs.

A cet ?gard  l'attention de l'utilisateur est attir?e sur les risques
associ?s au chargement,  ? l'utilisation,  ? la modification et/ou au
d?veloppement et ? la reproduction du logiciel par l'utilisateur ?tant 
donn? sa sp?cificit? de logiciel libre, qui peut le rendre complexe ? 
manipuler et qui le r?serve donc ? des d?veloppeurs et des professionnels
avertis poss?dant  des connaissances  informatiques approfondies.  Les
utilisateurs sont donc invit?s ? charger  et  tester  l'ad?quation  du
logiciel ? leurs besoins dans des conditions permettant d'assurer la
s?curit? de leurs syst?mes et ou de leurs donn?es et, plus g?n?ralement, 
? l'utiliser et l'exploiter dans les m?mes conditions de s?curit?. 

Le fait que vous puissiez acc?der ? cet en-t?te signifie que vous avez 
pris connaissance de la licence CeCILL-C, et que vous en avez accept? les 
termes.*/
			//recherche de la parcelle
define('GIS_ROOT', '../..');
include_once(GIS_ROOT . '/inc/common.php');
gis_session_start();

$insee = $_SESSION['profil']->insee;
$appli = $_SESSION['profil']->appli;

if ((!$_SESSION['profil']->acces_ssl) || !in_array ("Cadastre", $_SESSION['profil']->liste_appli)){
	die("Point d'entr&eacute;e r&eacute;glement&eacute;.<br> Accès interdit. <br>Veuillez vous connecter via <a href=\"https://".$_SERVER['HTTP_HOST']."\">serveur carto</a><SCRIPT language=javascript>setTimeout(\"window.location.replace('https://".$_SERVER['HTTP_HOST']."')\",3000)</SCRIPT>");
}
$clef=array_search('Cadastre',$_SESSION['profil']->liste_appli);
//    if (isset($_SESSION["code_insee"])){
		$titre='Recherche cadastrale';include('./head.php');
		if (!isset($_SESSION['profil']->appli)){include('head_cad.php');}else{echo '<link href="https://'.$_SERVER["SERVER_NAME"].'/css/cadastre.css" rel="stylesheet" type="text/css"><body class="body">';}
		echo '<form action="fich_parc.php" method="get">';
  		echo '<table width="100%" align="center">';
    // pour acces agglom?ration
     if (substr($insee,4)=='000'){
         echo '<tr><td colspan=2><h2>Recherche sur la commune de :</h2>';
         $q_commune="select idcommune,nom from admin_svg.commune where idagglo ='".$insee."' and idcommune !='".$insee."' order by nom asc";
         $r_commune=$DB->tab_result($q_commune);
         echo '<select name="commune">';
         for ($p=0;$p<count($r_commune);$p++){
             echo '<option value='.$r_commune[$p]['idcommune'].'>'.$r_commune[$p]['nom'].'</option>';
         }
         echo "</select>";
         echo '</td><td colspan=2><h2>&nbsp;</h2></td></tr>';
    }
		echo '<tr><td colspan=2><h2>Parcelle</h2></td><td colspan=2><h2>Propri&eacute;taire</h2></td></tr>';		
		echo '<tr><td rowspan=2 width="22%" >Section<br>numero</td>';
		echo '<td rowspan=2 width="28%"><input name="sect" type="text" onChange="javascript:this.value=this.value.toUpperCase();" size="2" maxlength="2"><br><input name="num" type="text" size="5" maxlength="4"></td>';
		echo '<td width="25%">Nom du propri&eacute;taire</td>';
		echo '<td width="25%"><input name="noprop" type="text" onChange="javascript:this.value=this.value.toUpperCase();" size="30" maxlength="30"></td>';
		echo '</tr><tr><td></td><td></td></tr>';
        if (($_SESSION["profil"]->appli_droit[$clef]=='e')or($_SESSION["profil"]->appli_droit[$clef]=='a')or($_SESSION["profil"]->droit=='AD')){
         echo '<tr><td>Par le nom du propri&eacute;taire</td>';
		   echo '<td><input name="pnprop" type="text" onChange="javascript:this.value=this.value.toUpperCase();" size="30" maxlength="30"></td>';
		   echo '<td></td><td></td></tr>';
        }
        echo '<tr><td colspan=2 align="center"><input name="" type="submit" value="Rechercher"></td><td colspan=2>&nbsp;</td></tr>';
		echo '</table>';
		echo '</form>';
		include('pied_cad.php');
	//}
?>
