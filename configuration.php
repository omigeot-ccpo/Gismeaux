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
define('GIS_ROOT', '.');
include_once(GIS_ROOT . '/inc/common.php');
gis_init();
if ($_POST['projection']){
$fichier="./config/db.local.php"; 

//ouverture en lecture et modification 
$text=fopen($fichier,'r'); 
//$contenu=file_get_contents($fichier); 
//$contenuMod=str_replace('27571', $_POST['projection'], $contenu); 
//fclose($text); 

$contenuMod = '';
while (!feof($text)) {

		$buffer = fgets($text, 4096);
							if (ereg ("projection", $buffer)) 
							{
									$contenuMod .= '$projection="'.$_POST['projection'].'";'."\n";
							}
							else
							{
 							 $contenuMod .= $buffer;
 							 }
}
fclose($text);

//ouverture en écriture 
$text2=fopen($fichier,'w+'); 
fwrite($text2,$contenuMod); 
fclose($text2);

if(ereg ("RU",$_POST['a_instal']))
{

$ru="
SET search_path = admin_svg, pg_catalog;
INSERT INTO application (libelle_appli, btn_polygo, libelle_btn_polygo, divers, zoom_ouverture, zoom_min, zoom_max, url, type_appli) VALUES ('RU', '', '', '', 600, 600, 8000, 'interface/carto.php', '0');
INSERT INTO apputi VALUES (currval('admin_svg.appli'::text), '1', 'a', NULL, NULL, (select max(ordre)+1 from admin_svg.apputi where idutilisateur=1));
INSERT INTO appthe (idapplication, idtheme, mouseover, click, mouseout, ordre, sordre, ordre_couche, pointer_events, raster, zoommin, zoommax, zoommaxraster, objselection, objprincipal, objrecherche, partiel, vu_initial,force_chargement) VALUES (currval('admin_svg.appli'::text), '1', '', '', '', 2, 0, 0, '', false, NULL, NULL, NULL, false, false, false, '1', '0', '0');
INSERT INTO col_theme VALUES (currval('admin_svg.appth'::text), 'constructi', 'Bati leger', '', '', 'Bati leger', '221,174,205', 'none', '', '1', '', '', '', '', '', '-1', '', '', 2);
INSERT INTO col_theme VALUES (currval('admin_svg.appth'::text), 'constructi', 'Bati dur', '', '', 'Bati dur', '184,84,149', 'none', '', '1', '', '', '', '', '', '-1', '', '', 1);

INSERT INTO appthe (idapplication, idtheme, mouseover, click, mouseout, ordre, sordre, ordre_couche, pointer_events, raster, zoommin, zoommax, zoommaxraster, objselection, objprincipal, objrecherche, partiel, vu_initial,force_chargement) VALUES (currval('admin_svg.appli'::text), '2', 'sur(evt,''red'')', 'lien(evt,''parcel'',''http://''+serveur+''/apps/ru/requete.php?obj_keys='',''m'',''5'')', 'hors(evt)', 1, 0, 0, 'visible', false, NULL, NULL, NULL, false, true, true, '1', '1', '0');
INSERT INTO theme (libelle_them, schema, tabl, raster, partiel, vu_initial, couch_tjs_visible, zoommin, zoommax, zoommax_raster, vu_anonyme, force_chargement) VALUES ('Zone de bruit', 'geotest', 'zonebruit', '', '', '', '', 600, 10000, '0', false, '0');
INSERT INTO col_sel VALUES (currval('admin_svg.them'::text), 'the_geom', 'geom', '2');
INSERT INTO col_sel VALUES (currval('admin_svg.them'::text), 'gid', 'ident', '1');
INSERT INTO appthe (idapplication, idtheme, mouseover, click, mouseout, ordre, sordre, ordre_couche, pointer_events, raster, zoommin, zoommax, zoommaxraster, objselection, objprincipal, objrecherche, partiel, vu_initial,force_chargement) VALUES (currval('admin_svg.appli'::text), currval('admin_svg.them'::text), '', '', '', 4, 0, 0, '', false, NULL, NULL, NULL, false, false, false, '0', '0', '0');
INSERT INTO col_theme VALUES (currval('admin_svg.appth'::text), 'type', 'Route 1', '', '', '1_route', '131,79,189', '0,0,0', '', '1', '', '', '', '', '', '-1', '', '', 1);
INSERT INTO col_theme VALUES (currval('admin_svg.appth'::text), 'type', 'SNCF', '', '', '1_sncf', '111,62,162', '0,0,0', '', '1', '', '', '', '', '', '-1', '', '', 2);
INSERT INTO col_theme VALUES (currval('admin_svg.appth'::text), 'type', 'Route 2', '', '', '2_route', '156,115,202', '0,0,0', '', '1', '', '', '', '', '', '-1', '', '', 3);
INSERT INTO col_theme VALUES (currval('admin_svg.appth'::text), 'type', 'Route 3', '', '', '3_route', '204,183,227', '0,0,0', '', '1', '', '', '', '', '', '-1', '', '', 4);
INSERT INTO col_theme VALUES (currval('admin_svg.appth'::text), 'type', 'Route 4', '', '', '4_route', '183,152,216', '0,0,0', '', '1', '', '', '', '', '', '-1', '', '', 5);
INSERT INTO theme (libelle_them, schema, tabl, raster, partiel, vu_initial, couch_tjs_visible, zoommin, zoommax, zoommax_raster, vu_anonyme, force_chargement) VALUES ('Zone archeo', 'geotest', 'z_archeo', '', '', '', '', 600, 10000, '0', false, '0');
INSERT INTO col_sel VALUES (currval('admin_svg.them'::text), 'the_geom', 'geom', '1');
INSERT INTO appthe (idapplication, idtheme, mouseover, click, mouseout, ordre, sordre, ordre_couche, pointer_events, raster, zoommin, zoommax, zoommaxraster, objselection, objprincipal, objrecherche, partiel, vu_initial,force_chargement) VALUES (currval('admin_svg.appli'::text), currval('admin_svg.them'::text), '', '', '', 6, 0, 0, '', false, NULL, NULL, NULL, false, false, false, '0', '0', '0');
INSERT INTO col_theme VALUES (currval('admin_svg.appth'::text), 'nom', '1', '', '', '1', '215,99,50', '0,0,0', '', '1', '', '', '', '', '', '-1', '', '', 1);
INSERT INTO col_theme VALUES (currval('admin_svg.appth'::text), 'nom', '2', '', '', '2', '251,243,96', '0,0,0', '', '1', '', '', '', '', '', '-1', '', '', 2);
INSERT INTO theme (libelle_them, schema, tabl, raster, partiel, vu_initial, couch_tjs_visible, zoommin, zoommax, zoommax_raster, vu_anonyme, force_chargement) VALUES ('Emplacement reserve', 'geotest', 'emplreserve', '', '', '', '', 600, 10000, '0', false, '0');
INSERT INTO col_sel VALUES (currval('admin_svg.them'::text), 'the_geom', 'geom', '1');
INSERT INTO style VALUES (nextval('admin_svg.styl'::text), currval('admin_svg.them'::text), NULL, '136,213,217', '136,213,217', '', '1', '', '', '', '', '', '-1', '', '');
INSERT INTO appthe (idapplication, idtheme, mouseover, click, mouseout, ordre, sordre, ordre_couche, pointer_events, raster, zoommin, zoommax, zoommaxraster, objselection, objprincipal, objrecherche, partiel, vu_initial,force_chargement) VALUES (currval('admin_svg.appli'::text), currval('admin_svg.them'::text), '', '', '', 8, 0, 0, '', false, NULL, NULL, NULL, false, false, false, '0', '0', '0');
INSERT INTO theme (libelle_them, schema, tabl, raster, partiel, vu_initial, couch_tjs_visible, zoommin, zoommax, zoommax_raster, vu_anonyme, force_chargement) VALUES ('Cimetiere', 'geotest', 'cimetiere', '', '', '', '', 600, 10000, '0', false, '0');
INSERT INTO col_sel VALUES (currval('admin_svg.them'::text), 'the_geom', 'geom', '1');
INSERT INTO style VALUES (nextval('admin_svg.styl'::text), currval('admin_svg.them'::text), NULL, '252,247,35', '252,247,35', '', '1', '', '', '', '', '', '-1', '', '');
INSERT INTO appthe (idapplication, idtheme, mouseover, click, mouseout, ordre, sordre, ordre_couche, pointer_events, raster, zoommin, zoommax, zoommaxraster, objselection, objprincipal, objrecherche, partiel, vu_initial,force_chargement) VALUES (currval('admin_svg.appli'::text), currval('admin_svg.them'::text), '', '', '', 7, 0, 0, '', false, NULL, NULL, NULL, false, false, false, '0', '0', '0');
INSERT INTO theme (libelle_them, schema, tabl, raster, partiel, vu_initial, couch_tjs_visible, zoommin, zoommax, zoommax_raster, vu_anonyme, force_chargement) VALUES ('Zone inondable', 'geotest', 'zoneinondable', '', '', '', '', 600, 10000, '0', false, '0');
INSERT INTO col_sel VALUES (currval('admin_svg.them'::text), 'the_geom', 'geom', '1');
INSERT INTO appthe (idapplication, idtheme, mouseover, click, mouseout, ordre, sordre, ordre_couche, pointer_events, raster, zoommin, zoommax, zoommaxraster, objselection, objprincipal, objrecherche, partiel, vu_initial,force_chargement) VALUES (currval('admin_svg.appli'::text), currval('admin_svg.them'::text), '', '', '', 9, 0, 0, '', false, NULL, NULL, NULL, false, false, false, '0', '0', '0');
INSERT INTO col_theme VALUES (currval('admin_svg.appth'::text), 'zone', 'Zone inondable A', '', '', 'A', '21,9,253', '21,9,253', '', '1', '', '', '', '', '', '-1', '', '', 1);
INSERT INTO col_theme VALUES (currval('admin_svg.appth'::text), 'zone', 'Zone inondable B', '', '', 'B', '155,150,254', '155,150,254', '', '1', '', '', '', '', '', '-1', '', '', 2);
INSERT INTO theme (libelle_them, schema, tabl, raster, partiel, vu_initial, couch_tjs_visible, zoommin, zoommax, zoommax_raster, vu_anonyme, force_chargement) VALUES ('Lisiere', 'geotest', 'lisiere', '', '', '', '', 600, 10000, '0', false, '0');
INSERT INTO col_sel VALUES (currval('admin_svg.them'::text), 'the_geom', 'geom', '1');
INSERT INTO style VALUES (nextval('admin_svg.styl'::text), currval('admin_svg.them'::text), NULL, '50,164,21', '50,164,21', '', '1', '', '', '', '', '', '-1', '', '');
INSERT INTO appthe (idapplication, idtheme, mouseover, click, mouseout, ordre, sordre, ordre_couche, pointer_events, raster, zoommin, zoommax, zoommaxraster, objselection, objprincipal, objrecherche, partiel, vu_initial,force_chargement) VALUES (currval('admin_svg.appli'::text), currval('admin_svg.them'::text), '', '', '', 11, 0, 0, '', false, NULL, NULL, NULL, false, false, false, '0', '0', '0');
INSERT INTO theme (libelle_them, schema, tabl, raster, partiel, vu_initial, couch_tjs_visible, zoommin, zoommax, zoommax_raster, vu_anonyme, force_chargement) VALUES ('Lotissement', 'geotest', 'lotissement', '', '', '', '', 600, 10000, '0', false, '0');
INSERT INTO col_sel VALUES (currval('admin_svg.them'::text), 'the_geom', 'geom', '1');
INSERT INTO style VALUES (nextval('admin_svg.styl'::text), currval('admin_svg.them'::text), NULL, '205,177,82', '205,177,82', '', '1', '', '', '', '', '', '-1', '', '');
INSERT INTO appthe (idapplication, idtheme, mouseover, click, mouseout, ordre, sordre, ordre_couche, pointer_events, raster, zoommin, zoommax, zoommaxraster, objselection, objprincipal, objrecherche, partiel, vu_initial,force_chargement) VALUES (currval('admin_svg.appli'::text), currval('admin_svg.them'::text), '', '', '', 12, 0, 0, '', false, NULL, NULL, NULL, false, false, false, '0', '0', '0');
INSERT INTO theme (libelle_them, schema, tabl, raster, partiel, vu_initial, couch_tjs_visible, zoommin, zoommax, zoommax_raster, vu_anonyme, force_chargement) VALUES ('PPMH', 'geotest', 'ppmh', '', '', '', '', 600, 10000, '0', false, '0');
INSERT INTO col_sel VALUES (currval('admin_svg.them'::text), 'the_geom', 'geom', '1');
INSERT INTO style VALUES (nextval('admin_svg.styl'::text), currval('admin_svg.them'::text), NULL, '163,71,156', '163,71,156', '', '1', '', '', '', '', '', '-1', '', '');
INSERT INTO appthe (idapplication, idtheme, mouseover, click, mouseout, ordre, sordre, ordre_couche, pointer_events, raster, zoommin, zoommax, zoommaxraster, objselection, objprincipal, objrecherche, partiel, vu_initial,force_chargement) VALUES (currval('admin_svg.appli'::text), currval('admin_svg.them'::text), '', '', '', 13, 0, 0, '', false, NULL, NULL, NULL, false, false, false, '0', '0', '0' );
INSERT INTO theme (libelle_them, schema, tabl, raster, partiel, vu_initial, couch_tjs_visible, zoommin, zoommax, zoommax_raster, vu_anonyme, force_chargement) VALUES ('Risque technologique', 'geotest', 'sidobre', '', '', '', '', 600, 10000, '0', false, '0');
INSERT INTO col_sel VALUES (currval('admin_svg.them'::text), 'the_geom', 'geom', '1');
INSERT INTO style VALUES (nextval('admin_svg.styl'::text), currval('admin_svg.them'::text), NULL, '255,0,0', '255,0,0', '', '1', '', '', '', '', '', '-1', '', '');
INSERT INTO appthe (idapplication, idtheme, mouseover, click, mouseout, ordre, sordre, ordre_couche, pointer_events, raster, zoommin, zoommax, zoommaxraster, objselection, objprincipal, objrecherche, partiel, vu_initial,force_chargement) VALUES (currval('admin_svg.appli'::text), currval('admin_svg.them'::text), '', '', '', 14, 0, 0, '', false, NULL, NULL, NULL, false, false, false, '0', '0', '0');
INSERT INTO theme (libelle_them, schema, tabl, raster, partiel, vu_initial, couch_tjs_visible, zoommin, zoommax, zoommax_raster, vu_anonyme, force_chargement) VALUES ('alignement', 'geotest', 'alignement', '', '0', '', '', 600, 10000, '0', false, '0');
INSERT INTO col_sel VALUES (currval('admin_svg.them'::text), 'gid', 'ident', '1');
INSERT INTO col_sel VALUES (currval('admin_svg.them'::text), 'gid', 'ad', '2');
INSERT INTO col_sel VALUES (currval('admin_svg.them'::text), 'the_geom', 'geom', '3');
INSERT INTO style VALUES (nextval('admin_svg.styl'::text), currval('admin_svg.them'::text), NULL, '', '255,0,0', '0.5', '', '', '', '', '', '', '', '', '');
INSERT INTO appthe (idapplication, idtheme, mouseover, click, mouseout, ordre, sordre, ordre_couche, pointer_events, raster, zoommin, zoommax, zoommaxraster, objselection, objprincipal, objrecherche, partiel, vu_initial,force_chargement) VALUES (currval('admin_svg.appli'::text), currval('admin_svg.them'::text), '', '', '', 18, 0, 0, '', false, NULL, NULL, NULL, false, false, false, '0', '0', '0');
INSERT INTO theme (libelle_them, schema, tabl, raster, partiel, vu_initial, couch_tjs_visible, zoommin, zoommax, zoommax_raster, vu_anonyme, force_chargement) VALUES ('zonage', 'geotest', 'zonage', '', '', '', '', 600, 10000, '600', false, '0');
INSERT INTO col_sel VALUES (currval('admin_svg.them'::text), 'the_geom', 'geom', '1');
INSERT INTO appthe (idapplication, idtheme, mouseover, click, mouseout, ordre, sordre, ordre_couche, pointer_events, raster, zoommin, zoommax, zoommaxraster, objselection, objprincipal, objrecherche, partiel, vu_initial,force_chargement) VALUES (currval('admin_svg.appli'::text), currval('admin_svg.them'::text), '', '', '', 3, 0, 0, '', false, NULL, NULL, NULL, false, false, false, '0', '0', '0');
INSERT INTO col_theme VALUES (currval('admin_svg.appth'::text), 'zone', 'AUB', '', '', 'AUB', '120,234,243', '0,0,0', '', '1', '', '', '', '', '', '-1', '', '', 1);
INSERT INTO col_theme VALUES (currval('admin_svg.appth'::text), 'zone', 'AUCa', '', '', 'AUCa', '120,234,243', '0,0,0', '', '1', '', '', '', '', '', '-1', '', '', 2);
INSERT INTO col_theme VALUES (currval('admin_svg.appth'::text), 'zone', 'AUCb', '', '', 'AUCb', '120,234,243', '0,0,0', '', '1', '', '', '', '', '', '-1', '', '', 3);
INSERT INTO col_theme VALUES (currval('admin_svg.appth'::text), 'zone', 'AUD', '', '', 'AUD', '120,234,243', '0,0,0', '', '1', '', '', '', '', '', '-1', '', '', 4);
INSERT INTO col_theme VALUES (currval('admin_svg.appth'::text), 'zone', 'AUE', '', '', 'AUE', '120,234,243', '0,0,0', '', '1', '', '', '', '', '', '-1', '', '', 5);
INSERT INTO col_theme VALUES (currval('admin_svg.appth'::text), 'zone', 'AUXa', '', '', 'AUXa', '120,234,243', '0,0,0', '', '1', '', '', '', '', '', '-1', '', '', 6);
INSERT INTO col_theme VALUES (currval('admin_svg.appth'::text), 'zone', 'AUXb', '', '', 'AUXb', '120,234,243', '0,0,0', '', '1', '', '', '', '', '', '-1', '', '', 7);
INSERT INTO col_theme VALUES (currval('admin_svg.appth'::text), 'zone', 'N', '', '', 'N', '9,208,18', '0,0,0', '', '1', '', '', '', '', '', '-1', '', '', 8);
INSERT INTO col_theme VALUES (currval('admin_svg.appth'::text), 'zone', 'NAa', '', '', 'NAa', '41,138,28', '0,0,0', '', '1', '', '', '', '', '', '-1', '', '', 9);
INSERT INTO col_theme VALUES (currval('admin_svg.appth'::text), 'zone', 'NAd', '', '', 'NAd', '64,210,43', '0,0,0', '', '1', '', '', '', '', '', '-1', '', '', 10);
INSERT INTO col_theme VALUES (currval('admin_svg.appth'::text), 'zone', 'NAv', '', '', 'NAv', '0,255,0', '0,0,0', '', '1', '', '', '', '', '', '-1', '', '', 11);
INSERT INTO col_theme VALUES (currval('admin_svg.appth'::text), 'zone', 'NAxb', '', '', 'NAxb', '82,180,35', '0,0,0', '', '1', '', '', '', '', '', '-1', '', '', 12);
INSERT INTO col_theme VALUES (currval('admin_svg.appth'::text), 'zone', 'NAxc', '', '', 'NAxc', '105,216,52', '0,0,0', '', '1', '', '', '', '', '', '-1', '', '', 13);
INSERT INTO col_theme VALUES (currval('admin_svg.appth'::text), 'zone', 'NBa', '', '', 'NBa', '90,147,28', '0,0,0', '', '1', '', '', '', '', '', '-1', '', '', 14);
INSERT INTO col_theme VALUES (currval('admin_svg.appth'::text), 'zone', 'NBb', '', '', 'NBb', '108,177,33', '0,0,0', '', '1', '', '', '', '', '', '-1', '', '', 15);
INSERT INTO col_theme VALUES (currval('admin_svg.appth'::text), 'zone', 'NBc', '', '', 'NBc', '125,204,38', '0,0,0', '', '1', '', '', '', '', '', '-1', '', '', 16);
INSERT INTO col_theme VALUES (currval('admin_svg.appth'::text), 'zone', 'NBd', '', '', 'NBd', '151,221,74', '0,0,0', '', '1', '', '', '', '', '', '-1', '', '', 17);
INSERT INTO col_theme VALUES (currval('admin_svg.appth'::text), 'zone', 'NCa', '', '', 'NCa', '100,122,22', '0,0,0', '', '1', '', '', '', '', '', '-1', '', '', 18);
INSERT INTO col_theme VALUES (currval('admin_svg.appth'::text), 'zone', 'NCb', '', '', 'NCb', '125,154,29', '0,0,0', '', '1', '', '', '', '', '', '-1', '', '', 19);
INSERT INTO col_theme VALUES (currval('admin_svg.appth'::text), 'zone', 'NCc', '', '', 'NCc', '174,214,39', '0,0,0', '', '1', '', '', '', '', '', '-1', '', '', 20);
INSERT INTO col_theme VALUES (currval('admin_svg.appth'::text), 'zone', 'NDa', '', '', 'NDa', '28,157,73', '0,0,0', '', '1', '', '', '', '', '', '-1', '', '', 21);
INSERT INTO col_theme VALUES (currval('admin_svg.appth'::text), 'zone', 'NDb', '', '', 'NDb', '34,189,88', '0,0,0', '', '1', '', '', '', '', '', '-1', '', '', 22);
INSERT INTO col_theme VALUES (currval('admin_svg.appth'::text), 'zone', 'NDc', '', '', 'NDc', '58,220,115', '0,0,0', '', '1', '', '', '', '', '', '-1', '', '', 23);
INSERT INTO col_theme VALUES (currval('admin_svg.appth'::text), 'zone', 'NL', '', '', 'NL', '134,219,168', '0,0,0', '', '1', '', '', '', '', '', '-1', '', '', 24);
INSERT INTO col_theme VALUES (currval('admin_svg.appth'::text), 'zone', 'UA', '', '', 'UA', '186,157,114', '0,0,0', '', '1', '', '', '', '', '', '-1', '', '', 25);
INSERT INTO col_theme VALUES (currval('admin_svg.appth'::text), 'zone', 'UAa', '', '', 'UAa', '215,134,100', '0,0,0', '', '1', '', '', '', '', '', '-1', '', '', 26);
INSERT INTO col_theme VALUES (currval('admin_svg.appth'::text), 'zone', 'UAb', '', '', 'UAb', '171,158,143', '0,0,0', '', '1', '', '', '', '', '', '-1', '', '', 27);
INSERT INTO col_theme VALUES (currval('admin_svg.appth'::text), 'zone', 'UB', '', '', 'UB', '188,157,84', '0,0,0', '', '1', '', '', '', '', '', '-1', '', '', 28);
INSERT INTO col_theme VALUES (currval('admin_svg.appth'::text), 'zone', 'UBa', '', '', 'UBa', '213,150,19', '0,0,0', '', '1', '', '', '', '', '', '-1', '', '', 29);
INSERT INTO col_theme VALUES (currval('admin_svg.appth'::text), 'zone', 'UBb', '', '', 'UBb', '219,111,13', '0,0,0', '', '1', '', '', '', '', '', '-1', '', '', 30);
INSERT INTO col_theme VALUES (currval('admin_svg.appth'::text), 'zone', 'UCa', '', '', 'UCa', '238,250,12', '0,0,0', '', '1', '', '', '', '', '', '-1', '', '', 31);
INSERT INTO col_theme VALUES (currval('admin_svg.appth'::text), 'zone', 'UCb', '', '', 'UCb', '251,254,129', '0,0,0', '', '1', '', '', '', '', '', '-1', '', '', 32);
INSERT INTO col_theme VALUES (currval('admin_svg.appth'::text), 'zone', 'UD', '', '', 'UD', '219,194,53', '0,0,0', '', '1', '', '', '', '', '', '-1', '', '', 33);
INSERT INTO col_theme VALUES (currval('admin_svg.appth'::text), 'zone', 'UFa', '', '', 'UFa', '214,101,171', '0,0,0', '', '1', '', '', '', '', '', '-1', '', '', 34);
INSERT INTO col_theme VALUES (currval('admin_svg.appth'::text), 'zone', 'UFb', '', '', 'UFb', '224,141,193', '0,0,0', '', '1', '', '', '', '', '', '-1', '', '', 35);
INSERT INTO col_theme VALUES (currval('admin_svg.appth'::text), 'zone', 'UG', '', '', 'UG', '62,121,221', '0,0,0', '', '1', '', '', '', '', '', '-1', '', '', 36);
INSERT INTO col_theme VALUES (currval('admin_svg.appth'::text), 'zone', 'UGa', '', '', 'UGa', '111,155,230', '0,0,0', '', '1', '', '', '', '', '', '-1', '', '', 37);
INSERT INTO col_theme VALUES (currval('admin_svg.appth'::text), 'zone', 'UGb', '', '', 'UGb', '154,185,237', '0,0,0', '', '1', '', '', '', '', '', '-1', '', '', 38);
INSERT INTO col_theme VALUES (currval('admin_svg.appth'::text), 'zone', 'UL', '', '', 'UL', '115,249,121', '0,0,0', '', '1', '', '', '', '', '', '-1', '', '', 39);
INSERT INTO col_theme VALUES (currval('admin_svg.appth'::text), 'zone', 'UV', '', '', 'UV', '251,170,239', '0,0,0', '', '1', '', '', '', '', '', '-1', '', '', 40);
INSERT INTO col_theme VALUES (currval('admin_svg.appth'::text), 'zone', 'UVa', '', '', 'UVa', '165,0,165', '0,0,0', '', '1', '', '', '', '', '', '-1', '', '', 41);
INSERT INTO col_theme VALUES (currval('admin_svg.appth'::text), 'zone', 'UXa', '', '', 'UXa', '170,6,183', '0,0,0', '', '1', '', '', '', '', '', '-1', '', '', 42);
INSERT INTO col_theme VALUES (currval('admin_svg.appth'::text), 'zone', 'UXb', '', '', 'UXb', '236,207,239', '0,0,0', '', '1', '', '', '', '', '', '-1', '', '', 43);
INSERT INTO col_theme VALUES (currval('admin_svg.appth'::text), 'zone', 'UXc', '', '', 'UXc', '209,138,217', '0,0,0', '', '1', '', '', '', '', '', '-1', '', '', 44);
INSERT INTO col_theme VALUES (currval('admin_svg.appth'::text), 'zone', 'UY', '', '', 'UY', '255,127,127', '0,0,0', '', '1', '', '', '', '', '', '-1', '', '', 45);
INSERT INTO col_theme VALUES (currval('admin_svg.appth'::text), 'zone', 'UZa', '', '', 'UZa', '182,203,209', '0,0,0', '', '1', '', '', '', '', '', '-1', '', '', 46);
INSERT INTO col_theme VALUES (currval('admin_svg.appth'::text), 'zone', 'UZb', '', '', 'UZb', '182,203,209', '0,0,0', '', '1', '', '', '', '', '', '-1', '', '', 47);
INSERT INTO theme (libelle_them, schema, tabl, raster, partiel, vu_initial, couch_tjs_visible, zoommin, zoommax, zoommax_raster, vu_anonyme, force_chargement) VALUES ('Zone Boise', 'geotest', 'zoneboise', '', '', '', '', 600, 10000, '0', false, '0');
INSERT INTO col_sel VALUES (currval('admin_svg.them'::text), 'the_geom', 'geom', '1');
INSERT INTO style VALUES (nextval('admin_svg.styl'::text), currval('admin_svg.them'::text), NULL, '0,128,0', '0,128,0', '', '1', '', '', '', '', '', '-1', '', '');
INSERT INTO appthe (idapplication, idtheme, mouseover, click, mouseout, ordre, sordre, ordre_couche, pointer_events, raster, zoommin, zoommax, zoommaxraster, objselection, objprincipal, objrecherche, partiel, vu_initial,force_chargement) VALUES (currval('admin_svg.appli'::text), currval('admin_svg.them'::text), '', '', '', 5, 0, 0, '', false, NULL, NULL, NULL, false, false, false, '0', '0', '0');
INSERT INTO theme (libelle_them, schema, tabl, raster, partiel, vu_initial, couch_tjs_visible, zoommin, zoommax, zoommax_raster, vu_anonyme, force_chargement) VALUES ('Site inscrit', 'geotest', 'siteinscrit', '', '', '', '', 600, 10000, '0', false, '0');
INSERT INTO col_sel VALUES (currval('admin_svg.them'::text), 'the_geom', 'geom', '1');
INSERT INTO style VALUES (nextval('admin_svg.styl'::text), currval('admin_svg.them'::text), NULL, '217,95,231', '217,95,231', '', '1', '', '', '', '', '', '-1', '', '');
INSERT INTO appthe (idapplication, idtheme, mouseover, click, mouseout, ordre, sordre, ordre_couche, pointer_events, raster, zoommin, zoommax, zoommaxraster, objselection, objprincipal, objrecherche, partiel, vu_initial,force_chargement) VALUES (currval('admin_svg.appli'::text), currval('admin_svg.them'::text), '', '', '', 10, 0, 0, '', false, NULL, NULL, NULL, false, false, false, '0', '0', '0')
INSERT INTO theme (libelle_them, schema, tabl, raster, partiel, vu_initial, couch_tjs_visible, zoommin, zoommax, zoommax_raster, vu_anonyme, force_chargement) VALUES ('Radio electrique', 'geotest', 'servradioelectrik', '', '', '', '', 600, 10000, '0', false, '0');
INSERT INTO col_sel VALUES (currval('admin_svg.them'::text), 'the_geom', 'geom', '1');
INSERT INTO style VALUES (nextval('admin_svg.styl'::text), currval('admin_svg.them'::text), NULL, '83,131,242', '83,131,242', '', '1', '', '', '', '', '', '-1', '', '');
INSERT INTO appthe (idapplication, idtheme, mouseover, click, mouseout, ordre, sordre, ordre_couche, pointer_events, raster, zoommin, zoommax, zoommaxraster, objselection, objprincipal, objrecherche, partiel, vu_initial,force_chargement) VALUES (currval('admin_svg.appli'::text), currval('admin_svg.them'::text), '', '', '', 15, 0, 0, '', false, NULL, NULL, NULL, false, false, false, '0', '0', '0');
INSERT INTO theme (libelle_them, schema, tabl, raster, partiel, vu_initial, couch_tjs_visible, zoommin, zoommax, zoommax_raster, vu_anonyme, force_chargement) VALUES ('Zone non-aedificandi', 'geotest', 'zononaedificandi', '', '', '', '', 600, 10000, '0', false, '0');
INSERT INTO col_sel VALUES (currval('admin_svg.them'::text), 'the_geom', 'geom', '1');
INSERT INTO style VALUES (nextval('admin_svg.styl'::text), currval('admin_svg.them'::text), NULL, '128,0,128', '128,0,128', '', '1', '', '', '', '', '', '-1', '', '');
INSERT INTO appthe (idapplication, idtheme, mouseover, click, mouseout, ordre, sordre, ordre_couche, pointer_events, raster, zoommin, zoommax, zoommaxraster, objselection, objprincipal, objrecherche, partiel, vu_initial,force_chargement) VALUES (currval('admin_svg.appli'::text), currval('admin_svg.them'::text), '', '', '', 16, 0, 0, '', false, NULL, NULL, NULL, false, false, false);
INSERT INTO theme (libelle_them, schema, tabl, raster, partiel, vu_initial, couch_tjs_visible, zoommin, zoommax, zoommax_raster, vu_anonyme, force_chargement) VALUES ('Chemin de halage', 'geotest', 'halage', '', '', '', '', 600, 10000, '0', false, '0');
INSERT INTO col_sel VALUES (currval('admin_svg.them'::text), 'the_geom', 'geom', '1');
INSERT INTO style VALUES (nextval('admin_svg.styl'::text), currval('admin_svg.them'::text), NULL, '126,238,111', '126,238,111', '', '1', '', '', '', '', '', '-1', '', '');
INSERT INTO appthe (idapplication, idtheme, mouseover, click, mouseout, ordre, sordre, ordre_couche, pointer_events, raster, zoommin, zoommax, zoommaxraster, objselection, objprincipal, objrecherche, partiel, vu_initial,force_chargement) VALUES (currval('admin_svg.appli'::text), currval('admin_svg.them'::text), '', '', '', 17, 0, 0, '', false, NULL, NULL, NULL, false, false, false, '0', '0', '0');


SET search_path = geotest, pg_catalog;

CREATE TABLE alignement (
    gid serial NOT NULL,
    date_ali text,
    code_insee character varying);
ALTER TABLE geotest.alignement OWNER TO sig;
COMMENT ON COLUMN alignement.date_ali IS 'format jj/mm/yyyy';
ALTER TABLE ONLY alignement
ADD CONSTRAINT alignement_pkey PRIMARY KEY (gid);
ALTER INDEX geotest.alignement_pkey OWNER TO ".$DB->db_user.";
select addgeometrycolumn('geotest','alignement','the_geom',".$_POST['projection'].",'MULTILINESTRING',2);


CREATE TABLE cimetiere (
    gid serial NOT NULL,
    code_insee character varying);
ALTER TABLE geotest.cimetiere OWNER TO sig;
ALTER TABLE ONLY cimetiere
    ADD CONSTRAINT cimetiere_pkey PRIMARY KEY (gid);
ALTER INDEX geotest.cimetiere_pkey OWNER TO ".$DB->db_user.";
select addgeometrycolumn('geotest','cimetiere','the_geom',".$_POST['projection'].",'MULTIPOLYGON',2);


CREATE TABLE emplreserve (
    gid serial NOT NULL,
    desc character varying,
    code_insee character varying);
ALTER TABLE geotest.emplreserve OWNER TO sig;
COMMENT ON COLUMN emplreserve.desc IS 'description';
ALTER TABLE ONLY emplreserve
ADD CONSTRAINT emplreserve_pkey PRIMARY KEY (gid);
ALTER INDEX geotest.emplreserve_pkey OWNER TO ".$DB->db_user.";
select addgeometrycolumn('geotest','emplreserve','the_geom',".$_POST['projection'].",'MULTIPOLYGON',2);


CREATE TABLE halage (
    gid serial NOT NULL,
    code_insee character varying);
ALTER TABLE geotest.halage OWNER TO sig;
ALTER TABLE ONLY halage
ADD CONSTRAINT halage_pkey PRIMARY KEY (gid);
ALTER INDEX geotest.halage_pkey OWNER TO ".$DB->db_user.";
select addgeometrycolumn('geotest','halage','the_geom',".$_POST['projection'].",'MULTILINESTRING',2);


CREATE TABLE ht_fuseau (
    id_fuseau serial NOT NULL,
    gid1 integer,
    gid2 integer,
    distance real,
    hauteur real,
    code_insee character varying
);
ALTER TABLE geotest.ht_fuseau OWNER TO ".$DB->db_user.";
COMMENT ON COLUMN ht_fuseau.gid1 IS 'point de depart';
COMMENT ON COLUMN ht_fuseau.gid2 IS 'point de fin';


CREATE TABLE ht_ligne (
    id_ligne serial NOT NULL,
    libelle character varying
);
ALTER TABLE geotest.ht_ligne OWNER TO ".$DB->db_user.";



CREATE TABLE ht_pylone (
    id_ligne integer DEFAULT 1,
    gid serial NOT NULL,
    type character varying DEFAULT 'pylone'::character varying,
    precision real DEFAULT 5
);
ALTER TABLE geotest.ht_pylone OWNER TO ".$DB->db_user.";
select addgeometrycolumn('geotest','ht_pylone','the_geom',".$_POST['projection'].",'POINT',2);


CREATE TABLE lisiere (
    gid serial NOT NULL,
    code_insee character varying);
ALTER TABLE geotest.lisiere OWNER TO ".$DB->db_user.";
ALTER TABLE ONLY lisiere
ADD CONSTRAINT lisiere_pkey PRIMARY KEY (gid);
ALTER INDEX geotest.lisiere_pkey OWNER ".$DB->db_user.";
select addgeometrycolumn('geotest','lisiere','the_geom',".$_POST['projection'].",'MULTIPOLYGON',2);


CREATE TABLE lotissement (
    gid serial NOT NULL,
    nom character varying,
    date character varying,
    numarrete character varying,
    code_insee character varying);
ALTER TABLE geotest.lotissement OWNER TO ".$DB->db_user.";
COMMENT ON COLUMN lotissement.nom IS 'nom du lotissement';
COMMENT ON COLUMN lotissement.date IS 'format jj/mm/yyyy';
COMMENT ON COLUMN lotissement.numarrete IS 'numero arrete';
ALTER TABLE ONLY lotissement
    ADD CONSTRAINT lotissement_pkey PRIMARY KEY (gid);
ALTER INDEX geotest.lotissement_pkey OWNER TO ".$DB->db_user.";
select addgeometrycolumn('geotest','lotissement','the_geom',".$_POST['projection'].",'MULTIPOLYGON',2);


CREATE TABLE ppmh (
    gid serial NOT NULL,
    code_insee character varying);
ALTER TABLE geotest.ppmh OWNER TO ".$DB->db_user.";
ALTER TABLE ONLY ppmh
ADD CONSTRAINT ppmh_pkey PRIMARY KEY (gid);
ALTER INDEX geotest.ppmh_pkey OWNER TO ".$DB->db_user.";
select addgeometrycolumn('geotest','ppmh','the_geom',".$_POST['projection'].",'MULTIPOLYGON',2);


CREATE TABLE ppri (
    gid serial NOT NULL,
    ppri_id integer,
    code_insee character varying);
ALTER TABLE geotest.ppri OWNER TO ".$DB->db_user.";
ALTER TABLE ONLY ppri
ADD CONSTRAINT ppri_pkey PRIMARY KEY (gid);
ALTER INDEX geotest.ppri_pkey OWNER TO ".$DB->db_user.";
select addgeometrycolumn('geotest','ppri','the_geom',".$_POST['projection'].",'MULTIPOLYGON',2);



CREATE TABLE servradioelectrik (
    gid serial NOT NULL,
    code_insee character varying);
ALTER TABLE geotest.servradioelectrik OWNER TO ".$DB->db_user.";
ALTER TABLE ONLY servradioelectrik
    ADD CONSTRAINT servradioelectrik_pkey PRIMARY KEY (gid);
ALTER INDEX geotest.servradioelectrik_pkey OWNER TO ".$DB->db_user.";
select addgeometrycolumn('geotest','servradioelectrik','the_geom',".$_POST['projection'].",'MULTIPOLYGON',2);



CREATE TABLE sidobre (
    gid serial NOT NULL,
   code_insee character varying);
ALTER TABLE geotest.sidobre OWNER TO ".$DB->db_user.";
ALTER TABLE ONLY sidobre
ADD CONSTRAINT sidobre_pkey PRIMARY KEY (gid);
ALTER INDEX geotest.sidobre_pkey OWNER TO ".$DB->db_user.";
select addgeometrycolumn('geotest','sidobre','the_geom',".$_POST['projection'].",'MULTIPOLYGON',2);


CREATE TABLE siteinscrit (
    gid serial NOT NULL,
    code_insee character varying);
ALTER TABLE geotest.siteinscrit OWNER TO ".$DB->db_user.";
ALTER TABLE ONLY siteinscrit
    ADD CONSTRAINT siteinscrit_pkey PRIMARY KEY (gid);
ALTER INDEX geotest.siteinscrit_pkey OWNER TO ".$DB->db_user.";
select addgeometrycolumn('geotest','siteinscrit','the_geom',".$_POST['projection'].",'MULTIPOLYGON',2);



CREATE TABLE z_archeo (
    gid serial NOT NULL,
    code bigint,
    code_insee character varying,
    nom character varying);
ALTER TABLE geotest.z_archeo OWNER TO ".$DB->db_user.";
COMMENT ON COLUMN z_archeo.code IS 'code zone';
COMMENT ON COLUMN z_archeo.nom IS 'niveau archeo';
ALTER TABLE ONLY z_archeo
    ADD CONSTRAINT z_archeo_pkey PRIMARY KEY (gid);
ALTER INDEX geotest.z_archeo_pkey OWNER TO ".$DB->db_user.";
select addgeometrycolumn('geotest','z_archeo','the_geom',".$_POST['projection'].",'MULTIPOLYGON',2);



CREATE TABLE zac (
    gid serial NOT NULL,
    code_insee character varying);
ALTER TABLE geotest.zac OWNER TO ".$DB->db_user.";
ALTER TABLE ONLY zac
    ADD CONSTRAINT zac_pkey PRIMARY KEY (gid);
ALTER INDEX geotest.zac_pkey OWNER TO ".$DB->db_user.";
select addgeometrycolumn('geotest','zac','the_geom',".$_POST['projection'].",'MULTIPOLYGON',2);



CREATE TABLE zonage (
    gid serial NOT NULL,
    zone character varying,
    code_insee character varying);
ALTER TABLE geotest.zonage OWNER TO ".$DB->db_user.";
COMMENT ON COLUMN zonage.zone IS 'reference zone';
select addgeometrycolumn('geotest','zonage','the_geom',".$_POST['projection'].",'MULTIPOLYGON',2);




CREATE TABLE zoneboise (
    gid serial NOT NULL,
    code_insee character varying);
ALTER TABLE geotest.zoneboise OWNER TO ".$DB->db_user.";
ALTER TABLE ONLY zoneboise
    ADD CONSTRAINT zoneboise_pkey PRIMARY KEY (gid);
ALTER INDEX geotest.zoneboise_pkey OWNER TO ".$DB->db_user.";
select addgeometrycolumn('geotest','zoneboise','the_geom',".$_POST['projection'].",'MULTIPOLYGON',2);



CREATE TABLE zonebruit (
    gid serial NOT NULL,
    type character varying,
    code_insee character varying);
ALTER TABLE geotest.zonebruit OWNER TO ".$DB->db_user.";
COMMENT ON COLUMN zonebruit.type IS 'type zone de bruit';
ALTER TABLE ONLY zonebruit
    ADD CONSTRAINT zonebruit_pkey PRIMARY KEY (gid);
ALTER INDEX geotest.zonebruit_pkey OWNER TO ".$DB->db_user.";
select addgeometrycolumn('geotest','zonebruit','the_geom',".$_POST['projection'].",'MULTIPOLYGON',2);




CREATE TABLE zoneinondable (
    gid serial NOT NULL,
    zone character varying,
    code_insee character varying);
ALTER TABLE geotest.zoneinondable OWNER TO ".$DB->db_user.";
COMMENT ON COLUMN zoneinondable.zone IS 'reference zone';
ALTER TABLE ONLY zoneinondable
    ADD CONSTRAINT zoneinondable_pkey PRIMARY KEY (gid);
ALTER INDEX geotest.zoneinondable_pkey OWNER TO ".$DB->db_user.";
select addgeometrycolumn('geotest','zoneinondable','the_geom',".$_POST['projection'].",'MULTIPOLYGON',2);



CREATE TABLE zononaedificandi (
    gid serial NOT NULL,
   code_insee character varying);
ALTER TABLE geotest.zononaedificandi OWNER TO ".$DB->db_user.";
ALTER TABLE ONLY zononaedificandi
    ADD CONSTRAINT zononaedificandi_pkey PRIMARY KEY (gid);
ALTER INDEX geotest.zononaedificandi_pkey OWNER TO ".$DB->db_user.";
select addgeometrycolumn('geotest','zononaedificandi','the_geom',".$_POST['projection'].",'MULTIPOLYGON',2);



CREATE VIEW ligne_ht AS SELECT ht_fuseau.id_fuseau AS gid, buffer(makeline((( SELECT astext(ht_pylone.the_geom) AS astext FROM ht_pylone WHERE ht_pylone.gid = ht_fuseau.gid1))::geometry, (( SELECT astext(ht_pylone.the_geom) AS astext FROM ht_pylone WHERE ht_pylone.gid = ht_fuseau.gid2))::geometry), (ht_fuseau.distance + (( SELECT max(ht_pylone.precision) AS max FROM ht_pylone WHERE ht_pylone.gid = ht_fuseau.gid1 OR ht_pylone.gid = ht_fuseau.gid2)))::double precision) AS the_geom,ht_fuseau.code_insee FROM ht_fuseau;



";
$DB->exec($ru);
}
if(ereg ("espVerts",$_POST['a_instal']))
{
$espverts="
SET search_path = admin_svg, pg_catalog;
INSERT INTO application (libelle_appli, btn_polygo, libelle_btn_polygo, divers, zoom_ouverture, zoom_min, zoom_max, url, type_appli) VALUES ('espVerts', '/apps/esp_vert/ins.php', 'Insertion', '', 600, 100, 10000, 'interface/carto.php', '0');
INSERT INTO apputi VALUES (currval('admin_svg.appli'::text), '1', 'a', NULL, NULL, (select max(ordre)+1 from admin_svg.apputi where idutilisateur=1));
INSERT INTO appthe (idapplication, idtheme, mouseover, click, mouseout, ordre, sordre, ordre_couche, pointer_events, raster, zoommin, zoommax, zoommaxraster, objselection, objprincipal, objrecherche, partiel, vu_initial,force_chargement) VALUES (currval('admin_svg.appli'::text), '1', '', '', '', 2, 0, 0, '', true, 200, 10000, 1200, false, false, false, '1', '0', '0');
INSERT INTO col_theme VALUES (currval('admin_svg.appth'::text), 'constructi', 'Bati leger', '', '', 'Bati leger', '221,174,205', 'none', '', '1', '', '', '', '', '', '-1', '', '', 2);
INSERT INTO col_theme VALUES (currval('admin_svg.appth'::text), 'constructi', 'Bati dur', '', '', 'Bati dur', '184,84,149', 'none', '', '1', '', '', '', '', '', '-1', '', '', 1);

INSERT INTO appthe (idapplication, idtheme, mouseover, click, mouseout, ordre, sordre, ordre_couche, pointer_events, raster, zoommin, zoommax, zoommaxraster, objselection, objprincipal, objrecherche, partiel, vu_initial,force_chargement) VALUES (currval('admin_svg.appli'::text), '2', '', '', '', 1, 0, 0, '', true, 200, 10000, 600, false, true, true, '1', '1', '0');

INSERT INTO theme (libelle_them, schema, tabl, raster, partiel, vu_initial, couch_tjs_visible, zoommin, zoommax, zoommax_raster, vu_anonyme, force_chargement) VALUES ('Secteur', 'esvert', 'sector', '', '1', '1', '', 600, 10000, '0', false, '1');
INSERT INTO col_sel VALUES (currval('admin_svg.them'::text), 'libel', 'ad', '');
INSERT INTO col_sel VALUES (currval('admin_svg.them'::text), 'gid', 'ident', '');
INSERT INTO col_sel VALUES (currval('admin_svg.them'::text), 'the_geom', 'geom', '');
INSERT INTO style VALUES (nextval('admin_svg.styl'::text), currval('admin_svg.them'::text), NULL, '0,188,0', '0,0,0', '1', '', '', '', '', '', '0.2', '', '', '');
INSERT INTO appthe (idapplication, idtheme, mouseover, click, mouseout, ordre, sordre, ordre_couche, pointer_events, raster, zoommin, zoommax, zoommaxraster, objselection, objprincipal, objrecherche, partiel, vu_initial,force_chargement) VALUES (currval('admin_svg.appli'::text), currval('admin_svg.them'::text), 'sur(evt,'rgb(172,165,232)')', 'lien(evt,'secteur','https://'+serveur+'/apps/esp_vert/secteur.php?obj_keys=','','')', 'hors(evt)', 4, 0, 0, 'visible', true, 600, 10000, 0, false, false, false, '0', '1', '1');
INSERT INTO theme (libelle_them, schema, tabl, raster, partiel, vu_initial, couch_tjs_visible, zoommin, zoommax, zoommax_raster, vu_anonyme, force_chargement) VALUES ('Pelouse', 'esvert', 'pelouse', '', '1', '', '', 600, 10000,'10000', false, '1');
INSERT INTO col_sel VALUES (currval('admin_svg.them'::text), 'gid', 'ident', '');
INSERT INTO col_sel VALUES (currval('admin_svg.them'::text), 'the_geom', 'geom', '');
INSERT INTO style VALUES (nextval('admin_svg.styl'::text), currval('admin_svg.them'::text), NULL, '0,226,0', '0,0,0', '1', '', '', '', '', '', '0.47', '', '', '');
INSERT INTO appthe (idapplication, idtheme, mouseover, click, mouseout, ordre, sordre, ordre_couche, pointer_events, raster, zoommin, zoommax, zoommaxraster, objselection, objprincipal, objrecherche, partiel, vu_initial,force_chargement) VALUES (currval('admin_svg.appli'::text), currval('admin_svg.them'::text), '', '', '', 3, 0, 0, 'none', true, 600, 10000, 0, false, false, false, '1', '0', '0');
INSERT INTO theme (libelle_them, schema, tabl, raster, partiel, vu_initial, couch_tjs_visible, zoommin, zoommax, zoommax_raster, vu_anonyme, force_chargement) VALUES ('Arbre', 'esvert', 'arbre', '', '1', '', '', 100, 10000,'100', false, '0');
INSERT INTO col_sel VALUES (currval('admin_svg.them'::text), 'geopt', 'geom', '');
INSERT INTO style VALUES (nextval('admin_svg.styl'::text), currval('admin_svg.them'::text), NULL, '0,255,0', '', '', '', '10', '', 'I', 'I', '1', '', '', '');
create schema esvert;
CREATE TABLE esvert.arbre
(
  arrosage character varying(1),
  contrainte character varying(10),
  date_pose date,
  date_sup date,
  diam double precision,
  diam_houp double precision,
  etat character varying(1),
  hauteur double precision,
  ht_houp double precision,
  lab_x double precision,
  lab_y double precision,
  ll_x double precision,
  ll_y double precision,
  num_arbre character varying(10) NOT NULL,
  num_espece character varying(4),
  num_fou character varying(3),
  num_obj character varying(6),
  num_s_secteur character varying(3),
  obs character varying(255),
  protection character varying(10),
  rot_lab double precision,
  structure character varying(1),
  typ_taille character varying(1),
  x double precision,
  y double precision);
ALTER TABLE esvert.arbre OWNER TO ".$DB->db_user.";
select addgeometrycolumn('esvert','arbre','geopt',".$_POST['projection'].",'POINT',2);
select addgeometrycolumn('esvert','arbre','labpt',-1,'POINT',2);

CREATE TABLE esvert.sector
(
  gid serial NOT NULL,
  libel character varying(254),
  code_insee character varying,
  creepar character varying(25),
  creele date);
ALTER TABLE esvert.sector OWNER TO ".$DB->db_user.";
select addgeometrycolumn('esvert','sector','the_geom',".$_POST['projection'].",'MULTIPOLYGON',2);

CREATE TABLE esvert.pelouse
(
  gid serial NOT NULL,
  tonte character varying(10),
  arrosage character varying(10),
  contrainte character varying(254),
  creele date,
  creepar character varying(25),
  code_insee character varying(6));
ALTER TABLE esvert.pelouse OWNER TO ".$DB->db_user.";
select addgeometrycolumn('esvert','pelouse','the_geom',".$_POST['projection'].",'MULTIPOLYGON',2);

CREATE TABLE esvert.fleurie
(
  gid serial NOT NULL,
  etat character varying(1),
  date_pose date,
  date_sup date,
  arrosage character varying(1),
  type_plant character varying(1),
  creele date,
  creepar character varying(25),
  code_insee character varying(6));
ALTER TABLE esvert.fleurie OWNER TO ".$DB->db_user.";
select addgeometrycolumn('esvert','fleurie','the_geom',".$_POST['projection'].",'MULTIPOLYGON',2);

";
$DB->exec($espverts);
}
if(ereg ("Prg Immobilier",$_POST['a_instal']))
{
$prg_immo="
SET search_path = admin_svg, pg_catalog;
INSERT INTO application (libelle_appli, btn_polygo, libelle_btn_polygo, divers, zoom_ouverture, zoom_min, zoom_max, url, type_appli) VALUES ('Prg_Immobilier', '/apps/prg_immo/program_immo.php', 'Créer un programme immobilier', '', 600, 100, 4800, 'interface/carto.php', '0');
INSERT INTO apputi VALUES (currval('admin_svg.appli'::text), '1', 'a', NULL, NULL, (select max(ordre)+1 from admin_svg.apputi where idutilisateur=1));
INSERT INTO appthe (idapplication, idtheme, mouseover, click, mouseout, ordre, sordre, ordre_couche, pointer_events, raster, zoommin, zoommax, zoommaxraster, objselection, objprincipal, objrecherche, partiel, vu_initial,force_chargement) VALUES (currval('admin_svg.appli'::text), '1', '', '', '', 2, 0, 0, '', true, 100, 10000, 1200, false, false, false, '1', '0', '0');
INSERT INTO col_theme VALUES (currval('admin_svg.appth'::text), 'constructi', 'Bati leger', '', '', 'Bati leger', '221,174,205', 'none', '', '1', '', '', '', '', '', '-1', '', '', 2);
INSERT INTO col_theme VALUES (currval('admin_svg.appth'::text), 'constructi', 'Bati dur', '', '', 'Bati dur', '184,84,149', 'none', '', '1', '', '', '', '', '', '-1', '', '', 1);

INSERT INTO appthe (idapplication, idtheme, mouseover, click, mouseout, ordre, sordre, ordre_couche, pointer_events, raster, zoommin, zoommax, zoommaxraster, objselection, objprincipal, objrecherche, partiel, vu_initial,force_chargement) VALUES (currval('admin_svg.appli'::text), '2', '', '', '', 1, 0, 0, '', true, 100, 10000, 600, false, true, false, '1', '1', '0');

INSERT INTO theme (libelle_them, schema, tabl, raster, partiel, vu_initial, couch_tjs_visible, zoommin, zoommax, zoommax_raster, vu_anonyme, force_chargement) VALUES ('Prg Immobilier', 'urba', 'program', '', '1', '0', '', 200, 10000, '0', false, '1');
INSERT INTO col_sel VALUES (currval('admin_svg.them'::text), 'test.chg_car_spx('Programme:'||nom||' $ ')', 'ad', '');
INSERT INTO col_sel VALUES (currval('admin_svg.them'::text), 'gid', 'ident', '');
INSERT INTO col_sel VALUES (currval('admin_svg.them'::text), 'the_geom', 'geom', '');
INSERT INTO col_theme VALUES (currval('admin_svg.appth'::text), 'typ_lgt', 'Collectif', '', '', 'C', '255,111,0', '0,0,0', '1', '', '', '', '', '', '1', '', '', '', 1);
INSERT INTO col_theme VALUES (currval('admin_svg.appth'::text), 'typ_lgt', 'Individuel', '', '', 'I', '255,255,0', '0,0,0', '1', '', '', '', '', '', '1', '', '', '', 2);
INSERT INTO col_theme VALUES (currval('admin_svg.appth'::text), 'typ_lgt', 'Mixte', '', '', 'M', '255,182,0', '0,0,0', '1', '', '', '', '', '', '1', '', '', '', 3);
INSERT INTO appthe (idapplication, idtheme, mouseover, click, mouseout, ordre, sordre, ordre_couche, pointer_events, raster, zoommin, zoommax, zoommaxraster, objselection, objprincipal, objrecherche, partiel, vu_initial,force_chargement) VALUES (currval('admin_svg.appli'::text), currval('admin_svg.them'::text), 'sur(evt,'red')', 'lien(evt,'program','https://'+serveur+'/apps/prg_immo/program_immo.php?obj_keys=','','')', 'hors(evt)', 3, 0, 0, 'visible', false, 200, 10000, 200, false, false, false, '1', '0', '1');
INSERT INTO theme (libelle_them, schema, tabl, raster, partiel, vu_initial, couch_tjs_visible, zoommin, zoommax, zoommax_raster, vu_anonyme, force_chargement) VALUES ('Quartier', 'general', 'quartier', '', '', '', '', 100, 10000, '10000', false, '0');
INSERT INTO col_sel VALUES (currval('admin_svg.them'::text), 'nom', 'ad', '');
INSERT INTO col_sel VALUES (currval('admin_svg.them'::text), 'gid', 'ident', '');
INSERT INTO col_sel VALUES (currval('admin_svg.them'::text), 'the_geom', 'geom', '');
INSERT INTO style VALUES (nextval('admin_svg.styl'::text), currval('admin_svg.them'::text), NULL, '0,188,0', '0,0,0', '1', '', '', '', '', '', '0.5', '', '', '');
INSERT INTO appthe (idapplication, idtheme, mouseover, click, mouseout, ordre, sordre, ordre_couche, pointer_events, raster, zoommin, zoommax, zoommaxraster, objselection, objprincipal, objrecherche, partiel, vu_initial,force_chargement) VALUES (currval('admin_svg.appli'::text), currval('admin_svg.them'::text), 'sur(evt,'red')', 'lien(evt,'ccq','https://'+serveur+'/apps/prg_immo/requete_ccq.php?obj_keys=','m','5')', 'hors(evt)', 4, 0, 0, 'visible', false, 200, 10000, 200, false, false, false, '0', '0', '1');
INSERT INTO appthe (idapplication, idtheme, mouseover, click, mouseout, ordre, sordre, ordre_couche, pointer_events, raster, zoommin, zoommax, zoommaxraster, objselection, objprincipal, objrecherche, partiel, vu_initial,force_chargement) VALUES (currval('admin_svg.appli'::text), '4', '', '', '', 5, 0, 0, '', true, 200, 10000, 50000, true, false, false, '0', '0', '0');
INSERT INTO appthe (idapplication, idtheme, mouseover, click, mouseout, ordre, sordre, ordre_couche, pointer_events, raster, zoommin, zoommax, zoommaxraster, objselection, objprincipal, objrecherche, partiel, vu_initial,force_chargement) VALUES (currval('admin_svg.appli'::text), '5', '', '', '', 6, 0, 0, '', true, 200, 10000, 50000, true, false, false, '0', '0', '0');
INSERT INTO theme (libelle_them, schema, tabl, raster, partiel, vu_initial, couch_tjs_visible, zoommin, zoommax, zoommax_raster, vu_anonyme, force_chargement) VALUES ('Num Prg_Immobilier', 'urba', 'program', '', '', '', '', 100, 10000, '50000', false, '0');
INSERT INTO col_sel VALUES (currval('admin_svg.them'::text), 'num', 'ad', '');
INSERT INTO col_sel VALUES (currval('admin_svg.them'::text), 'gid', 'ident', '');
INSERT INTO col_sel VALUES (currval('admin_svg.them'::text), 'centroid(the_geom)', 'geom', '');
INSERT INTO style VALUES (nextval('admin_svg.styl'::text), currval('admin_svg.them'::text), NULL, '0,0,0', '0,0,0', '', 'arial', '12', '', '', '', '1', '', '', '');
INSERT INTO appthe (idapplication, idtheme, mouseover, click, mouseout, ordre, sordre, ordre_couche, pointer_events, raster, zoommin, zoommax, zoommaxraster, objselection, objprincipal, objrecherche, partiel, vu_initial,force_chargement) VALUES (currval('admin_svg.appli'::text), currval('admin_svg.them'::text), '', '', '', 7, 0, 0, '', true, 200, 10000, 50000, true, false, false, '1', '0', '0');

CREATE TABLE urba.program
(
  gid serial NOT NULL,
  num bigint,
  nom character varying,
  nbre_lgt bigint,
  typ_lgt character varying,
  nbre_ind bigint,
  nbre_coll bigint,
  annee bigint,
  code_insee character varying(6),
  pc character varying,
  commentaire text,
  nbre_logt_demol integer,
  num_pd character varying,
  date_demol date,
  date_livraison date,
  logt_sociaux integer,
  mpc character varying(1) DEFAULT 0,
  mpd character varying(1) DEFAULT 0,
  pct text[],
  pdt text[]);

ALTER TABLE urba.program OWNER TO ".$DB->db_user.";
select addgeometrycolumn('urba','program','the_geom',".$_POST['projection'].",'MULTIPOLYGON',2);
CREATE TABLE general.quartier
(
  gid serial NOT NULL ,
  nom character varying(254),
  code_insee character varying(6));
ALTER TABLE general.ccq OWNER TO ".$DB->db_user.";
select addgeometrycolumn('general','quartier','the_geom',".$_POST['projection'].",'MULTIPOLYGON',2);
";
$DB->exec($prg_immo);
}
if(ereg ("Ravalement",$_POST['a_instal']))
{
$raval="
SET search_path = admin_svg, pg_catalog;
INSERT INTO application (libelle_appli, btn_polygo, libelle_btn_polygo, divers, zoom_ouverture, zoom_min, zoom_max, url, type_appli) VALUES ('Ravalement', '/apps/ravalement/creation.php', 'Sélection du batiment', '', 600, 100, 10000, 'interface/carto.php', '0');
INSERT INTO apputi VALUES (currval('admin_svg.appli'::text), '1', 'a', NULL, NULL, (select max(ordre)+1 from admin_svg.apputi where idutilisateur=1));
INSERT INTO appthe (idapplication, idtheme, mouseover, click, mouseout, ordre, sordre, ordre_couche, pointer_events, raster, zoommin, zoommax, zoommaxraster, objselection, objprincipal, objrecherche, partiel, vu_initial,force_chargement) VALUES (currval('admin_svg.appli'::text), '1', '', '', '', 2, 0, 0, 'none', true, 100, 10000, 600, false, false, false, '1', '0', '0');
INSERT INTO col_theme VALUES (currval('admin_svg.appth'::text), 'constructi', 'Bati leger', '', '', 'Bati leger', '221,174,205', 'none', '', '1', '', '', '', '', '', '-1', '', '', 2);
INSERT INTO col_theme VALUES (currval('admin_svg.appth'::text), 'constructi', 'Bati dur', '', '', 'Bati dur', '184,84,149', 'none', '', '1', '', '', '', '', '', '-1', '', '', 1);
INSERT INTO appthe (idapplication, idtheme, mouseover, click, mouseout, ordre, sordre, ordre_couche, pointer_events, raster, zoommin, zoommax, zoommaxraster, objselection, objprincipal, objrecherche, partiel, vu_initial,force_chargement) VALUES (currval('admin_svg.appli'::text), '2', '', '', '', 1, 0, 0, 'none', true, 100, 10000, 600, false, true, false, '1', '1', '0');
INSERT INTO theme (libelle_them, schema, tabl, raster, partiel, vu_initial, couch_tjs_visible, zoommin, zoommax, zoommax_raster, vu_anonyme, force_chargement) VALUES ('Etat des facades', 'urba', 'ravalement', '', '', '', '', 100, 10000, '0', false, '1');
INSERT INTO col_sel VALUES (currval('admin_svg.them'::text), 'gid', 'ad', '');
INSERT INTO col_sel VALUES (currval('admin_svg.them'::text), 'gid', 'ident', '');
INSERT INTO col_sel VALUES (currval('admin_svg.them'::text), 'the_geom', 'geom', '');
INSERT INTO col_theme VALUES (currval('admin_svg.appth'::text), 'etat', 'bon etat', '', '', 'a', '0,112,0', 'none', '', '', '', '', '', '', '0.85', '', '', '', 1);
INSERT INTO col_theme VALUES (currval('admin_svg.appth'::text), 'etat', 'etat moyen', '', '', 'b', '255,88,0', 'none', '', '', '', '', '', '', '0.85', '', '', '', 2);
INSERT INTO col_theme VALUES (currval('admin_svg.appth'::text), 'etat', 'mauvais etat', '', '', 'c', '126,64,0', 'none', '', '', '', '', '', '', '0.85', '', '', '', 3);
INSERT INTO appthe (idapplication, idtheme, mouseover, click, mouseout, ordre, sordre, ordre_couche, pointer_events, raster, zoommin, zoommax, zoommaxraster, objselection, objprincipal, objrecherche, partiel, vu_initial,force_chargement) VALUES (currval('admin_svg.appli'::text), currval('admin_svg.them'::text), 'sur(evt,'rgb(85,198,78)')', 'lien(evt,'facade','https://'+serveur+'/apps/ravalement/interro.php?obj_keys=','','')', 'hors(evt)', 3, 0, 0, 'visible', true, 200, 10000, 0, true, false, false, '0', '0', '0');
INSERT INTO theme (libelle_them, schema, tabl, raster, partiel, vu_initial, couch_tjs_visible, zoommin, zoommax, zoommax_raster, vu_anonyme, force_chargement) VALUES ('Facade a surveiller', 'urba', 'ravalement', '', '', '', '', 100, 10000, '0', false, '1');
INSERT INTO col_sel VALUES (currval('admin_svg.them'::text), 'gid', 'ad', '');
INSERT INTO col_sel VALUES (currval('admin_svg.them'::text), 'gid', 'ident', '');
INSERT INTO col_sel VALUES (currval('admin_svg.them'::text), 'the_geom', 'geom', '');
INSERT INTO col_where VALUES (currval('admin_svg.them'::text), 'surveiller='1'');
INSERT INTO style VALUES (nextval('admin_svg.styl'::text), currval('admin_svg.them'::text), NULL, '0,0,255', '0,0,0', '1', '', '', '', '', '', '0.6', '', '', '');
INSERT INTO appthe (idapplication, idtheme, mouseover, click, mouseout, ordre, sordre, ordre_couche, pointer_events, raster, zoommin, zoommax, zoommaxraster, objselection, objprincipal, objrecherche, partiel, vu_initial,force_chargement) VALUES (currval('admin_svg.appli'::text), currval('admin_svg.them'::text), '', '', '', 4, 0, 0, 'none', true, 100, 10000, 0, true, false, false, '0', '0', '0');
INSERT INTO appthe (idapplication, idtheme, mouseover, click, mouseout, ordre, sordre, ordre_couche, pointer_events, raster, zoommin, zoommax, zoommaxraster, objselection, objprincipal, objrecherche, partiel, vu_initial,force_chargement) VALUES (currval('admin_svg.appli'::text), '4', '', '', '', 5, 0, 0, 'none', true, 2000, 10000, 10000, false, false, false, '1', '0', '0');
INSERT INTO appthe (idapplication, idtheme, mouseover, click, mouseout, ordre, sordre, ordre_couche, pointer_events, raster, zoommin, zoommax, zoommaxraster, objselection, objprincipal, objrecherche, partiel, vu_initial,force_chargement) VALUES (currval('admin_svg.appli'::text), '5', '', '', '', 6, 0, 0, 'none', true, 2000, 10000, 10000, false, false, false, '1', '0', '0');

CREATE TABLE urba.ravalement
(
  gid serial NOT NULL,
  etat character varying,
  date character varying,
  observation character varying,
  photo character varying,
  propriet character varying,
  code_insee character varying,
  surveiller character varying,
  annee_dernier_ravalement text,
  date_rav date);
ALTER TABLE geotest.ravalement OWNER TO ".$DB->db_user.";
select addgeometrycolumn('urba','ravalement','the_geom',".$_POST['projection'].",'MULTIPOLYGON',2);

CREATE TABLE urba.photo_ravalement
(
  id_photo serial NOT NULL,
  id_ravalement integer
);
ALTER TABLE geotest.photo_ravalement OWNER TO ".$DB->db_user.";
";
$DB->exec($raval);
}

if(ereg ("Plan geometre",$_POST['a_instal']))
{
echo 'non ok';
}




if($_POST['acces_inter'])
{
echo 'cr&eacute;ation de l&acute;acc&egrave;s invit&eacute;';
if(ereg ("RU",$_POST['app_invite']))
{
echo 'invite associe avec RU\n';
}
if(ereg ("espVerts",$_POST['app_invite']))
{
echo 'invite associe avec espVerts\n';
}
if(ereg ("Prg Immobilier",$_POST['app_invite']))
{
echo 'invite associe avec Prg Immobiler\n';
}
if(ereg ("Ravalement",$_POST['app_invite']))
{
echo 'invite associe avec Ravalement\n';
}

if(ereg ("Plan geometre",$_POST['app_invite']))
{
echo 'invite associe avec Plan geometre\n';
}


}

}
else
{
$test_appli="select application.idapplication,application.libelle_appli from admin_svg.application";
	$mn_test=$DB->tab_result($test_appli);
	if(count($mn_test)==0)
	{
	$defaut_appli="
SET search_path = admin_svg, pg_catalog;
INSERT INTO application (libelle_appli, btn_polygo, libelle_btn_polygo, divers, zoom_ouverture, zoom_min, zoom_max, url, type_appli) VALUES ('cadastre', '', '', '', 600, 200, 8000, 'interface/carto.php', '0');
INSERT INTO apputi VALUES (currval('admin_svg.appli'::text), '1', 'a', NULL, NULL, 1);
INSERT INTO theme (libelle_them, schema, tabl, raster, partiel, vu_initial, couch_tjs_visible, zoommin, zoommax, zoommax_raster, vu_anonyme, force_chargement) VALUES ('batiment', 'cadastre', 'batiment', '', '1', '0', '', 200, 10000, '1200', false, '0');
INSERT INTO col_sel VALUES (currval('admin_svg.them'::text), 'the_geom', 'geom', '3');
INSERT INTO appthe (idapplication, idtheme, mouseover, click, mouseout, ordre, sordre, ordre_couche, pointer_events, raster, zoommin, zoommax, zoommaxraster, objselection, objprincipal, objrecherche, partiel, vu_initial,force_chargement) VALUES (currval('admin_svg.appli'::text), currval('admin_svg.them'::text), '', '', '', 2, 0, 0, '', true, NULL, NULL, NULL, false, false, false, '0', '0', '0');
INSERT INTO style VALUES (nextval('admin_svg.styl'::text), currval('admin_svg.them'::text), NULL, '221,174,205', 'none', '', '', '', '', '', '', '1', '', '', '');
INSERT INTO col_theme VALUES (currval('admin_svg.appth'::text), 'constructi', 'Bati leger', '', '', 'Bati leger', '221,174,205', 'none', '', '1', '', '', '', '', '', '-1', '', '', 2);
INSERT INTO col_theme VALUES (currval('admin_svg.appth'::text), 'constructi', 'Bati dur', '', '', 'Bati dur', '184,84,149', 'none', '', '1', '', '', '', '', '', '-1', '', '', 1);
INSERT INTO theme (libelle_them, schema, tabl, raster, partiel, vu_initial, couch_tjs_visible, zoommin, zoommax, zoommax_raster, vu_anonyme, force_chargement) VALUES ('parcelle', 'cadastre', 'parcelle', '', '1', '1', '', 200, 10000, '600', false, '0');
INSERT INTO col_sel VALUES (currval('admin_svg.them'::text), 'identifian', 'ident', '1');
INSERT INTO col_sel VALUES (currval('admin_svg.them'::text), 'the_geom', 'geom', '2');
INSERT INTO col_sel VALUES (currval('admin_svg.them'::text), 'identifian', 'ad', '3');
INSERT INTO style VALUES (nextval('admin_svg.styl'::text), currval('admin_svg.them'::text), NULL, '255,128,0', '0,0,0', '0.2', '', '', '', '', '', '0.05', '', '', '');
INSERT INTO appthe (idapplication, idtheme, mouseover, click, mouseout, ordre, sordre, ordre_couche, pointer_events, raster, zoommin, zoommax, zoommaxraster, objselection, objprincipal, objrecherche, partiel, vu_initial,force_chargement) VALUES (currval('admin_svg.appli'::text), currval('admin_svg.them'::text), 'sur(evt,''red'')', 'lien(evt,''parcel'',''https://''+serveur+''/apps/cadastre/fich_parc.php?obj_keys='',''m'','''')', 'hors(evt)', 1, 0, 0, 'visible', true, NULL, NULL, NULL, false, true, true, '0', '0', '0');
INSERT INTO theme (libelle_them, schema, tabl, raster, partiel, vu_initial, couch_tjs_visible, zoommin, zoommax, zoommax_raster, vu_anonyme, force_chargement) VALUES ('Parcelle ville', 'cadastre', 'parcelle1', '', '1', '', '', 600, 10000, '600', false, '0');
INSERT INTO col_sel VALUES (currval('admin_svg.them'::text), 'identifian', 'ident', '1');
INSERT INTO col_sel VALUES (currval('admin_svg.them'::text), 'the_geom', 'geom', '2');
INSERT INTO col_where VALUES (currval('admin_svg.them'::text), 'prop1 in(select prop1 from cadastre.propriet where ddenom like (select ''COMMUNE D%''||upper(nom)||''%'' from admin_svg.commune where idcommune like VALEUR))');
INSERT INTO style VALUES (nextval('admin_svg.styl'::text), currval('admin_svg.them'::text), NULL, '131,214,164', '0,0,0', '', '1', '', '', '', '', '', '-1', '', '');
INSERT INTO appthe (idapplication, idtheme, mouseover, click, mouseout, ordre, sordre, ordre_couche, pointer_events, raster, zoommin, zoommax, zoommaxraster, objselection, objprincipal, objrecherche, partiel, vu_initial,force_chargement) VALUES (currval('admin_svg.appli'::text), currval('admin_svg.them'::text), '', '', '', 5, 0, 0, '', false, NULL, NULL, NULL, false, false, false, '0', '0', '0');
INSERT INTO theme (libelle_them, schema, tabl, raster, partiel, vu_initial, couch_tjs_visible, zoommin, zoommax, zoommax_raster, vu_anonyme, force_chargement) VALUES ('nom_voie', 'cadastre', 'nomvoie', '', '1', '', '', 200, 10000, '50000', false, '0');
INSERT INTO col_sel VALUES (currval('admin_svg.them'::text), 'texte||texte2||texte3||texte4||texte5||texte6||texte7||texte8||texte9||texte10', 'ad', '1');
INSERT INTO col_sel VALUES (currval('admin_svg.them'::text), 'the_geom', 'geom', '2');
INSERT INTO col_sel VALUES (currval('admin_svg.them'::text), 'rd2dg(rot_lab)', 'rotation', '3');
INSERT INTO style VALUES (nextval('admin_svg.styl'::text), currval('admin_svg.them'::text), NULL, '0,0,0', '', '', 'arial', '4', '', '', '', '', '', '', '');
INSERT INTO appthe (idapplication, idtheme, mouseover, click, mouseout, ordre, sordre, ordre_couche, pointer_events, raster, zoommin, zoommax, zoommaxraster, objselection, objprincipal, objrecherche, partiel, vu_initial,force_chargement) VALUES (currval('admin_svg.appli'::text), currval('admin_svg.them'::text), '', '', '', 3, 0, 0, '', true, 200, 10000, 50000, true, false, false, '0', '0', '0');
INSERT INTO theme (libelle_them, schema, tabl, raster, partiel, vu_initial, couch_tjs_visible, zoommin, zoommax, zoommax_raster, vu_anonyme, force_chargement) VALUES ('num_voie', 'cadastre', 'numvoie', '', '1', '', '', 200, 10000, '50000', false, '0');
INSERT INTO col_sel VALUES (currval('admin_svg.them'::text), 'texte', 'ad', '1');
INSERT INTO col_sel VALUES (currval('admin_svg.them'::text), 'the_geom', 'geom', '2');
INSERT INTO style VALUES (nextval('admin_svg.styl'::text), currval('admin_svg.them'::text), NULL, '0,0,255', '', '', 'arial', '2', '', '', '', '', '', '', '');
INSERT INTO appthe (idapplication, idtheme, mouseover, click, mouseout, ordre, sordre, ordre_couche, pointer_events, raster, zoommin, zoommax, zoommaxraster, objselection, objprincipal, objrecherche, partiel, vu_initial,force_chargement) VALUES (currval('admin_svg.appli'::text), currval('admin_svg.them'::text), '', '', '', 4, 0, 0, '', true, 200, 10000, 50000, true, false, false, '0', '0', '0');
INSERT INTO application (libelle_appli, btn_polygo, libelle_btn_polygo, divers, zoom_ouverture, zoom_min, zoom_max, url, type_appli) VALUES ('Cadastre', '', '', '', NULL, NULL, NULL, 'apps/cadastre/index.php','1');
INSERT INTO apputi VALUES (currval('admin_svg.appli'::text), '1', 'a', NULL, NULL, 1);
INSERT INTO application (libelle_appli, btn_polygo, libelle_btn_polygo, divers, zoom_ouverture, zoom_min, zoom_max, url, type_appli) VALUES ('administation', '', '', '', NULL, NULL, NULL, 'apps/administration/utilisateur.php','1');
INSERT INTO apputi VALUES (currval('admin_svg.appli'::text), '1', 'a', NULL, NULL, 2);
INSERT INTO application (libelle_appli, btn_polygo, libelle_btn_polygo, divers, zoom_ouverture, zoom_min, zoom_max, url, type_appli) VALUES ('back_office', '', '', '', NULL, NULL, NULL, 'interface/back_office/','1');
INSERT INTO apputi VALUES (currval('admin_svg.appli'::text), '1', 'a', NULL, NULL, 3);
create schema geotest;
create schema urba;
create schema general;
";
$DB->exec($defaut_appli);
	}

	
$liste_appli_dispo = array("espVerts","Plan geometre","Prg Immobilier","Ravalement","RU");
$liste_appli_instal= array();
$liste_appli_invite= array();
echo "<html>";
	    echo "<head>";
	    echo "<title>GISMeaux :: Connexion</title>";
	    echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">";
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
	font-size: 30px;
	background-color: transparent;
}
</style>";
echo "<SCRIPT LANGUAGE=\"JavaScript\">
	var sw=0;
	var app_a_install='';
	var app_invite='';
	function bascule()
	{
		if(sw==0)
		{
		document.getElementById('liste3').disabled=false;
		document.getElementById('liste4').disabled=false;
		document.getElementById('bouton2').disabled=false;
		sw=1;
		}
		else
		{
		document.getElementById('liste3').disabled=true;
		document.getElementById('liste4').disabled=true;
		document.getElementById('bouton2').disabled=true;
		sw=0;
		}
	}
	
	function Deplacer(l1,l2,y) {
		if (l1.options.selectedIndex>=0) {
			o=new Option(l1.options[l1.options.selectedIndex].text,l1.options[l1.options.selectedIndex].value);
			l2.options[l2.options.length]=o;
			if(y=='liste2')
		{
		app_a_install+=l1.options[l1.options.selectedIndex].value+',';
		document.getElementById('a_instal').value=app_a_install;
		}
		if(y=='liste4')
		{
		app_invite+=l1.options[l1.options.selectedIndex].value+',';
		document.getElementById('app_invite').value=app_invite;
		}
			l1.options[l1.options.selectedIndex]=null;
			
			
		
		}else{
			alert(\"Aucune application selectionnee\");
		}
		
		
	}
</SCRIPT>";
	    echo "</head>";
	    echo "<body class=\"login\">";
		
		echo "<CENTER>\n";
	echo "<table>\n";
	echo "<tr><td align=\"center\">\n";
	echo "<img src=\"../logo/ihead.png\" alt=\"\" title=\"\"/>";
	echo "<br><br>\n";
	echo "</td></tr>\n";
	echo "<FORM name=\"formulaire\" action=\"configuration.php\" method=\"POST\">";	
	echo "<tr><td align=\"center\" class=\"login\">\n";
	echo "Configuration";
	echo "<br>\n";
	echo "</td></tr>\n";

	echo "<tr><td align=\"center\" class=\"login\">\n";
	echo "<FONT size=\"2\">Projection:</font><SELECT align=top name=\"projection\" size=1 style=\"width:150px\">";
	$appli_instal_query="select application.idapplication,application.libelle_appli from admin_svg.application";
	$mn=$DB->tab_result($appli_instal_query);
	$projection_query="select * from public.spatial_ref_sys where auth_name like ('IGN%')";
	$mn1=$DB->tab_result($projection_query);
	for ($z=0;$z<count($mn1);$z++)
{
echo "<OPTION value=\"".$mn1[$z]['srid']."\">".substr($mn1[$z]['proj4text'],6)."</OPTION>";
}
	echo "</SELECT>\n";
	echo "<br>\n";
	echo "</td></tr>\n";	
	//echo "</td></tr>\n";
	
	
	echo "<TABLE class=\"ident\"><TR><TD align=\"center\" class=\"login\"><FONT size=\"2\">Applications Disponnibles</FONT><BR>";
	echo "<SELECT align=top name=\"liste1\" size=6  style=\"width:150px\">";
	for ($y1=0;$y1<count($mn);$y1++)
		{
			array_push($liste_appli_instal,$mn[$y1]['libelle_appli']);
		}
	for ($y=0;$y<count($liste_appli_dispo);$y++)
	{	
			
			if (!in_array($liste_appli_dispo[$y],$liste_appli_instal)) {
   			 echo "<OPTION value=\"".$liste_appli_dispo[$y]."\">".$liste_appli_dispo[$y]."</OPTION>";
			}

		
	}
		
	echo "</SELECT>";
	echo "</TD><TD align=\"center\">";
	echo "<BR>";
	echo "<INPUT type=\"button\" value=\"Ajouter >>>\" onClick=\"Deplacer(this.form.liste1,this.form.liste2,'liste2')\">";
	
	//echo "<INPUT type=\"button\" value=\"&lt;&lt;&lt; Enlever\" onClick=\"Deplacer(this.form.liste2,this.form.liste1)\">";
	echo "</TD><TD align=\"center\" class=\"login\"><FONT size=\"2\">Applications &agrave; installer</FONT><BR>";
	echo "<SELECT align=top name=\"liste2\" size=6 style=\"width:150px\">";
	for ($c=0;$c<count($mn);$c++)
{
echo "<OPTION value=\"".$mn[$c]['idapplication']."\">".$mn[$c]['libelle_appli']."</OPTION>";
}
		/*<OPTION value="10">----------------------</OPTION>*/
	echo "</SELECT>";
	echo "</TD></TR><tr><td></td><br><td><br></td></tr>";
	
	
	echo "<TR><TD align=\"center\" class=\"login\"><FONT size=\"2\">Souhaitez-vous cr&eacute;er un acc&egrave;s invit&eacute; pour internet ?</FONT><TD><input type=\"checkbox\" name=\"acces_inter\" value=\"true\" onclick=\"bascule()\"/></td></td></tr>
	<TR><TD align=\"center\" class=\"login\" ><FONT size=\"2\">Applications Disponnibles</FONT><BR>";
	echo "<SELECT align=top name=\"liste3\" size=6  style=\"width:150px\" disabled=\"true\" id=\"liste3\">";
	$invite_query="select application.libelle_appli from admin_svg.apputi inner join admin_svg.application on admin_svg.apputi.idapplication=admin_svg.application.idapplication join admin_svg.utilisateur on admin_svg.apputi.idutilisateur=admin_svg.utilisateur.idutilisateur where utilisateur.login='invite' order by application.type_appli asc";
$mn2=$DB->tab_result($invite_query);
	for ($y2=0;$y2<count($mn2);$y2++)
		{
			array_push($liste_appli_invite,$mn2[$y2]['libelle_appli']);
		}
	for ($y3=0;$y3<count($liste_appli_dispo);$y3++)
	{	
			
			if (!in_array($liste_appli_dispo[$y3],$liste_appli_invite)) {
   			 echo "<OPTION value=\"".$liste_appli_dispo[$y3]."\">".$liste_appli_dispo[$y3]."</OPTION>";
			}

		
	}
		
	echo "</SELECT>";
	echo "</TD><TD align=\"center\">";
	echo "<BR>";
	echo "<INPUT type=\"button\" value=\"Ajouter >>>\" disabled=\"true\" onClick=\"Deplacer(this.form.liste3,this.form.liste4,'liste4')\" id=\"bouton2\">";
	
	//echo "<INPUT type=\"button\" value=\"&lt;&lt;&lt; Enlever\" onClick=\"Deplacer(this.form.liste2,this.form.liste1)\">";
	echo "</TD><TD align=\"center\" class=\"login\"><FONT size=\"2\">Applications &agrave; associer au compte invit&eacute;</FONT><BR>";
	echo "<SELECT align=top name=\"liste4\" size=6 style=\"width:150px\" disabled=\"true\" id=\"liste4\">";
	for ($c=0;$c<count($mn2);$c++)
{
echo "<OPTION value=\"".$mn2[$c]['idapplication']."\">".$mn2[$c]['libelle_appli']."</OPTION>";
}
		/*<OPTION value="10">----------------------</OPTION>*/
	echo "</SELECT>";
	echo "</TD></TR>";
	
	/*<SCRIPT language="javascript">
		// Astuce pour Netscape qui ne supporte pas style="width:100"
		// Donc : création d'une ligne pour initialiser la largeur puis suppression par ce javascript
		document.formulaire.liste2.options.length=0;
	</SCRIPT>*/
	
	echo "</TR><tr><td><input type=\"hidden\" id=\"a_instal\" name=\"a_instal\" value=\"\">
<input type=\"hidden\" id=\"app_invite\" name=\"app_invite\" value=\"\"><INPUT type=\"submit\" value=\"enregistrer\"></td></tr>";
	echo "</FORM>";
	echo "</table>\n";
	
	
		
	    echo "</body>";
	    echo "</html>";
		}
		?>