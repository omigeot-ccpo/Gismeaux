<?php
/*Copyright Pays de l'Ourcq 2008
contributeur: jean-luc Dechamp - robert Leguay - olivier Migeot
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

if (!defined('GIS_ROOT'))
  {
    die('Interdit. Forbidden. Verboten.');
  }

function enreg_conn(){
	global $DB;
	if (($_SERVER['QUERY_STRING']!="PHPSESSID=".session_id()) and ($_SERVER['QUERY_STRING']!="")){
	$query=str_replace("'","\'",$_SERVER['QUERY_STRING']);
	$query=str_replace(","," ",$query);
		$sql="insert into admin_svg.connexion (sessionid,idutilisateur,appli,query,page) values('".session_id()."',".$_SESSION['profil']->idutilisateur.",".$_SESSION['profil']->appli.",'".$query."','".$_SERVER['SCRIPT_NAME']."')";
		$DB->tab_result($sql);
	}
}

function gis_session_start() // Doit être appellée par toute "page" (php) de GISMeaux, quelle qu'elle soit.
{global $pg_reg;
  if(!session_id())
    {
//      ini_set('session.gc_maxlifetime', 3600);
ob_start('ob_gzhandler');
ini_set('session.gc_maxlifetime', 3600 * 2);
//session_start();

      @session_start();
header('Cache-Control: public');
header("Pragma:");
      if (!$_SESSION["starttime"])
	$_SESSION["starttime"] = time();
      //      if (!$_SESSION["user"])
      //	$_SESSION["user"] = new User();
    }
  //  if ($_SESSION['previous'])
  if (!$_SESSION['profil']) {
     return 0;
    }else
    {
    	if (($pg_reg=='1')and($_SESSION['profil']->idutilisateur!="")and($_SESSION['profil']->appli!="")){ enreg_conn();}
      return 1;
    }
}
// function get_root_url($http=0,$https=0) // Retourne l'URL de la racine du serveur, sous la forme proto://host:port
// {
//   $res = 'https';
//   $ssl = 0;
//   if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on')
//     {
//  //    $res .=  's';
//       $ssl = 1;
//     }
//   $res .=  '://';
//   if((($_SERVER['SERVER_PORT']!='80') && ($ssl == 0))||(($_SERVER['SERVER_PORT']!='443')&&($ssl == 1)))
//     {
//       $res .= $_SERVER['HTTP_HOST'].':'.$_SERVER['SERVER_PORT'];
//     }
//   else
//     {
//       $res .=  $_SERVER['HTTP_HOST'];
//     }
//   return $res;
// }

function get_full_url($http=0,$https=0) // Retourne l'URL vers la page courante, paramètres inclus.
{
  $res =  "https://".$_SERVER['HTTP_HOST'];
  $ssl=1;
  //$res = get_root_url($http,$https);
  $script_name = '';
  if(isset($_SERVER['REQUEST_URI']))
    {
      $script_name = $_SERVER['REQUEST_URI'];
    }
  else
    {
      $script_name = $_SERVER['PHP_SELF'];
      if($_SERVER['QUERY_STRING']>' ')
	{
	  $script_name .=  '?'.$_SERVER['QUERY_STRING'];
	}
    }
  if ($script_name != '?') $res .= $script_name;
  return $res;
}
// function get_full_url(){// prend l'url
// $url =  $_SERVER['SCRIPT_URI'];$ssl=1;
// // Parse l'url
// $base = parse_url($url);
// // Creation du chemin
// $chemin = "https://".$base[host].$base[path];
// return $chemin;
// }

function gis_init() // Ne doit être appellée QUE depuis les pages "maitresses".
{
  if (!gis_session_start())
    {
      save_previous();
    	if ($_GET['authcode'] == '2')
	  	{
			header("Location: /auth.php?authcode=".$_GET['authcode']);
		}else{
			header("Location: /auth.php");
		}
   	}
}

function save_previous($suffix="")
{
  $_SESSION['previous'.$suffix] = get_full_url();
}

function force_https_auth()
{
  
}

function load_previous($suffix="")
{
  if ($_SESSION['previous'.$suffix])
    if ($_SESSION['previous'.$suffix] != "")
      {
	$prev = $_SESSION['previous'.$suffix];
	//	unset($_SESSION['previous'.$suffix]);
	header('Location: '.$prev);
	//header("Location: https://carto284");
	exit;
	//die();
      }
  
  header('Location: /erreur.php?code=1');
}

?>
