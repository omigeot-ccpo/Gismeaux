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
include_once(GIS_ROOT . '/inc/common.php');

function p_identifi(){
		echo "<html>";
	    echo "<head>";
	    echo "<title>GISMeaux :: Connexion</title>";
	    echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf8\">";
	    echo "</head>";
	    
			echo "<style type=\"text/css\">
		body.login {background-color: #FFFFFF;}

fieldset.boxlogin{
	border: 3px solid #5B8BAB;
	padding-bottom:10px;
}

legend.boxlogin {
	color: #005FA9;
	font-family:\"Trebuchet MS\",Verdana,Geneva,Arial,Helvetica,sans-serif;
	font-size: 16px;
	font-weight: 700;
	background-color: transparent;
}

table.ident {
	background-color: #ffffff;
	/*border: black 2px outset;*/
}

td.login {
	color: #005FA9;
	font-family:\"Trebuchet MS\",Verdana,Geneva,Arial,Helvetica,sans-serif;
	font-size: 12px;
	background-color: transparent;
}
</style>";
	    echo "</head>";
	    echo "<body class=\"login\">";
		
		echo "<CENTER>\n";
	echo "<table>\n";
	echo "<tr><td align=\"center\">\n";
	echo "<img src=\"../logo/ihead.png\" alt=\"\" title=\"\"/>";
	echo "<br><br><br>\n";
	echo "</td></tr>\n";	
	echo "<table>\n";
	
	echo "<tr><td align=\"center\">\n";
		echo "<form action=\"auth.php\" method=\"post\">\n";
		
		echo "<fieldset class=\"boxlogin\">\n";
		echo "<legend class=\"boxlogin\">Identification</legend>\n";
		echo "<TABLE class=\"ident\">\n";
		echo "<TR>\n";
		echo "	<TD class=\"login\">Login :</TD>\n";
		echo "	<TD><INPUT TYPE='text'     NAME='form_user' SIZE=32  VALUE=''></TD>\n";
		echo "</TR>\n";
		echo "<TR>\n";
		echo "	<TD class=\"login\">Mot de Passe :</TD>\n";
		echo "	<TD><INPUT TYPE='password' NAME='form_pass' SIZE=32  VALUE=''></TD>\n";
		echo "</TR>\n";
		echo "</TABLE>\n";
		echo "</fieldset>\n";
		
		echo "<TABLE BORDER='0'>\n";
		echo "<TR>\n";
		echo "	<TD COLSPAN='2'><CENTER><INPUT TYPE='submit' VALUE='Connexion'></CENTER></TD>\n";
		echo "</TR>\n";
		echo "</TABLE>\n";
		echo "</FORM>\n";
	echo "</td></tr>\n";
	echo "</table>\n";
	
	echo "<table width=\"100%\">\n";
	if ($_GET['authcode']==2)echo "<tr><TD><CENTER>Erreur dans le processus d'authentification. V&eacute;rifiez votre mot de passe.</CENTER></TD></tr>\n";
	echo "</table>\n";
	echo "</CENTER>\n";
	//phpinfo();	

		/*echo "<body>";
	    if ($_GET['authcode']==2)echo "Erreur dans le processus d'authentification. Vérifiez votre mot de passe.";
	    echo "<p><form action=\"auth.php\" method=\"post\"><table>";
	    echo "<tr><td>Login: </td><td><input type=\"text\" name=\"form_user\" value=\"\" /></td></tr>";
	    echo "<tr><td>Password: </td><td><input type=\"password\" name=\"form_pass\" value=\"\" /></td></tr>";
	    echo "<tr><td colspan=2><center><input type=\"submit\" value=\"Connexion\" /></center></td></tr>";
	    echo "<table></form>";
	    echo "</p>";*/
	    echo "</body>";
	    echo "</html>";
	    die();
}

// PROFIL DE BASE (CLASSE PARENTE)

class Profile {
  var $name; // Probablement sans objet, mais parfois utile pour débugguer.
  var $insee; // Code INSEE par défaut -> les permissions devraient être positionnées en concordance.
  var $appli; // Application chargée par défaut -> même remarque que ci-dessus
 var $idagglo;
  var $roles;
  var $rolequery;
  var $idutilisateur;
  var $droit;
  var $droit_appli;//droit de l'utilisateur sur l'application sélectionnnée.
  var $liste_appli;
  var $acces_ssl;
  var $appli_droit;
  
  function __construct($name)
  {
    $this->name = $name;
    $this->insee = 770000;
	 $this->idagglo = 770000;
    $this->appli = "";
    $this->roles = array();
    $this->rolequery = "";
    $this->idutilisateur = "";
    $this->droit = "";
	$this->droit_appli = "";
	$this->liste_appli = "";
    $this->acces_ssl = false;
    $this->appli_droit="";
  }

  function matches() // Permet de vérifier si un profil s'applique au cas présent
  {
    return 0;
  }

  function checkMatch() // Ne pas dériver
  {
    if ($this->matches())
      $_SESSION['profil'] = $this;
  }

  function is_identified()
  {
    // Retourne 1 si le nom de l'utilisateur est connu - par quelque moyen que ce soit - et 0 sinon.
    // Peut obtenir le nom de l'utilisateur lui-même ou faire appel à une fonction externe (TODO).
    // Dans tous les cas, on voudra mettre cette valeur en cache "au cas ou".
    die("ERROR method Profile::is_identified() is missing");
    return 0;
  }

  function is_authentified()
  {
    // Retourne 1 si l'utilisateur "prétendu" a été validé.
    // Peut pratiquer l'authentification lui-même à la volée, ou faire appel à un "authentificateur" externe (TODO)
    die("ERROR method Profile::is_authentified() is missing");
    return 0;
  }

  function fetch_roles()
  {
    global $DB;

    $this->roles = array();
    $query = "SELECT idrole FROM admin_svg.roleuti WHERE idutilisateur = '".$this->getUserName()."'";
    $t = $DB->tab_result($query);
    for ($i=0;$i<count($t);$i++)
      {
	$role = $t[$i]['idrole'];
	$this->roles[] = $role;
	if ($i > 0)
	  $this->rolequery .= " OR ";
	$this->rolequery .= "idrole = " . $role;
      }
  }

  function getUserName()
  {
    die("ERROR method Profile::getUserName() is missing");
    return "No user";
  }

  function info($value="")
  {
    static $val;
    $tmp = $val;
    $val = $value;
    return $tmp;
  }

  function ok($insee="",$appli=0,$action="")
  {
    die("ERROR method Profile::ok() is missing");
    return 0;
  }

}

// FIN DU PROFIL DE BASE

class InternetProfile extends Profile {
  var $guestname;
 
  function __construct($guest)
  {
    parent::__construct("internet");
    $this->guestname = $guest;
  }

  function is_identified()
  {
    return 1;
  }
  
  function is_authentified()
  {
	global $DB;
	if($_SESSION['rewriting'])
	{
	$res = $DB->tab_result("SELECT idcommune,idagglo FROM admin_svg.commune WHERE nom = '".$_SESSION['com']."';");
   	$this->insee = $res[0]['idcommune'];
	$this->idagglo = $res[0]['idagglo'];
	//$this->insee = "770284";
	$res2 = $DB->tab_result("SELECT idutilisateur FROM admin_svg.utilisateur WHERE login='invite' and idcommune = '".$res[0]['idcommune']."';");
   	$this->idutilisateur =$res2[0]['idutilisateur'];
	//$this->idutilisateur = "1";
	$res3 = $DB->tab_result("SELECT idapplication FROM admin_svg.application WHERE libelle_appli='".$_SESSION['app']."';");
   	$this->appli =$res3[0]['idapplication'];
	//$this->appli="13";
	$this->droit = "";
	
	$res1 = pg_query($DB->con,"select application.libelle_appli,apputi.droit from admin_svg.application inner join admin_svg.apputi on admin_svg.application.idapplication=admin_svg.apputi.idapplication join admin_svg.utilisateur on admin_svg.apputi.idutilisateur=admin_svg.utilisateur.idutilisateur where apputi.idutilisateur='".$res2[0]['idutilisateur']."' order by application.type_appli asc;");
	$this->liste_appli = pg_fetch_all_columns($res1,0);
	$this->appli_droit = pg_fetch_all_columns($res1,1);
	
	//$this->droit_appli = "";
	//$this->liste_appli = array('RU');
	}
	else
	{
	$this->insee = "770284";
	$this->idagglo = "770000";
	$this->idutilisateur = "124";
	$this->droit = "";
	$this->appli="13";
	$this->droit_appli = "";
	$this->liste_appli = array('RU');
	}
    
   // $res1 = pg_query($DB->con,"select application.libelle_appli from admin_svg.application inner join admin_svg.apputi on admin_svg.application.idapplication=admin_svg.apputi.idapplication join admin_svg.utilisateur on admin_svg.apputi.idutilisateur=admin_svg.utilisateur.idutilisateur where apputi.idutilisateur='".$this->idutilisateur."' order by application.type_appli asc;");
	//$this->liste_appli = pg_fetch_all_columns($res1,0);
	

	return 1;
  }

  function getUserName()
  {
    return $this->guestname;
  }

  function ok()
  {
    return 1;
  }

  function matches()
  {
    if (!$_SERVER['HTTPS'])
      return 1; // Works by default
    return 0;
  }
}

/////////////////////////////////////////////

class CertifiedProfile extends Profile {
  var $username;
  var $ssl;

  function __construct()
  {
    parent::__construct("certified");
  }

  function getUserName()
  {
    return $this->username;
  }

  function is_identified()
  {
    if ($_SERVER["SSL_CLIENT_CERT"])
     {
	$this->ssl = openssl_x509_parse($_SERVER["SSL_CLIENT_CERT"]);
	if ($this->ssl)
	  {
	    $this->username = $this->ssl['subject']['CN'];
	    $this->fetch_roles();
	    return 1;
	  }
      }
    return 0;
  }

  function is_authentified()
  {
    global $DB;

    $org = str_replace("'","\\'",$this->ssl['subject']['O']);
    $orgunit = str_replace("'","\\'",$this->ssl['subject']['OU']);
    $query = "SELECT appli, insee FROM admin_svg.profils WHERE org = '".$org."' AND (orgunit = '".$orgunit."' OR orgunit IS NULL) ORDER BY orgunit";
    $t = $DB->tab_result($query);
    if (count($t) == 0)
      {
	$this->insee = "770000"; // FIXME param
	$this->appli = 2; // FIXME param
      }
    else
      {
	$this->insee = $t[0]['insee'];
	$this->appli = $t[0]['appli'];
      }
    $this->liste_appli[] = "cadastre";
    $this->acces_ssl=true;
    return 1;
  }
  
  function ok($insee="",$appli=0,$action="")
  {
    return 1;
  }

  function matches()
  {
    if ($_SERVER)
      if ($_SERVER['HTTPS'])
	if ($_SERVER['SSL_CLIENT_CERT'])
	  {
	    die($_SERVER["SSL_CLIENT_CERT"]);
	    $cainfo = array();
	    $cainfo[] = '/etc/apache2/ssl/cacert.pem'; // FIXME param
	    $this->ssl = openssl_x509_parse($_SERVER["SSL_CLIENT_CERT"]);
	    if (openssl_x509_checkpurpose($SERVER["SSL_CLIENT_CERT"],X509_PURPOSE_SSL_CLIENT,$cainfo))
	      return 1;
	  }
    return 0;
  }
}

//////////////////////////////////////////////////////////////////

class TestingProfile extends Profile {
  function __construct()
  {
    parent::__construct("testing");
  }

  function getUserName()
  {
    return "Olivier Migeot";
  }

  function is_identified()
  {
    return 1;
  }

  function is_authentified()
  {
    return 1;
  }

  function ok($insee="",$appli=0,$action="")
  {
    return 1;
  }

  function matches()
  {
    if ($_SERVER)
      if ($_SERVER['REMOTE_ADDR'] == "192.168.1.82")
	return 1;
    return 0;
  }

}

///////////////////////////////////////////

class IntranetLDAPProfile extends Profile {
  var $user;
  var $pass;

  function __construct()
  {
    parent::__construct("ldap");
  }

  function is_identified()
  {
    if (!$this->user)
      {
	$this->user = $_POST['form_user'];
	$this->pass = $_POST['form_pass'];
	
	if ($this->user) // Cette partie correspond à auth()
	  {
	    return 1;
	  }
	else // Cette partie correspond à ident() (du moins à sa première phase)
	  {
	  	  p_identifi();
	  }
    }
  }
  
  function getUserName()
  {
    return $this->user;
  }

  function ok($insee="",$appli=0,$action="")
  {
    return 1;
  }

  function is_authentified()
  {
    global $ldap_host,$ldap_version,$ldap_base_dn,$ldap_uid_attr;
    $ds=ldap_connect($ldap_host);
    ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, $ldap_version);
    
    if ($ds)
      {
	$res = @ldap_bind($ds,$ldap_uid_attr.'='.$this->user.','.$ldap_base_dn,$this->pass);
	if ($res)
	  {
	    global $DB;
	    
	    
	    $sr=ldap_search($ds,$ldap_base_dn, $ldap_uid_attr."=".$this->user);
	    $info = ldap_get_entries($ds,$sr);
	    
	    $org = str_replace("'","\\'",$info[0]["o"][0]);
	    $orgunit = str_replace("'","\\'",$info[0]['ou'][0]);
	    $query = "SELECT appli, insee FROM admin_svg.profils WHERE org = '".$org."' AND (orgunit = '".$orgunit."' OR orgunit IS NULL) ORDER BY orgunit";
	    $t = $DB->tab_result($query);
	    if (count($t) == 0)
	      {
		$this->insee = "770000"; // FIXME param
		$this->appli = 2; // FIXME param
	      }
	    else
	      {
		$this->insee = $t[0]['insee'];
		$this->appli = $t[0]['appli'];
	      }
	    return 1;
	  }
      }
    return 0;
  }
  
  function matches()
  {
    if ($_SERVER)
      if ($_SERVER['REMOTE_ADDR'] == '192.168.1.82') // FIXME param (dev ip)
	//	if ($_SERVER['HTTPS'])
	return 1;
    return 0;

  }

}
///////////////////////////////////////////

