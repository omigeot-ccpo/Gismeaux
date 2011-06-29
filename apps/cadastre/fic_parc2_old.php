<?php 
/*Copyright Ville de Meaux 2004-2007
contributeur: jean-luc Dechamp - robert Leguay 
sig@meaux.fr

Ce logiciel est un programme informatique fournissant une interface cartographique WEB communale. 

Ce logiciel est rÃ©gi par la licence CeCILL-C soumise au droit franÃ§ais et
respectant les principes de diffusion des logiciels libres. Vous pouvez
utiliser, modifier et/ou redistribuer ce programme sous les conditions
de la licence CeCILL-C telle que diffusÃ©e par le CEA, le CNRS et l'INRIA 
sur le site "http://www.cecill.info".

En contrepartie de l'accessibilitÃ© au code source et des droits de copie,
de modification et de redistribution accordÃ©s par cette licence, il n'est
offert aux utilisateurs qu'une garantie limitÃ©e.  Pour les mÃªmes raisons,
seule une responsabilitÃ© restreinte pÃ¨se sur l'auteur du programme,  le
titulaire des droits patrimoniaux et les concÃ©dants successifs.

A cet Ã©gard  l'attention de l'utilisateur est attirÃ©e sur les risques
associÃ©s au chargement,  Ã  l'utilisation,  Ã  la modification et/ou au
dÃ©veloppement et Ã  la reproduction du logiciel par l'utilisateur Ã©tant 
donnÃ© sa spÃ©cificitÃ© de logiciel libre, qui peut le rendre complexe Ã  
manipuler et qui le rÃ©serve donc Ã  des dÃ©veloppeurs et des professionnels
avertis possÃ©dant  des connaissances  informatiques approfondies.  Les
utilisateurs sont donc invitÃ©s Ã  charger  et  tester  l'adÃ©quation  du
logiciel Ã  leurs besoins dans des conditions permettant d'assurer la
sÃ©curitÃ© de leurs systÃ¨mes et ou de leurs donnÃ©es et, plus gÃ©nÃ©ralement, 
Ã  l'utiliser et l'exploiter dans les mÃªmes conditions de sÃ©curitÃ©. 

Le fait que vous puissiez accÃ©der Ã  cet en-tÃªte signifie que vous avez 
pris connaissance de la licence CeCILL-C, et que vous en avez acceptÃ© les 
termes.*/
define('GIS_ROOT', '../..');
include_once(GIS_ROOT . '/inc/common.php');
gis_session_start();

$insee = $_SESSION['profil']->insee;
$cominsee = substr($insee,3,3); // Les 3 derniers caractères du code INSEE, pour éviter de les extraire à chaque fois.
$appli = $_SESSION['profil']->appli;

if ((!$_SESSION['profil']->acces_ssl) || !in_array ("cadastre", $_SESSION['profil']->liste_appli)){
  die("Point d'entr&eacute;e r&eacute;glement&eacute;.<br> Accès interdit. <br>Veuillez vous connecter via <a href=\"https://".$_SERVER['HTTP_HOST']."\">serveur carto</a><SCRIPT language=javascript>setTimeout(\"window.location.replace('https://".$_SERVER['HTTP_HOST']."')\",3000)</SCRIPT>");
 }

$commune=$insee;
$titre='Recherche cadastrale - Fiche parcelle';
if (isset($_GET["par1"]))
  {
    $ind=$cominsee."000".substr($par1,0,2).str_pad(substr($_GET["par1"],2),4,'0',STR_PAD_LEFT);
  }
include("./head.php");
/* Lecture de la fiche parcelle */
if (isset($_GET["ind"]))
  {
    if ($cominsee != '000')
      $ind=$cominsee . substr($_GET["ind"],3); // On se protège contre les incursions extra-communales.
    else
      $ind = $_GET["ind"];
  }
