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

header("Content-type: image/svg+xml");//}

$data="<?xml version=\"1.0\" encoding=\"ISO-8859-1\" standalone=\"no\"?>";
if (file_exists("../doc_commune/".$_SESSION["profil"]->insee."/css_interface/interface.css"))
{
$data.="<?xml-stylesheet href=\"../doc_commune/".$_SESSION["profil"]->insee."/css_interface/interface.css\" type=\"text/css\" ?>";
}
else
{
$data.="<?xml-stylesheet href=\"../doc_commune/default/css_interface/interface.css\" type=\"text/css\" ?>";
}

$styll="";
if($_SESSION['nav']==2)
{
$styll="style=\"-moz-user-select: none;\"";
}
$data.="<!DOCTYPE svg PUBLIC \"-//W3C//DTD SVG 1.0//EN\" \"http://www.w3.org/TR/2001/REC-SVG-20010904/DTD/svg10.dtd\">";
$data.="<svg id=\"svg2\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\" xmlns:cc=\"http://web.resource.org/cc/\" xmlns:rdf=\"http://www.w3.org/1999/02/22-rdf-syntax-ns#\" xmlns:svg=\"http://www.w3.org/2000/svg\" xmlns=\"http://www.w3.org/2000/svg\" xmlns:xlink=\"http://www.w3.org/1999/xlink\" width=\"100%\" heigth=\"100%\" viewBox=\"0 0 800 566\" onload=\"init(evt);clear_legende();".$_SESSION['extraction']."\" onmousemove=\"determ_ratio()\" ".$styll.">";
$data.="<rect id=\"rectdefond\" width=\"100%\" height=\"100%\" x=\"0\" y=\"0\" fill=\"white\"/>"; 
$data.="<script xlink:href=\"./script.js\" language=\"text/javascript\"></script>";
$data.="<script type=\"text/ecmascript\"><![CDATA[\n";
$data.="nav=".$_SESSION['nav'].";\n";
$data.=$_SESSION['tab_layer']."\n";
$data.=$_SESSION['layer']."\n";
$data.=$_SESSION['lay']."\n"; 
$data.="function glayer(controle,visible,zoom_charge,position,zoomraster,partiel,force_charge){
	this.svg_controle=controle;
	this.svg_visible=visible;
	this.svg_zoom_charge=zoom_charge;
	this.svg_position=position;
	this.svg_zoomraster=zoomraster;
	this.svg_partiel=partiel;
	this.svg_force_charge=force_charge;
	
}\n";
$data.=" function ylayer(zmin,zmax,typ){
	this.zoommin=zmin;
	this.zoommax=zmax;
	this.type=typ;
}\n";
$data.="nblayer=".$_SESSION['nb_couche'].";\n";
$data.="ref_rep='".$_SESSION['ref_rep']."';\n";
$data.="url_polygo='".$_SESSION['url_polygo']."';\n";
$data.="zoommin=".$_SESSION['zoommin'].";\n";
$data.="zoommax=".$_SESSION['zoommax'].";\n";
$data.="cx=".$_SESSION['xc'].";\n";
$data.="cy=".$_SESSION['yc'].";\n";
$data.="xcenterini=".($_SESSION['xcenter']-$_SESSION['xini']).";\n";
$data.="ycenterini=".($_SESSION['yini']-$_SESSION['ycenter']).";\n";
$data.="intervale=".$_SESSION['intervale'].";\n";
$data.="theZoom=".$_SESSION['zoomouv'].";\n";
$data.="zoomVal=".$_SESSION['zoomouv'].";\n";
$data.="appli=".$_SESSION["profil"]->appli."; \n";
$data.="sessionid='".session_id()."';\n";
$data.="sessionname='".session_name()."';\n";
$data.="code_insee=".$_SESSION["profil"]->insee.";\n";
$data.="xini=".$_SESSION['xini'].";\n";
$data.="yini=".$_SESSION['yini'].";\n";
$data.="largeurini=".$_SESSION['large'].";\n";
$data.="hauteurini=".$_SESSION['haute'].";\n";
$data.="va_appli='".$_SESSION['va_appli']."';\n";
if ($_SESSION['profil']->serveur == "")
	$data.="serveur='".$_SERVER['HTTP_HOST']."';\n";