class IntranetProfile extends Profile {
  var $user;
  var $pass;

  function __construct($appli='')
  {
    parent::__construct("intranet");
    $this->appli = $appli;
  }

  function is_identified()
  {
    if (!$this->user)
      {
	$this->user = $_POST['form_user'];
	$this->pass = $_POST['form_pass'];
	if ($this->user) // Cette partie correspond à auth()
	  {
	    return 1;
	  }
	else // Cette partie correspond à ident() (du moins à sa première phase)
	  {
			p_identifi();
	  }
    }
  }
  
  function getUserName()
  {
    return $this->user;
  }

  function ok($insee="",$appli="",$action="")
  {
   return 1;
  }

  function is_authentified()
  {
    global $DB;

    $res = $DB->tab_result("SELECT * FROM admin_svg.utilisateur WHERE login = '".$this->user."' AND psw = '".$this->pass."';");
    
    if (count($res) == 0)
      {
	return 0;
      }
    else
      {
	$this->insee = $res[0]['idcommune'];
	$this->idutilisateur = $res[0]['idutilisateur'];
	$this->droit = $res[0]['droit'];
	$this->droit_appli = "";
	$this->acces_ssl = true;

$res1 = pg_query($DB->con,"select application.libelle_appli,apputi.droit from admin_svg.application inner join admin_svg.apputi on admin_svg.application.idapplication=admin_svg.apputi.idapplication join admin_svg.utilisateur on admin_svg.apputi.idutilisateur=admin_svg.utilisateur.idutilisateur where apputi.idutilisateur='".$res[0]['idutilisateur']."' order by application.type_appli asc;");
	$this->liste_appli = pg_fetch_all_columns($res1,0);
	$this->appli_droit = pg_fetch_all_columns($res1,1);

	$this->roles[] = 2;
	if ($res[0]['droit'] == 'AD') // FIXME: affiner la gestion des droits
	  $this->roles[] = 1;
	return 1;
      }
  }
  
