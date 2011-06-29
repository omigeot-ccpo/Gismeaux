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

function codalpha($ch){
  $tx=base_convert($ch,10,26);
  if ($ch>259){
    $txt=chr(96+ord(substr($tx,0,2))-87);
    $txt.=chr(65+($ch-(26*substr($tx,0,2))));
  }else if (($ch>26)and($ch<260)){
    $txt=chr(96+substr($tx,0,1));
    $txt.=chr(65+($ch-(26*substr($tx,0,1))));
  }else{
    $txt=chr(64+$ch);
  }
  if ($ch==0){$txt="";}
  return $txt;
}
function ch2dat($ch){
  $annee=substr($ch,0,4);
  $mois=substr($ch,5,2);
  $jour=substr($ch,8,2);
  $dat=$jour." ".moix($mois)." ".$annee;
  return $dat;
}
function datesql2dmy($ch){
  ereg("([0-9]{4})([[:punct:]]{1})([0-9]{1,2})([[:punct:]]{1})([0-9]{1,2})",$ch,$regs);
  if (($regs[1]!='')){
    return "$regs[5]/$regs[3]/$regs[1]";
  }else{
    return "&nbsp;";
  }
}
function datedmy2sql($ch){
  ereg("([0-9]{2})([[:punct:]]{1})([0-9]{2})([[:punct:]]{1})([0-9]{4})",$ch,$regs);
  if (($regs[5]!='')){
    return "'".$regs[5]."-".$regs[3]."-".$regs[1]."'";
  }else{
    return "null";
  }
}
function kot($ch){
  return ereg_replace("'","''",$ch);
  
}
function ivar($ch){
	$ch2="'".kot(utf8_encode($ch))."'";
	return $ch2;
}
function ifloat($ch){
  $ch=ereg_replace(",","\.",$ch);
  $p=strpos($ch,"/");
  if ($p!==false){
     $ch=round(substr($ch,0,$p)/substr($ch,$p+1),6);
  }
  if ($ch==""){
    return "0";
  }else{
    return $ch;
  }
}
function iint($ch){
  if ($ch==""){
    return "null";
  }else{
    return $ch;
  }
}
function moix($mm){
  if ($mm=='01'){
    return "janvier";
  }elseif ($mm=='02'){
    return "f�vrier";
  }elseif ($mm=='03'){
    return "mars";
  }elseif ($mm=='04'){
    return "avril";
  }elseif ($mm=='05'){
    return "mai";
  }elseif ($mm=='06'){
    return "juin";
  }elseif ($mm=='07'){
    return "juillet";
  }elseif ($mm=='08'){
    return "aout";
  }elseif ($mm=='09'){
    return "septembre";
  }elseif ($mm=='10'){
    return "octobre";
  }elseif ($mm=='11'){
    return "novembre";
  }elseif ($mm=='12'){
    return "d�cembre";
  }
}
function poly2pt($poly){
	$pol= explode(",",$poly);
	return $pol[0];
}
function poly2chemin($poly){
	$pol= explode(",",$poly);
	$polygo=$pol[0];
	for ($i=1;$i<count($pol)-1;$i++){
	$polygo.=",".$pol[$i];
	}
	return $polygo;
}

class DBpg {
  var $db_host = "";
  var $db_user = "";
  var $db_passwd = "";
  var $db_name = "";
  var $db_con; // Connexion à la base

  function params()
  {
    $db_params="dbname=".$this->db_name." host=".$this->db_host." user=".$this->db_user;
    if($this->db_passwd != "")
      {
	$db_params.=" password=".$this->db_passwd;
      }
    return $db_params;
  }

  function DBpg()
  {
    $this->con = @pg_connect($this->params());
    if (! $this->con)
      {
	errorHeader('DB',$_SERVER['PHP_SELF']);
	echo "<p>Le lien vers le serveur de base de donn&eacute;es est invalide. Essayez de revoir votre configuration.</p>";
	errorFooter('DB',$_SERVER['PHP_SELF']);
      }
  }
  
  function tab_result($query)
  {
    if (!$this->con)
      {
	die('DB error in tab_result');
      }
    $resultat = @pg_query($this->con, $query);
    if (!$resultat){
      echo pg_errormessage();
      echo $query;
      die();
    }
    $num=pg_num_rows($resultat);
    for ($i=0; $i<$num; $i++){
      $arr[$i]=pg_fetch_array($resultat,$i);
    }
    return $arr;
  }
  
  function list_result($query){
    $resultat = @pg_query($this->con, $query);
    $num=pg_num_rows($resultat);
    $l="'";
    for ($i=0; $i<$num; $i++){
      $arr=pg_fetch_array($resultat,$i);
      $l.=$arr[0]."','";
    }
    $l=substr($l,0,-2);
    return $l;
  }

  function exec($query)
  {
    @pg_query($this->con,$query);
  }
  function get_result($query)
  {
  @pg_send_query($this->con, $query);
  $resultat = pg_get_result($this->con);
  return pg_result_error($resultat);
  }
}

if (!file_exists(GIS_ROOT . "/config/db.local.php"))
  {
    die('Error - database isn\'t configured yet');
  }
include_once(GIS_ROOT . '/config/db.local.php');
$DB = new DB();
?>