else
	$data.="serveur='".$_SESSION['profil']->serveur."';\n";
$data.="protocol='".$_SESSION['protocol']."';\n";
$data.="zoom_init=100;\n";
$data.="]]></script>
  <defs>
 <clipPath id=\"masque\">
 	<path style=\"stroke:none;fill:none\" d='".$_SESSION['geom_comm']."'/>
		
		</clipPath> 
 
  <path transform=\"matrix(0.011 0 0 -0.011 0 0)\" id=\"imp\" d=\"M1760 1011Q1760 900 1659 797H1758V40H1708V0H334V40H288V797H491Q654 933 654 1121Q654 1267 554 1329H1565Q1641 1300 1700 1202T1760 1011ZM1734 1020Q1734 1096 1682 1186Q1627 1279 1560 1309H616Q679
1243 679 1119Q679 939 539 797H1622Q1734 894 1734 1020ZM1728 286V767H318V286H1728ZM1728 53V260H1405V217H553V260H318V53H1728ZM1712 347H1003V742H1712V347ZM1686 373V716H1029V373H1686ZM1639 585H1608V686H1639V585ZM1622 467H1472V501H1622V467ZM1622
401H1472V436H1622V401ZM1563 578H1062V686H1563V578ZM1437 467H1288V501H1437V467ZM1437 401H1288V436H1437V401ZM1253 467H1104V501H1253V467ZM1253 401H1104V436H1253V401Z\"/>
<path transform=\"matrix(0.014 0 0 -0.014 0 0)\" id=\"a\" d=\"M2032 508L2013 414H1772V428Q1794 429 1802 437T1810 467V653Q1810 681 1803 689T1774 698V707H2011V623H2003Q1998 663 1977 679T1909 696Q1891 696 1885 691T1878 666V573H1884Q1910 573 1923 588T1944
639H1954V494H1944Q1940 530 1927 544T1884 559H1878V461Q1878 445 1883 440T1907 434H1919Q1956 434 1981 453T2019 508H2032ZM1230 1544Q1209 1542 1203 1536T1196 1505V1257H1184L999 1487V1313Q999 1290 1007 1283T1036 1274V1264H944L945 1274Q967 1276 974
1283T981 1313V1511L967 1528Q965 1529 962 1533Q954 1542 945 1544L944 1554H1030L1178 1372V1505Q1178 1527 1171 1534T1139 1544V1554H1231L1230 1544ZM1743 553L1225 416L1085 -102L946 416L428 553L946 690L1085 1210L1225 690L1743 553ZM1122 -295Q1156 -312
1170 -332T1184 -385Q1184 -427 1157 -451T1083 -475Q1064 -475 1041 -468T1016 -461Q1010 -461 1007 -464T1001 -475H991V-371H1003Q1013 -417 1032 -439T1085 -461Q1110 -461 1123 -448T1137 -412Q1137 -397 1130 -387T1104 -367L1065 -346Q1026 -326 1011 -306T995
-256Q995 -218 1018 -195T1079 -172Q1094 -172 1141 -184Q1147 -185 1150 -186Q1155 -185 1158 -182T1163 -172H1176V-264H1166Q1152 -226 1132 -206T1085 -186Q1065 -186 1054 -196T1042 -225Q1042 -243 1049 -252T1081 -274L1122 -295ZM411 696Q392 691 383 665Q382
662 381 659L299 414H289L219 612L141 414H129L43 667Q37 684 31 689T13 696L12 707H135V696H129Q119 696 115 692T111 674Q111 668 112 663T115 653L162 514L209 641L201 671Q199 678 197 682T190 690Q187 693 174 695Q167 696 164 696V707H295V696H287Q279 696
274 692T266 680L270 664L317 522L358 651Q360 654 361 660T364 675Q363 687 357 691T336 696V707H412L411 696ZM1206 678L1087 1110V563L1206 678ZM1659 553H1094L1210 432L1659 553ZM1077 559L961 674L532 559H1077ZM1083 -4V549L965 428L1083 -4Z\"/>
<path transform=\"matrix(0.011 0 0 -0.011 0 0)\" id=\"f\" d=\"M1360 1028Q1360 867 1277 767Q1188 659 1030 659Q865 659 760 802Q664 932 664 1102Q664 1450 985 1450Q1143 1450 1255 1316Q1360 1190 1360 1028ZM1086 488L1052 501L1037 615H1021L1032 507H1020Q990
507 948 487Q902 466 893 443L858 610Q732 616 633 730Q531 848 531 1002Q531 1150 584 1230Q614 1277 747 1389Q636 1270 636 1105Q636 929 730 794Q836 643 1005 643Q1030 643 1065 643L1086 488ZM1178 -157Q1178 -191 1149 -217T1083 -243Q1044 -243 1013 -214Q986
-189 983 -163L901 409Q896 441 942 465Q985 488 1038 488Q1074 488 1092 455L1167 -85L1178 -157ZM1328 1031Q1328 1178 1231 1292Q1129 1413 985 1413Q695 1413 695 1098Q695 943 783 825Q879 695 1028 695Q1172 695 1253 793Q1328 884 1328 1031ZM1306 1020Q1306
808 1115 722Q1235 858 1235 1010Q1235 1158 1142 1255T902 1358Q946 1377 998 1377Q1128 1377 1220 1262Q1306 1154 1306 1020ZM1140 1052Q1140 968 1058 895Q1068 974 1068 1007Q1068 1064 1029 1125Q1014 1148 950 1226Q1025 1223 1081 1175Q1140 1124 1140
1052ZM832 867Q791 881 765 952Q743 1010 743 1064Q743 1130 777 1169Q813 1037 832 867Z\" />
<path transform=\"scale(0.011,-0.011)\" id=\"g\" d=\"M1259 1480V0H173V1480H1259ZM1209 1431H222V49H1209V1431ZM370 247V296H1061V247H370ZM370 444V493H1061V444H370ZM370 641V691H1061V641H370ZM370 839V888H1061V839H370ZM370 1036V1086H1061V1036H370ZM370
1234V1283H1061V1234H370Z\" />
<path transform=\"matrix(0.011 0 0 -0.011 0 0)\" id=\"h\" d=\"M1456 -197H1259V-395H173V1086H370V1283H568V1480H1653V0H1456V-197ZM617 1431V1283H1456V49H1604V1431H617ZM420 1234V1086H1259V-148H1407V1234H420ZM1209 1036H222V-346H1209V1036ZM370 -148V-99H1061V-148H370ZM370
49V99H1061V49H370ZM370 247V296H1061V247H370ZM370 444V493H1061V444H370ZM370 641V691H1061V641H370ZM370 839V888H1061V839H370Z\" />
<path transform=\"matrix(0.009 0 0 -0.009 0 0)\" id=\"j\" d=\"M1653 740L1283 1110V814H1061V666H1283V370L1653 740ZM962 814H765V666H962V814ZM666 814H469V666H666V814ZM370 814H173V666H370V814Z\" />
<path transform=\"matrix(0.009 0 0 -0.009 0 0)\" id=\"ij\" d=\"M173 740L543 1110V814H765V666H543V370L173 740ZM864 814H1061V666H864V814ZM1160 814H1357V666H1160V814ZM1456 814H1653V666H1456V814Z M1653 740L1283 1110V814H1061V666H1283V370L1653 740ZM962 814H765V666H962V814ZM666 814H469V666H666V814ZM370 814H173V666H370V814Z\" />
<path transform=\"matrix(0.009 0 0 -0.009 0 0)\" id=\"n\" d=\"M209 969L913 1480L1617 969L1348 141H478L209 969Z\" />
<path transform=\"matrix(0.011 0 0 -0.011 0 0)\" id=\"Z\" d=\"M173 197V1382Q173 1423 202 1451T272 1480H1555Q1596 1480 1624 1452T1653 1382V99Q1653 58 1625 29T1555 0H370L173 197ZM864 493H617V49H864V493ZM1259 49H1555Q1580 49 1592 61T1604 98V1382Q1604
1431 1555 1431H1407V839Q1407 798 1378 769T1308 740H518Q477 740 449 769T420 839V1431H272Q222 1431 222 1382V217L390 49H568V493Q568 543 617 543H1209Q1259 543 1259 493V49ZM1357 1431H469V839Q469 815 481 803T518 790L1308 789Q1357 789 1357 839V1431Z\"/>
<path transform=\"matrix(0.009 0 0 -0.009 0 0)\" id=\"Y\" d=\"M878 740L222 1396V84L878 740ZM1407 705L1230 529Q1201 499 1160 499Q1119 499 1089 529L913 705L257 49H2062L1407 705ZM1442 740L2097 84V1396L1442 740ZM257 1431L1125 563Q1139 549 1160 549Q1181
549 1195 563L2063 1431H257ZM173 1480H2147V0H173V1480Z\" />
<path transform=\"matrix(0.007 0 0 -0.007 0 0)\" id=\"l\" d=\"M913 1480L1653 740H173L913 1480Z\" />
<path transform=\"matrix(0.007 0 0 -0.007 0 0)\" id=\"m\" d=\"M913 0L173 740H1653L913 0Z\" />


