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
define('GIS_ROOT', '..');
include_once(GIS_ROOT . '/inc/common.php');
gis_session_start();
error_reporting (1);
$extra_url = "&user=".$DB->db_user."&password=".$DB->db_passwd."&dbname=".$DB->db_name."&host=".$DB->db_host;

if ($map_mode)
        $extra_url .= "&mode=map";


//$url_qrcode="https://".$_SERVER["HTTP_HOST"]."/interface/printpdf.php?format=".$_GET['format']."&legende=".$_GET['legende']."&titre=".$_GET['titre']."&raster=".$_GET['raster']."&x=".$_GET['x']."&y=".$_GET['y']."&lar=".$_GET['lar']."&hau=".$_GET['hau']."&zoom=".$_GET['zoom']."&xini=".$_GET['xini']."&yini=".$_GET['yini']."&parce=".$_GET['parce']."&echelle=".$_GET['echelle'];



function generateQRCode($string='Nothing Here !', $size=30, $displayStringAlt=false)
{
 $sqSize = $size.'x'.$size;
 $imgURL = 'http://chart.apis.google.com/chart?cht=qr&chs='.$sqSize.'&chl='.urlencode($string);

 /*if ($displayStringAlt)
   return '<img src="'.$imgURL.'" alt="'.$string.'" />';
 else
   return '<img src="'.$imgURL.'" alt="" />';*/
   return $imgURL;
}

$xi=$_GET['x'];
$orientation='P';
$unit='mm';
$aph=4; //espace avant paragraphe
$alig=5; //espace entre ligne
$acel=2; //espace entre deux ligne dans la meme cellule
$rastx=explode(";",$_GET['raster']);
$raster="";
for($i=0;$i<count($rastx);$i++)
  {
    $ras=explode(".",$rastx[$i]);
    $raster.=$ras[1].";";
  }
$raster=substr($raster,0,strlen($raster)-1);

$raste=str_replace("_"," ",$raster);
$raste=explode(";",$raste);
$raster=str_replace(";","&layer=",$raster);
define('FPDF_FONTPATH','../fpdf/font/');
require('../fpdf/fpdf.php');
class PDF extends FPDF {
  var $B;
  var $I;
  var $U;
  var $HREF;
  var $angle=0;
  var $extgstates;
  
  function SetAlpha($alpha, $bm='Normal')
  {
    // set alpha for stroking (CA) and non-stroking (ca) operations
    $gs = $this->AddExtGState(array('ca'=>$alpha, 'CA'=>$alpha, 'BM'=>'/'.$bm));
    $this->SetExtGState($gs);
  }
  
  function AddExtGState($parms)
  {
    $n = count($this->extgstates)+1;
    $this->extgstates[$n]['parms'] = $parms;
    return $n;
  }

  function SetExtGState($gs)
  {
    $this->_out(sprintf('/GS%d gs', $gs));
  }

  function _enddoc()
  {
    if(!empty($this->extgstates) && $this->PDFVersion<'1.4')
      $this->PDFVersion='1.4';
    parent::_enddoc();
  }
  
  function _putextgstates()
  {
    for ($i = 1; $i <= count($this->extgstates); $i++)
      {
	$this->_newobj();
	$this->extgstates[$i]['n'] = $this->n;
	$this->_out('<</Type /ExtGState');
	foreach ($this->extgstates[$i]['parms'] as $k=>$v)
	  $this->_out('/'.$k.' '.$v);
	$this->_out('>>');
	$this->_out('endobj');
      }
  }
  
  function _putresourcedict()
  {
    parent::_putresourcedict();
    $this->_out('/ExtGState <<');
    foreach($this->extgstates as $k=>$extgstate)
      $this->_out('/GS'.$k.' '.$extgstate['n'].' 0 R');
    $this->_out('>>');
  }
  
  function _putresources()
  {
    $this->_putextgstates();
    parent::_putresources();
  }
  
  
  function Rotate($angle,$x=-1,$y=-1)
  {
    if($x==-1)
      $x=$this->x;
    if($y==-1)
      $y=$this->y;
    if($this->angle!=0)
      $this->_out('Q');
    $this->angle=$angle;
    if($angle!=0)
      {
        $angle*=M_PI/180;
        $c=cos($angle);
        $s=sin($angle);
        $cx=$x*$this->k;
        $cy=($this->h-$y)*$this->k;
        $this->_out(sprintf('q %.5f %.5f %.5f %.5f %.2f %.2f cm 1 0 0 1 %.2f %.2f cm',$c,$s,-$s,$c,$cx,$cy,-$cx,-$cy));
      }
  }
  
