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
?>
<html>
<head>
<title>Document sans titre</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<?php if ($voracle=='oracle') {
	set_time_limit(120);
	$ctab=fopen($rep_f."cree_tab.sql",w);
	if ($nvl=='O'){
		/* Dépendance des bâtiments cenr=60 */
		fwrite ($ctab,"CREATE TABLE b_depdgi (commune varchar(6),invar varchar(10),dnupev char(3),dnudes char(3),
						  dsudep varchar(6),cconad char(2),asitet varchar(6),dmatgm char(2),
						  dmatto char(2),detent char(1),geaulc char(1),gelelc char(1),
						  gchclc char(1),dnbbai char(2),dnbdou char(2),dnblav char(2),
						  dnbwc char(2),deqtlc char(3),dcimlc char(2),dcetde char(3),
						  dcspde char(3));\n");
		fwrite ($ctab,"CREATE index ndx_b_dep_comm on b_depdgi (commune);\n");
		/* Description sommaire des locaux cenr=10 */
		fwrite ($ctab,"CREATE TABLE b_desdgi (commune varchar(6),invar varchar(10),gpdl char(1),dsrpar char(1),
						  dnupro varchar(6),jdata varchar(8),dnufnl varchar(6),ccoeva char(1),
						  dteloc char(1),gtauom char(2),dcomrd char(3),ccoplc char(1),
						  cconlc char(2),dvltrt varchar(9),ccoape varchar(4),cc48lc char(2),
						  dloy48a varchar(9),top48 char(1),dnatic char(1),cchpr char(1),
						  jannat varchar(4),dnbniv char(2),hmsem char(1),postel char(1),
						  cbtabt varchar(2),jdtabt varchar(4),jrtabt varchar(4));\n");
		fwrite ($ctab,"CREATE index ndx_b_des_comm on b_desdgi (commune);\n");
		/* Locaux éxonérés, pas toujours servi par DGI cenr=30 */
		fwrite ($ctab,"CREATE TABLE b_exodgi (commune varchar(6),invar varchar(10),dnupev char(3),dnuord char(3),ccolloc char(2),
						  pexb varchar(5),gnextl char(2),jandeb varchar(4),janimp varchar(4),
						  dvldif2 varchar(9),dvldif2a varchar(9),fcexb2 varchar(9),fcexba2 varchar(9),
						  rcexba2 varchar(9));\n");
		fwrite ($ctab,"CREATE index ndx_b_exo_comm on b_exodgi (commune);\n");
		/* Description détaillée des locaux cenr=40 */
		fwrite ($ctab,"CREATE TABLE b_habdgi (commune varchar(6),invar varchar(10),dnupev char(3),dnudes char(3),cconadga char(2),
						  dsueicga varchar(6),dcimei char(2),cconadcv char(2),dsueiccv varchar(6),
						  dcimeicv char(2),cconadgr char(2),dsueicgr varchar(6),dcimeia char(2),
						  cconadtr char(2),dsueictr varchar(6),dcimeitr char(2),geaulc char(1),
						  gelelc char(1),gesclc char(1),ggazlc char(1),gasclc char(1),
						  gchclc char(1),gvorlc char(1),gteglc char(1),dnbbai char(2),
						  dnbdou char(2),dnblav char(2),dnbwc char(2),deqdha char(3),
						  dnbppr char(2),dnbsam char(2),dnbcha char(2),dnbcu8 char(2),
						  dnbcu9 char(2),dnbsea char(2),dnbann char(2),dnbpdc char(2),
						  dsupdc varchar(6),dmatgm char(2),dmatto char(2),jannat varchar(4),
						  detent char(1),dnbniv char(2));\n");
		fwrite ($ctab,"CREATE index ndx_b_hab_comm on b_habdgi (commune);\n");
		/* Description des locaux professionnels cenr=50 */
		fwrite ($ctab,"CREATE TABLE b_prodgi (commune varchar(6),invar varchar(10),dnupev char(3),dnudes char(3),vsurzt varchar(9));\n");
		fwrite ($ctab,"CREATE index ndx_b_pro_comm on b_prodgi (commune);\n");
		/* Subdivision des locaux cenr=21 */
		fwrite ($ctab,"CREATE TABLE b_subdgi (commune varchar(6),invar varchar(10),dnupev char(3),ccoaff char(1),ccostb char(1),
						  dcapec char(2),dcetlc char(3),dcsplc char(3),dsupot varchar(6),
						  dvlper varchar(9),dvlpera varchar(9),gnexpl char(2),ccthp char(1),
						  retimp char(1),dnuref char(3),gnidom char(1),dcsglc char(3),
						  dvltpe varchar(9),dcralc varchar(3));\n");
		fwrite ($ctab,"CREATE index ndx_b_sub_comm on b_subdgi (commune);\n");
		/* Taxation du bâti, pas toujours servi cenr=36 */
		fwrite ($ctab,"CREATE TABLE b_taxdgi (commune varchar(6),invar varchar(10),dnupev char(3),vlbaic varchar(9),vlbaiac varchar(9),
						  bipeviac varchar(9),vlbaid varchar(9),vlbaiad varchar(9),bipeviad varchar(9),
						  vlbair varchar(9),vlbaiar varchar(9),bipeviar varchar(9),vlbaigc varchar(9),
						  vlbaiagc varchar(9),bipeviagc varchar(9));\n");
		fwrite ($ctab,"CREATE index ndx_b_tax_comm on b_taxdgi (commune);\n");
		/* Identification des locaux cenr=00 */
		fwrite ($ctab,"CREATE TABLE batidgi (commune varchar(6),invar varchar(10),ccopre char(3),ccosec char(2),dnupla varchar(4),
						  dnubat char(2),desca char(2),dniv char(2),
						  dpor varchar(5),ccoriv varchar(4),ccovoi varchar(5),dnvoiri varchar(4),
						  dindic char(1),ccocif varchar(4),dvoilib varchar(30));\n");
		fwrite ($ctab,"CREATE index ndx_bati_comm on batidgi (commune);\n");
		fwrite ($ctab,"CREATE index ndx_bati_invar on batidgi (invar);\n");
		/* Exonération du non bâti cenr=30 */
		fwrite ($ctab,"CREATE TABLE p_exoner (commune varchar(6),ccosec char(2),dnupla varchar(4),ccosub char(2),muexn char(2),
						  vecexn varchar(10),ccolloc char(2),pexn varchar(5),gnexts char(2),
						  jandeb varchar(4),jfinex varchar(4),rcexnba varchar(10));\n");
		fwrite ($ctab,"CREATE index ndx_p_exo_comm on p_exoner (commune);\n");
		/* Subdivision fiscale du non bâti cenr=21 */
		fwrite ($ctab,"CREATE TABLE p_subdif (commune varchar(6),ccosec char(2),dnupla varchar(4),ccosub char(2),dcntsf varchar(9),
						  cgroup char(1),dnumcp varchar(5),gnexps char(2),drcsub varchar(10),
						  drcsuba varchar(10),ccostn char(1),cgmum char(2),dsgrpf char(2),
						  dclssf char(2),cnatsp varchar(5),drgpos char(1),ccoprel char(3),
						  ccosecl char(2),dnuplal varchar(4),dnupdl char(3),dnulot varchar(7),
						  topja char(1),datja varchar(8),postel char(1));\n");
		fwrite ($ctab,"CREATE index ndx_p_subdif_comm on p_subdif (commune);\n");
		/* Taxation du non bâti cenr=36 */
		fwrite ($ctab,"CREATE TABLE p_taxat (commune varchar(6),ccosec char(2),dnupla varchar(4),ccosub char(2),
						  majposac varchar(10),bisufadc varchar(10),majposad varchar(10),
						  bisufadd varchar(10),majposar varchar(10),bisufadr varchar(10),
						  majposagc varchar(10),bisufadgc varchar(10));\n");
		fwrite ($ctab,"CREATE index ndx_p_taxat_comm on p_taxat (commune);\n");
		/* Identification des parcelles cenr=10 */
		fwrite ($ctab,"CREATE TABLE parcel (commune varchar(6),ccosec char(2),dnupla varchar(4),dcntpa varchar(9),dsrpar char(1),
						  cgroup char(1),dnumcp varchar(5),jdatat varchar(8),dreflf varchar(5),
						  gpdl char(1),cprsecr char(3),ccosecr char(2),dnuplar varchar(4),
						  dnupdl char(3),gurbpa char(1),dparpi varchar(4),ccoarp char(1),
						  gparnf char(1),gparbat char(1),dnuvoi varchar(4),
						  dindic char(1),ccovoi varchar(5),ccoriv varchar(4),ccocif varchar(4),
						  par1 varchar(6),prop1 varchar(6));\n");
		fwrite ($ctab,"CREATE index ndx_parcel_comm on parcel (commune);\n");
		fwrite ($ctab,"CREATE index ndx_parcel_par1 on parcel (par1);\n");
		fwrite ($ctab,"CREATE index ndx_parcel_prop1 on parcel (prop1);\n");
		/* Table des propriétaires */
		fwrite ($ctab,"CREATE TABLE propriet (commune varchar(6),cgroup char(1),dnumcp varchar(5),dnulp char(2),ccocif varchar(4),
						  dnuper varchar(6),ccodro char(1),ccodem char(1),gdesip char(1),
						  gtoper char(1),ccoqua char(1),dnatpr char(3),ccogrm char(2),
						  dsglpm varchar(10),dforme varchar(7),ddenom varchar(60),dlign3 varchar(30),
						  dlign4 varchar(36),dlign5 varchar(30),dlign6 varchar(32),ccopay char(3),
						  dqualp char(3),dnomlp varchar(30),dprnlp varchar(15),jdatnss varchar(10),
						  dldnss varchar(58),epxnee char(3),dnomcp varchar(30),dprncp varchar(15),
						  dsiren varchar(10),prop1 varchar(6) NOT NULL);\n");
		fwrite ($ctab,"CREATE index ndx_propriet_comm on propriet (commune);\n");
		fwrite ($ctab,"CREATE index ndx_propriet_prop1 on propriet (prop1);\n");
		/* Table des voies, code RIVOLI */
		fwrite ($ctab,"CREATE TABLE voies (commune varchar(6),code_voie varchar(4),nom_voie varchar(56),
							caract varchar(1),typ varchar(1));\n");
		fwrite ($ctab,"CREATE index ndx_voies_comm on voies (commune);\n");
		fwrite ($ctab,"CREATE index ndx_voies_cod on voies (code_voie);\n");
		/* Table des communes */
		fwrite ($ctab,"CREATE TABLE commune(cod_comm varchar(6) NOT NULL,lib_com varchar(50),logo varchar(50));\n");
		fwrite ($ctab,"CREATE index ndx_commune_comm on commune (cod_comm);\n");
	}else{
		/* Base cadastre existante, on renomme les tables pour historique, et on créé les nouvelles */
		function rename_table($name_tb,$ann,$ct){
			$dx=strval($ann-1);
			$dx=substr($dx,2,2); echo $dx;
			$chain1="create table ".substr($name_tb,0,-2).$dx." as select * from ".$name_tb.";\n";
			fwrite ($ct,$chain1);
			$chain2="delete from ".$name_tb.";\n";
			fwrite ($ct,$chain2);
		}
		rename_table("b_depdgi",$ann_ref,$ctab);
		rename_table("b_desdgi",$ann_ref,$ctab);
		rename_table("b_exodgi",$ann_ref,$ctab);
		rename_table("b_habdgi",$ann_ref,$ctab);
		rename_table("b_prodgi",$ann_ref,$ctab);
		rename_table("b_subdgi",$ann_ref,$ctab);
		rename_table("b_taxdgi",$ann_ref,$ctab);
		rename_table("batidgi",$ann_ref,$ctab);
		rename_table("p_exoner",$ann_ref,$ctab);
		rename_table("p_subdif",$ann_ref,$ctab);
		rename_table("p_taxat",$ann_ref,$ctab);
		rename_table("parcel",$ann_ref,$ctab);
		rename_table("propriet",$ann_ref,$ctab);
		rename_table("voies",$ann_ref,$ctab);
		rename_table("commune",$ann_ref,$ctab);
	}
fclose($ctab);

}
?>
</body>
</html>