<path id=\"o\" d=\"M1112 737Q1170 737 1241 683T1313 567H1036L1002 240L984 380L980 402L962 567H688Q688 633 758 685T884 737V1145Q834 1145 784 1167Q724 1197 724 1245Q724 1317 810 1349Q868 1367 1002 1367Q1158
1367 1198 1353Q1277 1329 1277 1245Q1277 1205 1209 1169Q1154 1145 1112 1145V737Z\"  />

<path transform=\"matrix(0.005 0 0 -0.005 0 0)\" id=\"q\" d=\"M173 0V1480H1653V0H173Z\" />
<path transform=\"matrix(0.005 0 0 -0.005 0 0)\" id=\"b\" d=\"M1500 1568L1535 1518Q1321 1357 1059 1022T659 396L585 346Q493 282 460 251Q447 298 403 405L375 470Q315 610 264 677T148 766Q256 880 346 880Q423 880 517 671L548 601Q717 886 982 1155T1500 1568Z\" />
  <marker id=\"debut_mesure\" markerWidth=\"5\" markerHeight=\"10\" orient=\"auto\" refX=\"0\" refY=\"5\">
  	
	<path pointer-events=\"none\" fill=\"none\" stroke=\"red\" d=\"M 5 7.5 0 5 5 2.5\" />