  function _endpage()
  {
    if($this->angle!=0)
      {
        $this->angle=0;
        $this->_out('Q');
      }
    parent::_endpage();
  }
  
  function RotatedText($x,$y,$txt,$angle)
  {
    //Rotation du texte autour de son origine
    $this->Rotate($angle,$x,$y);
    $this->Text($x,$y,$txt);
    $this->Rotate(0);
  }
  
  function RotatedImage($file,$x,$y,$w,$h,$angle)
  {
    //Rotation de l'image autour du coin supérieur gauche
    $this->Rotate($angle,$x,$y);
    $this->Image($file,$x,$y,$w,$h);
    $this->Rotate(0);
  }
  
  function RotatedCell($angle,$x,$y,$w,$h,$txt,$bor,$ln,$aling)
  {
    //Rotation de la celulle autour du coin supérieur gauche
    $this->Rotate($angle,$x,$y);
    $this->Cell($w,$h,$txt,$bor,$ln,$aling); 
    $this->Rotate(0);
  }
  
  function PutLink($URL,$txt){
    //Place un hyperlien
    $this->SetTextColor(0,0,255);
    $this->SetStyle('U',true);
    $this->Write(3,$txt,$URL);
    $this->SetStyle('U',false);
    $this->SetTextColor(0);
  }
  
  function SetStyle($tag,$enable)
  {
    //Modifie le style et sélectionne la police correspondante
    $this->$tag+=($enable ? 1 : -1);
    $style='';
    $this->SetFont('times','',11);
    foreach(array('7','8','9','10','11','12','13','14','24') as $p)
      if($this->$p>0)
	$police.=$p;
    foreach(array('B','I','U') as $s)
      if($this->$s>0)
	$style.=$s;
    $this->SetFont('',$style,$police);
    
  }
}

$insee=$_SESSION['profil']->insee;
if (strlen($insee) == 3)
  $insee = $insee . '000';
$sql="select a.nom,a.logo,a.larg_logo,b.logo as logo_communaute,b.larg_logo as larg_communaute from admin_svg.commune as a left join admin_svg.commune as b on  a.idagglo=b.idcommune where a.idcommune='".$insee."'";
$retour=$DB->tab_result($sql);
// omigeot : desormais, on ne verifie plus l'existence du champ "larg_logo", mais celui de logo directement.
// Ainsi, on peut livrer une DB par defaut independante du repertoire d'installation, mais aussi pointer 
// vers des images situees en dehors de l'arborescence de Gismeaux, les rendant resistantes a la reinstallation
// de ce dernier.
if($retour[0]['logo']!="") 
  {
    $larglogo=($retour[0]['larg_logo']/2.5);
    $logo=$retour[0]['logo'];
  }
 else
   {
     $larglogo=($retour[0]['larg_communaute']/2.5);
     $logo=$retour[0]['logo_communaute'];
   }
