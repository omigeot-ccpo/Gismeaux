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
//header('Content-type: application/pdf');
//session_start();
//header('Cache-Control: public');
define('GIS_ROOT', '../..');
include_once(GIS_ROOT . '/inc/common.php');
gis_session_start();
//phpinfo();
if($_SESSION['profil']->insee)
{
$insee = $_SESSION['profil']->insee;
}
else{
$insee ='770284';
}
//$insee ='770284';
//$appli = $_SESSION['profil']->appli;

/*if ((!$_SESSION['profil']->idutilisateur) ){	//|| !in_array ("RU", $_SESSION['profil']->liste_appli)
	die("Point d'entr&eacute;e r&eacute;glement&eacute;.<br> Accès interdit. <br>Veuillez vous connecter via <a href=\"https://".$_SERVER['HTTP_HOST']."\">serveur carto</a><SCRIPT language=javascript>setTimeout(\"window.location.replace('https://".$_SERVER['HTTP_HOST']."')\",3000)</SCRIPT>");
}*/
$extra_url = "&user=".$DB->db_user."&password=".$DB->db_passwd."&dbname=".$DB->db_name."&host=".$DB->db_host;
$aph=4; //espace avant paragraphe
$alig=5; //espace entre ligne
$acel=2; //espace entre deux ligne dans la meme cellule
define('FPDF_FONTPATH',GIS_ROOT . '/fpdf/font/');
require(GIS_ROOT . '/fpdf/afpdf.php');
//include("connexion/deb.php");
$nocoche="deco.png";
$coche="okcoche.png";
$q="SELECT distinct nom_voie,dnuvoi,dindic,identifian FROM cadastre.parcelle1 WHERE identifian in ('";
$wh=""; $q2="";
//if ($OBJ_KEYS){	$obj_keys=$OBJ_KEYS;}
//if ($_GET["obj_keys"]){ $obj_keys=$_GET["obj_keys"];}
if (isset($_GET["obj_keys"])){
    $obj_keys=$_GET["obj_keys"];
    $p=explode(",",$obj_keys);
	$nb_obj=0;
    $codeinsee='770'.substr($p[$nb_obj],0,3);$parc=$p[0];
	//préparation des requetes utilisant les obj_keys
	while (isset($p[$nb_obj])) {
		$a1=substr($p[$nb_obj],6,2);
		$b1=str_pad(substr($p[$nb_obj],8,4),4,"0",STR_PAD_LEFT);
		$q2.=substr($p[0],0,6).$a1.$b1."','";
		$wh.="(a.identifian='".substr($p[0],0,6).$a1.$b1."' and Intersects(Transform(a.the_geom,$projection),Transform(b.the_geom,$projection))) or ";
		$nb_obj++;
	}
}elseif(isset($_POST["section"])){
   $po=1;$codeinsee=$insee;
   $pi="parcelle";$pu="section";$codeins=substr($codeinsee,3,3)."000";$parc=$codeins.strtoupper($_POST["section"][1]).str_pad($_POST["parcelle"][1],4,"0",STR_PAD_LEFT);
   while($_POST["parcelle"][$po]!=""){
     $b1=str_pad($_POST["parcelle"][$po],4,"0",STR_PAD_LEFT);
     $q2.=$codeins.strtoupper($_POST["section"][$po]).$b1."','";
	 $wh.="(a.identifian='".$codeins.strtoupper($_POST["section"][$po]).$b1."' and Intersects(Transform(a.the_geom,$projection),Transform(b.the_geom,$projection))) or ";
     $po++;
   }
}else{
	 header("Location: ./ru.php");
}
$q2=substr($q2,0,strlen($q2)-3);
$q.=$q2."') order by identifian";
$wh=substr($wh,0,strlen($wh)-4);
$an=number_format(date('Y'));
if (file_exists("../../doc_commune/".$codeinsee."/ru/compteur.txt"))
{
$fp=fopen("../../doc_commune/".$codeinsee."/ru/compteur.txt","r");
while (!feof($fp)){
      $ligne=fgets($fp,255);
      $liste=explode(";",$ligne);
      $n=number_format($liste[0]);
      $annee=number_format($liste[1]);
}
fclose($fp);
}

