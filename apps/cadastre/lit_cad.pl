#!/usr/bin/perl
# Paramétrage minimal...
die "Usage : lit_cad.pl <répertoire source> <extension>\n" if ($ARGV >= 1);

$dirbase=@ARGV[0];
$ext=@ARGV[1];
opendir (IN, $dirbase) || die "$dirbase n'est pas un répertoire valide\n";
@liste = readdir( IN);
	foreach (@liste) {
		push(@thf, $_) if (/.$ext$/);
	}
die "$dirbase ne contient pas de fichier cadastraux\n" if ($#thf < 0);
$v='","';
#traitement du fichier non bati (parcelle)
open(THF, "$dirbase/REVNBAT.$ext") || die "Ouverture de $dirbase/REVNBAT.$ext impossible\n";
open(parc, ">$dirbase/parcelle.csv");
open(p_sub, ">$dirbase/p_subdif.csv");
open(p_exo, ">$dirbase/p_exoner.csv");
open(p_tax, ">$dirbase/p_taxat.csv");
while(<THF>) {
	$code_commune=substr($_,0,6);
	$ccosec=substr($_,9,2);
	$ccosec=~ s/^\s+//g;
	$ccosec=substr("00".$ccosec,-2,2);
	$dnupla=substr($_,11,4);
	$cenr=substr($_,19,2);
	if ($cenr==10){
		$dcntpa=int(substr($_,21,9));
		$dsrpar=substr($_,30,1);
		$dnupro=substr($_,31,6);
		$jdata=substr($_,37,8);
		$dreflf=ch_vide(substr($_,45,5));
		$gpdl=substr($_,50,1);
		$cprsecr=ch_vide(substr($_,51,3));
		$ccosecr=ch_vide(substr($_,54,2));
		$dnuplar=ch_vide(substr($_,56,4));
		$dnupdl=ch_vide(substr($_,60,3));
		$gurbpa=substr($_,63,1);
		$dparpi=ch_vide(substr($_,64,4));
		$ccoarp=substr($_,68,1);
		$gparnf=substr($_,69,1);
		$gparbat=substr($_,70,1);
		$parrev=substr($_,71,12);
		$gpardp=substr($_,83,1);
		$fviti=substr($_,84,1);
		$dnvoiri=ch_vide(substr($_,85,4));
		$dindic=ch_vide(substr($_,89,1));
		$ccovoi=substr($_,90,5);
		$ccoriv=substr($_,95,4);
		$ccocif=substr($_,99,4);
		$gpafpd=substr($_,103,1);
		$comma10="\"$code_commune$v$ccosec$v$dnupla$v$dcntpa$v$dsrpar$v".substr($dnupro,0,1).$v.substr($dnupro,1)."$v$jdata\",$dreflf,\"$gpdl\",$cprsecr,$ccosecr,$dnuplar,$dnupdl,\"$gurbpa\",$dparpi,\"$ccoarp$v$gparnf$v$gparbat\",$dnvoiri,$dindic,\"$ccovoi$v$ccoriv$v$ccocif$v$ccosec".int($dnupla)."$v$dnupro$v".substr($code_commune,3,3)."000".$ccosec.$dnupla."\"\n";
		print parc $comma10;
	}elsif ($cenr==21){
		$ccosub=ch_vide(substr($_,15,2));
		$dcntsf=int(substr($_,21,9));
		$dnupro=substr($_,30,6);
		$gnexps=ch_vide(substr($_,36,2));
		$drcsub=int(substr($_,38,10));
		$drcsuba=int(substr($_,48,10));
		$ccostn=substr($_,58,1);
		$cgmum=substr($_,59,2);
		$dsgrpf=substr($_,61,2);
		$dclssf=substr($_,63,2);
		$cnatsp=ch_vide(substr($_,65,5));
		$drgpos=substr($_,70,1);
		$ccoprel=substr($_,71,3);
		$ccosecl=substr($_,74,2);
		$dnuplal=substr($_,76,4);
		$dnupdl=substr($_,80,3);
		$dnulot=substr($_,83,7);
		$rclsi=substr($_,90,46);
		$gnidom=substr($_,136,1);
		$topja=substr($_,137,1);
		$datja=substr($_,138,8);
		$postel=substr($_,146,1);
		$comma21="\"$code_commune$v$ccosec$v$dnupla\",$ccosub,\"$dcntsf$v".substr($dnupro,0,1).$v.substr($dnupro,1)."\",$gnexps,\"$drcsub$v$drcsuba\",\"$ccostn$v$cgmum$v$dsgrpf$v$dclssf\",$cnatsp,\"$drgpos\",".ch_vide($ccoprel).",".ch_vide($ccosecl).",".ch_vide($dnuplal).",".ch_vide($dnupdl).",".ch_vide($dnulot).",\"$topja$v$datja$v$postel\"\n";
		print p_sub $comma21;
	}elsif ($cenr==30){
		$ccosub=substr($_,15,2);
		$muexn=substr($_,17,2);
		$vecexn=int(substr($_,21,10));
		$ccolloc=substr($_,31,2);
		$pexn=substr($_,33,5);
		$gnexts=substr($_,38,2);
		$jandeb=substr($_,40,4);
		$jfinex=substr($_,44,4);
		$fcexn=substr($_,48,10);
		$fcexna=substr($_,58,10);
		$rcexna=substr($_,68,10);
		$rcexnba=int(substr($_,78,10))/100;
		$mpexnba=substr($_,89,10);
		$comma30="\"$code_commune$v$ccosec$v$dnupla\",".ch_vide($ccosub).",\"$muexn$v$vecexn$v$ccolloc$v$pexn$v$gnexts$v$jandeb$v$jfinex$v$rcexnba\"\n";
		print p_exo $comma30;
	}elsif ($cenr==36){
		$ccosub=substr($_,15,2);
		$majposac=int(substr($_,22,10))/100;
		$bisufadc=int(substr($_,33,10))/100;
		$majposad=int(substr($_,44,10))/100;
		$bisufadd=int(substr($_,55,10))/100;
		$majposar=int(substr($_,66,10))/100;
		$bisufadr=int(substr($_,77,10))/100;
		$majposagc=int(substr($_,88,10))/100;
		$bisufadgc=int(substr($_,99,10))/100;
		$comma36="\"$code_commune$v$ccosec$v$dnupla$v$ccosub$v$majposac$v$bisufadc$v$majposad$v$bisufadd$v$majposar$v$bisufadr$v$majposagc$v$bisufadgc\"\n";
		print p_tax $comma36;
	}
#print "$code_commune;$ccosec;$dnupla;$cenr";
}
close(parc);
close(p_sub);
close(p_exo);
close(p_tax);
close(thf);
#traitement des batiments
open(THF, "$dirbase/REVBATI.$ext") || die "Ouverture de $dirbase/REVBATI.$ext impossible\n";
open(batidgi, ">$dirbase/batidgi.csv");
open(b_desdgi, ">$dirbase/bdesdgi.csv");
open(b_exodgi, ">$dirbase/bexodgi.csv");
open(b_taxdgi, ">$dirbase/btaxdgi.csv");
open(b_habdgi, ">$dirbase/bhabdgi.csv");
open(b_prodgi, ">$dirbase/bprodgi.csv");
open(b_subdgi, ">$dirbase/bsubdgi.csv");
open(b_depdgi, ">$dirbase/bdepdgi.csv");
while(<THF>) {
	$code_commune=substr($_,0,6);
		$code_commune=~ s/\s+$//g;
	$invar=substr($_,6,10);
	$cenr=substr($_,30,2); 
	if ($cenr eq "00"){
		$ccopre=substr($_,35,3);
		$ccosec=substr($_,38,2);
		$ccosec=~ s/^\s+//g;
		$ccosec=substr("00".$ccosec,-2,2);
		$dnupla=substr($_,40,4);
		$dnubat=substr($_,45,2);
		$desca=substr($_,47,2);
		$dniv=substr($_,49,2);
		$dpor=substr($_,51,5);
		$ccoriv=substr($_,56,4);
		$ccovoi=substr($_,61,5);
		$dnvoiri=substr($_,66,4);
		$dindic=substr($_,70,1);
		$ccocif=substr($_,71,4);
		$dvoilib=substr($_,75,30);
		$dvoilib=~ s/\'/\'\'/g;
		$dvoilib=~ s/\ +$//g;
		$comma00="\"$code_commune$v$invar\",".ch_vide($ccopre).",\"$ccosec$v$dnupla$v$dnubat$v$desca$v$dniv$v$dpor$v$ccoriv$v$ccovoi$v$dnvoiri$v$dindic$v$ccocif$v$dvoilib\"\n";
		print batidgi $comma00;
	}elsif ($cenr eq "10"){
		$gpdl=substr($_,35,1);
		$dsrpar=substr($_,36,1);
		$dnupro=substr($_,37,6);
		$jdata=substr($_,43,8);
		$dnufnl=substr($_,51,6);
		$ccoeva=substr($_,57,1);
		$ccitlv=substr($_,58,1);
		$dteloc=substr($_,59,1);
		$gtauom=substr($_,60,2);
		$dcomrd=substr($_,62,3);
		$ccoplc=substr($_,65,1);
		$cconlc=substr($_,66,2);
		$dvltrt=substr($_,68,9);
		$ccoape=substr($_,77,4);
		$cc48lc=substr($_,81,2);
		$dloy48a=substr($_,83,9);
		$top48=substr($_,92,1);
		$dnatic=substr($_,93,1);
		$dnupas=substr($_,94,8);
		$gnexcf=substr($_,102,2);
		$dtaucf=substr($_,104,3);
		$cchpr=substr($_,107,1);
		$jannat=substr($_,108,4);
		$dnbniv=substr($_,112,2);
		$hmsem=substr($_,114,1);
		$postel=substr($_,115,1);
		$dnatcg=substr($_,116,2);
		$jdatcgl=substr($_,118,8);
		$dnutbx=substr($_,126,6);
		$dvltla=substr($_,132,9);
		$janloc=substr($_,141,4);
		$ccsloc=substr($_,145,2);
		$fburx=substr($_,147,1);
		$gimtom=substr($_,148,1);
		$cbtabt=substr($_,149,2);
		$jdtabt=substr($_,151,4);
		$jrtabt=substr($_,155,4);
		$comma10="\"$code_commune$v$invar$v$gpdl$v$dsrpar$v$dnupro$v$jdata\",".ch_vide($dnufnl).",\"$ccoeva$v$dteloc$v$gtauom$v$dcomrd$v$ccoplc$v$cconlc$v".int($dvltrt)."\",".ch_vide($ccoape).",".ch_vide($cc48lc).",".ch_vide($dloy48a).",\"$top48$v$dnatic$v$cchpr$v$jannat$v$dnbniv\",".ch_vide($hmsem).",\"$postel$v$cbtabt$v$jdtabt$v$jrtabt\"\n";
		print b_desdgi $comma10;
	}elsif ($cenr eq "21"){
		$dnupev=substr($_,27,3);
		$ccoaff=substr($_,35,1);
		$ccostb=substr($_,36,1);
		$dcapec=substr($_,37,2);
		$dcetlc=substr($_,39,3);
		$dcsplc=substr($_,42,3);
		$dsupot=substr($_,45,6);
		$dvlper=substr($_,51,9);
		$dvlpera=substr($_,60,9);
		$gnexpl=substr($_,69,2);
		$libocc=substr($_,71,30);
		$ccthp=substr($_,101,1);
		$retimp=substr($_,102,1);
		$dnuref=substr($_,103,3);
		$rclsst=substr($_,106,32);
		$gnidom=substr($_,138,1);
		$dcsglc=substr($_,139,3);
		$ccogrb=substr($_,142,1);
		$cocdi=substr($_,143,4);
		$cosatp=substr($_,147,3);
		$gsatp=substr($_,150,1);
		$clocv=substr($_,151,1);
		$dvltpe=substr($_,152,9);
		$dcralc=substr($_,161,3);
		$comma21="\"$code_commune$v$invar$v$dnupev$v$ccoaff$v$ccostb$v$dcapec$v$dcetlc$v$dcsplc$v".int($dsupot).$v.int($dvlper).$v.int($dvlpera)."$v$gnexpl$v$ccthp$v$retimp$v$dnuref$v$gnidom$v$dcsglc$v".int($dvltpe)."$v$dcralc\"\n";
		print b_subdgi $comma21;
	}elsif ($cenr eq "30"){
		$dnupev=substr($_,27,3);
		$janbil=substr($_,23,4);
		$dnuord=substr($_,32,3);
		$ccolloc=substr($_,35,2);
		$pexb=substr($_,37,5);
		$gnextl=substr($_,42,2);
		$jandeb=substr($_,44,4);
		$janimp=substr($_,48,4);
		$dvldif2=substr($_,102,9);
		$dvldif2a=substr($_,112,9);
		$fcexb2=substr($_,122,9);
		$fcexba2=substr($_,132,9);
		$rcexba2=substr($_,142,9);
		$comma30="\"$code_commune$v$invar$v$dnupev$v$dnuord$v$ccolloc$v$pexb$v$gnextl$v$jandeb$v$janimp$v".int($dvldif2).$v.int($dvldif2a).$v.int($fcexb2).$v.int($fcexba2).$v.int($rcexba2)."\"\n";
		print b_exodgi $comma30;
	}elsif ($cenr eq "36"){
		$dnupev=substr($_,27,3);
		$janbil=substr($_,23,4);
		$lbaic=substr($_,35,9);
		$vlbaiac=substr($_,45,9);
		$bipeviac=substr($_,55,9);
		$vlbaid=substr($_,65,9);
		$vlbaiad=substr($_,75,9);
		$bipeviad=substr($_,85,9);
		$vlbair=substr($_,95,9);
		$vlbaiar=substr($_,105,9);
		$bipeviar=substr($_,115,9);
		$vlbaigc=substr($_,125,9);
		$vlbaiagc=substr($_,135,9);
		$bipeviagc=substr($_,145,9);
		$comma36="\"$code_commune$v$invar$v$dnupev$v".int($vlbaic).$v.int($vlbaiac).$v.int($bipeviac).$v.int($vlbaid).$v.int($vlbaiad).$v.int($bipeviad).$v.int($vlbair).$v.int($vlbaiar).$v.int($bipeviar).$v.int($vlbaigc).$v.int($vlbaiagc).$v.int($bipeviagc)."\"\n";
		print b_taxdgi $comma36;
	}elsif ($cenr eq "40"){
		$dnupev=substr($_,27,3);
		$dnudes=substr($_,32,3);
		$cconadga=substr($_,35,2);
		$dsueicga=substr($_,37,6);
		$dcimei=substr($_,43,2);
		$cconadcv=substr($_,45,2);
		$dsueiccv=substr($_,47,6);
		$dcimeicv=substr($_,53,2);
		$cconadgr=substr($_,55,2);
		$dsueicgr=substr($_,57,6);
		$dcimeia=substr($_,63,2);
		$cconadtr=substr($_,65,2);
		$dsueictr=substr($_,67,6);
		$dcimeitr=substr($_,73,2);
		$geaulc=substr($_,75,1);
		$gelelc=substr($_,76,1);
		$gesclc=substr($_,77,1);
		$ggazlc=substr($_,78,1);
		$gasclc=substr($_,79,1);
		$gchclc=substr($_,80,1);
		$gvorlc=substr($_,81,1);
		$gteglc=substr($_,82,1);
		$dnbbai=substr($_,83,2);
		$dnbdou=substr($_,85,2);
		$dnblav=substr($_,87,2);
		$dnbwc=substr($_,89,2);
		$deqdha=substr($_,91,3);
		$dnbppr=substr($_,94,2);
		$dnbsam=substr($_,96,2);
		$dnbcha=substr($_,98,2);
		$dnbcu8=substr($_,100,2);
		$dnbcu9=substr($_,102,2);
		$dnbsea=substr($_,104,2);
		$dnbann=substr($_,106,2);
		$dnbpdc=substr($_,108,2);
		$dsupdc=substr($_,110,6);
		$dmatgm=substr($_,116,2);
		$dmatto=substr($_,118,2);
		$jannat=substr($_,120,4);
		$detent=substr($_,124,1);
		$dnbniv=substr($_,125,2);
		$comma40="\"$code_commune$v$invar$v$dnupev$v$dnudes$v$cconadga$v".int($dsueicga).$v.int($dcimei)."$v$cconadcv$v".int($dsueiccv).$v.int($dcimeicv)."$v$cconadgr$v".int($dsueicgr).$v.int($dcimeia)."$v$cconadtr$v".int($dsueictr).$v.int($dcimeitr)."$v$geaulc$v$gelelc$v$gesclc$v$ggazlc$v$gasclc$v$gchclc$v$gvorlc$v$gteglc$v$dnbbai$v$dnbdou$v$dnblav$v$dnbwc$v".int($deqdha)."$v$dnbppr$v$dnbsam$v$dnbcha$v$dnbcu8$v$dnbcu9$v$dnbsea$v$dnbann$v$dnbpdc$v".int($dsupdc)."$v$dmatgm$v$dmatto$v$jannat$v$detent$v$dnbniv\"\n";
		print b_habdgi $comma40;
	}elsif ($cenr eq "50"){
		$dnupev=substr($_,27,3);
		$dnudes=substr($_,32,3);
		$vsupot=substr($_,35,9);
		$vsurz1=substr($_,44,9);
		$vsurz2=substr($_,53,9);
		$vsurz3=substr($_,62,9);
		$vsurzt=substr($_,71,9);
		$vsurb1=substr($_,81,9);
		$vsurb2=substr($_,90,9);
		$comma50="\"$code_commune$v$invar$v$dnupev$v$dnudes$v".int($vsurzt)."\"\n";
		print b_prodgi $comma50;
	}elsif ($cenr eq "60"){
		$dnupev=substr($_,27,3);
		$dnudes=substr($_,32,3);
		$dsudep=substr($_,35,6);
		$cconad=substr($_,41,2);
		$asitet=substr($_,43,6);
		$dmatgm=substr($_,49,2);
		$dmatto=substr($_,51,2);
		$detent=substr($_,53,1);
		$geaulc=substr($_,54,1);
		$gelelc=substr($_,55,1);
		$gchclc=substr($_,56,1);
		$dnbbai=substr($_,57,2);
		$dnbdou=substr($_,59,2);
		$dnblav=substr($_,61,2);
		$dnbwc=substr($_,63,2);
		$deqtlc=substr($_,65,3);
		$dcimlc=substr($_,68,2);
		$dcetde=substr($_,70,3);
		$dcspde=substr($_,73,3);
		$comma60="\"$code_commune$v$invar$v$dnupev$v$dnudes$v".int($dsudep)."$v$cconad$v$asitet$v$dmatgm$v$dmatto$v$detent$v$geaulc$v$gelelc$v$gchclc$v$dnbbai$v$dnbdou$v$dnblav$v$dnbwc$v$deqtlc$v$dcimlc$v$dcetde$v$dcspde\"\n";
		print b_depdgi $comma60;
	}
}
close(batidgi);
close(b_desdgi);
close(b_exodgi);
close(b_taxdgi);
close(b_habdgi);
close(b_prodgi);
close(b_subdgi);
close(b_depdgi);
close(thf);
#traitement du fichier des propriétaires
open(THF, "$dirbase/REVPROP.$ext") || die "Ouverture de $dirbase/REVPROP.$ext impossible\n";
open(prop, ">$dirbase/propriet.csv");
while (<THF>) {
	$code_commune=substr($_,0,6);
	$cgroup=substr($_,6,1);
	$dnumcp=substr($_,7,5);
	$dnulp=substr($_,12,2);
	$ccocif=substr($_,14,4);
	$dnuper=substr($_,18,6);
	$ccodro=substr($_,24,1);
	$ccodem=substr($_,25,1);
	$gdesip=substr($_,26,1);
	$gtoper=substr($_,27,1);
	$ccoqua=substr($_,28,1);
	$gnexcf=substr($_,29,2);
	$dtaucf=substr($_,31,3);
	$dnatpr=substr($_,34,3);
	$ccogrm=substr($_,37,2);
	$dsglpm=substr($_,39,10);
	$dforme=substr($_,49,7);
	$ddenom=substr($_,56,60);
	#$ddenom=~ s/\'/\'\'/g;
	$ddenom=~ s/\ +$//g;
	$dlign3=substr($_,120,30);
	#$dlign3=~ s/\'/\'\'/g;
	$dlign3=~ s/\ +$//g;
	$dlign4=substr($_,150,36);
	#$dlign4=~ s/\'/\'\'/g;
	$dlign4=~ s/\ +$//g;
	$dlign5=substr($_,186,30);
	#$dlign5=~ s/\'/\'\'/g;
	$dlign5=~ s/\ +$//g;
	$dlign6=substr($_,216,32);
	#$dlign6=~ s/\'/\'\'/g;
	$dlign6=~ s/\ +$//g;
	$ccopay=substr($_,248,3);
	#$ccopay=~ s/\'/\'\'/g;
	$dqualp=substr($_,286,3);
	$dnomlp=substr($_,289,30);
	#$dnomlp=~ s/\'/\'\'/g;
	$dprnlp=substr($_,319,15);
	#$dprnlp=~ s/\'/\'\'/g;
	$jdatnss=substr($_,334,10);
	$dldnss=substr($_,344,58);
	#$dldnss=~ s/\'/\'\'/g;
	$dldnss=~ s/\ +$//g;
	$epxnee=substr($_,402,3);
	$dnomcp=substr($_,405,30);
	#$dnomcp=~ s/\'/\'\'/g;
	$dprncp=substr($_,435,15);
	#$dprncp=~ s/\'/\'\'/g;
	$dsiren=substr($_,466,10);
	$comma="\"$code_commune$v$cgroup$v$dnumcp$v$dnulp$v$ccocif$v$dnuper$v$ccodro$v$ccodem$v$gdesip$v$gtoper$v$ccoqua\",".ch_vide($dnatpr).",\"$ccogrm\",".ch_vide($dsglpm).",".ch_vide($dforme).",\"$ddenom$v$dlign3$v$dlign4$v$dlign5$v$dlign6$v$ccopay\",".ch_vide($dqualp).",".ch_vide($dnomlp).",".ch_vide($dprnlp).",\"$jdatnss$v$dldnss$v$epxnee\",".ch_vide($dnomcp).",".ch_vide($dprncp).",\"$dsiren$v$cgroup$dnumcp\"\n";
	if ($cgroup =~ /[+*A-Z]/){
		print prop $comma;
	}
}
close(prop);
close(thf);
#traitement du fichier des rues
open(THF, "$dirbase/TOPFANR.$ext") || die "Ouverture de $dirbase/TOPFANR.$ext impossible\n";
open(fant, ">$dirbase/fantoir.csv");
while (<THF>) {
	$code_commune=substr($_,0,6);
	$code=substr($_,6,4);
	$nat=substr($_,11,4);
	$lib=substr($_,15,26);
	$lib=~ s/\'/\'\'/g;;
	$caract=substr($_,48,1);
	$typ=substr($_,108,1);
	if ($code!=""){
		if ($nat eq "AER "){$libel="Aérodrome ";}
		elsif ($nat eq "AERG"){$libel="Aérogare ";}
		elsif ($nat eq "AGL "){$libel="Agglomération ";}
		elsif ($nat eq "ALL "){$libel="Allée ";}
		elsif ($nat eq "ACH "){$libel="Ancien chemin ";}
		elsif ($nat eq "ART "){$libel="Ancienne route ";}
		elsif ($nat eq "ANGL"){$libel="Angle ";}
		elsif ($nat eq "ARC "){$libel="Arcade ";}
		elsif ($nat eq "AUT "){$libel="Autoroute  ";}
		elsif ($nat eq "AV  "){$libel="Avenue ";}
		elsif ($nat eq "BRE "){$libel="Barrière ";}
		elsif ($nat eq "BSN "){$libel="Bassin ";}
		elsif ($nat eq "BER "){$libel="Berge ";}
		elsif ($nat eq "BD  "){$libel="Boulevard ";}
		elsif ($nat eq "BRG "){$libel="Bourg ";}
		elsif ($nat eq "BRTL"){$libel="Bretelle ";}
		elsif ($nat eq "CALL"){$libel="Calle, callada  ";}
		elsif ($nat eq "CAMI"){$libel="Camin ";}
		elsif ($nat eq "CPG "){$libel="Camping ";}
		elsif ($nat eq "CAN "){$libel="Canal ";}
		elsif ($nat eq "CAR "){$libel="Carrefour ";}
		elsif ($nat eq "CAE "){$libel="Carriera ";}
		elsif ($nat eq "CARE"){$libel="Carrière ";}
		elsif ($nat eq "CASR"){$libel="Caserne ";}
		elsif ($nat eq "CTRE"){$libel="Centre ";}
		elsif ($nat eq "CHP "){$libel="Champ ";}
		elsif ($nat eq "CHA "){$libel="Chasse ";}
		elsif ($nat eq "CHT "){$libel="Chateau ";}
		elsif ($nat eq "CHS "){$libel="Chaussée ";}
		elsif ($nat eq "CHE "){$libel="Chemin ";}
		elsif ($nat eq "CHEM"){$libel="Cheminement ";}
		elsif ($nat eq "CC  "){$libel="Chemin communal ";}
		elsif ($nat eq "CD  "){$libel="Chemin départemental ";}
		elsif ($nat eq "CR  "){$libel="Chemin rural ";}
		elsif ($nat eq "CF  "){$libel="Chemin forestier ";}
		elsif ($nat eq "CHV "){$libel="Chemin vicinal ";}
		elsif ($nat eq "CTR "){$libel="Contour ";}
		elsif ($nat eq "COR "){$libel="Corniche ";}
		elsif ($nat eq "CORO"){$libel="Coron ";}
		elsif ($nat eq "CLR "){$libel="Couloir ";}
		elsif ($nat eq "CRS "){$libel="Cours ";}
		elsif ($nat eq "CIVE"){$libel="Coursive ";}
		elsif ($nat eq "CRX "){$libel="Croix ";}
		elsif ($nat eq "DARS"){$libel="Darse ";}
		elsif ($nat eq "DSC "){$libel="Descente ";}
		elsif ($nat eq "DEVI"){$libel="Déviation ";}
		elsif ($nat eq "DIG "){$libel="Digue ";}
		elsif ($nat eq "DOM "){$libel="Domaine ";}
		elsif ($nat eq "DRA "){$libel="Draille ";}
		elsif ($nat eq "ECA "){$libel="Ecart ";}
		elsif ($nat eq "ECL "){$libel="Ecluse ";}
		elsif ($nat eq "EMBR"){$libel="Embranchement ";}
		elsif ($nat eq "EMP "){$libel="Emplacement ";}
		elsif ($nat eq "ENV "){$libel="Enclave ";}
		elsif ($nat eq "ENC "){$libel="Enclos ";}
		elsif ($nat eq "ESC "){$libel="Escalier ";}
		elsif ($nat eq "ESPA"){$libel="Espace ";}
		elsif ($nat eq "ESP "){$libel="Esplanade ";}
		elsif ($nat eq "ETNG"){$libel="Etang ";}
		elsif ($nat eq "FG  "){$libel="Faubourg ";}
		elsif ($nat eq "FRM "){$libel="Ferme ";}
		elsif ($nat eq "FD  "){$libel="Fond ";}
		elsif ($nat eq "FON "){$libel="Fontaine ";}
		elsif ($nat eq "FOR "){$libel="Forêt ";}
		elsif ($nat eq "FOS "){$libel="Fosse ";}
		elsif ($nat eq "GAL "){$libel="Galerie ";}
		elsif ($nat eq "GBD "){$libel="Grand boulevard ";}
		elsif ($nat eq "GPL "){$libel="Grand place ";}
		elsif ($nat eq "GR  "){$libel="Grande rue ";}
		elsif ($nat eq "GREV"){$libel="Grêve ";}
		elsif ($nat eq "HAB "){$libel="Habitation ";}
		elsif ($nat eq "HLG "){$libel="Halage ";}
		elsif ($nat eq "HLE "){$libel="Halle ";}
		elsif ($nat eq "HAM "){$libel="Hameau ";}
		elsif ($nat eq "HTR "){$libel="Hauteur ";}
		elsif ($nat eq "HIP "){$libel="Hippodrome ";}
		elsif ($nat eq "IMP "){$libel="Impasse ";}
		elsif ($nat eq "JARD"){$libel="Jardin ";}
		elsif ($nat eq "JTE "){$libel="Jetée ";}
		elsif ($nat eq "LEVE"){$libel="Levée ";}
		elsif ($nat eq "LIGN"){$libel="Ligne ";}
		elsif ($nat eq "LOT "){$libel="Lotissement ";}
		elsif ($nat eq "MAIS"){$libel="Maison ";}
		elsif ($nat eq "MAR "){$libel="Marché ";}
		elsif ($nat eq "MRN "){$libel="Marina ";}
		elsif ($nat eq "MTE "){$libel="Montée ";}
		elsif ($nat eq "MNE "){$libel="Morne ";}
		elsif ($nat eq "NTE "){$libel="Nouvelle route ";}
		elsif ($nat eq "PKG "){$libel="Parking ";}
		elsif ($nat eq "PRV "){$libel="Parvis ";}
		elsif ($nat eq "PAS "){$libel="Passage ";}
		elsif ($nat eq "PLE "){$libel="Passerelle ";}
		elsif ($nat eq "PCH "){$libel="Petit chemin ";}
		elsif ($nat eq "PTA "){$libel="Petite allée ";}
		elsif ($nat eq "PAE "){$libel="Petite avenue ";}
		elsif ($nat eq "PRT "){$libel="Petite route ";}
		elsif ($nat eq "PTR "){$libel="Petite rue ";}
		elsif ($nat eq "PHAR"){$libel="Phare ";}
		elsif ($nat eq "PIST"){$libel="Piste ";}
		elsif ($nat eq "PLA "){$libel="Placa ";}
		elsif ($nat eq "PL  "){$libel="Place ";}
		elsif ($nat eq "PTTE"){$libel="Placette ";}
		elsif ($nat eq "PLCI"){$libel="Placis ";}
		elsif ($nat eq "PLAG"){$libel="Plage ";}
		elsif ($nat eq "PLN "){$libel="Plaine ";}
		elsif ($nat eq "PLT "){$libel="Plateau ";}
		elsif ($nat eq "PNT "){$libel="Pointe ";}
		elsif ($nat eq "PCHE"){$libel="Porche ";}
		elsif ($nat eq "PTE "){$libel="Porte ";}
		elsif ($nat eq "POST"){$libel="Poste ";}
		elsif ($nat eq "POT "){$libel="Poterne ";}
		elsif ($nat eq "PROM"){$libel="Promenade ";}
		elsif ($nat eq "QUA "){$libel="Quartier ";}
		elsif ($nat eq "RAC "){$libel="Raccourci ";}
		elsif ($nat eq "RPE "){$libel="Rampe ";}
		elsif ($nat eq "RVE "){$libel="Ravine ";}
		elsif ($nat eq "REM "){$libel="Rempart ";}
		elsif ($nat eq "RES "){$libel="Résidence ";}
		elsif ($nat eq "ROC "){$libel="Rocade ";}
		elsif ($nat eq "RPT "){$libel="Rond-point ";}
		elsif ($nat eq "RTD "){$libel="Rotonde ";}
		elsif ($nat eq "RTE "){$libel="Route ";}
		elsif ($nat eq "D   "){$libel="Route départementale ";}
		elsif ($nat eq "N   "){$libel="Route nationale ";}
		elsif ($nat eq "RLE "){$libel="Ruelle ";}
		elsif ($nat eq "RULT"){$libel="Ruellette ";}
		elsif ($nat eq "RUET"){$libel="Ruette ";}
		elsif ($nat eq "RUIS"){$libel="Ruisseau ";}
		elsif ($nat eq "SEN "){$libel="Sentier ";}
		elsif ($nat eq "SQ  "){$libel="Square ";}
		elsif ($nat eq "STDE"){$libel="Stade ";}
		elsif ($nat eq "TRN "){$libel="Terrain ";}
		elsif ($nat eq "TSSE"){$libel="Terrasse ";}
		elsif ($nat eq "TER "){$libel="Terre ";}
		elsif ($nat eq "TPL "){$libel="Terre-plein ";}
		elsif ($nat eq "TRT "){$libel="Tertre ";}
		elsif ($nat eq "TRAB"){$libel="Traboule ";}
		elsif ($nat eq "TRA "){$libel="Traverse ";}
		elsif ($nat eq "TUN "){$libel="Tunnel ";}
		elsif ($nat eq "VALL"){$libel="Vallée ";}
		elsif ($nat eq "VEN "){$libel="Venelle ";}
		elsif ($nat eq "VIAD"){$libel="Viaduc ";}
		elsif ($nat eq "VTE "){$libel="Vieille route ";}
		elsif ($nat eq "VCHE"){$libel="Vieux chemin ";}
		elsif ($nat eq "VLA "){$libel="Villa ";}
		elsif ($nat eq "VGE "){$libel="Village ";}
		elsif ($nat eq "VIL "){$libel="Ville ";}
		elsif ($nat eq "VC  "){$libel="Voie communale ";}
		elsif ($nat eq "VOIR"){$libel="Voirie ";}
		elsif ($nat eq "VOUT"){$libel="Voute ";}
		elsif ($nat eq "VOY "){$libel="Voyeul ";}
		else {$libel=$nat." ";
		}
		$libel.=$lib;
		$libel=~ s/\ +$//g;
		$comma="\"$code_commune$v$code$v$libel$v$caract$v$typ\"\n";
		print fant $comma;
	}
}
close(fant);
close(thf);
open(THF, "$dirbase/REVD166.$ext") || die "Ouverture de $dirbase/REVD166.$ext impossible\n";
open(parc, ">$dirbase/pdl.csv");
while(<THF>) {
	$code_commune=substr($_,0,6);
         $ccoprel=substr($_,6,3);
	$ccosecl=substr($_,9,2);
	$ccosecl=~ s/^\s+//g;
	$ccosecl=substr("00".$ccosecl,-2,2);
	$dnuplal=substr($_,11,4);
         $dnupdl=substr($_,15,3);
         $dnulot=substr($_,18,7);
	$cenr=substr($_,25,2);
         $ccopreb=substr($_,33,3);
         $invloc=substr($_,36,10);
         $dnumql=substr($_,46,7);
         $ddenql=substr($_,53,7);
	$comma10="\"$code_commune$v$ccoprel$v$ccosecl$v$dnuplal$v$dnupdl$v$dnulot$v$ccopreb$v$invloc$v$dnumql$v$ddenql"."\"\n";
	print parc $comma10;
}
close(parc);
close(thf);
open(THF, "$dirbase/REVFPDL.$ext") || die "Ouverture de $dirbase/REVFPDL.$ext impossible\n";
open(parc10, ">$dirbase/fpdl10.csv");
open(parc20, ">$dirbase/fpdl20.csv");
open(parc30, ">$dirbase/fpdl30.csv");
while(<THF>) {
	$code_commune=substr($_,0,6);
         $ccopre=substr($_,6,3);
	$ccosec=substr($_,9,2);
	$ccosec=~ s/^\s+//g;
	$ccosec=substr("00".$ccosec,-2,2);
	$dnupla=substr($_,11,4);
         $dnupdl=substr($_,15,3);
 	$cenr=substr($_,25,2);
   if ($cenr=='10'){
         $dnivim=substr($_,27,1);
         $ctpdl=substr($_,28,3);
         $nompdl=substr($_,31,30);
         $dmrpdl=substr($_,61,20);
         $gprmut=substr($_,81,1);
         $dnupro=substr($_,87,6);
	$comma10="\"$code_commune$v$ccopre$v$ccosec$v$dnupla$v$dnupdl$v$dnivim$v$ctpdl$v$nompdl$v$dmrpdl$v$gprmut$v$dnupro"."\"\n";
	print parc10 $comma10;
   }elsif ($cenr=='20'){
         $ccoprea=substr($_,27,3);
         $ccoseca=substr($_,30,2);
         $dnuplaa=substr($_,32,4);
	$comma20="\"$code_commune$v$ccopre$v$ccosec$v$dnupla$v$dnupdl$v$ccoprea$v$ccoseca$v$dnuplaa"."\"\n";
	print parc20 $comma20;
   }else{
	$dnulot=substr($_,18,7);
	$cconlo=substr($_,27,1);
	$dcntlo=substr($_,28,9);
	$dnumql=substr($_,37,7);
	$ddenql=substr($_,44,7);
	$dfilot=substr($_,51,20);
	$datact=substr($_,71,8);
	$dnuprol=substr($_,82,6);
	$dreflf=substr($_,88,5);
	$comma30="\"$code_commune$v$ccopre$v$ccosec$v$dnupla$v$dnupdl$v$dnulot$v$cconlo$v$dcntlo$v$dnumql$v$ddenql$v$dfilot$v$datact$v$dnuprol$v$dreflf"."\"\n";
	print parc30 $comma30;
   }
}
close(parc10);
close(parc20);
close(parc30);
close(thf);
sub ch_vide(){
	$ch=@_[0];
	$ch=~ s/\ +$//g;
	if (length($ch)==0){
		return ;
	}else{
		return "\"".$ch."\"";
	}
}