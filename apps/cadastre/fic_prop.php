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
$appli = $_SESSION['profil']->appli;

if ((!$_SESSION['profil']->acces_ssl) || !in_array ("Cadastre", $_SESSION['profil']->liste_appli)){
	die("Point d'entrÃ©e rÃ©glementÃ©.<br> Accès interdit. <br>Veuillez vous connecter via <a href=\"https://".$_SERVER['HTTP_HOST']."\">serveur carto</a><SCRIPT language=javascript>setTimeout(\"window.location.replace('https://".$_SERVER['HTTP_HOST']."')\",5000)</SCRIPT>");
}
if (isset($_GET["commune"]))
  {
    $commune=$_GET["commune"];
  }
 else
   {
     $commune=$insee;
   }
if(substr($commune,3)=="000"){$commune=substr($commune,0,3).'%';}
        $titre='Recherche cadastrale - Fiche propriétaire';
		include('./head.php');
		$fprop_query = "SELECT * FROM cadastre.propriet WHERE prop1 = '".$_GET["prop1"]."' and commune like '".$commune."'";
		$fprop_row = $DB->tab_result($fprop_query);
		echo '<table width="100%" align="center"><tr class="tt1">';
		echo '<td colspan="4" align="center">Fiche propriétaire</td></tr>';
		for($f=0;$f<count($fprop_row);$f++) {
			echo '<tr class="tt4"><td>N°:&nbsp;'.$fprop_row[$f]['dnulp'].'</td>';
			echo '<td>';
			if ($fprop_row[$f]['ccodro'] == "P"){ echo "Propriétaire";
			}elseif ($fprop_row[$f]['ccodro'] == "U"){ echo "Usufruitier";
			}elseif ($fprop_row[$f]['ccodro'] == "N"){ echo "Nu-propriétaire";
			}elseif ($fprop_row[$f]['ccodro'] == "B"){ echo "Bailleur à construction";
			}elseif ($fprop_row[$f]['ccodro'] == "R"){ echo "Preneur à construction";
			}elseif ($fprop_row[$f]['ccodro'] == "F"){ echo "Foncier";
			}elseif ($fprop_row[$f]['ccodro'] == "T"){ echo "Tenuyer";
			}elseif ($fprop_row[$f]['ccodro'] == "D"){ echo "Domanier";
			}elseif ($fprop_row[$f]['ccodro'] == "V"){ echo "Bailleur d'un bail à réhabilitation";
			}elseif ($fprop_row[$f]['ccodro'] == "W"){ echo "Preneur d'un bail à réhabilitation";
			}elseif ($fprop_row[$f]['ccodro'] == "A"){ echo "Locataire-attributaire";
			}elseif ($fprop_row[$f]['ccodro'] == "E"){ echo "Emphytéote";
			}elseif ($fprop_row[$f]['ccodro'] == "K"){ echo "Antichrésiste";
			}elseif ($fprop_row[$f]['ccodro'] == "L"){ echo "Fonctionnaire logé";
			}elseif ($fprop_row[$f]['ccodro'] == "G"){ echo "Gérant, mandataire, gestionnaire";
			}elseif ($fprop_row[$f]['ccodro'] == "H"){ echo "Associé d'une transparence fiscale";
			}elseif ($fprop_row[$f]['ccodro'] == "S"){ echo "Syndic de copropriété";}
			echo '&nbsp;';
			if ($fprop_row[$f]['ccodem'] == "C"){ echo "Un des copropriétaire";
			}elseif ($fprop_row[$f]['ccodem'] == "S"){ echo "Succession de";
			}elseif ($fprop_row[$f]['ccodem'] == "V"){ echo "La veuve ou les héritiers de ";
			}elseif ($fprop_row[$f]['ccodem'] == "I"){ echo "Indivision simple";
			}elseif ($fprop_row[$f]['ccodem'] == "L"){ echo "Litige";}
			echo '</td><td>';
			if ($fprop_row[$f]['dnatpr'] == "DOM"){ echo "Propriétaire occupant";
			}elseif ($fprop_row[$f]['dnatpr'] == "FNL"){ echo "Fonctionnaire logé";
			}elseif ($fprop_row[$f]['dnatpr'] == "CLL"){ echo "Collectivité local";
			}elseif ($fprop_row[$f]['dnatpr'] == "HLM"){ echo "Office HLM";
			}elseif ($fprop_row[$f]['dnatpr'] == "CAA"){ echo "Caisse assurance agricole";
			}elseif ($fprop_row[$f]['dnatpr'] == "TGV"){ echo "SNCF";}
			echo '</td><td>';
			if ($fprop_row[$f]['ccogrm'] == "0"){ echo "Personne morale non remarquable";
			}elseif ($fprop_row[$f]['ccogrm'] == "1"){ echo "Etat";
			}elseif ($fprop_row[$f]['ccogrm'] == "2"){ echo "Région";
			}elseif ($fprop_row[$f]['ccogrm'] == "3"){ echo "Département";
			}elseif ($fprop_row[$f]['ccogrm'] == "4"){ echo "Commune";
			}elseif ($fprop_row[$f]['ccogrm'] == "5"){ echo "Office HLM";
			}elseif ($fprop_row[$f]['ccogrm'] == "6"){ echo "Société d'économie mixte";
			}elseif ($fprop_row[$f]['ccogrm'] == "7"){ echo "Copropriétaire";
			}elseif ($fprop_row[$f]['ccogrm'] == "8"){ echo "Associé de transparence fiscale";}
			echo '</td></tr><tr class="tt3"><td>Nom:</td>';
			echo '<td colspan="3">'.$fprop_row[$f]['ddenom'].'</td>';
			echo '</tr><tr><td rowspan=4>Adresse:</td>';
			echo '<td colspan="3">'. $fprop_row[$f]['dlign3'].'</td>';
			echo '</tr><tr><td colspan="3">'.$fprop_row[$f]['dlign4'].'</td></tr>';
			echo '<tr><td colspan="3">'.$fprop_row[$f]['dlign5'].'</td></tr>';
			echo '<tr><td colspan="3">'.$fprop_row[$f]['dlign6'].'</td></tr>';
			echo '<tr><td>Né(e) le:&nbsp;'.$fprop_row[$f]['jdatnss'].'</td>';
			echo '<td>A:&nbsp;'.$fprop_row[$f]['dldnss'].'</td>';
			echo '<td colspan=2>'.$fprop_row[$f]['epxnee']." ".$fprop_row[$f]['dnomcp']." ".$fprop_row[$f]['dprncp'].'</td></tr>';
		}
		echo '</table>';
		include('pied_cad.php');
?>