$xm=$_GET['x'] + $_GET['xini'];
$xma=($_GET['x']+$_GET['lar']) + $_GET['xini'];
$yma= $_GET['yini'] - $_GET['y'];
$ym= $_GET['yini'] - ($_GET['y']+$_GET['hau']);
$mapsize="";
$tableau=$_SESSION["cotation"];
if(is_array($tableau))
  {
    for($ij=0;$ij<count($tableau);$ij++)
      {
	$coor=explode("|",$tableau[$ij]);
	$x1=$_GET['xini']+$coor[0];
	$y1=$_GET['yini']-$coor[1];
	$x2=$_GET['xini']+$coor[2];
	$y2=$_GET['yini']-$coor[3];
	
	$lo=2;
	
	$angl="";
	if($x1<=$x2 && $y2<=$y1)
	  {
	    $cosfl=($x2-$x1)/$coor[7];
	    $anglfl=rad2deg(acos($cosfl));
	    $dx=$x1+($lo*cos(deg2rad($anglfl+30)));
	    $dy=$y1-($lo*sin(deg2rad($anglfl+30)));
	    $dx1=$x1+($lo*cos(deg2rad($anglfl-30)));
	    $dy1=$y1-($lo*sin(deg2rad($anglfl-30)));
	    $dx2=$x2+($lo*cos(deg2rad($anglfl+210)));
	    $dy2=$y2-($lo*sin(deg2rad($anglfl+210)));
	    $dx3=$x2+($lo*cos(deg2rad($anglfl+150)));
	    $dy3=$y2-($lo*sin(deg2rad($anglfl+150)));
	    
	  }
	else if($x1<=$x2 && $y2>=$y1)
	  {
	    $cosfl=($x2-$x1)/$coor[7];
	    $anglfl=rad2deg(acos($cosfl));
	    $dx=$x1+($lo*cos(deg2rad($anglfl+30)));
	    $dy=$y1+($lo*sin(deg2rad($anglfl+30)));
	    $dx1=$x1+($lo*cos(deg2rad($anglfl-30)));
	    $dy1=$y1+($lo*sin(deg2rad($anglfl-30)));
	    $dx2=$x2+($lo*cos(deg2rad($anglfl+210)));
	    $dy2=$y2+($lo*sin(deg2rad($anglfl+210)));
	    $dx3=$x2+($lo*cos(deg2rad($anglfl+150)));
	    $dy3=$y2+($lo*sin(deg2rad($anglfl+150)));
	    
	  }
	else if($x1>=$x2 && $y2<=$y1)
	  {
	    $cosfl=($x2-$x1)/$coor[7];
	    $anglfl=rad2deg(acos($cosfl));
	    $dx=$x1+($lo*cos(deg2rad($anglfl+30)));
	    $dy=$y1-($lo*sin(deg2rad($anglfl+30)));
	    $dx1=$x1+($lo*cos(deg2rad($anglfl-30)));
	    $dy1=$y1-($lo*sin(deg2rad($anglfl-30)));
	    $dx2=$x2+($lo*cos(deg2rad($anglfl+210)));
	    $dy2=$y2-($lo*sin(deg2rad($anglfl+210)));
	    $dx3=$x2+($lo*cos(deg2rad($anglfl+150)));
	    $dy3=$y2-($lo*sin(deg2rad($anglfl+150)));
	    
	  }
	else
	  {
	    $cosfl=($x2-$x1)/$coor[7];
	    $anglfl=rad2deg(acos($cosfl));
	    $dx=$x1+($lo*cos(deg2rad($anglfl+30)));
	    $dy=$y1+($lo*sin(deg2rad($anglfl+30)));
	    $dx1=$x1+($lo*cos(deg2rad($anglfl-30)));
	    $dy1=$y1+($lo*sin(deg2rad($anglfl-30)));
	    $dx2=$x2+($lo*cos(deg2rad($anglfl+210)));
	    $dy2=$y2+($lo*sin(deg2rad($anglfl+210)));
	    $dx3=$x2+($lo*cos(deg2rad($anglfl+150)));
	    $dy3=$y2+($lo*sin(deg2rad($anglfl+150)));
	    
	  }
	
	
	
	$polygo=$x1." ".$y1.",".$x2." ".$y2;
	$sql="insert into admin_svg.temp_cotation (the_geom,valeur,session_temp,type) values(GeometryFromtext('MULTILINESTRING((".$polygo."))',$projection),'".$coor[7]."','".session_id()."','line')";
	
	$DB->exec($pgx,$sql);
	$sql="insert into admin_svg.temp_cotation (the_geom,session_temp,type) values(GeometryFromtext('MULTILINESTRING((".$x1." ".$y1.",".$dx." ".$dy."),(".$x1." ".$y1.",".$dx1." ".$dy1."),(".$x2." ".$y2.",".$dx2." ".$dy2."),(".$x2." ".$y2.",".$dx3." ".$dy3."))',$projection),'".session_id()."','fleche')";
		$DB->exec($sql);
      }
  }
  {
    for($ij=0;$ij<count($tableau);$ij++)
      {
	$coor=explode("|",$tableau[$ij]);
	$x1=$_GET['xini']+$coor[0];
	$y1=$_GET['yini']-$coor[1];
	$x2=$_GET['xini']+$coor[2];
	$y2=$_GET['yini']-$coor[3];
	
	$lo=2;
	
	$angl="";
	if($x1<=$x2 && $y2<=$y1)
	  {
	    $cosfl=($x2-$x1)/$coor[7];
	    $anglfl=rad2deg(acos($cosfl));
	    $dx=$x1+($lo*cos(deg2rad($anglfl+30)));
	    $dy=$y1-($lo*sin(deg2rad($anglfl+30)));
	    $dx1=$x1+($lo*cos(deg2rad($anglfl-30)));
	    $dy1=$y1-($lo*sin(deg2rad($anglfl-30)));
	    $dx2=$x2+($lo*cos(deg2rad($anglfl+210)));
	    $dy2=$y2-($lo*sin(deg2rad($anglfl+210)));
	    $dx3=$x2+($lo*cos(deg2rad($anglfl+150)));
	    $dy3=$y2-($lo*sin(deg2rad($anglfl+150)));
	    
	  }
	else if($x1<=$x2 && $y2>=$y1)
	  {
	    $cosfl=($x2-$x1)/$coor[7];
	    $anglfl=rad2deg(acos($cosfl));
	    $dx=$x1+($lo*cos(deg2rad($anglfl+30)));
	    $dy=$y1+($lo*sin(deg2rad($anglfl+30)));
	    $dx1=$x1+($lo*cos(deg2rad($anglfl-30)));
	    $dy1=$y1+($lo*sin(deg2rad($anglfl-30)));
	    $dx2=$x2+($lo*cos(deg2rad($anglfl+210)));
	    $dy2=$y2+($lo*sin(deg2rad($anglfl+210)));
	    $dx3=$x2+($lo*cos(deg2rad($anglfl+150)));
	    $dy3=$y2+($lo*sin(deg2rad($anglfl+150)));
	    
	  }
	else if($x1>=$x2 && $y2<=$y1)
	  {
	    $cosfl=($x2-$x1)/$coor[7];
	    $anglfl=rad2deg(acos($cosfl));
	    $dx=$x1+($lo*cos(deg2rad($anglfl+30)));
	    $dy=$y1-($lo*sin(deg2rad($anglfl+30)));
	    $dx1=$x1+($lo*cos(deg2rad($anglfl-30)));
	    $dy1=$y1-($lo*sin(deg2rad($anglfl-30)));
	    $dx2=$x2+($lo*cos(deg2rad($anglfl+210)));
	    $dy2=$y2-($lo*sin(deg2rad($anglfl+210)));
	    $dx3=$x2+($lo*cos(deg2rad($anglfl+150)));
	    $dy3=$y2-($lo*sin(deg2rad($anglfl+150)));
	    
	  }
	else
	  {
	    $cosfl=($x2-$x1)/$coor[7];
	    $anglfl=rad2deg(acos($cosfl));
	    $dx=$x1+($lo*cos(deg2rad($anglfl+30)));
	    $dy=$y1+($lo*sin(deg2rad($anglfl+30)));
	    $dx1=$x1+($lo*cos(deg2rad($anglfl-30)));
	    $dy1=$y1+($lo*sin(deg2rad($anglfl-30)));
	    $dx2=$x2+($lo*cos(deg2rad($anglfl+210)));
	    $dy2=$y2+($lo*sin(deg2rad($anglfl+210)));
	    $dx3=$x2+($lo*cos(deg2rad($anglfl+150)));
	    $dy3=$y2+($lo*sin(deg2rad($anglfl+150)));
	    
	  }
	
	
	$polygo=$x1." ".$y1.",".$x2." ".$y2;
	$sql="insert into admin_svg.temp_cotation (the_geom,valeur,session_temp,type) values(GeometryFromtext('MULTILINESTRING((".$polygo."))',$projection),'".$coor[7]."','".session_id()."','line')";
	$DB->exec($sql);
	$sql="insert into admin_svg.temp_cotation (the_geom,session_temp,type) values(GeometryFromtext('MULTILINESTRING((".$x1." ".$y1.",".$dx." ".$dy."),(".$x1." ".$y1.",".$dx1." ".$dy1."),(".$x2." ".$y2.",".$dx2." ".$dy2."),(".$x2." ".$y2.",".$dx3." ".$dy3."))',$projection),'".session_id()."','fleche')";
	$DB->exec($sql);
      }
  }