  function matches()
  {
    //if ($_SERVER)
      if ($_SERVER['HTTPS'])
    			return 1;
    	return 0;

  }

}

////////////////////////////////////////////

class SSOIntranetProfile extends Profile {
  var $user;

  function __construct($appli='')
  {
    parent::__construct("ssointranet");
    $this->appli = 1;
  }

  function getUserName()
  {
    return $this->user;
  }

  function ok($insee="",$appli="",$action="")
  {
   return 1;
  }

  function is_identified()
  {
    
    global $DB;

    $this->user = $_SERVER['HTTP_AUTH_USER'];


    $this->insee = $_SERVER['HTTP_AUTH_INSEE'];

    $apps = $_SERVER['HTTP_AUTH_APPLIS'];

    preg_match_all("/([^:]+):([^:]+)/", $apps, $pairs);
    $this->liste_appli = $pairs[1];
    $this->appli_droit = $pairs[2];
    $this->acces_ssl = true;
    $this->protocol = 'https'; 
 
    $this->roles[] = 2;
    if (strpos($_SERVER['HTTP_AUTH_ROLES'],'sig_admin'))
    {
	$this->droit = 'AD';
        $this->roles[] = 1;
    }
    else
	$this->droit = '';

    $res = $DB->tab_result("SELECT * FROM admin_svg.utilisateur WHERE login = '".$this->user."';");
    if (count($res) == 0)
    {
       // CREATE USER :)
	$q = "INSERT INTO admin_svg.utilisateur (idutilisateur,idcommune,login,droit,nom,prenom,email) VALUES (";
	$q .= "nextval('admin_svg.util'), ";
	$q .= "'" . $this->insee . "',";
	$q .= "'" . $this->user . "',";
	$q .= "'" . $this->droit . "',";
	$q .= "'" . "UnNom" . "',"; 
	$q .= "'" . "UnPrenom" . "',";
	$q .= "'" . "UnMail" . "');";
	$res = $DB->tab_result($q);
    }
    $res = $DB->tab_result("SELECT idutilisateur FROM admin_svg.utilisateur WHERE login = '".$this->user."';");
    $this->idutilisateur = $res[0][0];

    // (REMOVE AND) ADD APPS

    $res = $DB->tab_result("SELECT idapplication,libelle_appli FROM admin_svg.application");
    $apps = Array();
    foreach ($res as $r)
    {
      $apps[$r[1]] = $r[0];
    }
    $res = $DB->tab_result("DELETE FROM admin_svg.apputi WHERE idutilisateur = " . $this->idutilisateur );
    $i = 0;
    $this->appli = $apps[$this->liste_appli[0]];
    foreach ($this->liste_appli as $app) 
    {
	$q  = "INSERT INTO admin_svg.apputi (idutilisateur,idapplication,droit,ordre) VALUES (";
	$q .= $this->idutilisateur . ",";
	$q .= $apps[$app] . ",";
	$q .= "'" . $this->appli_droit[$i] . "',";
	$q .= $i . ")";
        $i += 1;
	$res = $DB->tab_result($q);
    }
    return 1;
  }

