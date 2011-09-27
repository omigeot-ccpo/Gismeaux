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
define('GIS_ROOT', '..');
include_once(GIS_ROOT . '/inc/common.php');
gis_session_start();
ini_set("memory_limit" , "100M");
set_time_limit(0);
if ($_SESSION['profil']->protocol)
{
	$protocol = $_SESSION['profil']->protocol;
} else {
	$protocol='https';
	if($_SERVER['SERVER_PORT']!=443)
	{
		$protocol='http';
	}
}
$extra_url = "&user=".$DB->db_user."&password=".$DB->db_passwd."&dbname=".$DB->db_name."&host=".$DB->db_host;

if ($map_mode)
        $extra_url .= "&mode=map";

$countlayer=1;
//$serv=$_SERVER["SERVER_NAME"];
$serv="127.0.0.1";
$placeid=explode(",",$_GET['parce']);
$xm=$_GET['x'] + $_GET['xini'];
$xma=($_GET['x']+$_GET['lar']) + $_GET['xini'];
$yma= $_GET['yini'] - $_GET['y'];
$ym= $_GET['yini'] - ($_GET['y']+$_GET['hau']);
$filename = "../tmp/".$_GET['nom'].".svg";
$myFile = fopen($filename, "w");  
$str1="<?xml version=\"1.0\" encoding=\"ISO-8859-1\" standalone=\"no\"?>";
$str1.="<!DOCTYPE svg PUBLIC \"-//W3C//DTD SVG 1.0//EN\" \"http://www.w3.org/TR/2001/REC-SVG-20010904/DTD/svg10.dtd\">";
$str1.="<svg 
   xmlns:dc=\"http://purl.org/dc/elements/1.1/\"
   xmlns:cc=\"http://web.resource.org/cc/\"
   xmlns:rdf=\"http://www.w3.org/1999/02/22-rdf-syntax-ns#\"
   xmlns:svg=\"http://www.w3.org/2000/svg\"
   xmlns=\"http://www.w3.org/2000/svg\"
   xmlns:xlink=\"http://www.w3.org/1999/xlink\"
   xmlns:sodipodi=\"http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd\"
   xmlns:inkscape=\"http://www.inkscape.org/namespaces/inkscape\"
   inkscape:output_extension=\"org.inkscape.output.svg.inkscape\"
   id=\"svg2\"
   width=\"1052.36px\"
   height=\"744.09px\"
   >";
$str1.="<sodipodi:namedview
     inkscape:current-layer=\"layer1\"
	 width=\"1052.36px\"
     height=\"744.09px\"
	 borderlayer=\"true\"
     inkscape:showpageshadow=\"false\"
	 />";
$str1.="<svg  id=\"cartographie\" x=\"26.18\" y=\"22.045\" width=\"1000\" height=\"700\" viewBox=\"".$_GET['x']." ".$_GET['y']." ".$_GET['lar']." ".$_GET['hau']."\">\n";
$str1.="<metadata
       id=\"metadata8\">
      <rdf:RDF>
        <cc:Work
           rdf:about=\"\">
          <dc:format>image/svg+xml</dc:format>
          <dc:type
             rdf:resource=\"http://purl.org/dc/dcmitype/StillImage\" />
        </cc:Work>
      </rdf:RDF>
    </metadata>";
$str1.="<defs>";
$str1.="<clipPath id=\"masque\">
		<rect id=\"rect_decoup\" x=\"".$_GET['x']."\" y=\"".$_GET['y']."\" width=\"".$_GET['lar']."\" height=\"".$_GET['hau']."\" style=\"stroke:none;fill:none\"/>
		</clipPath>  
		<marker
         id=\"debut_mesure\"
         markerWidth=\"5\"
         markerHeight=\"10\"
         orient=\"auto\"
         refX=\"0\"
         refY=\"5\">
        <path
           pointer-events=\"none\"
           fill=\"none\"
           stroke=\"red\"
           d=\"M 5 7.5 0 5 5 2.5\"
           id=\"path13\" />
      </marker>
      <marker
         id=\"fin_mesure\"
         markerWidth=\"5\"
         markerHeight=\"10\"
         orient=\"auto\"
         refX=\"5\"
         refY=\"5\">
        <path
           pointer-events=\"none\"
           fill=\"none\"
           stroke=\"red\"
           d=\"M 0 7.5 5 5 0 2.5\"
           id=\"path16\" />
      </marker>
	  <symbol id=\"o\" viewBox=\"0 0 2048 1700\" preserveAspectRatio=\"xMidYMid meet\"> 
			<path d=\"M1112 737Q1170 737 1241 683T1313 567H1036L1002 240L984 380L980 402L962 567H688Q688 633 758 685T884 737V1145Q834 1145 784 1167Q724 1197 724 1245Q724 1317 810 1349Q868 1367 1002 1367Q1158