$query_Recordset1 = "SELECT ccosec, dnupla, dcntpa, jdatat, gparbat, dnuvoi, dindic, ccoriv, prop1, commune FROM cadastre.parcel WHERE ind = '";
$query_Recordset1.= $ind."';";
$row_Recordset1 = $DB->tab_result($query_Recordset1);
/* Recherche des propriétaires */
$prop=$row_Recordset1[0]['prop1'];
$insee=$row_Recordset1[0]['commune'];
$query_Recordset2 = "SELECT cgroup, ddenom, dlign3, dlign4, dlign5, dlign6, ccopay FROM cadastre.propriet WHERE prop1 = '";
$query_Recordset2.= $prop."' and commune='".$insee."' order by dnulp asc;";
$row_Recordset2 = $DB->tab_result($query_Recordset2);
/* Si gparbat=1 alors terrain batie */
if ($row_Recordset1[0]['gparbat']==1)
  {
    $ccos=$row_Recordset1[0]['ccosec'];
    $dnup=$row_Recordset1[0]['dnupla'];
    $query_Recordset3 = "SELECT invar, dnubat, desca, dniv, dpor FROM cadastre.batidgi where ccosec='".$ccos."' and dnupla = '".$dnup."' and commune='".$insee."'";
    $row_Recordset3 = $DB->tab_result($query_Recordset3);
  }
/* Recherche du nom de la voie */
$cod_voie=$row_Recordset1[0]['ccoriv'];
$query_voie="SELECT nom_voie from cadastre.voies where code_voie like '".$cod_voie."' and commune='".$insee."';";
$row_voie=$DB->tab_result($query_voie);
echo '<table width="100%"  align="center">';
if ($row_Recordset1[0]['gparbat']==1)
  {
    echo '<tr><td colspan="4" align="center" class="tt1">Fiche d\'une parcelle b&acirc;tie ';
  }
 else
   {
     echo '<tr><td colspan="4" align="center" class="tt1">Fiche d\'une parcelle non b&acirc;tie '; 
   }
echo '<img src="../../doc_commune/770284/skins/sig.png" onclick="window.opener.svgWin.cadreparcelle(\''.$ind.'\')" alt="cadrer sur le SIG" align="right"/></td></td></tr><tr><td>Section</td>';
echo '<td>'.$row_Recordset1[0]['ccosec'].'</td><td>Numero</td>';
echo '<td>'.$row_Recordset1[0]['dnupla'].'</td></tr><tr><td>Adresse</td>';
echo '<td colspan="3">'.$row_Recordset1[0]['dnuvoi'].$row_Recordset1[0]['dindic'].', '.$row_voie[0]['nom_voie'].'</td>';
echo '</tr><tr><td>Contenance</td><td>'.$row_Recordset1[0]['dcntpa'].'</td>';
echo '<td>Date de l\'acte</td><td>'.$row_Recordset1[0]['jdatat'].'</td></tr><tr>';
echo '<td colspan="4" align="center" class="tt2">Propri&eacute;taire</td></tr>';
for($q=0;$q<count($row_Recordset2);$q++)
  {
    echo '<tr><td>Nom</td><td colspan="3">'.$row_Recordset2[$q]['ddenom'].'</td>';
    echo '</tr><tr><td rowspan="5">Adresse</td>';
    echo '<td colspan="3">'.$row_Recordset2[$q]['dlign3'].'</td>';
    echo '</tr><tr><td colspan="3">'.$row_Recordset2[$q]['dlign4'].'</td>';
    echo '</tr><tr><td colspan="3">'.$row_Recordset2[$q]['dlign5'].'</td>';
    echo '</tr><tr><td colspan="3">'.$row_Recordset2[$q]['dlign6'].'</td>';
    echo '</tr><tr><td colspan="3">'.$row_Recordset2[$q]['ccopay'].'</td></tr>';
  } 