  function is_authentified()
  {
        return 1;
  }


  function matches()
  { 
    if ($_SERVER['REMOTE_ADDR'] == '192.168.1.33')
    {
      return 1;
    }
    return 0;
  }

}

///////////////////////////////////////////

class urbaProfile extends Profile {
  var $user;
  var $pass;

  function __construct($appli='')
  {
    parent::__construct("intranet");
    $this->appli = $appli;
  }

  function is_identified()
  {
    if (!$this->user)
      {
	$this->user = 'capm';
	$this->pass = 'capm';
	if ($this->user) // Cette partie correspond à auth()
	  {
	    return 1;
	  }
	else // Cette partie correspond à ident() (du moins à sa première phase)
	  {
			p_identifi();
	  }
    }
  }
  
  function getUserName()
  {
    return $this->user;
  }

  function ok($insee="",$appli="",$action="")
  {
   return 1;
  }

  function is_authentified()
  {
    global $DB;

    $res = $DB->tab_result("SELECT * FROM admin_svg.utilisateur WHERE login = '".$this->user."' AND psw = '".$this->pass."';");
    
    if (count($res) == 0)
      {
	return 0;
      }
    else
      {
	$this->insee = $res[0]['idcommune'];
	$res2 = $DB->tab_result("SELECT idagglo FROM admin_svg.commune WHERE idcommune = '".$res[0]['idcommune']."';");
	$this->idagglo = $res2[0]['idagglo'];
	$this->idutilisateur = $res[0]['idutilisateur'];
	$this->droit = $res[0]['droit'];
	$this->droit_appli = "";
	$this->acces_ssl = true;

$res1 = pg_query($DB->con,"select application.libelle_appli from admin_svg.application inner join admin_svg.apputi on admin_svg.application.idapplication=admin_svg.apputi.idapplication join admin_svg.utilisateur on admin_svg.apputi.idutilisateur=admin_svg.utilisateur.idutilisateur where apputi.idutilisateur='".$res[0]['idutilisateur']."' order by application.type_appli asc;");
	$this->liste_appli = pg_fetch_all_columns($res1,0);

	$this->roles[] = 2;
	if ($res[0]['droit'] == 'AD') // FIXME: affiner la gestion des droits
	  $this->roles[] = 1;
	return 1;
      }
  }
  