1367 1198 1353Q1277 1329 1277 1245Q1277 1205 1209 1169Q1154 1145 1112 1145V737Z\"  />
 		</symbol>
		<symbol id=\"imp\" viewBox=\"0 0 2048 1700\" preserveAspectRatio=\"xMidYMid meet\">	
  			<path d=\"M1760 1011Q1760 900 1659 797H1758V40H1708V0H334V40H288V797H491Q654 933 654 1121Q654 1267 554 1329H1565Q1641 1300 1700 1202T1760 1011ZM1734 1020Q1734 1096 1682 1186Q1627 1279 1560 1309H616Q679
1243 679 1119Q679 939 539 797H1622Q1734 894 1734 1020ZM1728 286V767H318V286H1728ZM1728 53V260H1405V217H553V260H318V53H1728ZM1712 347H1003V742H1712V347ZM1686 373V716H1029V373H1686ZM1639 585H1608V686H1639V585ZM1622 467H1472V501H1622V467ZM1622
401H1472V436H1622V401ZM1563 578H1062V686H1563V578ZM1437 467H1288V501H1437V467ZM1437 401H1288V436H1437V401ZM1253 467H1104V501H1253V467ZM1253 401H1104V436H1253V401Z\"/>
		</symbol>
		<symbol id=\"a\" viewBox=\"0 0 2048 1000\" preserveAspectRatio=\"xMidYMid meet\">
			<path d=\"M2032 508L2013 414H1772V428Q1794 429 1802 437T1810 467V653Q1810 681 1803 689T1774 698V707H2011V623H2003Q1998 663 1977 679T1909 696Q1891 696 1885 691T1878 666V573H1884Q1910 573 1923 588T1944
639H1954V494H1944Q1940 530 1927 544T1884 559H1878V461Q1878 445 1883 440T1907 434H1919Q1956 434 1981 453T2019 508H2032ZM1230 1544Q1209 1542 1203 1536T1196 1505V1257H1184L999 1487V1313Q999 1290 1007 1283T1036 1274V1264H944L945 1274Q967 1276 974
1283T981 1313V1511L967 1528Q965 1529 962 1533Q954 1542 945 1544L944 1554H1030L1178 1372V1505Q1178 1527 1171 1534T1139 1544V1554H1231L1230 1544ZM1743 553L1225 416L1085 -102L946 416L428 553L946 690L1085 1210L1225 690L1743 553ZM1122 -295Q1156 -312
1170 -332T1184 -385Q1184 -427 1157 -451T1083 -475Q1064 -475 1041 -468T1016 -461Q1010 -461 1007 -464T1001 -475H991V-371H1003Q1013 -417 1032 -439T1085 -461Q1110 -461 1123 -448T1137 -412Q1137 -397 1130 -387T1104 -367L1065 -346Q1026 -326 1011 -306T995
-256Q995 -218 1018 -195T1079 -172Q1094 -172 1141 -184Q1147 -185 1150 -186Q1155 -185 1158 -182T1163 -172H1176V-264H1166Q1152 -226 1132 -206T1085 -186Q1065 -186 1054 -196T1042 -225Q1042 -243 1049 -252T1081 -274L1122 -295ZM411 696Q392 691 383 665Q382
662 381 659L299 414H289L219 612L141 414H129L43 667Q37 684 31 689T13 696L12 707H135V696H129Q119 696 115 692T111 674Q111 668 112 663T115 653L162 514L209 641L201 671Q199 678 197 682T190 690Q187 693 174 695Q167 696 164 696V707H295V696H287Q279 696
274 692T266 680L270 664L317 522L358 651Q360 654 361 660T364 675Q363 687 357 691T336 696V707H412L411 696ZM1206 678L1087 1110V563L1206 678ZM1659 553H1094L1210 432L1659 553ZM1077 559L961 674L532 559H1077ZM1083 -4V549L965 428L1083 -4Z\"/>
		</symbol>
		<symbol id=\"f\" viewBox=\"0 0 2048 1700\" preserveAspectRatio=\"xMidYMid meet\">
			<path d=\"M1360 1028Q1360 867 1277 767Q1188 659 1030 659Q865 659 760 802Q664 932 664 1102Q664 1450 985 1450Q1143 1450 1255 1316Q1360 1190 1360 1028ZM1086 488L1052 501L1037 615H1021L1032 507H1020Q990
