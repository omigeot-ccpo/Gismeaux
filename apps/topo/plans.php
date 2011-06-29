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

$insee = $_SESSION['profil']->insee;
$appli = $_SESSION['profil']->appli;

if ((!$_SESSION['profil']->acces_ssl) || !in_array ("Plan geometre", $_SESSION['profil']->liste_appli)){
	die("Point d'entrée réglementé.<br> Accès interdit. <br>Veuillez vous connecter via <a href=\"https://".$_SERVER['HTTP_HOST']."\">serveur carto</a><SCRIPT language=javascript>setTimeout(\"window.location.replace('https://".$_SERVER['HTTP_HOST']."')\",10000)</SCRIPT>");
}
//session_start();
//include('../connexion/deb.php');
$q="select * from public.geomet where intersects(the_geom,GeometryFromtext('POLYGON((".$_GET['polygo']."))',$projection))";
if ( $insee != '770000'){$q .= " and code_insee='".$insee."'";}
$resultat = $DB->tab_result($q);

//--------------------------------
//script java de gestion des div
echo "<head>\n";
echo '<script language="JavaScript" type="text/JavaScript">';
echo "\nfunction effacediv(i){document.getElementById(i).style.visibility='hidden';}";
echo "\nfunction affichediv(i){document.getElementById(i).style.visibility='visible';}";
echo "\nfunction nom_fichier(inc){";
echo "\n  slatche=inc.lastIndexOf('\\\\');";
echo "\n  poin= inc.lastIndexOf(\".\");";
//echo "\n  document.getElementById('fich_ins').value=inc.substring(0, poin)+'.dwg'; ";
echo "\n  document.forms['f1'].elements[14].value=inc.substring(slatche+1, poin);}";
//echo "\n  document.forms['f1'].elements[14].value=inc.substring(0,poin)+'.dwf';}";
/*echo "\nfunction control(){ ";
echo "\n  if ((popup.fich.value != '') && (popup.fich.value.length<9)) { ";
echo "\n    return true; ";
echo "\n  }else{ ";
echo "\n    if (popup.fich.value == '') { ";
echo "\n      alert('Le champ fichier ne peut-etre nul!'); ";
echo "\n      return false;";
echo "\n    }else{ ";
echo "\n      alert('Le nom du fichier est trop long!');";
echo "\n      return false;";
echo "\n    }";
echo "\n  }";
echo "\n}";*/
echo "\n</script>";
echo "\n</head>";
echo "\n<body>";