if($_GET['legende']==1 || $_GET['legende']==2)
  {
    $vision="pay";
    $angle=90;
    if($_GET['format']=='A4')
      {
	$xqrcode=180;
	$yqrcode=265; 
	$px=20;
	$py=280;
	$rect=3;
	$posiximage=15;
	$posiyimage=233;
	$posixrosa=195;
	$posiyrosa=233;
	$sizerosa=40;
	$posixlogo=8;
	$posiylogo=280;
	$larlogo=$larglogo;
	$haulogo=11;
	$posixechelle=203;
	$posiyechelle=220;
	$sizeechelle=12;
	$xtitre=144;
	$ytitre=149;
	$wtitre=265;
	$htitre=10;
	$sizetitre=20;
	$larimage=220;
	$hauimage=184.5;
	$mapsize='&mapsize=1240%201040';
	$ratioechelle=2;
	   }
    elseif($_GET['format']=='A3')
      {
	$xqrcode=190*(29.7/21);
	$yqrcode=275*(29.7/21);  
	$posiximage=15*(29.7/21);
	$posiyimage=233*(29.7/21);
	$larimage=220*(29.7/21);
	$hauimage=184.5*(29.7/21);
	$px=20*(29.7/21);
	$py=280*(29.7/21);
	$rect=3;
	$posixrosa=195*(29.7/21);
	$posiyrosa=233*(29.7/21);
	$sizerosa=50;
	$posixlogo=8*(29.7/21);
	$posiylogo=280*(29.7/21);
	$larlogo=$larglogo*(29.7/21);
	$haulogo=11*(29.7/21);
	$posixechelle=203*(29.7/21);
	$posiyechelle=220*(29.7/21);
	$sizeechelle=14;
	$xtitre=144*(29.7/21);
	$ytitre=149*(29.7/21);
	$wtitre=265*(29.7/21);
	$htitre=10*(29.7/21);
	$sizetitre=25;
	$mapsize='&mapsize=1753.7%201470.9';
	$ratioechelle=2;
      }
    elseif($_GET['format']=='A2')
      {
	$xqrcode=190*2;
	$yqrcode=275*2;   
	$posiximage=15*2;
	$posiyimage=233*2;
	$larimage=220*2;
	$hauimage=184.5*2;
	$px=20*2;
	$py=280*2;
	$rect=3;
	$posixrosa=195*2;
	$posiyrosa=233*2;
	$sizerosa=55;
	$posixlogo=8*2;
	$posiylogo=280*2;
	$larlogo=$larglogo*2;
	$haulogo=11*2;
	$posixechelle=203*2;
	$posiyechelle=220*2;
	$sizeechelle=18;
	$xtitre=144*2;
	$ytitre=149*2;
	$wtitre=265*2;
	$htitre=10*2;
	$sizetitre=30;
	$ratioechelle=2.5;
      }
    elseif($_GET['format']=='A1')
      {
	$xqrcode=190*2*(29.7/21);
	$yqrcode=275*2*(29.7/21);   
	$posiximage=15*2*(29.7/21);
	$posiyimage=233*2*(29.7/21);
	$larimage=220*2*(29.7/21);
	$hauimage=184.5*2*(29.7/21);
	$px=20*2*(29.7/21);
	$py=280*2*(29.7/21);
	$rect=3;
	$posixrosa=195*2*(29.7/21);
	$posiyrosa=233*2*(29.7/21);
	$sizerosa=60;
	$posixlogo=8*2*(29.7/21);
	$posiylogo=280*2*(29.7/21);
	$larlogo=$larglogo*2*(29.7/21);
	$haulogo=11*2*(29.7/21);
	$posixechelle=203*2*(29.7/21);
	$posiyechelle=220*2*(29.7/21);
	$sizeechelle=22;
	$xtitre=144*2*(29.7/21);
	$ytitre=149*2*(29.7/21);
	$wtitre=265*2*(29.7/21);
	$htitre=10*2*(29.7/21);
	$sizetitre=35;
	
	$ratioechelle=2.5/(29.7/21);
      }
    else
      {
	$xqrcode=190*4;
	$yqrcode=275*4;   
	$posiximage=15*4;
	$posiyimage=233*4;
	$larimage=220*4;
	$hauimage=184.5*4;
	$px=20*4;
	$py=280*4;
	$rect=3;
	$posixrosa=195*4;
	$posiyrosa=233*4;
	$sizerosa=70;
	$posixlogo=8*4;
	$posiylogo=280*4;
	$larlogo=$larglogo*4;
	$haulogo=11*4;
	$posixechelle=203*4;
	$posiyechelle=220*4;
	$sizeechelle=25;
	$xtitre=144*4;
	$ytitre=149*4;
	$wtitre=265*4;
	$htitre=10*4;
	$sizetitre=40;
	$ratioechelle=2.5/2;
      }
  }
 else
   {
     $vision="por";
     $angle=0;
     if($_GET['format']=='A4')
       {
	 $xqrcode=180;
	 $yqrcode=265;
	 $px=20;
	 $py=200;
	 $rect=3;
	 $sizerosa=40;
	 $sizeechelle=12;
	 $sizetitre=20;
	 $posiximage=17.5;
	 $posiyimage=30;
	 $posixrosa=178;
	 $posiyrosa=172;
	 $posixlogo=5;
	 $posiylogo=10;
	 $larlogo=$larglogo;
	 $haulogo=11;
	 $posixechelle=25;
	 $posiyechelle=185;
	 $xtitre=0;
	 $ytitre=0;
	 $wtitre=180;
	 $htitre=10;
	 $larimage=175;
	 $hauimage=146.77;
	 $mapsize='&mapsize=1240%201040';
	 $ratioechelle=2/(146.77/184.5);
       }
     elseif($_GET['format']=='A3')
       {
	 $xqrcode=190*(29.7/21);
	 $yqrcode=275*(29.7/21);  
	 $px=20*(29.7/21);
	 $py=200*(29.7/21);
	 $rect=3;
	 $sizerosa=50;
	 $sizeechelle=14;
	 $sizetitre=25;
	 $posixrosa=178*(29.7/21);
	 $posiyrosa=172*(29.7/21);
	 $posixlogo=5*(29.7/21);
	 $posiylogo=10*(29.7/21);
	 $larlogo=$larglogo*(29.7/21);
	 $haulogo=11*(29.7/21);
	 $posixechelle=25*(29.7/21);
	 $posiyechelle=185*(29.7/21);
	 $xtitre=0;
	 $ytitre=0;
	 $wtitre=180*(29.7/21);
	 $htitre=10*(29.7/21);
	 $posiximage=17.5*(29.7/21);
	 $posiximage=17.5*(29.7/21);
	 $posiyimage=30*(29.7/21);
	 $larimage=247.5;
	 $hauimage=207.57;
	 $mapsize='&mapsize=1753.7%201470.9';
	 $ratioechelle=2/(207.57/(184.5*(29.7/21)));
       }
     
   }