507 948 487Q902 466 893 443L858 610Q732 616 633 730Q531 848 531 1002Q531 1150 584 1230Q614 1277 747 1389Q636 1270 636 1105Q636 929 730 794Q836 643 1005 643Q1030 643 1065 643L1086 488ZM1178 -157Q1178 -191 1149 -217T1083 -243Q1044 -243 1013 -214Q986
-189 983 -163L901 409Q896 441 942 465Q985 488 1038 488Q1074 488 1092 455L1167 -85L1178 -157ZM1328 1031Q1328 1178 1231 1292Q1129 1413 985 1413Q695 1413 695 1098Q695 943 783 825Q879 695 1028 695Q1172 695 1253 793Q1328 884 1328 1031ZM1306 1020Q1306
808 1115 722Q1235 858 1235 1010Q1235 1158 1142 1255T902 1358Q946 1377 998 1377Q1128 1377 1220 1262Q1306 1154 1306 1020ZM1140 1052Q1140 968 1058 895Q1068 974 1068 1007Q1068 1064 1029 1125Q1014 1148 950 1226Q1025 1223 1081 1175Q1140 1124 1140
1052ZM832 867Q791 881 765 952Q743 1010 743 1064Q743 1130 777 1169Q813 1037 832 867Z\" />
		</symbol>
		<symbol id=\"g\" viewBox=\"0 0 2048 1700\" preserveAspectRatio=\"xMidYMid meet\">
			<path d=\"M1259 1480V0H173V1480H1259ZM1209 1431H222V49H1209V1431ZM370 247V296H1061V247H370ZM370 444V493H1061V444H370ZM370 641V691H1061V641H370ZM370 839V888H1061V839H370ZM370 1036V1086H1061V1036H370ZM370
1234V1283H1061V1234H370Z\" />
		</symbol>
		<symbol id=\"h\" viewBox=\"0 0 2048 1700\" preserveAspectRatio=\"xMidYMid meet\">
			<path d=\"M1456 -197H1259V-395H173V1086H370V1283H568V1480H1653V0H1456V-197ZM617 1431V1283H1456V49H1604V1431H617ZM420 1234V1086H1259V-148H1407V1234H420ZM1209 1036H222V-346H1209V1036ZM370 -148V-99H1061V-148H370ZM370
49V99H1061V49H370ZM370 247V296H1061V247H370ZM370 444V493H1061V444H370ZM370 641V691H1061V641H370ZM370 839V888H1061V839H370Z\" />
		</symbol>
		<symbol id=\"j\" viewBox=\"0 0 2048 1700\" preserveAspectRatio=\"xMidYMid meet\">
			<path d=\"M1653 740L1283 1110V814H1061V666H1283V370L1653 740ZM962 814H765V666H962V814ZM666 814H469V666H666V814ZM370 814H173V666H370V814Z\" />
		</symbol>
		<symbol id=\"ij\" viewBox=\"0 0 2048 1700\" preserveAspectRatio=\"xMidYMid meet\">
			<path d=\"M173 740L543 1110V814H765V666H543V370L173 740ZM864 814H1061V666H864V814ZM1160 814H1357V666H1160V814ZM1456 814H1653V666H1456V814Z M1653 740L1283 1110V814H1061V666H1283V370L1653 740ZM962 814H765V666H962V814ZM666 814H469V666H666V814ZM370 814H173V666H370V814Z\" />
		</symbol>
		<symbol id=\"n\" viewBox=\"0 0 2048 1700\" preserveAspectRatio=\"xMidYMid meet\">
			<path d=\"M209 969L913 1480L1617 969L1348 141H478L209 969Z\" />
		</symbol>
		<symbol id=\"Z\" viewBox=\"0 0 2048 1700\" preserveAspectRatio=\"xMidYMid meet\">
			<path d=\"M173 197V1382Q173 1423 202 1451T272 1480H1555Q1596 1480 1624 1452T1653 1382V99Q1653 58 1625 29T1555 0H370L173 197ZM864 493H617V49H864V493ZM1259 49H1555Q1580 49 1592 61T1604 98V1382Q1604
1431 1555 1431H1407V839Q1407 798 1378 769T1308 740H518Q477 740 449 769T420 839V1431H272Q222 1431 222 1382V217L390 49H568V493Q568 543 617 543H1209Q1259 543 1259 493V49ZM1357 1431H469V839Q469 815 481 803T518 790L1308 789Q1357 789 1357 839V1431Z\"/>
		</symbol>
		<symbol id=\"Y\" viewBox=\"0 0 2048 1700\" preserveAspectRatio=\"xMidYMid meet\">
			<path d=\"M878 740L222 1396V84L878 740ZM1407 705L1230 529Q1201 499 1160 499Q1119 499 1089 529L913 705L257 49H2062L1407 705ZM1442 740L2097 84V1396L1442 740ZM257 1431L1125 563Q1139 549 1160 549Q1181
