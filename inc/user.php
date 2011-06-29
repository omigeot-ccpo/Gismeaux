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

if (!defined('GIS_ROOT')){
  die("Interdit. Forbidden. Verboten.");
 }

include_once(GIS_ROOT . '/inc/headers.php');
include_once(GIS_ROOT . '/inc/common.php');


class User {
  var $login = "Guest";
  var $groups;

  function User($login="Guest",$pass="",$force=0)
  { 
    $this->groups = array();
    if ($force)
      $this->login = $login;
    else
      if ($login != "Guest")
	if (@$this->check_ldap($login,$pass))
	  $this->login = $login;
	else
	  if (@$this->check_db($login,$pass))
	    $this->login = $login;
	  else
	    $this->login = "Guest";
    $this->init_groups();
  }

  function init_groups()
  { 

    global $DB;

    $this->groups[] = 0; // tout le monde est "au moins" invité
    if ($this->login == "Guest")
      return;
    
    // Pas invité, on a un vrai utilisateur, et on cherche à définir ses groupes.
    //    $ldap_groups = $this->get_ldap_groups();
    //  $req = "SELECT gid FROM admin_svg.groupes";
    // $where = "";
    //  foreach ($ldap_groups as $g)
    //  {
    //	$where .= "ldap_dn = '$g' OR ";
    //  }
    //$where .= " 0=0";
    //$t = $DB->tab_result($req." WHERE ".$where);
    //if (count($t) > 1)
    //  for ($i=0;$i<count($t);$i++)
    //	$this->groups[] = $t['gid'];
    

    //    if (in_array('cn=admins,ou=groups,dc=paysdelourcq,dc=fr',$ldap_groups))
    //      $this->groups[] = 999;
  }

  function has_right($what)
  {
    if ($this->groups)
      echo "groups ok";
    else
      echo "groups ko";
    if (in_array(999,$this->groups)) // DUMMY: Admins can do anything, others can't
      return 1;
    else
      return 0;
    
  }
  function get_ldap_groups()
  {
    $ds=ldap_connect("mercure");
    ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
    $groups = array();
    
    if ($ds)
      {
	{
	  $sr = ldap_search($ds,"ou=groups,dc=paysdelourcq,dc=fr","(&(member=uid=$this->login,ou=users,dc=paysdelourcq,dc=fr)(objectClass=groupOfNames))");
	  $info = ldap_get_entries($ds, $sr);
	  for ($i=0; $i<$info["count"]; $i++) {
	    $groups[] = $info[$i]["dn"];
	  }
	}      
      }
    return $groups;
  }
  
  function check_ldap($login,$pass)
  {
    $ds=ldap_connect("mercure");
    ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
	    
    if ($ds)
      {
	$res = ldap_bind($ds,'uid='.$login.',ou=users,dc=paysdelourcq,dc=fr',$pass);
	if ($res)
	  return 1;
      }
    return 0;
  }

  function check_db($login,$pass)
  {
    global $DB;

    $query = "SELECT idutilisateur FROM admin_svg.utilisateur WHERE login = '$login' AND psw = '$pass'";
    $t = $DB->tab_result($query);
    if (count($t) == 0)
      return 0;
    else
      return 1;
  }
}

function check_auth()
{
  if (!$_SESSION['profil'])
    die('Acc&egrave;s interdit (code = 1)');
//  if (!$_SESSION['profil']->roles)
//    die('Acc&egrave;s interdit (code = 2)');
//  if (count($_SESSION['profil']->roles) == 0)
//    die('Acc&egrave;s interdit (code = 3)');
}

function check_admin_auth()
{
  if (!$_SESSION['profil'])
    die('Acc&egrave;s interdit (code = 1)');
//  if (!$_SESSION['profil']->roles)
//    die('Acc&egrave;s interdit (code = 2)');
//  if (count($_SESSION['profil']->roles) == 0)
//    die('Acc&egrave;s interdit (code = 3)');
//  if (!in_array(1,$_SESSION['profil']->roles))
//    die('Acc&egrave;s interdit (code = 4)');
}




?>