if (!$ratioechelle)
  $ratioechelle = 1;

if (!$_GET['echelle'])
  $_GET['echelle'] = 1;

$ech="&mapxy=".($xm+($xma-$xm)/2).'%20'.($ym+($yma-$ym)/2)."&SCALE=".($_GET['echelle'])/$ratioechelle;
//$raster=str_replace(";","&layer=",$raster);
//$erreur=error_reporting ();
//error_reporting (1);
//$serv=$_SERVER["SERVER_NAME"];
$serv="127.0.0.1";
if(substr($_SESSION['profil']->insee, -3)=='000')
  {
    $code_insee=substr($_SESSION['profil']->insee,0,3);
  }
 else
   {
     $code_insee=$insee;
   }
//$_SESSION['appli'] = 2; // Attention, ceci semble nécessaire, la session n'était pas spécialement bien configurée :(
if($_GET['idappli']!="")
{
$idappli=$_GET['idappli'];
}
else
{
$idappli=$_SESSION["profil"]->appli;
}
$sql_app="select supp_chr_spec(libelle_appli) as libelle_appli from admin_svg.application where idapplication='".$idappli."'";
$app=$DB->tab_result($sql_app);
$application=$app[0]['libelle_appli'];
//$application=str_replace(" ","_",$application);

//$url='http://'.$serv.'/cgi-bin/mapserv?map='.$fs_root.'/capm/'.$application.'.map&insee='.$code_insee.'&sess='.session_id().'&parce='.stripslashes($_GET['parce']).'&map_imagetype=jpeg&layer=cotation&layer='.$raster.$ech.$mapsize.$extra_url;
$url='http://'.$serv.'/cgi-bin/mapserv?map='.$fs_root.'/capm/'.$application.'.map&insee='.$code_insee.'&sess='.session_id().'&parce='.stripslashes($_GET['parce']).'&map_imagetype=agg&layer=cotation&layer='.$raster.$ech.$mapsize.$extra_url;