549 1195 563L2063 1431H257ZM173 1480H2147V0H173V1480Z\" />
		</symbol>
		<symbol id=\"l\" viewBox=\"0 0 2048 1700\" preserveAspectRatio=\"xMidYMid meet\">
			<path d=\"M913 1480L1653 740H173L913 1480Z\" />
		</symbol>
		<symbol id=\"m\" viewBox=\"0 0 2048 1700\" preserveAspectRatio=\"xMidYMid meet\">
			<path d=\"M913 0L173 740H1653L913 0Z\" />
		</symbol>
		<symbol id=\"b\" viewBox=\"0 0 2048 1700\" preserveAspectRatio=\"xMidYMid meet\"><path transform=\"matrix(0.005 0 0 -0.005 0 0)\" id=\"q\" d=\"M173 0V1480H1653V0H173Z\" />
			<path d=\"M1500 1568L1535 1518Q1321 1357 1059 1022T659 396L585 346Q493 282 460 251Q447 298 403 405L375 470Q315 610 264 677T148 766Q256 880 346 880Q423 880 517 671L548 601Q717 886 982 1155T1500 1568Z\" />
  		</symbol>
	  
	  ";
$str1.=$_SESSION['symbol'];	  
$str1.="</defs>";
fputs($myFile, $str1);

$textq="";
	if ($_GET['raster']!=''){
	$raster=str_replace("chr(224)","à",$_GET['raster']);
$raster=str_replace("chr(233)","é",$raster);
$raster=str_replace("chr(232)","è",$raster);
$raster=str_replace("chr(234)","ê",$raster);
$raster=str_replace("chr(226)","â",$raster);
$raster=str_replace("chr(231)","ç",$raster);
$raster=str_replace("chr(244)","ô",$raster);
$raster=str_replace("chr(238)","î",$raster);
$raster=str_replace("chr(251)","û",$raster);
$raster=str_replace("chr(95)","_",$raster);
	$rastx=explode(";",$raster);
	$raster="";
	for($i=0;$i<count($rastx);$i++)
	{
	$ras=explode(".",$rastx[$i]);
	$raster.=$ras[1].";";
	}
	$raster=substr($raster,0,strlen($raster)-1);
	$raster=str_replace(";","&layer=",$raster);
	$erreur=error_reporting ();
	error_reporting (1);
	$sql_app="select supp_chr_spec(libelle_appli) as libelle_appli from admin_svg.application where idapplication='".$_SESSION['profil']->appli."'";
$app=$DB->tab_result($sql_app);
$application=$app[0]['libelle_appli'];
$application=str_replace(" ","_",$application);
		
		
if(substr($_SESSION['profil']->insee, -3)=='000')
	{
				
$url="http://".$serv."/cgi-bin/mapserv?map=".$fs_root."capm/".$application.".map&map_imagetype=jpeg&insee=".substr($_SESSION['profil']->insee,0,3)."&layer=".$raster."&minx=".$xm."&miny=".$ym."&maxx=".$xma."&maxy=".$yma."&mapsize=1200%20840&parce=('')".$extra_url;
}
else
{
$url="http://".$serv."/cgi-bin/mapserv?map=".$fs_root."capm/".$application.".map&map_imagetype=jpeg&insee=".$_SESSION['profil']->insee."&layer=".$raster."&minx=".$xm."&miny=".$ym."&maxx=".$xma."&maxy=".$yma."&mapsize=1200%20840&parce=('')".$extra_url;
}
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
		
	error_reporting ($erreur);
		$textq.="<g inkscape:groupmode=\"layer\"
     id=\"layer".$countlayer."\"
     inkscape:label=\"raster\">\n";
	 $countlayer=$countlayer+1;
	 $textq.="<image y='".$_GET['y']."' x='".$_GET['x']."' height='".$_GET['hau']."' width='".$_GET['lar']."' sodipodi:absref='".$image.".jpg' xlink:href='".$image.".jpg' />";
		$textq.="</g>\n";
		fputs($myFile, $textq);
}

