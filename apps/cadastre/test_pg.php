<?php
/*Copyright Ville de Meaux 2004-2007
contributeur: jean-luc Dechamp - robert Leguay 
sig@meaux.fr

Ce logiciel est un programme informatique fournissant une interface cartographique WEB communale. 

Ce logiciel est r�gi par la licence CeCILL-C soumise au droit fran�ais et
respectant les principes de diffusion des logiciels libres. Vous pouvez
utiliser, modifier et/ou redistribuer ce programme sous les conditions
de la licence CeCILL-C telle que diffus�e par le CEA, le CNRS et l'INRIA 
sur le site "http://www.cecill.info".

En contrepartie de l'accessibilit� au code source et des droits de copie,
de modification et de redistribution accord�s par cette licence, il n'est
offert aux utilisateurs qu'une garantie limit�e.  Pour les m�mes raisons,
seule une responsabilit� restreinte p�se sur l'auteur du programme,  le
titulaire des droits patrimoniaux et les conc�dants successifs.

A cet �gard  l'attention de l'utilisateur est attir�e sur les risques
associ�s au chargement,  � l'utilisation,  � la modification et/ou au
d�veloppement et � la reproduction du logiciel par l'utilisateur �tant 
donn� sa sp�cificit� de logiciel libre, qui peut le rendre complexe � 
manipuler et qui le r�serve donc � des d�veloppeurs et des professionnels
avertis poss�dant  des connaissances  informatiques approfondies.  Les
utilisateurs sont donc invit�s � charger  et  tester  l'ad�quation  du
logiciel � leurs besoins dans des conditions permettant d'assurer la
s�curit� de leurs syst�mes et ou de leurs donn�es et, plus g�n�ralement, 
� l'utiliser et l'exploiter dans les m�mes conditions de s�curit�. 

Le fait que vous puissiez acc�der � cet en-t�te signifie que vous avez 
pris connaissance de la licence CeCILL-C, et que vous en avez accept� les 
termes.*/
if ($_POST['vpg']=='pgsql') {
	$pgx=pg_connect("dbname=".$_POST['bdpg']." host=localhost user=".$_POST['upg']." password=".$_POST['pswpg']);
	set_time_limit(120);
	//$ctab=fopen($rep_f."cree_tab.sql",w);
	if ($_POST['nvl']=='O'){
		/* D�pendance des b�timents cenr=60 */
		pg_exec($pgx,"CREATE SCHEMA cadastre");
		pg_exec($pgx,"CREATE TABLE cadastre.b_depdgi (commune varchar(6),invar varchar(10),dnupev char(3),dnudes char(3),
						  dsudep varchar(6),cconad char(2),asitet varchar(6),dmatgm char(2),
						  dmatto char(2),detent char(1),geaulc char(1),gelelc char(1),
						  gchclc char(1),dnbbai char(2),dnbdou char(2),dnblav char(2),
						  dnbwc char(2),deqtlc char(3),dcimlc char(2),dcetde char(3),
						  dcspde char(3));");
		pg_exec($pgx,"CREATE index ndx_b_dep_comm on cadastre.b_depdgi (commune);");
		/* Description sommaire des locaux cenr=10 */
		pg_exec($pgx,"CREATE TABLE cadastre.b_desdgi (commune varchar(6),invar varchar(10),gpdl char(1),dsrpar char(1),
						  dnupro varchar(6),jdata varchar(8),dnufnl varchar(6),ccoeva char(1),
						  dteloc char(1),gtauom char(2),dcomrd char(3),ccoplc char(1),
						  cconlc char(2),dvltrt varchar(9),ccoape varchar(4),cc48lc char(2),
						  dloy48a varchar(9),top48 char(1),dnatic char(1),cchpr char(1),
						  jannat varchar(4),dnbniv char(2),hmsem char(1),postel char(1),
						  cbtabt varchar(2),jdtabt varchar(4),jrtabt varchar(4));");
		pg_exec($pgx,"CREATE index ndx_b_des_comm on cadastre.b_desdgi (commune);");
		/* Locaux �xon�r�s, pas toujours servi par DGI cenr=30 */
		pg_exec($pgx,"CREATE TABLE cadastre.b_exodgi (commune varchar(6),invar varchar(10),dnupev char(3),dnuord char(3),ccolloc char(2),
						  pexb varchar(5),gnextl char(2),jandeb varchar(4),janimp varchar(4),
						  dvldif2 varchar(9),dvldif2a varchar(9),fcexb2 varchar(9),fcexba2 varchar(9),
						  rcexba2 varchar(9));");
		pg_exec($pgx,"CREATE index ndx_b_exo_comm on cadastre.b_exodgi (commune);");
		/* Description d�taill�e des locaux cenr=40 */
		pg_exec($pgx,"CREATE TABLE cadastre.b_habdgi (commune varchar(6),invar varchar(10),dnupev char(3),dnudes char(3),cconadga char(2),
						  dsueicga varchar(6),dcimei char(2),cconadcv char(2),dsueiccv varchar(6),
						  dcimeicv char(2),cconadgr char(2),dsueicgr varchar(6),dcimeia char(2),
						  cconadtr char(2),dsueictr varchar(6),dcimeitr char(2),geaulc char(1),
						  gelelc char(1),gesclc char(1),ggazlc char(1),gasclc char(1),
						  gchclc char(1),gvorlc char(1),gteglc char(1),dnbbai char(2),
						  dnbdou char(2),dnblav char(2),dnbwc char(2),deqdha char(3),
						  dnbppr char(2),dnbsam char(2),dnbcha char(2),dnbcu8 char(2),
						  dnbcu9 char(2),dnbsea char(2),dnbann char(2),dnbpdc char(2),
						  dsupdc varchar(6),dmatgm char(2),dmatto char(2),jannat varchar(4),
						  detent char(1),dnbniv char(2));");
		pg_exec($pgx,"CREATE index ndx_b_hab_comm on cadastre.b_habdgi (commune);");
		/* Description des locaux professionnels cenr=50 */
		pg_exec($pgx,"CREATE TABLE cadastre.b_prodgi (commune varchar(6),invar varchar(10),dnupev char(3),dnudes char(3),vsurzt varchar(9));");
		pg_exec($pgx,"CREATE index ndx_b_pro_comm on cadastre.b_prodgi (commune);\n");
		/* Subdivision des locaux cenr=21 */
		pg_exec($pgx,"CREATE TABLE cadastre.b_subdgi (commune varchar(6),invar varchar(10),dnupev char(3),ccoaff char(1),ccostb char(1),
						  dcapec char(2),dcetlc char(3),dcsplc char(3),dsupot varchar(6),
						  dvlper varchar(9),dvlpera varchar(9),gnexpl char(2),ccthp char(1),
						  retimp char(1),dnuref char(3),gnidom char(1),dcsglc char(3),
						  dvltpe varchar(9),dcralc varchar(3));");
		pg_exec($pgx,"CREATE index ndx_b_sub_comm on cadastre.b_subdgi (commune);");
		/* Taxation du b�ti, pas toujours servi cenr=36 */
		pg_exec($pgx,"CREATE TABLE cadastre.b_taxdgi (commune varchar(6),invar varchar(10),dnupev char(3),vlbaic varchar(9),vlbaiac varchar(9),
						  bipeviac varchar(9),vlbaid varchar(9),vlbaiad varchar(9),bipeviad varchar(9),
						  vlbair varchar(9),vlbaiar varchar(9),bipeviar varchar(9),vlbaigc varchar(9),
						  vlbaiagc varchar(9),bipeviagc varchar(9));");
		pg_exec($pgx,"CREATE index ndx_b_tax_comm on cadastre.b_taxdgi (commune);");
		/* Identification des locaux cenr=00 */
		pg_exec($pgx,"CREATE TABLE cadastre.batidgi (commune varchar(6),invar varchar(10),ccopre char(3),ccosec char(2),dnupla varchar(4),
						  dnubat char(2),desca char(2),dniv char(2),
						  dpor varchar(5),ccoriv varchar(4),ccovoi varchar(5),dnvoiri varchar(4),
						  dindic char(1),ccocif varchar(4),dvoilib varchar(30));");
		pg_exec($pgx,"CREATE index ndx_bati_comm on cadastre.batidgi (commune);");
		pg_exec($pgx,"CREATE index ndx_bati_invar on cadastre.batidgi (invar);");
		/* Exon�ration du non b�ti cenr=30 */
		pg_exec($pgx,"CREATE TABLE cadastre.p_exoner (commune varchar(6),ccosec char(2),dnupla varchar(4),ccosub char(2),muexn char(2),
						  vecexn varchar(10),ccolloc char(2),pexn varchar(5),gnexts char(2),
						  jandeb varchar(4),jfinex varchar(4),rcexnba varchar(10));");
		pg_exec($pgx,"CREATE index ndx_p_exo_comm on cadastre.p_exoner (commune);");
		/* Subdivision fiscale du non b�ti cenr=21 */
		pg_exec($pgx,"CREATE TABLE cadastre.p_subdif (commune varchar(6),ccosec char(2),dnupla varchar(4),ccosub char(2),dcntsf varchar(9),
						  cgroup char(1),dnumcp varchar(5),gnexps char(2),drcsub varchar(10),
						  drcsuba varchar(10),ccostn char(1),cgmum char(2),dsgrpf char(2),
						  dclssf char(2),cnatsp varchar(5),drgpos char(1),ccoprel char(3),
						  ccosecl char(2),dnuplal varchar(4),dnupdl char(3),dnulot varchar(7),
						  topja char(1),datja varchar(8),postel char(1));");
		pg_exec($pgx,"CREATE index ndx_p_subdif_comm on cadastre.p_subdif (commune);");
		/* Taxation du non b�ti cenr=36 */
		pg_exec($pgx,"CREATE TABLE cadastre.p_taxat (commune varchar(6),ccosec char(2),dnupla varchar(4),ccosub char(2),
						  majposac varchar(10),bisufadc varchar(10),majposad varchar(10),
						  bisufadd varchar(10),majposar varchar(10),bisufadr varchar(10),
						  majposagc varchar(10),bisufadgc varchar(10));");
		pg_exec($pgx,"CREATE index ndx_p_taxat_comm on cadastre.p_taxat (commune);");
		/* Identification des parcelles cenr=10 */
		pg_exec($pgx,"CREATE TABLE cadastre.parcel (commune varchar(6),ccosec char(2),dnupla varchar(4),dcntpa varchar(9),dsrpar char(1),
						  cgroup char(1),dnumcp varchar(5),jdatat varchar(8),dreflf varchar(5),
						  gpdl char(1),cprsecr char(3),ccosecr char(2),dnuplar varchar(4),
						  dnupdl char(3),gurbpa char(1),dparpi varchar(4),ccoarp char(1),
						  gparnf char(1),gparbat char(1),dnuvoi varchar(4),
						  dindic char(1),ccovoi varchar(5),ccoriv varchar(4),ccocif varchar(4),
						  par1 varchar(6),prop1 varchar(6),ind varchar(12));");
		pg_exec($pgx,"CREATE index ndx_parcel_comm on cadastre.parcel (commune);");
		pg_exec($pgx,"CREATE index ndx_parcel_par1 on cadastre.parcel (par1);");
		pg_exec($pgx,"CREATE index ndx_parcel_prop1 on cadastre.parcel (prop1);");
		/* Table des propri�taires */
		pg_exec($pgx,"CREATE TABLE cadastre.propriet (commune varchar(6),cgroup char(1),dnumcp varchar(5),dnulp char(2),ccocif varchar(4),
						  dnuper varchar(6),ccodro char(1),ccodem char(1),gdesip char(1),
						  gtoper char(1),ccoqua char(1),dnatpr char(3),ccogrm char(2),
						  dsglpm varchar(10),dforme varchar(7),ddenom varchar(60),dlign3 varchar(30),
						  dlign4 varchar(36),dlign5 varchar(30),dlign6 varchar(32),ccopay char(3),
						  dqualp char(3),dnomlp varchar(30),dprnlp varchar(15),jdatnss varchar(10),
						  dldnss varchar(58),epxnee char(3),dnomcp varchar(30),dprncp varchar(15),
						  dsiren varchar(10),prop1 varchar(6) NOT NULL);");
		pg_exec($pgx,"CREATE index ndx_propriet_comm on cadastre.propriet (commune);");
		pg_exec($pgx,"CREATE index ndx_propriet_prop1 on cadastre.propriet (prop1);");
		/* Table des voies, code RIVOLI */
		pg_exec($pgx,"CREATE TABLE cadastre.voies (commune varchar(6),code_voie varchar(4),nom_voie varchar(56),
							caract varchar(1),typ varchar(1));");
		pg_exec($pgx,"CREATE index ndx_voies_comm on cadastre.voies (commune);");
		pg_exec($pgx,"CREATE index ndx_voies_cod on cadastre.voies (code_voie);");
		/* Table des communes */
		pg_exec($pgx,"CREATE TABLE cadastre.commune(cod_comm varchar(6) NOT NULL,lib_com varchar(50),logo varchar(50));");
		pg_exec($pgx,"CREATE index ndx_commune_comm on cadastre.commune (cod_comm);");
		pg_exec($pgx,"CREATE TABLE cadastre.pdldgi (  commune character varying(6) NOT NULL,  ccoprel character varying(3),
                                                  ccosecl character varying(2),  dnuplal character varying(4),  dnupdl character varying(3),
                                                  dnulot character varying(7),  ccopreb character varying(3),  invloc character varying(10),
                                                  dnumql character varying(7)) WITH (  OIDS=TRUE);");
               pg_exec($pgx,"ALTER TABLE cadastre.pdldgi OWNER TO postgres;");
               pg_exec($pgx,"CREATE TABLE cadastre.pdlardgi (  commune character varying(6) NOT NULL,  ccopre character varying(3),
                                                  ccosec character varying(2),  dnupla character varying(4),  dnupdl character varying(3),
                                                  dnivim character varying(1),  ctpdl character varying(3),  dnompdl character varying(30),
                                                  dmrpdl character varying(20),  gprmut character varying(1),  dnupro character varying(6)
                                                   ) WITH ( OIDS=TRUE );");
               pg_exec($pgx,"ALTER TABLE cadastre.pdlardgi OWNER TO postgres;");
               pg_exec($pgx,"CREATE TABLE cadastre.pdlasdgi (  commune character varying NOT NULL DEFAULT 6,  ccopre character varying(3),
                                                   ccosec character varying(2),  dnupla character varying(4),  dnupdl character varying(3),
                                                   ccoprea character varying(3),  ccoseca character varying(2),  dnuplaa character varying(4)
                                                   ) WITH OIDS=TRUE );");
               pg_exec($pgx,"ALTER TABLE cadastre.pdlasdgi OWNER TO postgres;");
               pg_exec($pgx,"CREATE TABLE cadastre.pdldesdgi ( commune character varying(6) NOT NULL,  ccopre character varying(3),
                                                   ccosec character varying(2),  dnupla character varying(4),  dnupdl character varying(3),
                                                   dnulot character varying(7),  cconlo character varying(1),  dcntlo character varying(9),
                                                   dnumql character varying(7),  ddenql character varying(7),  dfilot character varying(20),
                                                   datact character varying(8),  dnuprol character varying(6),  dreflf character varying(5)
                                                   ) WITH ( OIDS=TRUE );");
               pg_exec($pgx,"ALTER TABLE cadastre.pdldesdgi OWNER TO postgres;");
	}else{
		/* Base cadastre existante, on renomme les tables pour historique, et on cr�� les nouvelles */
		function rename_table($name_tb,$ann,$pgx){
			$dx=strval($ann-1);
			$dx=substr($dx,2,2); //echo $dx;
			$chain1=pg_exec($pgx,"create table ".substr($name_tb,0,-2).$dx." as select * from ".$name_tb.";");
			//fwrite ($ct,$chain1);
			$chain2=pg_exec($pgx,"delete from ".$name_tb.";");
			//fwrite ($ct,$chain2);
		}
		rename_table("cadastre.b_depdgi",$_POST['ann_ref'],$pgx);
		rename_table("cadastre.b_desdgi",$_POST['ann_ref'],$pgx);
		rename_table("cadastre.b_exodgi",$_POST['ann_ref'],$pgx);
		rename_table("cadastre.b_habdgi",$_POST['ann_ref'],$pgx);
		rename_table("cadastre.b_prodgi",$_POST['ann_ref'],$pgx);
		rename_table("cadastre.b_subdgi",$_POST['ann_ref'],$pgx);
		rename_table("cadastre.b_taxdgi",$_POST['ann_ref'],$pgx);
		rename_table("cadastre.batidgi",$_POST['ann_ref'],$pgx);
		rename_table("cadastre.p_exoner",$_POST['ann_ref'],$pgx);
		rename_table("cadastre.p_subdif",$_POST['ann_ref'],$pgx);
		rename_table("cadastre.p_taxat",$_POST['ann_ref'],$pgx);
		rename_table("cadastre.parcel",$_POST['ann_ref'],$pgx);
		rename_table("cadastre.propriet",$_POST['ann_ref'],$pgx);
		rename_table("cadastre.voies",$_POST['ann_ref'],$pgx);
		rename_table("cadastre.pdldgi",$_POST['ann_ref'],$pgx);
		rename_table("cadastre.pdlardgi",$_POST['ann_ref'],$pgx);
		rename_table("cadastre.pdlasdgi",$_POST['ann_ref'],$pgx);
		rename_table("cadastre.pdldesdgi",$_POST['ann_ref'],$pgx);
		//rename_table("cadastre.commune",$_POST['ann_ref'],$pgx);
	}