if ($map_mode) {
        $image = "msnew-" .md5($url);
        if (!file_exists($fs_root."/tmp/".$image . ".jpg"))
        {
                $contenu = file_get_contents($url.$extra_url);
                $fd = fopen($fs_root."/tmp/".$image . ".jpg" ,'w');
                fwrite($fd,$contenu);
                fclose($fd);
        }
} else {
        $contenu=file($url);
                while (list($ligne,$cont)=each($contenu)){
                        $numligne[$ligne]=$cont;
                }
                $texte=$contenu[$ms_dbg_line];
                $image=explode('/',$texte);
                $conte1=explode('.',$image[4]);
                $image=$conte1[0];
        }


$sql="delete from admin_svg.temp_cotation where session_temp='".session_id()."'";
$DB->exec($sql);

//variable
//creation du fichier pdf
$pdf=new PDF();
$pdf->Open();
//$pdf->FPDF($orientation,$unit,$_GET['format']);
//$format="A4";
//phpinfo();
//echo $_GET["format"];
$pdf->FPDF($orientation,$unit,$_GET['format']);
//$pdf->FPDF('P','mm','A4');
//création page
$pdf->AddFont('font1','','font1.php');
$pdf->AddPage();
$pdf->RotatedImage('../tmp/'.$image.'.jpg',$posiximage,$posiyimage,$larimage,$hauimage,$angle);
$pdf->SetFont('font1','',$sizerosa);
//echo $logo.",".$posixlogo.",".$posiylogo.",".$larlogo.",".$haulogo.",".$angle;
$pdf->RotatedText($posixrosa,$posiyrosa,'a',$angle);
if ($logo != "")
  if ($logo[0] != '/') // Si le chemin du logo est relatif, le faire decouler de fs_root
    $pdf->RotatedImage($logo,$posixlogo,$posiylogo,$larlogo,$haulogo,$angle);
  else
    $pdf->RotatedImage($fs_root."/".$logo,$posixlogo,$posiylogo,$larlogo,$haulogo,$angle);