if($_GET['svg']!="")
{
$rast=$_GET['svg'];

if($_GET['nav']!="0")
{
$rast=str_replace("chr(224)","à",$_GET['svg']);
$rast=str_replace("chr(233)","é",$rast);
$rast=str_replace("chr(232)","è",$rast);
$rast=str_replace("chr(234)","ê",$rast);
$rast=str_replace("chr(226)","â",$rast);
$rast=str_replace("chr(231)","ç",$rast);
$rast=str_replace("chr(244)","ô",$rast);
$rast=str_replace("chr(238)","î",$rast);
$rast=str_replace("chr(251)","û",$rast);
$rast=str_replace("chr(60)","<",$rast);
$rast=str_replace("chr(62)",">",$rast);
$rast=str_replace("chr(63)","?",$rast);
$rast=str_replace("chr(34)",'"',$rast);
$rast=str_replace("chr(39)","'",$rast);
$rast=str_replace("chr(35)","#",$rast);
$rast=str_replace("chr(33)","!",$rast);
$rast=str_replace("chr(95)","_",$rast);
}
$ras=explode(",",$rast);
//$ylegend=32.045;
for($i=0;$i<count($ras);$i++)
{
	$ra=explode(".",$ras[$i]);
	$rast[$i]=$ra[1];
	$id[$i]=$ra[0];
}	
$ylegend=32.045+20*count($id);
$sql="select theme.libelle_them,appthe.idappthe,appthe.ordre,theme.schema,theme.tabl,col_theme.colonn,col_theme.intitule_legende,admin_svg.v_fixe(col_theme.valeur_texte),col_theme.valeur_mini,col_theme.valeur_maxi,col_theme.valeur_texte,sinul(col_theme.fill, style.fill) as fill,sinul(col_theme.stroke_rgb, style.stroke_rgb) as stroke_rgb,sinul(col_theme.symbole,style.symbole) as symbole,sinul(col_theme.opacity,style.opacity) as opacity,sinul(col_theme.font_familly,style.font_familly) as font_familly,sinul(col_theme.font_size,style.font_size) as font_size,appthe.mouseover,appthe.mouseout,appthe.click,appthe.idtheme,theme.partiel,sinul(col_theme.stroke_width,style.stroke_width) as stroke_width from admin_svg.appthe join admin_svg.theme on appthe.idtheme=theme.idtheme left outer join  admin_svg.col_theme on appthe.idappthe=col_theme.idappthe left outer join  admin_svg.style on appthe.idtheme=style.idtheme where appthe.idapplication='".$_SESSION['profil']->appli."' group by theme.libelle_them,appthe.idappthe,appthe.ordre,theme.schema,theme.tabl,col_theme.colonn,col_theme.intitule_legende,admin_svg.v_fixe(col_theme.valeur_texte),col_theme.valeur_mini,col_theme.valeur_maxi,col_theme.valeur_texte,sinul(col_theme.fill, style.fill),sinul(col_theme.stroke_rgb, style.stroke_rgb),sinul(col_theme.symbole,style.symbole),sinul(col_theme.opacity,style.opacity),sinul(col_theme.font_familly,style.font_familly),sinul(col_theme.font_size,style.font_size),appthe.mouseover,appthe.mouseout,appthe.click,appthe.idtheme,theme.partiel,sinul(col_theme.stroke_width,style.stroke_width) order by appthe.ordre desc";
$cou=$DB->tab_result($sql);

for ($l=0;$l<count($cou);$l++){

$req1="select distinct (col_theme.intitule_legende) as intitule_legende from admin_svg.appthe join admin_svg.col_theme on appthe.idappthe=col_theme.idappthe join admin_svg.theme on appthe.idtheme=theme.idtheme";
	if($cou[$l]['v_fixe']=='1' and $cou[$l]['colonn']<>'')
	{
	$req1.=" join ".$cou[$l]['schema'].".".$cou[$l]['tabl']." on col_theme.valeur_texte=".$cou[$l]['tabl'].".".$cou[$l]['colonn']." where 					appthe.idapplication='".$_SESSION["profil"]->appli."' and theme.libelle_them='".$cou[$l]['libelle_them']."'";
	if($cou[$l]['schema']!="bd_topo")
	{
		if(substr($_SESSION["profil"]->insee, -3)!='000' )
				{$req1.=" and (".$cou[$l]['tabl'].".code_insee like '".$_SESSION["profil"]->insee."'  or code_insee is null) ";}
		else{$req1.=" and (".$cou[$l]['tabl'].".code_insee like '".substr($_SESSION["profil"]->insee,0,3)."%'  or code_insee is null) ";}
	 }
	 
	}
	else
	{
	$req1.=" where appthe.idapplication='".$_SESSION["profil"]->appli."' and theme.libelle_them='".$cou[$l]['libelle_them']."' ";
	}
	$couch=$DB->tab_result($req1);

if(count($couch)>0)
{
for($i=0;$i<count($couch);$i++)
{
	
	$libel[$i]=$couch[$i]['intitule_legende'];
	
}
}
else
{
$libel[0]=$cou[$l]['intitule_legende'];
}




if(in_array($cou[$l]['idappthe'],$id) and in_array($cou[$l]['intitule_legende'],$libel))
{

$rotation='false';
$d="select * from admin_svg.col_sel where idtheme='".$cou[$l]['idtheme']."'";
		$col=$DB->tab_result($d);
		$f="select distinct ";
		$geometrie="";
		for ($z=0;$z<count($col);$z++){
		if($col[$z]['nom_as']=='rotation')
		{
		$rotation='true';
		}
			if($col[$z]['nom_as']=='geom')
			{
			$geometrie=$col[$z]['appel'];
			$f.="assvg(Translate(Transform(".$col[$z]['appel'].",$projection),-".$_SESSION['xini'].",-".$_SESSION['yini'].",0),1,6) as ".$col[$z]['nom_as'].",";}
			else
			{
			$f.="(".$col[$z]['appel'].") as ".$col[$z]['nom_as'].",";
			}
		}
		$f=substr($f,0,-1)." from ".$cou[$l]['schema'].".".$cou[$l]['tabl'];
		
	if(substr($geometrie, 0,17) == "difference(buffer")
	{
	$f.=" where 1=1";
	}
		elseif ($cou[$l]['schema']=="bd_topo"){
                $f.=" where Transform(".$geometrie.",$projection) && box'(".$xm.",".$ym.",".$xma.",".$yma.")'";
            }else{
                if (substr($_SESSION['profil']->insee, -3) == "000")
					{
					
                	$f.=" where (code_insee like '".substr($_SESSION['profil']->insee,0,3)."%' or code_insee is null) and Transform(".$geometrie.",".$projection.") && box'($xm,$ym,$xma,$yma)'";
            		}
				else
					{
					
                	$f.=" where (code_insee like '".$_SESSION['profil']->insee."%' or code_insee is null) and Transform(".$geometrie.",".$projection.") && box'($xm,$ym,$xma,$yma)'";
            		}
            }
			
       $j="select * from admin_svg.col_where where idtheme='".$cou[$l]['idtheme']."'";
		$whr=$DB->tab_result($j);
		if (count($whr)>0){
			$f.=" and ".str_replace("VALEUR","'".$_SESSION['profil']->insee."'",$whr[0]['clause']);
			}
		$type_geo="";	
		if($geometrie!="")
		{
		$dd="select distinct geometrytype(".$geometrie.") as geome from ".$cou[$l]['schema'].".".$cou[$l]['tabl'];
		if($whr[0]['clause']!='')
		{
		$dd.=" where ".str_replace("VALEUR","'".$_SESSION['profil']->insee."'",$whr[0]['clause']);
		}
		$geo=$DB->tab_result($dd);
		if($geo[0]['geome']=="POINT" AND $cou[$l]['symbole']!="") //si symbole
		{
			$type_geo="symbole";
		}
		else if($geo[0]['geome']=="POINT") //si texte
		{
		$type_geo="texte";
		}
		else if($geo[0]['geome']=="MULTILINESTRING" AND $cou[$l]['font_familly']!='') //si texte avec chemin
		{
		$type_geo="texte_chemin";
		}
		}
	 
		if($cou[$l]['valeur_mini']!='')
		{
			$f.=" and ".$cou[$l]['colonn'].">=".$cou[$l]['valeur_mini']." and ".$cou[$l]['colonn']."<=".$cou[$l]['valeur_maxi'];
		}
		else
		{
			if($cou[$l]['colonn']!='')
			{
			$f.=" and ".$cou[$l]['colonn']."='".$cou[$l]['valeur_texte']."'";
			}
		}
		
		$res=$DB->tab_result($f);
$styl="";
if($cou[$l]['fill']!=''&&$cou[$l]['fill']!='none')
{$styl="fill:rgb(".$cou[$l]['fill'].");";$fill_legend="fill:rgb(".$cou[$l]['fill'].");";}else{$styl="fill:none;";$fill_legend="fill:none;";}
if($cou[$l]['stroke_rgb']!='')
{if($cou[$l]['stroke_rgb']=='none'){$styl.="stroke:none;";$strok_legend=="stroke:none;";}else{$styl.="stroke:rgb(".$cou[$l]['stroke_rgb'].");";$strok_legend=="stroke:rgb(".$cou[$l]['stroke_rgb'].");";}}
if($cou[$l]['opacity']!='')
{$styl.="fill-opacity:".$cou[$l]['opacity'].";";$opa_legend="fill-opacity:".$cou[$l]['opacity'].";";}else{$opa_legend="fill-opacity:1;";}
if($cou[$l]['font_familly']!='' && $type_geo!='')
{$styl.="font-familly:".$cou[$l]['font_familly'].";";}
if($cou[$l]['font_size']!='' && $type_geo!='')
{
if($type_geo=="texte_chemin")
{
$styl.="font-size:".($cou[$l]['font_size']/1.5).";startOffset:10%;spacing:auto;";
}
else
{
$styl.="font-size:".$cou[$l]['font_size'].";";
}
}
if($cou[$l]['stroke_width']!='' && ($cou[$l]['stroke_rgb']!='none' || $cou[$l]['stroke_rgb']!=''))
{$styl.="stroke-width:".$cou[$l]['stroke_width'].";";}
if($type_geo=="texte" && $rotation=="false")
{
$styl.="text-anchor:middle;";
}
if($cou[$l]['valeur_texte']=='')
{
$label=$cou[$l]['libelle_them'];
}
else
{
$label=$cou[$l]['valeur_texte'];
}

if($type_geo!="texte_chemin")
{	 
$textq="<g inkscape:groupmode=\"layer\"
     id=\"layer".$countlayer."\"
     inkscape:label=\"".$label."\" style=\"clip-path:url(#masque);".$styl."\" ";

$textq.=">\n";
fputs($myFile, $textq);

$countlayer=$countlayer+1;
}
	
	if($type_geo=="symbole")
				{
				for ($e=0;$e<count($res);$e++)
					{
					$taille=$cou[$l]['font_size']*$_SESSION['large']/6000;
					$coordo = explode(' ', $res[$e]['geom']);
					$coorx=substr($coordo[0],3,-1);	
					$coory=substr($coordo[1],3,-1);
					$textq="<use transform=\"matrix(1,0,0,-1,".($coorx-$taille/2).",".($coory+$taille/2).")\" width=\"".$taille."\"  height=\"".$taille."\" xlink:href=\"#".$cou[$l]['symbole']."\" />";
					//$textq="<text ".$res[$e]['geom']." style=\"font-family:svg\">".$cou[$l]['symbole']."</text>\n";
					fputs($myFile, $textq);
					}
					$legend.="<use transform=\"matrix(1,0,0,-1,-150,".$ylegend.")\" width=\"10\"  height=\"10\" xlink:href=\"#".$cou[$l]['symbole']."\" style=\"".$fill_legend.$strok_legend.$opa_legend."\"/>";
					//$legend.="<text x=\"-150\" y=\"".$ylegend."\" style=\"".$fill_legend.$strok_legend.$opa_legend."font-size:11pt;font-family:svg\">".$cou[$l]['symbole']."</text>\n";
					$legend.="<text x=\"-130\" y=\"".$ylegend."\" style=\"fill:black;font-size:11pt;font-family:arial\">".$label."</text>\n";
					$ylegend=$ylegend-20;
				}
	elseif($type_geo=="texte")
				{
				for ($e=0;$e<count($res);$e++)
					{
					if($rotation=="true")
					{
					$posi=explode(" ",$res[$e]['geom']);
				$textq="<text ".$res[$e]['geom']." transform='rotate(-".$res[$e]['rotation'].",".substr($posi[0],3,-1).",".substr($posi[1],3,-1).")'>".$res[$e]['ad']."</text>\n";
					fputs($myFile, $textq);
					}
					else
					{
					$textq="<text ".$res[$e]['geom']." >".$res[$e]['ad']."</text>\n";
					fputs($myFile, $textq);
					}
					}
					//$legend.="<text x=\"-150\" y=\"".$ylegend."\" style=\"".$fill_legend.$strok_legend.$opa_legend."font-size:11pt;font-family:svg\">q</text>\n";
					$legend.="<rect x=\"-150\" y=\"".($ylegend-10)."\"  height='10' width='10' style=\"".$fill_legend.$opa_legend."stroke:black;stroke-width:0.2\" />";
					$legend.="<text x=\"-130\" y=\"".$ylegend."\" style=\"fill:black;font-size:11pt;font-family:arial\">".$label."</text>\n";
					$ylegend=$ylegend-20;
				}
	elseif($type_geo=="texte_chemin")
				{
				$textq="<g inkscape:groupmode=\"layer\"
     			id=\"layer".$countlayer."\" inkscape:label=\"troncon_voirie\" style=\"clip-path:url(#masque);opacity:0;display:none\" ";
				$textq.=">\n";
				fputs($myFile, $textq);
				$countlayer=$countlayer+1;
				for ($e=0;$e<count($res);$e++)
					{
					$textq="<path opacity='0' id='path_text".$e."' d='".$res[$e]['geom']."'/>\n";
					fputs($myFile, $textq);
					}
				
				$textq="</g><g inkscape:groupmode=\"layer\" id=\"layer".$countlayer."\" inkscape:label=\"".$label."\" style=\"clip-path:url(#masque);".$styl."\" >\n";
				fputs($myFile, $textq);
				$countlayer=$countlayer+1;
				for ($f=0;$f<count($res);$f++)
					{
					$textq="<text><textPath xlink:href='#path_text".$f."'><tspan dy='2'>".$res[$f]['ad']."</tspan></textPath></text>\n";
					fputs($myFile, $textq);
					}
				$textq="</g>";
				fputs($myFile, $textq);	
				//$legend.="<text x=\"-150\" y=\"".$ylegend."\" style=\"".$fill_legend.$strok_legend.$opa_legend."font-size:11pt;font-family:svg\">q</text>\n";
				$legend.="<rect x=\"-150\" y=\"".($ylegend-10)."\"  height='10' width='10' style=\"".$fill_legend.$opa_legend."stroke:black;stroke-width:0.2\" />";
					$legend.="<text x=\"-130\" y=\"".$ylegend."\" style=\"fill:black;font-size:11pt;font-family:arial\">".$label."</text>\n";
					$ylegend=$ylegend-20;
				}
	
	else
				{
				
				for ($e=0;$e<count($res);$e++)
					{
					if(in_array($res[$e]['ident'],$placeid) && $res[$e]['ident']!='')
					{
					$textq="<path fill='rgb(150,254,150)' fill-opacity='0.7' d='".$res[$e]['geom']."'/>\n";
					fputs($myFile, $textq);
					}
					else
					{
					$textq="<path d='".$res[$e]['geom']."'/>\n";
					fputs($myFile, $textq);
					}
					}
					//legend.="<text x=\"-150\" y=\"".$ylegend."\" style=\"".$fill_legend.$strok_legend.$opa_legend."font-size:11pt;font-family:svg\">q</text>\n";
					$legend.="<rect x=\"-150\" y=\"".($ylegend-10)."\"  height='10' width='10' style=\"".$fill_legend.$opa_legend."stroke:black;stroke-width:0.2\" />";
					$legend.="<text x=\"-130\" y=\"".$ylegend."\" style=\"fill:black;font-size:11pt;font-family:arial\">".$label."</text>\n";
					$ylegend=$ylegend-20;
				
				}
if($type_geo!="texte_chemin")
{				
$textq="</g>";
fputs($myFile, $textq);
}
}
}
}
/*$str3="<g inkscape:groupmode=\"layer\"
     id=\"layer".$countlayer."\"
     inkscape:label=\"bordure\" style='fill:white;stroke:none'>";
$countlayer=$countlayer+1;	 
$str3.="<rect y='".($_GET['y']-600)."' x='".($_GET['x']-1200)."' height='".($_GET['hau']+600)."' width='1200' />";
$str3.="<rect y='".($_GET['y']-600)."' x='".($_GET['x']+$_GET['lar'])."' height='".($_GET['hau']+600)."' width='1200' style='fill:white;stroke:none'/>";
$str3.="<rect y='".($_GET['y']-600)."' x='".($_GET['x']-1200)."' height='600' width='".($_GET['lar']+1800)."' style='fill:white;stroke:none'/>";
$str3.="<rect y='".($_GET['y']+$_GET['hau'])."' x='".($_GET['x']-600)."' height='600' width='".($_GET['lar']+1800)."' style='fill:white;stroke:none'/>";
$str3.="</g>";*/
$str3.="</svg>";
$str3.="<text y=\"710\" x=\"65\" style=\"fill:#008;text-anchor:middle;font-size:8px\">M&#x00E9;tres</text>";
$str3.="<text id=\"gauche\" y=\"694\" x=\"40\" style=\"fill:#008;text-anchor:middle;font-size:8px\">0</text>";
$str3.="<text id=\"droite\" y=\"694\" x=\"90\" style=\"fill:#008;text-anchor:middle;font-size:8px\">".$_GET['droite']."</text>";
$str3.="<path d=\"M 40,695 40,700 L 90,700 90,695  \" fill=\"none\" stroke=\"#008\"/>";
$dess="<g inkscape:groupmode=\"layer\"
     id=\"layer".$countlayer."\"
     inkscape:label=\"cotation\" style=\"clip-path:url(#masque);stroke-width:0.2\">";