</marker>
<marker id=\"fin_mesure\" markerWidth=\"5\" markerHeight=\"10\" orient=\"auto\" refX=\"5\" refY=\"5\">
  	<path pointer-events=\"none\" fill=\"none\" stroke=\"red\" d=\"M 0 7.5 5 5 0 2.5\" />
	
</marker>
 

";
$data.=$_SESSION['symbol'];

/*if($os=="Linux")
{
$texte=fopen("./linux_arial.svg","r");
$contents = fread($texte, filesize ("./linux_arial.svg"));
$data.=$contents;
fclose($texte);
}*/
$data.="


   </defs>";
  
    $data.="<g id=\"layer1\" class=\"defaut\">
   	
    <svg id=\"mapid\"  x=\"10\" y=\"10\" width=\"780\" height=\"546\" viewBox=\"0 0 ".$_SESSION['large']." ".$_SESSION['haute']."\"  onmousedown=\"createcircle(evt);\" onmouseup=\"fintrait(evt)\" onmousemove=\"bougetrait(evt)\"  onmouseover=\"desinib_use();\">
	<g id=\"enregistrement\">
<rect id=\"desrect\" x=\"0\" y=\"0\" width=\"".$_SESSION['large']."\" height=\"".$_SESSION['haute']."\" stroke=\"none\" fill=\"white\" pointer-events=\"none\"/>

	<g id=\"dessin\" clip-path='none'>";
$data.=$_SESSION['controle'];

$data.="</g>
<g id='dess' stroke-width='0.2'>
	
	</g>