$pdf->SetFont('arial','',$sizetitre);
$pdf->RotatedCell($angle,$xtitre,$ytitre,$wtitre,$htitre,$_GET['titre'],0,0,'C'); 
$pdf->RotatedText(15, 15, $titre,0);
$pdf->SetFont('arial','',$sizeechelle);
if($_GET['echelle']==0)
  {
    $pdf->RotatedText($posixechelle,$posiyechelle,'Sans échelle',$angle);
  }
 else
   {
     $pdf->RotatedText($posixechelle,$posiyechelle,'1/'.$_GET['echelle'].' ème',$angle);
   }
if ($print_basic_copyright)
{
  $pdf->SetFont('arial','',6);
  $pdf->RotatedText(5, 5, "Les photographies sont propriété de l'IGN, les données cadastrales sont propriété de la DGI. Reproduction interdite.",0);
}
//génération du qrcode;
$url_qrcode="https://".$_SERVER["HTTP_HOST"]."/interface/qrprint.php?var=".$application."$".$_GET['x']."$".$_GET['y']."$".$_GET['lar']."$".$_GET['hau']."$".$_GET['zoom']."$".$_GET['format']."$".$_GET['legende']."$".$_GET['titre']."$".$_GET['echelle']."$".$_GET['parce']."$".$_GET['raster'];

$pdf->Image(generateQRCode($url_qrcode,100) ,$xqrcode, $yqrcode, 30, 30, 'PNG'); 