$tableau=$_SESSION['cotation'];
for($ij=0;$ij<count($tableau);$ij++)
{
$coor=explode("|",$tableau[$ij]);
$dess.="<line id=\"cotation".($ij+1)."\" x1=\"".$coor[0]."\" y1=\"".$coor[1]."\" x2=\"".$coor[2]."\" y2=\"".$coor[3]."\" marker-start=\"url(#debut_mesure)\" marker-end=\"url(#fin_mesure)\" stroke-width=\"0.5\" fill=\"blue\" stroke=\"blue\"/><text fill=\"red\" id=\"texcotation".($ij+1)."\" font-size=\"3\" x=\"".$coor[5]."\" y=\"".$coor[6]."\" transform=\"rotate(".$coor[4].",".$coor[5].",".$coor[6].")\" text-anchor=\"middle\" startOffset=\"0\">".$coor[7]."</text>";
}	
$dess.="</g>";
$cota=$dess;
$str4="<g inkscape:groupmode=\"layer\"
     id=\"layer".($countlayer+1)."\"
     inkscape:label=\"legende\" style=\"display:none\"><rect y='".$ylegend."' x='-160' height='".($ylegend+20*count($id))."' width='140' style=\"fill:rgb(255,255,255);stroke:black;stroke-width:0.5\" />";
$data=$cota.$str3.$str4.$legend.$rrrr."</g></svg>";
fputs($myFile, $data);
fclose($myFile);
$ch_image="";
if ($_GET['raster']!=''){$ch_image=" ".$fs_root."tmp/".$image.".jpg";}
$da=date("His");
exec("mv ".$fs_root."tmp/".$_GET['nom'].".svg ".$fs_root."tmp/carte".$da.".svg");
exec("zip -j ".$fs_root."tmp/carte".$da.".zip ".$fs_root."tmp/carte".$da.".svg".$ch_image);
header("Location: ".$protocol."://".$_SERVER['HTTP_HOST']."/tmp/carte".$da.".zip");
?> 