<g id=\"desrectpostit\" pointer-events=\"none\" onclick=\"pose_postit(evt)\"><a id=\"lipostit\"><rect  x=\"0\" y=\"0\" width=\"".$_SESSION['large']."\" height=\"".$_SESSION['haute']."\" stroke=\"none\" fill=\"none\"/></a></g>	
</g>
<rect id=\"rectevt\" x=\"0\" y=\"0\" width=\"0\" height=\"0\" opacity=\"0.5\" visibility=\"hidden\" pointer-events=\"none\"/>
	</svg>
	<g id=\"cardinal\" style=\"stroke:none\">
	<rect x=\"2\" y=\"10\" width=\"8\" height=\"546\" onmouseover=\"switchColor(evt,'class','survol','','ouest')\" onmouseout=\"switchColor(evt,'class','horssurvol','','ouest')\" onclick=\"goWest();\"/>
	<path id=\"ouest\" pointer-events=\"none\" d=\"M 2 261 10 190 10 332z\" />
	<text pointer-events=\"none\" x=\"2.25\" y=\"263\" class=\"textcardi\" font-size=\"8\">W</text>
	<rect x=\"790\" y=\"125\" width=\"8\" height=\"431\" onmouseover=\"switchColor(evt,'class','survol','','est')\" onmouseout=\"switchColor(evt,'class','horssurvol','','est')\" onclick=\"goEast();\"/>
	<path id=\"est\" pointer-events=\"none\" d=\"M 798 261 790 190 790 332z\" />
	<text pointer-events=\"none\" x=\"791\" y=\"263\" class=\"textcardi\" font-size=\"8\">E</text>
	<rect x=\"10\" y=\"2\" width=\"780\" height=\"8\" onmouseover=\"switchColor(evt,'class','survol','','nord')\" onmouseout=\"switchColor(evt,'class','horssurvol','','nord')\" onclick=\"goNorth();\"/>
	<path id=\"nord\" pointer-events=\"none\" d=\"M 400 2 329 10 471 10z\" />
	<text pointer-events=\"none\" x=\"399\" y=\"9\" class=\"textcardi\" font-size=\"8\">N</text>
	<rect x=\"10\" y=\"556\" width=\"780\" height=\"8\" onmouseover=\"switchColor(evt,'class','survol','','sud')\" onmouseout=\"switchColor(evt,'class','horssurvol','','sud')\" onclick=\"goSouth();\"/>
	<path id=\"sud\" pointer-events=\"none\" d=\"M 400 564 329 556 471 556z\" />
	<text pointer-events=\"none\" x=\"399\" y=\"564\" class=\"textcardi\" font-size=\"8\">S</text>
	</g>";
	$data.="<rect id=\"map\" width=\"780\" height=\"546\" x=\"10\" y=\"10\" class=\"contourmap\"/>
	<rect x=\"540\" y=\"537\" width=\"245\" height=\"14\" class=\"cadre\"/>
	<use x=\"13\" y=\"36\" xlink:href=\"#a\" pointer-events=\"none\" class=\"fillfonce\"/>
	<text pointer-events=\"none\" x=\"545\" y=\"547\" class=\"fillfonce\" font-size=\"8\">Source: direction g&#233;n&#233;rale des imp&#244;ts - cadastre;mise &#224; jour:".$maj."</text>
	";
	
	$data.="<rect class=\"cadre\" width=\"55\" height=\"10\" x=\"730\" y=\"12\" pointer-events=\"none\"/>";
