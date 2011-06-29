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

define('GIS_ROOT','.');
include_once(GIS_ROOT . '/inc/common.php');


$map = $_GET["map"];
$insee = $_GET["insee"];
$layer = $_GET["layer"];
$minx = $_GET["minx"];
$miny = $_GET["miny"];
$maxx = $_GET["maxx"];
$maxy = $_GET["maxy"];
$parce = $_GET["parce"];
$sess = $_GET["sess"];
$idparc = $_GET["idparc"];
$digest = $map."/";
        
$fmap = ms_newMapObj($map);
$fmap->setExtent($minx,$miny,$maxx,$maxy);
$size = explode(" ",$_GET['mapsize']);
$fmap->setSize($size[0], $size[1]);

$fmap->setconfigoption("parce",$parce);
$fmap->setconfigoption("insee",$insee);
$fmap->applyconfigoptions();
for ($l = 0; $l < $fmap->numlayers; $l++)
  {
    $lay = $fmap->getLayer($l);
    $lay->set("status",MS_OFF);
    if ($insee)
      $lay->setFilter(str_replace('%insee%',$insee,$lay->getFilter()));
    if ($sess)
      $lay->setFilter(str_replace('%sess%',$sess,$lay->getFilter()));
    if ($idparc)
      $lay->setFilter(str_replace('%idparc%',$idparc,$lay->getFilter()));
  }
foreach ($layer as $l)
{
  if ($l)
    {
      $digest.=$l."/";
      $fmap->getLayerByName($l)->set("status",MS_ON);
    }
}
$digest.="$insee/$minx/$miny/$maxx/$maxy/$parce/$sess";
$name = "/tmp/".$fmap->name.md5($digest).".png";
if (!file_exists("/home/sig/gismeaux/application".$name))
  {
    $image=$fmap->draw();
    $image_url=$image->saveImage("/home/sig/gismeaux/application".$name);
    //    echo $image_url;
    //rename("/home/sig/gismeaux/application".$image_url,"/home/sig/gismeaux/application/".$name);
    passthru('mogrify -colors 32 /home/sig/gismeaux/application'.$name);
  }

echo get_root_url();
echo $name;

?>
