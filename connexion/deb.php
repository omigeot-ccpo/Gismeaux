<?php 
/*Copyright Ville de Meaux 2004-2007
contributeur: jean-luc Dechamp - robert Leguay 
sig@meaux.fr

Ce logiciel est un programme informatique fournissant une interface cartographique WEB communale. 

Ce logiciel est rï¿½gi par la licence CeCILL-C soumise au droit franï¿½ais et
respectant les principes de diffusion des logiciels libres. Vous pouvez
utiliser, modifier et/ou redistribuer ce programme sous les conditions
de la licence CeCILL-C telle que diffusï¿½e par le CEA, le CNRS et l'INRIA 
sur le site "http://www.cecill.info".

En contrepartie de l'accessibilitï¿½ au code source et des droits de copie,
de modification et de redistribution accordï¿½s par cette licence, il n'est
offert aux utilisateurs qu'une garantie limitï¿½e.  Pour les mï¿½mes raisons,
seule une responsabilitï¿½ restreinte pï¿½se sur l'auteur du programme,  le
titulaire des droits patrimoniaux et les concï¿½dants successifs.

A cet ï¿½gard  l'attention de l'utilisateur est attirï¿½e sur les risques
associï¿½s au chargement,  ï¿½ l'utilisation,  ï¿½ la modification et/ou au
dï¿½veloppement et ï¿½ la reproduction du logiciel par l'utilisateur ï¿½tant 
donnï¿½ sa spï¿½cificitï¿½ de logiciel libre, qui peut le rendre complexe ï¿½ 
manipuler et qui le rï¿½serve donc ï¿½ des dï¿½veloppeurs et des professionnels
avertis possï¿½dant  des connaissances  informatiques approfondies.  Les
utilisateurs sont donc invitï¿½s ï¿½ charger  et  tester  l'adï¿½quation  du
logiciel ï¿½ leurs besoins dans des conditions permettant d'assurer la
sï¿½curitï¿½ de leurs systï¿½mes et ou de leurs donnï¿½es et, plus gï¿½nï¿½ralement, 
ï¿½ l'utiliser et l'exploiter dans les mï¿½mes conditions de sï¿½curitï¿½. 

Le fait que vous puissiez accï¿½der ï¿½ cet en-tï¿½te signifie que vous avez 
pris connaissance de la licence CeCILL-C, et que vous en avez acceptï¿½ les 
termes.*/
$fs_root=$_SERVER["DOCUMENT_ROOT"]."/";
include($fs_root."interface/config.php");
// Quelques reglages (omigeot) 
$db_host = "localhost";
$db_name = "sig";
$db_user = "sig";
 $db_passwd = "sig";
 $db_params="dbname=".$db_name." host=".$db_host." user=".$db_user;
 if($db_passwd!="")
 {
 $db_params.=" password=".$db_passwd;
 }
 $ms_dbg_line = 0;
 $fs_root = "/home/sig/gismeaux/intranet/";
// Fin des reglages

$pgx=pg_connect($db_params);
function tab_result($pgx,$quest){
	$resultat = pg_exec($pgx, $quest);
	if (!$resultat){
		pg_errormessage();
		echo $quest;
	}
	$num=pg_numrows($resultat);
//	if ($num>0){
		for ($i=0; $i<$num; $i++){
			$arr[$i]=pg_fetch_array($resultat,$i);
		}
//	}else{
//		$arr='0';
//	}
	return $arr;
}

function list_result($pgx,$quest){
	$resultat = pg_exec($pgx, $quest);
	$num=pg_numrows($resultat);
    $l="'";
	for ($i=0; $i<$num; $i++){
		$arr=pg_fetch_array($resultat,$i);
        $l.=$arr[0]."','";
	}
    $l=substr($l,0,-2);
    return $l;
}

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
     ereg("([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})",$ch,$regs);
     if (($regs[1]!='')){
        return "$regs[3]/$regs[2]/$regs[1]";
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
function ifloat($ch){
	ereg_replace(".",",",$ch);
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
		return "février";
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
		return "décembre";
	}
}
?>