  function matches()
  {
    //if ($_SERVER)
      if ($_SERVER['HTTP_REFERER']=='https://pays/auth1.php')
    			return 1;
    	return 0;

  }

}

/////////////////////////////////////////////
// CertifiedProxyProfile
//
// Ce profil fonctionne comme le profil "Certified", mais 
// lorsque la vérification du certificat et le dialogue
// SSL sont effectués sur une machine "frontale".
// Cette machine frontale doit donc transmettre les 
// requêtes au serveur SIG via mod_proxy, et doit 
// surtout s'arranger pour faire suivre les en-têtes
// liées à SSL au moyen de mod_headers. Pour le moment,
// la seule en-tête véritablement utile est 
// HTTP_SSL_CLIENT_CERT (équivalente à 
// SSL_CLIENT_CERT dans le cas "direct").

class CertifiedProxyProfile extends Profile {
  var $username;
  var $ssl;
  var $proxy;

  function __construct($proxy = "192.168.1.23")
  {
    parent::__construct("certified-proxy");
    $this->proxy = $proxy;
  }

  function getUserName()
  {
    return $this->username;
  }

  function is_identified()
  {
    //$this->ssl = openssl_x509_parse($cert);
    if ($this->ssl)
      {
	$this->username = $this->ssl['subject']['CN'];
	$this->fetch_roles();
	return 1;
      }
    return 0;
  }