$pdf->SetDrawColor(0);
$pdf->SetFont('arial','',10);
if($_GET['legende']==1 || $_GET['legende']==3)
  {
    $legende="";
    
    //$pyy=250;
    $idprov="";
    for($i=0;$i<count($rastx);$i++)
      {
	$ra=explode(".",$rastx[$i]);
	$id=$ra[0];
	$lib=str_replace("_"," ",$ra[1]);;
	if($id!="")
	  {
	    $req1="select col_theme.intitule_legende as intitule_legende,theme.libelle_them,col_theme.fill,col_theme.symbole,col_theme.opacity,col_theme.ordre,col_theme.stroke_rgb,style.fill as style_fill,style.symbole as style_symbole,style.opacity as style_opacity,style.font_size  as style_fontsize,style.stroke_rgb  as style_stroke from admin_svg.appthe left outer join admin_svg.col_theme on appthe.idappthe=col_theme.idappthe join admin_svg.theme on appthe.idtheme=theme.idtheme left outer join admin_svg.style on appthe.idtheme=style.idtheme where appthe.idappthe='".$id."'  and (intitule_legende='".$lib."' or libelle_them='".$lib."')";
	    
	    $couch=$DB->tab_result($req1);
	    
	    if($couch[0]['intitule_legende']=="")
	      {
		$legend=$couch[0]['libelle_them'];
		if($couch[0]['style_fill']!="" && $couch[0]['style_fill']!="none")
		  {
		    $couleu=$couch[0]['style_fill'];
		  }
		else
		  {
		    $couleu=$couch[0]['style_stroke'];
		  }
		if($couch[0]['style_opacity']!=0 && $couch[0]['style_opacity']!="")
		  {
		    $apocit=$couch[0]['style_opacity'];
		  }
		else
		  {
		    $apocit=1;
		  }
	      }
	    else
	      {
		$legend=$couch[0]['intitule_legende'];
		//$couleu=$couch[0]['fill'];
		if($couch[0]['fill']!="" && $couch[0]['fill']!="none")
		  {
		    $couleu=$couch[0]['fill'];
		  }
		else
		  {
		    $couleu=$couch[0]['stroke_rgb'];
		  }
		if($couch[0]['opacity']!=0)
		  {
		    $apocit=$couch[0]['opacity'];
		  }
		else
		  {
		    $apocit=1;
		  }
	      }
	    
	    if(in_array($legend,$raste) and $couleu!="")
	      {
		if($idprov!=$id && $idprov!="")
		  {
		    if($vision=="pay")
		      {	
			$px=$px+2;
		      }
		    else
		      {
			$py=$py+2;
		      }
		  }
		if($couch[0]['intitule_legende']!="" && $couch[0]['libelle_them']!="" && $idprov!=$id)
		  {
		    if($vision=="pay")
		      {	
			$px=$px+3;
			$pdf->RotatedText($px,$py+3,$couch[0]['libelle_them'],$angle);
		      }
		    else
		      {
			$py=$py+3;
			$pdf->RotatedText($px,$py,$couch[0]['libelle_them'],$angle);
		      }
		    
		    $idprov=$id;
		    if($vision=="pay")
		      {
			$px=$px+2;
		      }
		    else
		      {
			$py=$py+2;
		      }
		  }
		
		$coul = explode(",", $couleu);
		$pdf->SetAlpha($apocit);
		$pdf->SetFillColor($coul[0],$coul[1],$coul[2]);
		$pdf->Rect($px,$py,$rect,$rect,F);
		$pdf->SetAlpha(1);
		$pdf->Rect($px,$py,$rect,$rect,D);
		//$pdf->Text(8,$pyy,$legend);
		if($vision=="pay")
		  {
		    $pdf->RotatedText($px+3,$py-2,$legend,$angle);
		  }
		else
		  {
		    $pdf->RotatedText($px+5,$py+3,$legend,$angle);
		  }
		//$pyy=$pyy+3;
		if($vision=="pay")
		  {
		    $px=$px+5;
		  }
		else
		  {
		    $py=$py+5;
		    if($_GET['format']=='A4' && $py>280)
		      {
			$py=200;
			$px=$px+50;
		      }
		    if($_GET['format']=='A3' && $py>395)
		      {
			$py=200*(29.7/21);
			$px=$px+50;
		      }
		  }
		
		
	      }
	    
	  }
      }
  }
$pdf->Output();
die();
?> 
