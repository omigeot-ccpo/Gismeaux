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
//if($_GET['sansplug']=='true')
//{
header("Content-type: image/svg+xml");
//}
define('GIS_ROOT', '..');
include_once(GIS_ROOT . '/inc/common.php');
gis_session_start();
$indice=strtoupper($_GET['indice']);
$essai=ereg("([A-Z]{1,2})", $indice, $regs);
$debut=$regs[1];
$reste='0000'.str_replace($regs[1],"",$indice);
$reste=substr($reste,-4);
$concat=$debut.$reste;
//print("<g id=\"recherche\" xmlns=\"http://www.w3.org/2000/svg\" onclick=\"clear('controlrecherche');rechercheavance(evt)\"  onmouseover=\"switchColor(evt,'fill','red','','')\" onmouseout=\"switchColor(evt,'fill','url(#survol)','','')\" text-anchor=\"middle\">");
if(substr($_SESSION['profil']->insee, -3)=='000')
{
$result = $DB->tab_result("SELECT identifian,commune.nom FROM cadastre.parcelle join admin_svg.commune on parcelle.code_insee=commune.idcommune WHERE (identifian LIKE '%$indice' OR identifian LIKE '%$concat') AND parcelle.code_insee like '".substr($_SESSION['profil']->insee,0,3)."%' group by identifian,nom");
}
else
{
$result = $DB->tab_result("SELECT parcelle.identifian FROM cadastre.parcelle WHERE (identifian LIKE '%$indice' OR identifian LIKE '%$concat') AND code_insee='".$_SESSION['profil']->insee."' group by identifian");
}
if (count($result)>0)
{
//print("<text  x='316' y='120' pointer-events='none' class='fillfonce'>Sur la couche parcelle</text>");
$titre="Sur la couche parcelle";
}
$n=132;
for ($l=0;$l<count($result);$l++){
$nom=$result[$l]['identifian'];
if($result[$l]['commune']!="")
{
$nom1=$result[$l]['commune'].' ';
}
//print("<text n=\"1\" x='316' y='$n' id=\"$nom\" fill=\"url(#survol)\" font-size=\"10\">$nom1$nom</text>");
$resultat.="$nom1$nom|";
$n=$n+13;
}




$z=$n+13;
if(substr($_SESSION['profil']->insee, -3)=='000'){
    $resul = $DB->tab_result("SELECT voies.commune||code_voie as cod,commune.nom||', '||voies.nom_voie as nom_voie FROM cadastre.voies join admin_svg.commune on voies.commune=commune.idcommune WHERE voies.nom_voie LIKE '%$indice%' AND voies.commune like '".substr($_SESSION['profil']->insee,0,3)."%'");
	
}else{
    $resul = $DB->tab_result("SELECT voies.commune||code_voie as cod,nom_voie FROM cadastre.voies WHERE nom_voie LIKE '%".$indice."%' AND commune='".$_SESSION['profil']->insee."'");
}
if (count($resul)>0)
{
//print("<text n=\"2\" x='316' y='$z' pointer-events='none' class='fillfonce'>Sur l'adresse</text>");
$titre="Sur l'adresse";
}
$n=$z+15;
for ($l=0;$l<count($resul);$l++){
$code=$resul[$l]['cod'];
$nom=$resul[$l]['nom_voie'];
//print("<text id=\"$code\" n=\"2\" x='316' y='$n' fill=\"url(#survol)\" font-size=\"10\">$nom</text>");
$resultat.="$nom|";
$codage.="$code|";
$n=$n+13;
}

print("<g id=\"retour_recherche\" xmlns=\"http://www.w3.org/2000/svg\" titre=\"".$titre."\" resultat=\"".$resultat."\" codage=\"".$codage."\"></g>");
//pg_close($pgx);

?>