  function is_authentified()
  {
    global $DB;

    $org = str_replace("'","\\'",$this->ssl['subject']['O']);
    $orgunit = str_replace("'","\\'",$this->ssl['subject']['OU']);
    $query = "SELECT appli, insee FROM admin_svg.profils WHERE org = '".$org."' AND (orgunit = '".$orgunit."' OR orgunit IS NULL) ORDER BY orgunit";
    $t = $DB->tab_result($query);
    if (count($t) == 0)
      {
	$this->insee = "770000"; // FIXME param
	$this->appli = 2; // FIXME param
      }
    else
      {
	$this->insee = $t[0]['insee'];
	$this->appli = $t[0]['appli'];
      }
    $this->liste_appli[] = "cadastre";
    $this->acces_ssl=true;
    $_SESSION['previous'] = "https://ssl.paysdelourcq.fr";
    return 1;
  }
  
  function ok($insee="",$appli=0,$action="")
  {
    return 1;
  }

  function matches()
  {
    // Des vérifications supplémentaires pourraient être intéressantes (FORWARDED FOR, etc).
    if ($_SERVER)
      if ($_SERVER['REMOTE_ADDR'] == $this->proxy)
	if ($_SERVER['HTTP_SSL_CLIENT_CERT'])
	  {
	    $cert = "-----BEGIN CERTIFICATE-----\n";
	    $tmp = str_replace("-----BEGIN CERTIFICATE----- ","",$_SERVER['HTTP_SSL_CLIENT_CERT']);
	    $tmp = str_replace("-----END CERTIFICATE-----","",$tmp);
	    $cert .= str_replace(" ","\n",$tmp);
	    $cert .= "-----END CERTIFICATE----- ";
	    $cainfo = array();
	    $cainfo[] = '/etc/apache2/ssl/cacert.pem'; // FIXME param
	    $this->ssl = openssl_x509_parse($cert);
	    if (openssl_x509_checkpurpose($cert,X509_PURPOSE_SSL_CLIENT,$cainfo))
	      {
		return 1;
	      }
	  }
    return 0;
  }
}


?>