$data.="<text pointer-events=\"none\" x=\"735\" y=\"19\" class=\"fillfonce\" style=\"font-size:8px\">Navigation</text>
	<image id=\"t_navigation\" x=\"776\" y=\"13\" width=\"8\" height=\"8\" xlink:href=\"./expandbtn2.gif\" onclick=\"javascript:navigation()\" onmouseover=\"switchColor(evt,'opacity','0.7','','');\" onmouseout=\"switchColor(evt,'opacity','1','','')\"/>";
	
	$data.="<g id=\"navigation\" opacity=\"1\" pointer-events=\"visible\" >
	<rect width=\"157\" height=\"109.9\" x=\"628\" y=\"22\" fill=\"rgb(255,255,255)\" stroke=\"none\" pointer-events=\"none\"/>
	<svg id=\"overviewmap\" x=\"628\" y=\"22\" width=\"157\" height=\"109.9\" viewBox=\"0 0 ".$_SESSION['large']." ".$_SESSION['haute']."\" onmousedown=\"beginPan(evt)\" onmousemove=\"doPan(evt)\" onmouseup=\"endPan(evt)\" onmouseout=\"endPan(evt)\" onmouseover=\"inib_use();\" >";
    if (file_exists("./communes/".$_SESSION["profil"]->insee."_16_9.JPG"))
	{
	$data.="<image id=\"fond\" x=\"0\" y=\"0\" width=\"".$_SESSION['large']."\" height=\"".$_SESSION['haute']."\" xlink:href=\"./communes/".$_SESSION["profil"]->insee."_16_9.JPG\" />";
	}
	else
	{
	
	$url="https://".$_SERVER['HTTP_HOST']."/interface/crea_fond_carte_svg.php?codeinsee=".$_SESSION["profil"]->insee;
	$contenu=file($url);
       		while (list($ligne,$cont)=each($contenu)){
			$numligne[$ligne]=$cont;
		}
		$img=$contenu[0];
	$data.="<image id=\"fond\" x=\"0\" y=\"0\" width=\"".$_SESSION['large']."\" height=\"".$_SESSION['haute']."\" xlink:href=\"".$img."\"/>";
	}
	$data.="
	<g >
	<rect id=\"Rect1\" cursor=\"move\" style=\"fill:rgb(255,255,255);stroke-width:30;stroke:rgb(255,0,0);fill-opacity:0.7\" x=\"0\" y=\"0\"
 width=\"".$_SESSION['large']."\" height=\"".$_SESSION['haute']."\" />
 <rect id=\"lin1\"  style=\"fill:rgb(255,0,0);fill-opacity:1\" x=\"0\" y=\"".($_SESSION['haute']/2)."\" width=\"".$_SESSION['large']."\" height=\"20\" visibility=\"hidden\" pointer-events=\"none\"/>
 <rect id=\"lin2\"  style=\"fill:rgb(255,0,0);fill-opacity:1\" x=\"".($_SESSION['large']/2)."\" y=\"0\" width=\"20\" height=\"".$_SESSION['haute']."\" visibility=\"hidden\" pointer-events=\"none\"/>

	<rect id=\"locationRect\" cursor=\"move\" style=\"fill:rgb(0,0,128);stroke:rgb(255,0,0);stroke-width:20;fill-opacity:0.3\" x=\"0\" y=\"0\"
 width=\"".$_SESSION['large']."\" height=\"".$_SESSION['haute']."\"  visibility=\"hidden\" />
 </g>	
	
	</svg><rect id=\"locamap\" width=\"157\" height=\"109.9\" x=\"628\" y=\"22\" class=\"contourmap\"/></g>";
if($_SESSION["profil"]->droit_appli=='v')
{
$sty_postit="pointer-events=\"none\" opacity=\"0.4\"";
 } 	

 $data.="<g id=\"zoomin\">
      		<g id=\"graduation\" class=\"boutonzoom\">
        	<g id=\"moins\">
			
			<image id=\"rectmoins\" x=\"791\" y=\"114\" width=\"8\" height=\"8\" xlink:href=\"../doc_commune/".$_SESSION['ref_rep']."/skins/zoommoin.png\" onclick=\"Zoomless(evt);\" onmouseover=\"switchColor(evt,'opacity','0.7','','');\" onmouseout=\"switchColor(evt,'opacity','1','','')\"/>";
			
			$data.="</g>
        	<g id=\"plus\">
			<image id=\"rectplus\" x=\"791\" y=\"22\" width=\"8\" height=\"8\" xlink:href=\"../doc_commune/".$_SESSION['ref_rep']."/skins/zoomplus.png\" onclick=\"Zoommore(evt);\" onmouseover=\"switchColor(evt,'opacity','0.7','','');\" onmouseout=\"switchColor(evt,'opacity','1','','')\"/>";
			
				
     		$data.="</g>";
			
			$data.="<rect id=\"support_rectzoom\" fill=\"rgb(130,147,182)\" stroke=\"none\" x=\"793\" y=\"30\" width=\"4\" height=\"84\" pointer-events=\"none\"/>";
			$data.="<rect id=\"rectzoom\" x=\"791\" y=\"109\" width=\"8\" height=\"5\" rx=\"1\" ry=\"1\"  onmouseover=\"switchColor(evt,'class','survol','','');bougez(evt,'false',0)\" onmouseup=\"bougez(evt,'false',1)\" onmousedown=\"bougez(evt,'true',0)\" onmousemove=\"bougezoom(evt)\" onmouseout=\"switchColor(evt,'class','boutonzoom)','','');hideinfotip(evt);bougez(evt,'false',1)\"/>";