//--------------------------------
//Bouton d'insertion d'un plan topo
echo "\n<INPUT  type='button' value='Ins�rer un plan' onclick='effacediv(\"pl\");affichediv(\"ins\");'>";
echo "\n<div id='ins' style='visibility:hidden'> ";
    echo "\n<div align='center'>Insertion d'un plan g�om�tre</div><br>";
    echo "\n<table width='600'><form id='f1' method='post' action='ins_topo.php' onsubmit='control()' enctype='multipart/form-data'>";
	echo "\n <tr><th>Boite : <input name='boite' type='text' value='0' size='5' maxlength='2'><br></th><td>";
	echo "\n indice de class. :<input name='disk' type='text' value='0' size='5' maxlength='5'><br></td></tr>";
    echo "\n<tr><th>  G�om�tre : </th><td><input name='geometre' type='text' size='10' maxlength='10'>
		\n<select name='geom' onChange='geometre.value=this.value' >";
    $q1="SELECT distinct(GEOMETRE) as geometre FROM public.GEOMETRE_SSQL";
    $r1=$DB->tab_result($q1);
    for ($p=0;$p<count($r1);$p++){
		 echo "\n <option value='".$r1[$p]['geometre']."'>".$r1[$p]['geometre'];
    }
    echo "\n</select></td></tr>";
	echo "\n<tr><th>	Date : </th><td><input name='plan_dat' type='text' value='".date('d/m/Y')."'></td></tr>";
	echo "\n<tr><th>	Service : </th><td><input name='servi' type='text' size='10' maxlength='10'>
			\n<select name='servic' onChange='servi.value=this.value' >";
    $q2="SELECT distinct(SERVICE) as service FROM public.GEOMET";
    if ( $insee != '770000'){$q2 .= " where code_insee='".$insee."'";}
    $r2=$DB->tab_result($q2);
    for ($o=0;$o<count($r2);$o++){
		echo "\n<option value='".$r2[$o]['service']."'>".$r2[$o]['service'];
    }
    echo "\n</select></td></tr> ";
    echo "\n<tr><th colspan=2>	Contenu : <br><input name='ass' type='checkbox' value='1'> Assainissement
			\n<input name='aep' type='checkbox' value='1'> Adduction d'Eau Potable
			\n<input name='ep' type='checkbox' value='1'> Eclairage Public <br>
			\n<input name='recol' type='radio' value='1'> Recolement
			\n<input name='recol' type='radio' value='0' checked> Topo <br><br></th></tr>";
    echo "\n<tr><th>	Fichier dwg : </th><td><input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"30000000\" /><input id='fich_ins' name='fich_ins' type='file' onChange='nom_fichier(this.value)' value=''></td></tr>
		 \n<input name='fich' id='fich' type='hidden' value='' size='10' maxlength='8'>";
    echo "\n<tr><th>	Fichier dwf : </th><td><input name=\"dwf_ins\" type=\"file\" value=\"\"></td></tr>
	     \n<tr><td colspan=2>	Le fichier dwf n�cessaire � l'affichage sur intranet doit porter le m�me nom!<br>
		 \nLe nom est limit� � 8 caract�res</td></tr> \n<input name='polygo' type='hidden' value='".$_GET['polygo']."'>";
	echo "\n<tr><td colspan=2>	<input name='bt_reg' type='submit' value='Enregistrer'></td></tr>";

    echo "\n</table></form>";
echo "\n</div>";

//--------------------------------
//Affichage de la liste de plans
echo "<div id='pl' style='position: absolute;top : 50px;left: 15px;visibility:visible'> ";
if (count($resultat)==0){
    echo '<script language="JavaScript" type="text/JavaScript">';
    echo 'affichediv("ins");';
    echo "</script>";
    echo 'Pas de plan topo dans le p�rim�tre s�lectionn�';
}elseif (count($resultat)==1){
    $ch= "https://".$_SERVER['HTTP_HOST']."/apps/topo/topo.php?dess=../../doc_commune/".$resultat[0]['code_insee']."/dwf/".strtolower($resultat[0]['local1'])."/".strtolower($resultat[0]['fichier']);
    include($ch);
}else{
      echo '<table><tr><th>Fichier</th><th>Date</th><th>Assainissement</th><th>AEP</th>';
      echo '<th>EP</th><th>Recolement</th><th>G�om�tre</th></tr>';
      for ($j=0;$j<count($resultat);$j++){
	     echo '<tr><td><a href="https://'.$_SERVER['HTTP_HOST'].'/apps/topo/topo.php?dess=../../doc_commune/'.$resultat[$j]['code_insee'].'/dwf/'.strtolower($resultat[$j]['local1']).'/'.strtolower($resultat[$j]['fichier']).'">'.$resultat[$j]['fichier'].'.dwg</a></td>';
		 echo '<td>'.$resultat[$j]['dat'].'</td>';
		 echo '<td>'.$resultat[$j]['ass'].'</td>';
		 echo '<td>'.$resultat[$j]['aep'].'</td>';
		 echo '<td>'.$resultat[$j]['ep'].'</td>';
		 echo '<td>'.$resultat[$j]['recol'].'</td>' ;
		 echo '<td>'.$resultat[$j]['geometre'].'</td></tr>' ;
      }
      echo '</table>';
}
echo "</div>";
?>
</body>
</html>
