<?php
session_start();
if (isset($_POST['db_name'])){
	$connect=pg_connect("host=".$_POST['db_host']." port=5432 dbname=".$_POST['db_name']." user=".$_POST['db_user']." password=".$_POST['db_passwd']);
	if ($connect){
		$filnam="./config/db.local.php";
		$fic=fopen($filnam,"w");
		fwrite($fic,"<?php\nclass DB extends DBpg {\nvar ".'$db_host    = "'.$_POST['db_host'].'";'."\n");
		fwrite($fic,'var $db_user    = "'.$_POST['db_user'].'";'."\n");
		fwrite($fic,'var $db_passwd= "'.$_POST['db_passwd'].'";'."\n");
		fwrite($fic,'var $db_name = "'.$_POST['db_name'].'";'."\n}\n");
		fwrite($fic,'$projection="27571";'."\n");
		fwrite($fic,'$config_serveur_smtp="127.0.0.1" ;'."\n");
		fwrite($fic,'$adresse_admin="'.$_POST['ad_email'].'" ;'."\n");
		fwrite($fic,'$config_mail_sujet="- Problème interface -" ;'."\n");
		fwrite($fic,'$config_mail_contenu=" a rencontré un problème avec l\'interface cartographique.
		Merci de consulter la base d\'administration
		
		-------------------------------------------------------------------------------------------------------
		Ceci est un message automatique." ;'."\n?>");
		fclose($fic);
	//création table schema admin_svg
		$qq="create schema admin_svg;
		SET client_encoding = 'LATIN9';
		SET check_function_bodies = false;
		SET client_min_messages = warning;
		SET default_tablespace = '';
		SET default_with_oids = true;
		create sequence admin_svg.appli increment by 1 start with 1;
		create sequence admin_svg.appth increment by 1 start with 1;
		create sequence admin_svg.styl increment by 1 start with 1;
		create sequence admin_svg.them increment by 1 start with 1;
		create sequence admin_svg.util increment by 1 start with 1;
		CREATE TABLE admin_svg.application (
			idapplication character varying(6) DEFAULT nextval('admin_svg.appli'::text) NOT NULL,
			libelle_appli character varying,
			btn_polygo character varying,
			libelle_btn_polygo character varying,
			divers character varying,
			zoom_ouverture integer,
			zoom_min integer,
			zoom_max integer,
			url character varying,
			type_appli character varying DEFAULT 0);
		ALTER TABLE admin_svg.application OWNER TO ".$_POST['db_user'].";
		ALTER TABLE ONLY admin_svg.application ADD CONSTRAINT cleunik PRIMARY KEY (idapplication);
		ALTER INDEX admin_svg.cleunik OWNER TO ".$_POST['db_user'].";
		CREATE TABLE admin_svg.appthe (
			idappthe character varying DEFAULT nextval('admin_svg.appth'::text) NOT NULL,
			idapplication character varying(6),
			idtheme character varying,
			mouseover character varying,
			click character varying,
			mouseout character varying,
			ordre integer,
			sordre integer,
			ordre_couche integer,
			pointer_events character varying,
			raster boolean DEFAULT true,
			zoommin integer,
			zoommax integer,
			zoommaxraster integer,
			objselection boolean DEFAULT false,
			objprincipal boolean DEFAULT false,
			objrecherche boolean DEFAULT false,
			partiel character varying,
			vu_initial character varying,
			force_chargement character varying DEFAULT 0);
		ALTER TABLE admin_svg.appthe OWNER TO ".$_POST['db_user'].";
		CREATE TABLE admin_svg.apputi (
			idapplication character varying(6),
			idutilisateur character varying(10),
			droit character varying,
			btn_polygo character varying,
			libelle_btn_polygo character varying,
			ordre integer);
		ALTER TABLE admin_svg.apputi OWNER TO ".$_POST['db_user'].";
		ALTER TABLE ONLY admin_svg.apputi ADD CONSTRAINT fk_appli FOREIGN KEY (idapplication) REFERENCES admin_svg.application(idapplication);
		CREATE TABLE admin_svg.col_sel (
			idtheme character varying,
			appel character varying,
			nom_as character varying,
			ordre_sel character varying);
		ALTER TABLE admin_svg.col_sel OWNER TO ".$_POST['db_user'].";
		CREATE TABLE admin_svg.col_theme (
			idappthe character varying,
			colonn character varying,
			intitule_legende character varying,
			valeur_mini character varying,
			valeur_maxi character varying,
			valeur_texte character varying,
			fill character varying,
			stroke_rgb character varying,
			stroke_width character varying,
			font_familly character varying,
			font_size character varying,
			font_weight character varying,
			symbole character varying,
			id_symbole character varying,
			opacity character varying,
			fill_rule character varying,
			stroke_dasharray character varying,
			stroke_dashoffset character varying,
			ordre integer);
		ALTER TABLE admin_svg.col_theme OWNER TO ".$_POST['db_user'].";
		CREATE TABLE admin_svg. col_where (
			idtheme character varying,
			clause character varying);
		ALTER TABLE admin_svg.col_where OWNER TO ".$_POST['db_user'].";
		CREATE TABLE admin_svg.commune (
			gid integer,
			source character varying,
			nom character varying,
			idcommune character varying(6),
			statut character varying,
			canton character varying,
			arrond character varying,
			depart character varying,
			region character varying,
			population bigint,
			multi_cant character varying,
			enveloppe public.geometry,
			logo character varying,
			larg_logo character varying,
			xma character varying,
			xmi character varying,
			yma character varying,
			ymi character varying,
			tel_urba character varying,
			horaire_urba character varying,
			plu_pos character varying,
			approb character varying,
			modif character varying,
			idagglo character varying DEFAULT 770000);
		SELECT addgeometrycolumn('admin_svg','commune','the_geom',-1,'MULTYPOLYGON',2);
		ALTER TABLE admin_svg.commune OWNER TO ".$_POST['db_user'].";
		CREATE UNIQUE INDEX ndx_commune_insee ON admin_svg.commune USING btree (idcommune);
		ALTER INDEX admin_svg.ndx_commune_insee OWNER TO ".$_POST['db_user'].";
		CREATE TABLE admin_svg.style (
			idstyle character varying DEFAULT nextval('admin_svg.styl'::text) NOT NULL,
			idtheme character varying,
			idutilisateur character varying(10),
			fill character varying,
			stroke_rgb character varying,
			stroke_width character varying,
			font_familly character varying,
			font_size character varying,
			font_weight character varying,
			symbole character varying,
			id_symbole character varying,
			opacity character varying,
			fill_rule character varying,
			stroke_dasharray character varying,
			stroke_dashoffset character varying);
		ALTER TABLE admin_svg.style OWNER TO ".$_POST['db_user'].";
		ALTER TABLE ONLY admin_svg.style ADD CONSTRAINT pk_styl PRIMARY KEY (idstyle);
		ALTER INDEX admin_svg.pk_styl OWNER TO ".$_POST['db_user'].";
		CREATE TABLE admin_svg.theme (
			idtheme character varying DEFAULT nextval('admin_svg.them'::text) NOT NULL,
			libelle_them character varying,
			schema character varying,
			tabl character varying,
			raster character varying,
			partiel character varying,
			vu_initial character varying,
			couch_tjs_visible character varying,
			zoommin integer,
			zoommax integer,
			zoommax_raster character varying,
			vu_anonyme boolean DEFAULT false,
			groupe character varying,
			force_chargement character varying DEFAULT 0);
		ALTER TABLE admin_svg.theme OWNER TO ".$_POST['db_user'].";
		ALTER TABLE ONLY admin_svg.theme ADD CONSTRAINT pk_theme PRIMARY KEY (idtheme);
		ALTER INDEX admin_svg.pk_theme OWNER TO ".$_POST['db_user'].";
		ALTER TABLE ONLY admin_svg.col_sel ADD CONSTRAINT fk_appthe FOREIGN KEY (idtheme) REFERENCES admin_svg.theme(idtheme);
		ALTER TABLE ONLY admin_svg.col_where ADD CONSTRAINT fk_appthe FOREIGN KEY (idtheme) REFERENCES admin_svg.theme(idtheme);
		CREATE TABLE admin_svg.utilisateur (
			idutilisateur character varying(10) NOT NULL,
			idcommune character varying(6),
			login character varying(25),
			psw character varying(10),
			droit character varying(2),
			nom character varying,
			prenom character varying);
		ALTER TABLE admin_svg.utilisateur OWNER TO ".$_POST['db_user'].";
		ALTER TABLE ONLY admin_svg.utilisateur ADD CONSTRAINT pk_util PRIMARY KEY (idutilisateur);
		ALTER INDEX admin_svg.pk_util OWNER TO ".$_POST['db_user'].";
		ALTER TABLE ONLY admin_svg.apputi ADD CONSTRAINT fk_util FOREIGN KEY (idutilisateur) REFERENCES admin_svg.utilisateur(idutilisateur);
		ALTER TABLE ONLY admin_svg. style ADD CONSTRAINT fk_appthe FOREIGN KEY (idtheme) REFERENCES admin_svg.theme(idtheme);
		ALTER TABLE ONLY admin_svg.style ADD CONSTRAINT fk_util FOREIGN KEY (idutilisateur) REFERENCES admin_svg.utilisateur(idutilisateur);
		CREATE TABLE admin_svg.temp_cotation (
		session_temp character varying,
		the_geom public.geometry,
		valeur character varying,
		\"type\" character varying
		);
		ALTER TABLE admin_svg.temp_cotation OWNER TO ".$_POST['db_user'].";
		CREATE TABLE admin_svg.incident (
		num integer NOT NULL,
		date_entrer character varying,
		email character varying,
		incident character varying,
		correction character varying,
		date_correction character varying
		);
		ALTER TABLE admin_svg.incident OWNER TO ".$_POST['db_user'].";
		CREATE SEQUENCE admin_svg.incident_num_seq
		INCREMENT BY 1
		NO MAXVALUE
		NO MINVALUE
		CACHE 1;
		ALTER TABLE admin_svg.incident_num_seq OWNER TO ".$_POST['db_user'].";
		ALTER SEQUENCE admin_svg.incident_num_seq OWNED BY admin_svg.incident.num;
		create function admin_svg.v_fixe(character varying) returns character varying language plpgsql as $_$declare 
		id alias for $1;
		chaine character varying:='1';
		begin
		if (id ='') then 
			chaine = '0';
		end if;
			return chaine;
		end;$_$;
		CREATE FUNCTION public.rd2dg(double precision) RETURNS double precision
		AS $_$declare
		rd alias for $1;
		dg double precision;
		begin
		dg=(180/3.14)*rd;
		return dg;
		end;$_$
		LANGUAGE plpgsql;
		ALTER FUNCTION public.rd2dg(double precision) OWNER TO ".$_POST['db_user'].";
		CREATE FUNCTION public.sinul(character varying, character varying) RETURNS character varying
		AS $_$declare
		cola alias for $1;
		cole alias for $2;
		col  character varying ;
		begin
		col=cola;
		if (cola is NULL) then
		col = cole;
		end if;
		return col;
		end;$_$
		LANGUAGE plpgsql;
		ALTER FUNCTION public.sinul(character varying, character varying) OWNER TO ".$_POST['db_user'].";
		CREATE FUNCTION public.sivide(character varying, character varying) RETURNS character varying
		AS $_$declare
		cola alias for $1;
		cole alias for $2;
		col  character varying ;
		begin
		col=cola;
		if (cola='') then
		col = cole;
		end if;
		return col;
		end;$_$
		LANGUAGE plpgsql;
		ALTER FUNCTION public.sivide(character varying, character varying) OWNER TO ".$_POST['db_user'].";
		CREATE FUNCTION public.supp_chr_spec(character varying) RETURNS character varying
		AS $_$declare
		ch1 alias for $1;
		ch2 character varying;
		begin
		ch2=replace(ch1,' ','_');
		ch2=replace(ch2,'é','e');
		ch2=replace(ch2,'è','e');
		ch2=replace(ch2,'ê','e');
		ch2=replace(ch2,'ô','o');
		ch2=replace(ch2,'ö','o');
		ch2=replace(ch2,'ë','e');
		ch2=replace(ch2,'ï','i');
		ch2=replace(ch2,'ä','a');
		ch2=replace(ch2,'à','a');
		ch2=replace(ch2,'â','a');
		ch2=replace(ch2,'û','u');
		ch2=replace(ch2,'î','i');
		ch2=replace(ch2,'ç','c');
		ch2=replace(ch2,'ù','u');
		return ch2;
		end;
		$_$
		LANGUAGE plpgsql;
		ALTER FUNCTION public.supp_chr_spec(character varying) OWNER TO ".$_POST['db_user'].";
		CREATE FUNCTION public.xy2geom(text, text, text, text, text) RETURNS text
		AS $_$declare
		schema_name alias for $1;
		table_name alias for $2;
		new_col alias for $3;
		column1_name alias for $4;
		column2_name alias for $5;
		begin
		execute 'select public.AddGeometryColumn('''||schema_name||''','''||table_name||''','''||new_col||''',-1,''POINT'',2)';
		execute 'update '||schema_name||'.'||table_name||' set '||new_col||'=geomfromtext(''POINT(''||'||column1_name||'||'' ''||'||column2_name||'||'')'',-1) where oid=oid';
		return 'good';
		end;
		$_$
		LANGUAGE plpgsql;
		ALTER FUNCTION public.xy2geom(text, text, text, text, text) OWNER TO ".$_POST['db_user'].";";
		//pg_exec($connect,$qq);
	//création administrateur Gismeaux
		$q="insert into admin_svg.utilisateur (idutilisateur,login,psw,droit,idcommune) values(nextval('admin_svg.util'),'".$_POST["form_user"]."','".$_POST["form_pass"]."','AD','".$_POST["ad_commune"]."')";
		//pg_exec($connect,$q);
	//identification Gismeaux
		include_once("auth.php");
	//header vers config.php
		header('Location: ./configuration.php');
	}else{
		$pdb_host=$_POST['db_host'];
		$pdb_user=$_POST['db_user'];
		$pdb_passwd=$_POST['db_passwd'];
		$pdb_name=$_POST['db_name'];
		echo "Erreur dans les paramètres de connexion à postgrèSQL<br>";
	}
}else{
	//déclaration de variable par defaut
	$pdb_host='localhost';
	$pdb_user='postgres';
	$pdb_passwd='postgres';
	$pdb_name='MaBase';
}
echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <title></title>
  <meta name="GENERATOR" content="Quanta Plus">
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>';
echo '<FORM action="install.php" method="POST">';
/*$filnam="./config/db.local.php.def";
$resu=file_get_contents($filnam,"FILE_TEXT",null,7);
$resu=substr($resu,strpos($resu,"{")+1,strpos($resu,"}")-strpos($resu,"{")-1);
$resu= str_replace("var $","",$resu);
$resu=str_replace("'","",$resu);
$resu=str_replace(";","&",$resu);
$resu=str_replace(" ","",$resu);
parse_str($resu,$rt);*/
echo "Configuration accès PostgrèSQL"."<br>";
echo "<table border=\"2\" >";
echo "<tr><td>host de la base</td><td><INPUT type=\"text\" name=\"db_host\" value=\"".$pdb_host."\" size=\"20\"></td></tr>";
echo "<tr><td>utilisateur</td><td><INPUT type=\"text\" name=\"db_user\" value=\"".$pdb_user."\" size=\"20\"></td></tr>";
echo "<tr><td>mot de passe</td><td><INPUT type=\"text\" name=\"db_passwd\" value=\"".$pdb_passwd."\" size=\"20\"></td></tr>";
echo "<tr><td>nom de la base</td><td><INPUT type=\"text\" name=\"db_name\" value=\"".$pdb_name."\" size=\"20\"></td></tr>";
echo "</table>";
echo "<br>";
echo "<br>";
echo "Super utilisateur de Gismeaux"."<br>";
echo "<table border=\"2\" >";
echo "<tr><td>login</td><td><INPUT type=\"text\" name=\"form_user\" value=\"\" size=\"20\"></td></tr>";
echo "<tr><td>mot de passe</td><td><INPUT type=\"text\" name=\"form_pass\" value=\"\" size=\"20\"></td></tr>";
echo "<tr><td>code commune</td><td><INPUT type=\"text\" name=\"ad_commune\" value=\"\" size=\"20\" alt=\"departement+0+code insee de la commune\"></td></tr>";
echo "<tr><td>email</td><td><INPUT type=\"text\" name=\"ad_email\" value=\"\" size=\"20\"></td></tr>";
echo "</table>";
echo "<br>";
echo "<br>";

echo "<INPUT type=\"submit\" value=\"enregistrer\">";
echo '</FORM>';
echo '</body>
</html>';
?>
