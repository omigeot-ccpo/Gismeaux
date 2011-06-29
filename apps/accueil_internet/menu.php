<?php
define('GIS_ROOT', '../..');
include_once(GIS_ROOT . '/inc/common.php');
/*gis_session_start();

$insee = $_SESSION['profil']->insee;
$appli = $_SESSION['profil']->appli;

if ((!$_SESSION['profil']->idutilisateur)){
	die("Point d'entr&eacute;e r&eacute;glement&eacute;.<br> Accs interdit. <br>Veuillez vous connecter via <a href=\"https://".$_SERVER['HTTP_HOST']."\">serveur carto</a><SCRIPT language=javascript>setTimeout(\"window.location.replace('https://".$_SERVER['HTTP_HOST']."')\",3000)</SCRIPT>");
}*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN">

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<script type="text/javascript">
<!--
function hover(obj){
  if(document.all){
    UL = obj.getElementsByTagName('ul');
    if(UL.length > 0){
      sousMenu = UL[0].style;
      if(sousMenu .display == 'none' || sousMenu.display == ''){
        sousMenu.display = 'block';
      }else{
        sousMenu.display = 'none';
      }
    }
  }
}
function setHover(){
  LI = document.getElementById('menu').getElementsByTagName('li');
  nLI = LI.length;
  for(i=0; i < nLI; i++){
    LI[i].onmouseover = function(){
      hover(this);
    }
    LI[i].onmouseout = function(){
      hover(this);
    }
  }
}//-->
</script>
		<style type="text/css">
		<!--
#menu{
    width: 300px;
    list-style-type: none;
    margin: 0;
    padding: 0;
    border: 0;
}
#menu li {
    float: top;
    width: 150px;
    margin: 0;
    padding: 0;
    border: 0;
}
#menu li a {
    display: block;
    width: 100%;
}
#menu .sousmenu {
    display: none;
    list-style-type: none;
    margin: 0;
    padding: 0;
    border: 0;
}
#menu .sousmenu li {
    float:none;
    margin: 0;
    padding: 0;
    border: 0;
    width: 148px;
    border-top: 1px solid transparent;
    border-right: 1px solid transparent;
}
#menu li a:link , #menu li a:visited{
    display: block;
    height: auto;
    color: #FFF;
    background: #3B4E77;
    margin: 0;
    padding: 4px 8px;
    border-right: 1px solid #fff;
    text-decoration: none;
}
#menu li a:hover { background-color: #F2462E;}
#menu li a:active { background-color: #5F879D;}
#menu .sousmenu li a:link, #menu .sousmenu li a:visited {
    display: block;
    color: #FFF;
    margin: 0;
    border: 0;
    text-decoration: none;
    background-color: #56A5D3;
}
#menu li .sousmenu a:hover { background-color: #F2462E;}
#menu li:hover > .sousmenu {display: block;}
      		-->
		</style>
</head>

	<body onload="setHover()">
			<ul id="menu">
<?php //require_once('./connexion/deb.php');
 $ch2="select * from general.testmenu where id_pere in (select id from general.testmenu where id_pere is null) order by libelle";
$quer2=$DB->tab_result($ch2);
$kk=0;$t1='';
for($kk=0;$kk<count($quer2);$kk++){
//	if ($rw2['id_pere']!=''){
    if($quer2[$kk]['page']!=''){
        echo '<li ><a href="'.$quer2[$kk]['page'].'">'.htmlentities(utf8_decode($quer2[$kk]['libelle'])).'</a>';
    }else{
        echo '<li ><a href="#">'.htmlentities($quer2[$kk]['libelle']).'</a>';
    }
    $ch1="select * from general.testmenu where id_pere = '".$quer2[$kk]['id']."' and ( code_insee is null or code_insee='$insee' ) order by libelle";
    $quer1=$DB->tab_result($ch1);
    if (count($quer1)>0){
        echo '<ul class="sousmenu">';
        for ($qq=0;$qq<count($quer1);$qq++){
            echo '<li ><a href="'.$quer1[$qq]['page'].'">'.htmlentities(utf8_decode($quer1[$qq]['libelle'])).'</a></li>';
        }
        echo '</ul></li>';
    }else{ echo '</li>';}
//	}
}
//echo '</ul></li>';
?>
			</ul>
	</body>
</html>