//fclose($ctab);
	if (strrpos($_POST['rep_f'],"/")==(strlen($_POST['rep_f'])-1)){
		$_POST['rep_f']=substr($_POST['rep_f'],0,-1);
	}else{
		$_POST['rep_f']=$_POST['rep_f'];
	}
	exec("perl /var/www/application/apps/cadastre/lit_cad.pl ".$_POST['rep_f']. " ".$_POST['ext_f'] );
	pg_exec($pgx,"copy cadastre.parcel from '".$_POST['rep_f']."/parcelle.csv' with csv;");
	pg_exec($pgx,"copy cadastre.batidgi from '".$_POST['rep_f']."/batidgi.csv' with csv;");
	pg_exec($pgx,"copy cadastre.b_depdgi from '".$_POST['rep_f']."/bdepdgi.csv' with csv;");
	pg_exec($pgx,"copy cadastre.b_desdgi from '".$_POST['rep_f']."/bdesdgi.csv' with csv;");
	pg_exec($pgx,"copy cadastre.b_exodgi from '".$_POST['rep_f']."/bexodgi.csv' with csv;");
	pg_exec($pgx,"copy cadastre.b_taxdgi from '".$_POST['rep_f']."/btaxdgi.csv' with csv;");
	pg_exec($pgx,"copy cadastre.b_habdgi from '".$_POST['rep_f']."/bhabdgi.csv' with csv;");
	pg_exec($pgx,"copy cadastre.b_prodgi from '".$_POST['rep_f']."/bprodgi.csv' with csv;");
	pg_exec($pgx,"copy cadastre.b_subdgi from '".$_POST['rep_f']."/bsubdgi.csv' with csv;");
	pg_exec($pgx,"copy cadastre.voies from '".$_POST['rep_f']."/fantoir.csv' with csv;");
	pg_exec($pgx,"copy cadastre.p_exoner from '".$_POST['rep_f']."/p_exoner.csv' with csv;");
	pg_exec($pgx,"copy cadastre.p_taxat from '".$_POST['rep_f']."/p_taxat.csv' with csv;");
	pg_exec($pgx,"copy cadastre.p_subdif from '".$_POST['rep_f']."/p_subdif.csv' with csv;");
	pg_exec($pgx,"copy cadastre.propriet from '".$_POST['rep_f']."/propriet.csv' with csv;");
	pg_exec($pgx,"copy cadastre.pdldgi from '".$_POST['rep_f']."/pdl.csv' with csv;");
	pg_exec($pgx,"copy cadastre.pdlardgi from '".$_POST['rep_f']."/fpdl10.csv' with csv;");
	pg_exec($pgx,"copy cadastre.pdlasdgi from '".$_POST['rep_f']."/fpdl20.csv' with csv;");
	pg_exec($pgx,"copy cadastre.pdldesdgi from '".$_POST['rep_f']."/fpdl30.csv' with csv;");
#pg_exec($pgx,"update cadastre.parcel set ind = substr(commune,4,3)||'000'||lpad(ltrim(ccosec),2,'0')||dnupla where oid=oid");
echo "operation terminée ?";
}
?>