$data.="</g><rect id=\"releasezoom\" x=\"6\" y=\"11\" width=\"124\" height=\"124\" fill=\"rgb(255,0,0)\" opacity=\"0\" visibility=\"hidden\" pointer-events=\"none\" onclick=\"releaseZoom(evt);\"/>

<rect id=\"bgrectevt\"  cursor=\"crosshair\" x=\"10\" y=\"10\" width=\"780\" height=\"546\"  fill=\"rgb(255,0,255)\" opacity=\"0\" visibility=\"hidden\" onmousedown=\"beginResize(evt)\" onmouseup=\"endResize(evt)\" onmousemove=\"doResize(evt)\" pointer-events=\"none\"/>";
      		
      	$data.="</g>";
    

			$data.="<g id=\"valmultiple\"  visibility='hidden'>
     		<a id='livalide'>
			<image id='valid' x=\"10\" y=\"0\" width=\"30\" height=\"10\" xlink:href=\"../doc_commune/".$_SESSION['ref_rep']."/skins/validemultiple.png\" onclick='validmulti()'/></a>
			</g>";
			
			
            $data.="<g id=\"effacemesure\" visibility='hidden' onclick=\"effacetrait(evt)\">
			<image x=\"10\" y=\"0\" width=\"30\" height=\"10\" xlink:href=\"../doc_commune/".$_SESSION['ref_rep']."/skins/effacer.png\"/></g>
			<g id=\"effacesurface\" visibility='hidden' onclick=\"effacetrait(evt)\">
			<image x=\"10\" y=\"0\" width=\"10\" height=\"10\" xlink:href=\"../doc_commune/".$_SESSION['ref_rep']."/skins/delete.png\"/></g>
			<g id=\"validesurface\" visibility='hidden' onclick=\"validesurface(evt)\">
			<image x=\"25\" y=\"0\" width=\"10\" height=\"10\" xlink:href=\"../doc_commune/".$_SESSION['ref_rep']."/skins/valide.png\"/></g>
			<g id=\"validepolygo\" visibility='hidden'  onclick=\"validepoly(evt)\">
			<image x=\"25\" y=\"0\" width=\"10\" height=\"10\" xlink:href=\"../doc_commune/".$_SESSION['ref_rep']."/skins/valide.png\"/></g>
			<g id=\"effacepolygo\" visibility='hidden' onclick=\"effacetrait(evt)\">
			<image x=\"10\" y=\"0\" width=\"10\" height=\"10\" xlink:href=\"../doc_commune/".$_SESSION['ref_rep']."/skins/delete.png\"/></g>
			
			";
			
			
    	
$data.="<g id=\"echelle\" class=\"fillfonce\" > 
		<text y=\"551\" x=\"45\" style=\"text-anchor:middle;font-size:8px\">M&#x00E9;tres</text>
		<text id=\"gauche\" y=\"535\" x=\"20\" style=\"text-anchor:middle;font-size:8px\">0</text>
		<text id=\"droite\" y=\"535\" x=\"70\" style=\"text-anchor:middle;font-size:8px\">2</text>
		<path d=\"M 20,536 20,541 L 70,541 70,536  \" fill=\"none\"/>
  		</g>";
		
$data.="</g><g id=\"infotips\">
	<rect id=\"infotipRect\" x=\"20\" y=\"0\" width=\"100\" height=\"14\" class=\"cadre\" stroke-width=\"1\"  opacity=\"0.8\" pointer-events=\"none\" visibility=\"hidden\"></rect> 
	<text id=\"infotip\" x=\"25\" y=\"11\"  style=\"font-weight:normal;font-family:'Arial';font-size:8;text-anchor:left;pointer-events:none\" class=\"fillfonce\" visibility=\"hidden\" >!</text>
</g>";

$data.="</svg>";
//$data=gzcompress("$data",9);
echo $data;
?>
