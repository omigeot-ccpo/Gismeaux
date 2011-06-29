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
/*define('GIS_ROOT', '../..');
include_once(GIS_ROOT . '/inc/common.php');
gis_session_start();

$insee = $_SESSION['profil']->insee;
$appli = $_SESSION['profil']->appli;

if ((!$_SESSION['profil']->idutilisateur)){
	die("Point d'entr&eacute;e r&eacute;glement&eacute;.<br> Accès interdit. <br>Veuillez vous connecter via <a href=\"https://".$_SERVER['HTTP_HOST']."\">serveur carto</a><SCRIPT language=javascript>setTimeout(\"window.location.replace('https://".$_SERVER['HTTP_HOST']."')\",3000)</SCRIPT>");
}*/
?>
<html>
<head>
<title>Renseignement d'Urbanisme</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<!--- <link href="./styl.css" rel="stylesheet" type="text/css"> --->
<link href="../../doc_commune/<?php echo $insee; ?>/css_accueil_internet/styl.css" rel="stylesheet" type="text/css">
</head>



<body>

<table width="760" border="0">
  <!--DWLayoutTable-->
  <tr> 
    <td width="760" height="15" valign="top"> <div align="center"><strong><font size="4">RENSEIGNEMENTS 
        D'URBANISME</font></strong></div></td>
  </tr>
  <tr> 
    <TD height="15" valign="top"> <div align="center"><font size="2">MUTATION 
        D'UN IMMEUBLE BÂTI SANS MODIFICATION DE SON ETAT</font></div></TD>
  </tr>
 
</TABLE>
  


<!--
<form name="form2" method="get" action="../svg/">
	
<table width="100%">
   <tr><td width="78%" class="small"> <em>Rechercher par la carte(si vous ne possédez pas le N°de Section et le N° de la parcelle ni l'adresse):</em> </td><td width="22%"><input type="submit"  value="Rechercher"></td></tr></table></form>
-->
<form name="form1" method="post" action="./requete.php" target="_blank">	
<!--<input name="codeinsee" type="hidden" value="770284">-->
  <table width="760" border="0">
<tr> 
      <td height="15" colspan="2" valign="top" class="tr1"><div align="center">1 
          - Terrain. <font size="-3" face="Arial, Helvetica, sans-serif"><em>Le 
          terrain est l'ilot de propri&eacute;t&eacute; constitu&eacute; par la 
          parcelle, ou par l'ensemble des parcelles contigu&euml;s appartenant 
          &agrave; un m&ecirc;me propri&eacute;taire.</em></font></div></td>
    </tr>
    <!--DWLayoutTable-->
    <tr> 
      <td height="15" colspan="2" valign="top"><em>Section(s) cadastrale(s), et 
        pour chaque section , n&deg; des parcelles:</em></td>
    </tr>
   
    <tr width="760"> 
      <td height="20" width="50%" valign="top" align="right">Section&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
      <td valign="top" width="50%" align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;parcelle 
      </td>
    </tr>
    <tr> 
      <td height="15" valign="top"><div align="right"> 
        <?php
         print("<input name='section[1]' type='text' id='section1' onchange='this.value=this.value.toUpperCase();' value='$section1'>
        </div></td>
      <td width='50%'><input name='parcelle[1]' type='text' id='parcelle1' value='$parcelle1'>");?>
      </td>
    </tr>
    <tr> 
      <td height="15" valign="top"><div align="right"> 
          <input name="section[2]" type="text" id="section2" onchange='this.value=this.value.toUpperCase();'>
        </div></td>
      <td valign="top"><input name="parcelle[2]" type="text" id="parcelle2"></td>
    </tr>
    <tr> 
      <td height="15" valign="top"><div align="right"> 
          <input name="section[3]" type="text" id="section3" onchange='this.value=this.value.toUpperCase();'>
        </div></td>
      <td valign="top"><input name="parcelle[3]" type="text" id="parcelle3"></td>
    </tr>
    <tr> 
      <td height="15" valign="top"><div align="right"> 
          <input name="section[4]" type="text" id="section4" onchange='this.value=this.value.toUpperCase();'>
        </div></td>
      <td valign="top"><input name="parcelle[4]" type="text" id="parcelle4"></td>
    </tr>
    <tr> 
      <td height="15" valign="top"><div align="right"> 
          <input name="section[5]" type="text" id="section5" onchange='this.value=this.value.toUpperCase();'>
        </div></td>
      <td valign="top"><input name="parcelle[5]" type="text" id="parcelle5"></td>
    </tr>
    <tr> 
      <td height="15" colspan="2" valign="top"> <div align="center"> 
          <input type="submit" name="Submit" value="Envoyer">
        </div></td>
    </tr>
  </table>
</form>
  <form action="recherche.php" method="post">  
  <table width="760" border="0">
    <!--DWLayoutTable-->
    
    <tr> 
      <td height="15" colspan="2" valign="top" class="small"> <em>Si 
        vous ne possédez pas le N°de Section et le N° de la parcelle faite une recherche par l'adresse cadastrale du terrain:</em> </td>
    </tr>
    <tr> 
      <td width="610" height="15" valign="top">N° voie 
        <input name="nter" type="text" id="nter" size="4" maxlength="4"> &nbsp; 
        <select name="cpter" size="0" id="cpter">
          <option></option>
          <option>A</option>
          <option>B</option>
          <option>C</option>
          <option>D</option>
          <option>E</option>
          <option>F</option>
          <option>G</option>
          <option>H</option>
          <option>I</option>
          <option>J</option>
          <option>K</option>
          <option>L</option>
          <option>M</option>
          <option>N</option>
          <option>o</option>
          <option>P</option>
          <option>Q</option>
          <option>R</option>
          <option>S</option>
          <option>T</option>
        </select> &nbsp;type voie 
        <select name="typeter" size="0" id="select3">
          <option>Rue</option>
          <option>Avenue</option>
          <option>Allee</option>
          <option>Pont</option>
          <option>Parc</option>
          <option>Chemin</option>
          <option>Square</option>
          <option>Boulevard</option>
          <option>Impasse</option>
        </select> &nbsp; Libellé de voie 
        <input name="libelleter" type="text" id="libelleter" size="30" maxlength="50"> 
      </td>
      <td width="150" valign="top"><input type="submit" name="rechercher" value="Rechercher"></td>
    </tr>
  </table>
</form>
</body>
</html>