if ($row_Recordset1[0]['gparbat']==1)
  {
    echo '<tr><td colspan="4" align="center" class="tt2">';
    if (substr($row_Recordset1[0]['prop1'],0,1)=='*')
      {
	echo "Co-propri&eacute;taire"; 
      }
    else
      {
	echo "Locaux"; 
      } 
    echo '</td></tr>';
    for($s=0;$s<count($row_Recordset3);$s++)
      {
	echo '<tr class="tt4"><td>';
	if (($_SESSION['profil']->droit_appli=='a')||($_SESSION['profil']->droit_appli=='e')||($_SESSION['profil']->droit=='AD')) //($action="admin") FIXME: Perms
	  {
	    echo '<a href="fic_bat.php?invar1='.$row_Recordset3[$s]['invar'].'">B&acirc;timent : </a>';
	  }
	else
	  {
	    echo 'B&acirc;timent : ';
	  }
	echo $row_Recordset3[$s]['dnubat'].'</td>';
	echo '<td>Escalier : '.$row_Recordset3[$s]['desca'].'</td>';
	echo '<td>Niveau : '.$row_Recordset3[$s]['dniv'].'</td>';
	echo '<td>Local : '.$row_Recordset3[$s]['dpor'].'</td></tr>';
	if (substr($row_Recordset1[0]['prop1'],0,1)=='*')
	  {
	    $req="select dnupro from cadastre.b_desdgi where invar = '".$row_Recordset3[$s]['invar']."';";
	    $lrow=$DB->tab_result($req);
	    $preq="select * from cadastre.propriet where prop1='".$lrow[0]['dnupro']."' and commune='".$insee."' order by dnulp asc;";
	    $bprow=$DB->tab_result($preq);
	    for ($d=0;$d<count($bprow);$d++)
	      {
		echo '<tr><td>Nom</td><td colspan="3">';
		if ($bprow[$d]['gtoper']==1)
		  {
		    echo $bprow[$d]['dqualp'];
		  }
		else
		  {
		    echo $bprow[$d]['dforme'];
		  }
		echo " ".$bprow[$d]['ddenom'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong> ';
		if ($bprow[$d]['ccodro'] == "P")
		  {
		    echo "Propri&eacute;taire";
		  }
		elseif ($bprow[$d]['ccodro'] == "U")
		  {
		    echo "Usufruitier";
		  }
		elseif ($bprow[$d]['ccodro'] == "N")
		  {
		    echo "Nu-propri&eacute;taire";
		  }
		elseif ($bprow[$d]['ccodro'] == "B")
		  {
		    echo "Bailleur &agrave; construction";
		  }
		elseif ($bprow[$d]['ccodro'] == "R")
		  {
		    echo "Preneur &agrave; construction";
		  }
		elseif ($bprow[$d]['ccodro'] == "F")
		  {
		    echo "Foncier";
		  }
		elseif ($bprow[$d]['ccodro'] == "T")
		  {
		    echo "Tenuyer";
		  }
		elseif ($bprow[$d]['ccodro'] == "D")
		  {
		    echo "Domanier";
		  }
		elseif ($bprow[$d]['ccodro'] == "V")
		  {
		    echo "Bailleur d'un bail &agrave; r&eacute;habilitation";
		  }
		elseif ($bprow[$d]['ccodro'] == "W")
		  {
		    echo "Preneur d'un bail &agrave; r&eacute;habilitation";
		  }
		elseif ($bprow[$d]['ccodro'] == "A")
		  {
		    echo "Locataire-attributaire";
		  }
		elseif ($bprow[$d]['ccodro'] == "E")
		  {
		    echo "Emphyt&eacute;ote";
		  }
		elseif ($bprow[$d]['ccodro'] == "K")
		  {
		    echo "Antichr&eacute;siste";
		  }
		elseif ($bprow[$d]['ccodro'] == "L")
		  {
		    echo "Fonctionnaire log&eacute;";
		  }
		elseif ($bprow[$d]['ccodro'] == "G")
		  {
		    echo "G&eacute;rant, mandataire, gestionnaire";
		  }
		elseif ($bprow[$d]['ccodro'] == "H")
		  {
		    echo "Associ&eacute; d'une transparence fiscale";
		  }
		elseif ($bprow[$d]['ccodro'] == "S")
		  {
		    echo "Syndic de copropri&eacute;t&eacute;";
		  }; 
		echo '</strong></td></tr><tr><td rowspan="5">Adresse</td>';
		echo '<td colspan="3">'.$bprow[$d]['dlign3'].'</td></tr><tr>';
		echo '<td colspan="3">'.$bprow[$d]['dlign4'].'</td></tr><tr>';
		echo '<td colspan="3">'.$bprow[$d]['dlign5'].'</td></tr><tr>';
		echo '<td colspan="3">'.$bprow[$d]['dlign6'].'</td></tr><tr>';
		echo '<td colspan="3">'.$bprow[$d]['ccopay'].'</td></tr>';
	      }
	  }
      }
  }
echo '</table>';
include('pied_cad.php');

?>