if($an>$annee){
    $n=1;
    $annee=date('Y');
}else{
    $n++;
    $annee=date('Y');
}
$fp=fopen("../../doc_commune/".$codeinsee."/ru/compteur.txt","w");
fputs($fp,"$n;$annee");
$comp=$n;
fclose($fp);
$rq = $DB->tab_result($q);
if (count($rq)==0){header("Location: ./messparcel.php");
}
else{
    
	 $q1="select nom,tel_urba,horaire_urba,plu_pos,approb,modif,larg_logo from admin_svg.commune where idcommune = '".$codeinsee."'";
     $r1=$DB->tab_result($q1);
//======================	 
//	$table=array("geotest.zonebruit","geotest.ppri2","geotest.zoneboise","geotest.lisiere","geotest.ppmh","geotest.sidobre","geotest.emplreserve","geotest.z_archeo","geotest.siteinscrit","geotest.servradioelectrik","geotest.zononaedificandi","geotest.alignement","geotest.halage","geotest.cimetiere","geotest.lotissement","geotest.ligne_ht","geotest.vpprt","urba.peri_commerce");
        $table=array("geotest.zonebruit","geotest.ppri2","geotest.zoneboise","geotest.lisiere","geotest.ppmh","geotest.sidobre","geotest.emplreserve","geotest.z_archeo","geotest.siteinscrit","geotest.servradioelectrik","geotest.zononaedificandi","geotest.alignement","geotest.halage","geotest.cimetiere","geotest.lotissement","geotest.ligne_ht","geotest.vpprt"); // TODO 

     $tabl=array("bruit","idinond","bois","lisiere","ppmh","sidobre","empl","archeo","inscrit","radio","sncf","alignement","halage","cimet","idlotiss","lg_ht","pprt");//,"psc");
//$table=array("zonebruit","ppri2","zoneboise","lisiere","ppmh","sidobre","emplreserve","z_archeo","siteinscrit","servradioelectrik","zononaedificandi","alignement","halage","cimetiere","lotissement");
 //    $tabl=array("bruit","idinond","bois","lisiere","ppmh","sidobre","empl","archeo","inscrit","radio","sncf","alignement","halage","cimet","idlotiss");


     $nb=count($table);$idlotiss="";$dloti="";$ppmh="";$alignement="";$inscrit="";$idinond="";$qinon=Array();$sncf="";$sidobre="";$lg_ht="";$bois="";$cimet="";$lisiere="";$radio="";$halage="";$edf="";$carriere="";$rinon="";$qphec="";$empl="";$pprt="";$psc="";
     $cinon=0;
	 for($j=0;$j<=$nb-1;$j++){
       $q="select Intersects(Transform(a.the_geom,$projection),Transform(b.the_geom,$projection)) as inters, b.gid as gid, area(intersection(Transform(a.the_geom,$projection),Transform(b.the_geom,$projection))) as aire from cadastre.parcelle as a ,$table[$j] as b where (".$wh.");";
     	 $result = $DB->tab_result($q);
	    $num = count($result);
	    for ($i=0; $i<$num; $i++){
		   if ($tabl[$j]=="alignement" or $tabl[$j]=="halage"){
		       if($result[$i]['inters']){
                    $$tabl[$j]="true";
                    if($tabl[$j]=="idlotiss"){$idlotis=$result[$i]['gid'];}
               }
           }else{
               if($result[$i]['aire']>1){
		             $$tabl[$j]="true";
		             if($tabl[$j]=="idlotiss"){$idlotis=$result[$i]['gid'];}
		             if($tabl[$j]=="idinond"){$zinond[$cinon]=$result[$i]['gid'];$cinon++;}
		             if($tabl[$j]=="empl"){$emplreserv=$result[$i]['gid'];}
               }
           }
		}
	}
//===========================
$pdf=new TPDF();
$pdf->AddPage();
$pdf->SetFont('times','',11);
     //fixe la marge gauche des textes qui suivent après un retour à la ligne(<br>)
     $pdf->SetLeftMargin(15);
     //supprime le saut de page
     $pdf->Setautopagebreak(0,0);
     //fixe la marge droite des textes qui suivent
     $pdf->SetrightMargin(5);
     $larg=(70*$r1[0]['larg_logo'])/100;
	 
	 if (file_exists("../../logo/".$codeinsee.".png"))
{
$logo="../../logo/".$codeinsee.".png";
}	
else
{
$logo="../../logo/770000.png";
} 
$taillecom = GetImageSize($logo);	 
$width = 60;
$height=20;
$ratio_comm = $taillecom[0]/$taillecom[1];
if ($width/$height> $ratio_comm) {
    		$width_comm = $height*$ratio_comm;
	} else {
   		$height_comm = $width/$ratio_comm;
		}

		

     $pdf->Image($logo,10,8,$width,$height,'','');
	 //on se positionne à 130mm du bord gauche et à 15 mm du bord haut
     $pdf->Setxy(130,10);
     $pdf->Write(5,$r1[0]['nom'].', le '.date("d").' '.moix(date("m")).' '.date("Y"));
     $pdf->SetFont('','B',13);
     $pdf->Setxy(85,17);
     $pdf->Write(5,'Renseignement d'.chr(180).'Urbanisme N° I'.$comp.'/'.$annee);
     $pdf->SetFont('','',11);
     $pdf->Setxy(15,45);
     $pdf->Write(5,'Pour contacter le service Urbanisme:');
     $pdf->Setxy(15,50);
     $pdf->Write(5,$r1[0]['tel_urba'].' ('.$r1[0]['horaire_urba'].')');
     $pdf->Setxy(10,60);
     $pdf->SetFont('','B',11);
     $pdf->Write(5,'le terrain est concerné par les rubriques cochées d'.chr(180).'une croix:');
     $pdf->SetFont('','',11);
     //création de l'encart Adresse
     $pdf->Setxy(85,25);
     $pdf->SetFillColor(225);
     $pdf->cell(15,5,'Section',1,1,'C',1);
     $pdf->Setxy(100,25);
     $pdf->SetFillColor(225);
     $pdf->cell(15,5,'Parcelle',1,1,'C',1);
     $pdf->Setxy(115,25);
     $pdf->SetFillColor(225);
     $pdf->cell(85,5,'Adresse Parcellaire',1,1,'C',1);
	 for ($i=0; $i<count($rq); $i++){
         $adresse1=number_format($rq[$i][1]).' '.$rq[$i][2].', '.ucwords(strtolower(utf8_decode($rq[$i][0])));
         $y=$pdf->GetY();
         $pdf->Setxy(85,$y);
         $pdf->SetFillColor(255);
         $pdf->cell(15,5,strtoupper(substr($rq[$i][3],6,2)),1,1,'C',1);
         $pdf->Setxy(100,$y);
         $pdf->SetFillColor(255);
         $pdf->cell(15,5,substr($rq[$i][3],8,4),1,1,'C',1);
         $pdf->Setxy(115,$y);
         $pdf->SetFillColor(255);
         $pdf->cell(85,5,$adresse1,1,1,'C',1);
         //if ($numa1!="okcoche.png"){
             if ($rq[$i][1]!=""){
                 $numa2="deco.png";
                 $numa1="okcoche.png";
             }else{
                 $numa1="deco.png";
                 $numa2="okcoche.png";
             }
         //}
     }
//récupération du zonage pour droit de préemption
$n=0;
$renforcer="deco.png";
/*
$toto= "SELECT a.identifian,area(intersection(Transform(a.the_geom,$projection),Transform(b.the_geom,$projection))) as aire FROM cadastre.parcelle as a ,urba.pnrqad as b group by a.identifian,a.the_geom, b.gid,b.the_geom having (".$wh.") and b.gid=1 order by a.identifian";
$result = $DB->tab_result($toto);
for ($i=0; $i<count($result); $i++){
	if($result[$i]['aire']!=0)
	{
	$renforcer="okcoche.png";
		
	}	
}
*/

 $simple="deco.png";
$toto= "SELECT b.zone,a.identifian,area(intersection(Transform(a.the_geom,$projection),Transform(b.the_geom,$projection))) FROM cadastre.parcelle as a ,geotest.zonage as b group by b.zone,a.identifian,a.the_geom,b.the_geom having (".$wh.") order by b.zone";
//echo $toto;
$result = $DB->tab_result($toto);
for ($i=0; $i<count($result); $i++){
    $zone[-1]="";
    if (($result[$i][2]>1) and ($zone[$n-1]!=$result[$i][0])){
       $zone[$n]=$result[$i][0];$simple="";
       if ($simple!="okcoche.png"){
          if($result[$i][0]=="N" or $result[$i][0]=="NL"){
               $simple="deco.png";
          }else{
		  	if($renforcer=="okcoche.png")
			{
			$simple="deco.png";
			}
			else
			{
               $simple="okcoche.png";
			   }
          }
       }
       $n=$n+1;
    }
}

// Extraction du nom de la ville.
$nomville = $r1[0][0];
if ($nomville) {
	$nomville = ucfirst(strtolower($nomville));
	if (! stripos('aeiouy',$nomville[0]))
		$beneficiaire = 'Commune de ' . $nomville;
	else
		$beneficiaire = 'Commune d\'' . $nomville; 
} else $beneficiaire="ville de Meaux";

$toto= "SELECT b.nom,b.creer,b.modifier,b.gid,a.identifian,area(intersection(Transform(a.the_geom,$projection),Transform(b.the_geom,$projection))),area(Transform(a.the_geom,$projection)) FROM cadastre.parcelle as a ,geotest.zac as b group by b.gid,a.identifian,a.the_geom,b.the_geom,b.nom,b.creer,b.modifier having (".$wh.") order by b.gid";
//echo $toto;
$zac="false";
$result = $DB->tab_result($toto);
for ($i=0; $i<count($result); $i++){
			if(($result[$i][5]/$result[$i][6])>0.05)
			{
			$zac="true";
			$nomzac=$result[0][0];
			$creerzac=$result[0][1];
			$modzac=$result[0][2];
			}
			
          if(($result[$i][5]/$result[$i][6])>0.05 and ($result[$i][3]=="4" or $result[$i][3]=="5")){
		  $simple="okcoche.png";
          $beneficiaire="AFTRP";   
          }
}
//création de l'encart A-Droit de Préemption
$pdf->Setxy(8,70);
$pdf->SetFillColor(225);
$pdf->Cell(195,5,'A-Droit de Préemption ',1,1,'L',1);
$y=$pdf->GetY()+$aph;
$pdf->Setxy(9,$y);
$pdf->Write(3,'Droit de Préemption Urbain');
$pdf->Image($simple,60,$y,3,3,'','');
$pdf->Setx(65);
$pdf->Write(3,'Simple');
$pdf->Image($renforcer,80,$y,3,3,'','');
$pdf->Setx(85);
$pdf->Write(3,'Renforcé');
$pdf->Setx(105);
$pdf->Write(3,'Bénéficiaire du droit:');
$pdf->Setx(140);
$pdf->Write(3,$beneficiaire);
$pdf->Ln();
$y=$pdf->GetY()+$alig;
//pas de données sur Zone d'Aménagement Différé donc nocoche par defaut à remplacer par un test si on possede la donnée
$pdf->Image($nocoche,10,$y,3,3,'','');
$pdf->Setxy(15,$y);//$pdf->Setxy(15,90);
$pdf->Write(3,'Zone d'.chr(180).'Aménagement Différé');
//périmetre de sauvegarde du commerce
if($psc=="true"){$psc="okcoche.png";}else{$psc="deco.png";}
$pdf->Image($psc,70,$y,3,3,'','');
$pdf->Setx(75);
$pdf->Write(3,'Périmètre de sauvegarde du commerce');
//pas de données sur Espaces Naturels Sensibles donc nocoche par defaut à remplacer par un test si on possede la donnée
$pdf->Image($nocoche,145,$y,3,3,'','');
$pdf->Setx(150);
$pdf->Write(3,'Espaces Naturels Sensibles');

//création de l'encart B-Nature des dispositions d'.chr(180).'urbanisme applicables au terrain
$pdf->Ln();
$y=$pdf->GetY()+$aph+$alig;
$pdf->Setxy(8,$y);
$pdf->SetFillColor(225);
$pdf->Cell(195,5,'B-Nature des dispositions d'.chr(180).'urbanisme applicables au terrain ',1,1,'L',1);
$y1=$pdf->GetY()+$aph;
if($idlotiss=="true"){
	$idlotiss="okcoche.png";
    $r = $DB->tab_result("SELECT  nom,date,gid FROM geotest.lotissement WHERE gid=$idlotis");
    $nomlotiss=$r[0][0];
    $datlotiss=$r[0][1];
    $pattern = "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})";
   // Découpe la chaîne
   ereg($pattern,$datlotiss,$regs);
      // Permute les éléments
    $mois=$regs[2];
	$jour=$regs[1];
	$annee=$regs[3];
    $timestamp = mktime(0,0,0,$mois,$jour,$annee);
    // -- DATE ACTUELLE --
    $d2 = time();
    // -- CALCUL --
    $diff = $d2 - $timestamp;
    $ecart_annee = floor($diff / 31557600);
    if($ecart_annee<10){
         $plu="deco.png";
         $dloti=" ".$nomlotiss." approuvé le ".$datlotiss;
         $simple="okcoche.png";
    }else{
          $plu="okcoche.png";
          $approu="(Approuvé le ".$r1[0]['approb'];
          if ($r1[0]['modif']!=""){$approu.=" - Modifié le ".$r1[0]['modif'];}
          $approu.=")";
    }
    $y=$y+$alig+$acel;
}
else{
    for($p=0;$p<$n;$p++){
       ereg("[A-Z]{1,}",$zone[$p],$vr);
      $pdf-> Setxy(135+(15*$p),$y1);
	   
	     $pdf->PutLink('https://'.$_SERVER['HTTP_HOST'].'/doc_commune/'.$codeinsee.'/ru/'.$vr[0].'.pdf',$zone[$p]);
    }
	$idlotiss="deco.png";
    $plu="okcoche.png";
    $approu="(Approuvé le ".$r1[0]['approb'];
    if ($r1[0]['modif']!=""){$approu.=" - Révisé le ".$r1[0]['modif'];}
    $approu.=")";
    //création de l'encart Secteur
    $pdf->Setxy(122,$y1);
    $pdf->Write(3,'Secteur:');
    $pdf->SetFont('','I',8);
    $pdf->Ln();
	$y=$pdf->GetY()+$acel;
	$pdf->Setxy(135,$y);
    $pdf->Write(3,'(cliquer pour voir le réglement du secteur)');
    $pdf->Setxy(15,$y);
    $pdf->Write(3,'(cliquer');
    $pdf->Setxy(25,$y);
    $pdf->SetFont('','IU',8);
    $pdf->SetTextColor(0,0,255);
    $pdf->Write(3,'ici','https://'.$_SERVER['HTTP_HOST'].'/doc_commune/'.$codeinsee.'/ru/REGLEMENT.pdf');
    $pdf->SetFont('','I',8);
    $pdf->SetTextColor(0);
    $pdf->Setxy(29,$y);
    if ($r1[0]['plu_pos']=='1'){
          $pdf->Write(3,'pour voir le réglement complet du PLU)');
    }else{
        $pdf->Write(3,'pour voir le réglement complet du POS)');
    }
    $pdf->SetFont('','',11);
}
$pdf->Image($plu,10,$y1,3,3,'','');
$pdf->Setxy(15,$y1);
if ($r1[0]['plu_pos']=='1'){
    $pdf->Write(3,'Plan local d'.chr(180).'urbanisme ');
}else{
    $pdf->Write(3,'Plan d'.chr(180).'occupation des sols ');
}
$pdf->SetFont('','I',8);
$pdf->Write(3.5,$approu);
$pdf->SetFont('','',11);
$pdf->SetY($y);
$pdf->Ln();
$y=$pdf->GetY()+$alig;
$pdf->Image($idlotiss,10,$y,3,3,'','');
$pdf->Setxy(15,$y);
$pdf->Write(3,'Lotissement '.$dloti);

//création de l'encart c-nature des servitudes d'utilité publiques applicables au terrain
$pdf->Ln();
$y=$pdf->GetY()+$aph+$alig;
$pdf->Setxy(8,$y);
$pdf->SetFillColor(225);
$pdf->Cell(195,5,'C-Nature des servitudes d'.chr(180).'utilité publiques applicables au terrain ',1,1,'L',1);
$y=$pdf->GetY()+$aph;
if($ppmh=="true"){$ppmh="okcoche.png";}else{$ppmh="deco.png";}
//1 ere ligne
$pdf->Image($ppmh,10,$y,3,3,'','');
$pdf->Setxy(15,$y);
$pdf->Write(3,'Périmètre de Protection');
//pas de données sur Zone Protection Patrimoine donc nocoche par defaut à remplacer par un test si on possede la donnée
$pdf->Image($nocoche,75,$y,3,3,'','');
$pdf->Setxy(80,$y);
$pdf->Write(3,'Zone Protection Patrimoine');
if($alignement=="true"){
	$align=$alignement;
	$alignement="okcoche.png";
}else{$alignement="deco.png";}
$pdf->Image($alignement,140,$y,3,3,'','');
$pdf->Setxy(145,$y);
$pdf->Write(3,'Plan d'.chr(180).'alignement');
//2eme ligne
$pdf->Ln();
$y=$pdf->GetY()+$acel;
$pdf->Setxy(15,$y);
$pdf->Write(3,'d'.chr(180).'un Monument Historique');
$pdf->Setxy(80,$y);
$pdf->Write(3,'Architectural et Urbain');
$pdf->Ln();
$y=$pdf->GetY()+$alig;
if($inscrit=="true"){$inscrit="okcoche.png";}else{$inscrit="deco.png";}
$pdf->Image($inscrit,10,$y,3,3,'','');
$pdf->Setxy(15,$y);
$pdf->Write(3,'Site Inscrit');
if($idinond=="true"){
    $inond="okcoche.png";
    $zoninon=$zinond[0];
    for ($p=1;$p<$cinon;$p++){
        $zoninon.=",".$zinond[$p];
    }
    $q="select distinct(nom_zr) as nom_z, code_zr from geotest.ppri2 where gid in (".$zoninon.") order by code_zr asc;";
    //$rinon=list_result($pgx,$q);
    $qinon=$DB->tab_result($q);
     //echo $rinon;
	 $exclu=0;
	  if(count($qinon)==1 && $qinon[0]['nom_z']=='zone boucle nord de la marne')
	  {
	  $inond="deco.png";
	  $exclu=1;
	  }else{
	      if (count($qinon)==0){$inond="deco.png";}else{ 
     		$rphec="select geotest.phec('".$parc."') as phec";
     		$qphec=$DB->tab_result($rphec);
	  }
     $rinon=$exclusion.$qinon[0]['nom_z'];
     if (count($qinon)>1){
     	$rinon.=' et '.$qinon[1]['nom_z'];
     }}
    //$rinon=str_replace("'","",$rinon);
    //$rinon=str_replace(","," et ",$rinon);
    //$pdf->Setxy(90,155);
    //$pdf->Write(3,$rinon);
}else{$inond="deco.png";}
$pdf->Image($inond,75,$y,3,3,'','');
$pdf->Setxy(80,$y);
$pdf->Write(3,'Concerné ');
/*if ((($_SESSION["profil"]->droit=='AD') or ($_SESSION["profil"]->droit_appli=='e') or ($_SESSION["profil"]->droit_appli=='a')) and (count($qinon)!=0)){
	$pdf->Write(3,'(PHEC= '.$qphec[0]['phec'].') ');
	$pdf->Write(3,'par la ');
}else{
	$pdf->Write(3,'par le ');
}*/
if ((($_SESSION["profil"]->droit=='AD') or ($_SESSION["profil"]->droit_appli=='e') or ($_SESSION["profil"]->droit_appli=='a')) and (count($qinon)!=0) and $exclu!=1){
	$pdf->Write(3,'(PHEC= '.$qphec[0]['phec'].') ');}
$pdf->Write(3,'par la ');
if($sncf=="true"){$sncf="okcoche.png";}else{$sncf="deco.png";}
$pdf->Image($sncf,140,$y,3,3,'','');
$pdf->Setxy(145,$y);
$pdf->Write(3,'Zone non aedificanti');
//3eme ligne
$pdf->Ln();
$y1=$pdf->GetY()+$acel;
$y=$pdf->GetY()+$alig;
//pas de données sur perimetre Site Classé donc nocoche par defaut à remplacer par un test si on possede la donnée
$pdf->Image($nocoche,10,$y,3,3,'','');
$pdf->Setxy(15,$y);
$pdf->Write(3,'Site Classé');
$pdf->Setxy(75,$y1);
/*if ((($_SESSION["profil"]->droit=='AD') or ($_SESSION["profil"]->droit_appli=='e')) and (count($qinon)!=0)){
	$pdf->Write(3,$rinon.' du ');
}else{
	$pdf->write(3, 'Plan de Prévention de Risque Naturel');
}*/
$pdf->Write(3,$rinon.' du ');
if($sidobre=="true"){$sidobre="okcoche.png";}else{$sidobre="deco.png";}
$pdf->Image($sidobre,140,$y,3,3,'','');
$pdf->Setxy(145,$y);
//$pdf->Write(3,'Périmètre de Protection de Risque');
$pdf->Write(3,'Périmètre de Protection usine');
//4eme ligne
$pdf->Ln();
$y1=$y1+3+$acel;
$y=$pdf->GetY()+$acel;
$pdf->Setxy(75,$y1);
/*if ((($_SESSION["profil"]->droit=='AD') or ($_SESSION["profil"]->droit_appli=='e')) and (count($qinon)!=0)){
	$pdf->PutLink('http://'.$_SERVER['SERVER_NAME'].'/doc_commune/770284/ru/Reglementppri.pdf', 'Plan de Prévention de Risque Naturel');
}else{
	$pdf->Write(3, '(approuvé le 16/7/2007)');
}*/
$pdf->PutLink('https://'.$_SERVER['HTTP_HOST'].'/doc_commune/770284/ru/Reglementppri.pdf', 'Plan de Prévention de Risque Naturel');
$pdf->Setxy(145,$y);
//$pdf->Write(3, 'Technologique');
$pdf->Write(3, 'Cognis');
//5eme ligne
$pdf->Ln();
$y=$pdf->GetY()+$acel;
$y1=$y1+3+$acel;
//$y=$pdf->GetY()+$alig;
if($lg_ht=="true"){$lht="okcoche.png";}else{$lht="deco.png";}
$pdf->Image($lht,10,$y,3,3,'','');
$pdf->Setxy(15,$y);
$pdf->Write(3,'Surplomb ligne haute tension');
$pdf->Setxy(75,$y1-2);
/*if ((($_SESSION["profil"]->droit=='AD') or ($_SESSION["profil"]->droit_appli=='e')) and (count($qinon)!=0)){
	$pdf->Write(3, '(approuvé le 16/7/2007)');
}*/
$pdf->SetFont('','I',6);
    $pdf->SetTextColor(0);
    
    
$pdf->Write(3, '(approuvé le 16/7/2007)');
$pdf->SetFont('','',11);

if($pprt=="true"){$ipprt="okcoche.png";}else{$ipprt="deco.png";}
$pdf->Image($ipprt,75,$y,3,3,'','');
$pdf->Setxy(80,$y);
$pdf->Write(3,'PPRT prescrit');

if($archeo=="true"){$archeo="okcoche.png";}else{$archeo="deco.png";}
$pdf->Image($archeo,140,$y,3,3,'','');
$pdf->Setxy(145,$y);
$pdf->Write(3,'Zone de risque archéologique');

//création de l'encart D-Opérations concernant le terrain
$pdf->Ln();
$y=$pdf->GetY()+$aph+$alig;
$pdf->Setxy(8,$y);
$pdf->SetFillColor(225);
$pdf->Cell(195,5,'D-Opérations concernant le terrain ',1,1,'L',1);
$y=$pdf->GetY()+$aph;
if($empl=="true"){$empl="okcoche.png";}else{$empl="deco.png";}
$pdf->Image($empl,10,$y,3,3,'','');
$pdf->Setxy(15,$y);
$pdf->Write(3,'Emplacement Réservé pour équipement public');
//pas de données sur perimetre de rénovaton urbaine donc nocoche par defaut à remplacer par un test si on possede la donnée
$pdf->Image($nocoche,115,$y,3,3,'','');
$pdf->Setxy(120,$y);
$pdf->Write(3,'Périmètre de Rénovation Urbaine');
$pdf->Ln();
$y=$pdf->GetY()+$alig;
//pas de données sur perimetre de Déclaration d'Utilité Publique donc nocoche par defaut à remplacer par un test si on possede la donnée
$pdf->Image($nocoche,10,$y,3,3,'','');
$pdf->Setxy(15,$y);
$pdf->Write(3,'Périmètre de Déclaration d'.chr(180).'Utilité Publique');
//pas de données sur Périmètre de Restauration Immobilière donc nocoche par defaut à remplacer par un test si on possede la donnée
$pdf->Image($nocoche,115,$y,3,3,'','');
$pdf->Setxy(120,$y);
$pdf->Write(3,'Périmètre de Restauration Immobilière');
$pdf->Ln();
$y=$pdf->GetY()+$alig;
//idem pas de donnée
$pdf->Image($nocoche,10,$y,3,3,'','');
$pdf->Setxy(15,$y);
$pdf->Write(3,'Secteur Sauvegardé');
//idem pas de donnée
$pdf->Image($nocoche,115,$y,3,3,'','');
$pdf->Setxy(120,$y);
$pdf->Write(3,'Périmètre de Résorption Habitat Insalubre');
$pdf->Ln();
$y=$pdf->GetY()+$alig;
//idem pas de donnée
if($zac=="true")
{
$zac="okcoche.png";
$ecrizac=" ".$nomzac." créée le ".$creerzac;
if($modzac)
{
$ecrizac=$ecrizac." , modidifiée le ".$modzac;
}

}else{$zac="deco.png";}
$pdf->Image($zac,10,$y,3,3,'','');
$pdf->Setxy(15,$y);
$pdf->Write(3,'Zone d'.chr(180).'Aménagement Concerté'.$ecrizac);

//création de l'encart E-Divers
$pdf->Ln();
$y=$pdf->GetY()+$aph+$alig;
$pdf->Setxy(8,$y);
$pdf->SetFillColor(225);
$pdf->Cell(195,5,'E-Divers ',1,1,'L',1);
$y=$pdf->GetY()+$aph;
//idem pas de donnée
$pdf->Image($nocoche,10,$y,3,3,'','');
$pdf->Setxy(15,$y);
$pdf->Write(3,'Interdiction d'.chr(180).'habiter');
if($bois=="true"){$bois="okcoche.png";}else{$bois="deco.png";}
$pdf->Image($bois,75,$y,3,3,'','');
$pdf->Setxy(80,$y);
$pdf->Write(3,'Espace boisé classé');
//idem pas de donnée
$pdf->Image($nocoche,140,$y,3,3,'','');
$pdf->Setxy(145,$y);
$pdf->Write(3,'Zone de carrière');
$pdf->Ln();
$y=$pdf->GetY()+$alig;
//idem pas de donnée
$pdf->Image($nocoche,10,$y,3,3,'','');
$pdf->Setxy(15,$y);
$pdf->Write(3,'Arrêté de péril');
if($cimet=="true"){$cimet="okcoche.png";}else{$cimet="deco.png";}
$pdf->Image($cimet,75,$y,3,3,'','');
$pdf->Setxy(80,$y);
$pdf->Write(3,'Voisinage cimetière');
if($bruit=="true"){$bruit="okcoche.png";}else{$bruit="deco.png";}
$pdf->Image($bruit,140,$y,3,3,'','');
$pdf->Setxy(145,$y);
$pdf->Write(3,'Secteur de nuisances de bruit');

if($lisiere=="true"){
	$lisiere="okcoche.png";
}else{
	$lisiere="deco.png";
}
if($radio=="true"){
	$radio="okcoche.png";
}else{
	$radio="deco.png";
}
if($halage=="true"){
	$halage="okcoche.png";
}else{
	$halage="deco.png";
}
if($edf=="true"){
	$edf="okcoche.png";
}else{
	$edf="deco.png";
}
if($carriere=="true"){
	$carriere="okcoche.png";
}else{
	$carriere="deco.png";
}

//création de l'encart F-Numérotage
$pdf->Ln();
$y=$pdf->GetY()+$aph+$alig;
$pdf->Setxy(8,$y);
$pdf->SetFillColor(225);
$pdf->Cell(195,5,'F-Numérotage ',1,1,'L',1);
$y=$pdf->GetY()+$aph;
$pdf->Image($numa1,10,$y,3,3,'','');
$pdf->Setxy(15,$y);
$pdf->Write(3,'Le terrain porte le numéro de voirie indiqué dans le cadre en-tête');
$pdf->Ln();
$y=$pdf->GetY()+$alig;
$pdf->Image($numa2,10,$y,3,3,'','');
$pdf->Setxy(15,$y);
$pdf->Write(3,'Le terrain est situé en bordure d'.chr(180).'une voie sans numérotage');


$pdf->SetFont('times','B',8);
$pdf->Settextcolor(255,0,0);
$pdf->SetLeftMargin(21);
$pdf->Setxy(14,290);
$pdf->Write(3,'P.S : La présente notice d'.chr(180).'urbanisme fait état des renseignements connus à ce jour par l'.chr(180).'autorité indiquée ci-contre. Elle constitue un simple document d'.chr(180).'information et ne peut en aucun cas être considérée comme une autorisation administrative quelconque, ni un certificat d'.chr(180).'urbanisme.');

if (($alignement=="okcoche.png"))
{


$result = $DB->tab_result("select XMIN(the_geom),YMIN(the_geom),XMAX(the_geom),Ymax(the_geom) from cadastre.parcelle where identifian in ('$q2')");
for ($i=0; $i<count($result); $i++)
{  
$xmin=$result[$i][0];
	$ymin=$result[$i][1];
	$xmax=$result[$i][2];
	$ymax=$result[$i][3];
}

$xm=$xmin-45;
$xma=$xmax+45;
$yma=$ymax+45;
$ym=$ymin-45;
$h=($yma-$ym);
$l=($xma-$xm);
if($l>$h*(400/326))
{
$yma=$ym+($l/(400/326));
}
else
{
$xma=$xm+($h*(400/326));
}
$idpar = str_replace(",", "','",$obj_keys);
$erreur=error_reporting ();
	error_reporting (1);
	//$serv=$_SERVER["SERVER_NAME"];
	$serv="127.0.0.1";
	$url="http://".$serv."/cgi-bin/mapserv?map=/home/sig/gismeaux/application/capm/RU.map&map_imagetype=jpeg&insee=".$code_insee."&parce=('".$idpar."')&layer=alignement&layer=num_voie&layer=nom_voie&layer=parcelle&layer=batiment&minx=".$xm."&miny=".$ym."&maxx=".$xma."&maxy=".$yma."&mapsize=1240%201040".$extra_url;
     //echo $url;
        $contenu=file($url);
       		while (list($ligne,$cont)=each($contenu)){
			$numligne[$ligne]=$cont;
		}
		$texte=$numligne[0];
	
	$couche=explode("/",$texte);
	$cou=explode(".",$couche[4]);
	$imag='../../tmp/'.$cou[0];
	error_reporting ($erreur);


$pdf->AddPage();
  $pdf->SetFont('times','',11);

//fixe la marge gauche des textes qui suivent après un retour à la ligne(<br>)
  $pdf->SetLeftMargin(15);
//supprime le saut de page
  $pdf->Setautopagebreak(0,0);
//fixe la marge droite des textes qui suivent
  $pdf->SetrightMargin(5);
$pdf->SetTextColor(0);
$pdf->Image("../../logo/".$codeinsee.".png",10,8,$lar,'20','','');
//on se positionne à 130mm du bord gauche et à 15 mm du bord haut
$pdf->Setxy(130,10);
     $pdf->Write(5,$r1[0]['nom'].', le '.date("d").' '.moix(date("m")).' '.date("Y"));
$pdf->SetFont('','B',13);
$pdf->Setxy(85,17);
     $pdf->Write(5,'Renseignement d'.chr(180).'Urbanisme N° I'.$comp.'/'.$annee);
$pdf->SetFont('','',11);
$pdf->Setxy(15,45);
$pdf->Write(5,'Pour contacter le service Urbanisme:');
$pdf->Setxy(15,50);
     $pdf->Write(5,$r1[0]['tel_urba'].' ('.$r1[0]['horaire_urba'].')');
$pdf->Image($imag.".jpg",10,80,'190','154,7','','');
$pdf->Image("legende.PNG",10,250,'40','32','','');
$pdf->Setxy(85,30);
$pdf->SetFillColor(225,225,225);
$pdf->Multicell(115,5,'Le présent document graphique est délivré à titre indicatif. Il ne peut en aucun cas se substituer au plan d'.chr(180).'alignement approuvé, consultable en Mairie. ',1,1,'L',1);
}

// Sortie alternative

$resultpdf = $pdf->Output('', 'S');
$pdfname = 'fiche_ru_'.$n.'_'.$annee.'.pdf';

header('Content-disposition: inline; filename='.$pdfname);
header('Content-type: application/pdf');
die($resultpdf);

// Fin sortie alternative

$pdf->Output();
/*$file=tempnam('../../tmp','tmp');
rename($file,$file.'.pdf');
$file.='.pdf';

//Sauvegarde du PDF dans le fichier
$pdf->Output($file);
$file=basename($file);

//Redirection JavaScript
echo "<HTML><SCRIPT>document.location='../../tmp/$file';</SCRIPT></HTML>";*/

}
?>
