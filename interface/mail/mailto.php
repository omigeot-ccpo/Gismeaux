<!--Copyright Ville de Meaux 2004-2007
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
termes.-->
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Cartographie - Contactez-nous...</title>
</head>
<body bgcolor='#FFFFFF' LIEN='ORANGE' VLIEN='RED'>
<CENTER><P><IMG SRC="../../logo/headmail.PNG" WIDTH="620" HEIGHT="40"></P></CENTER>
<script language="JavaScript">
function check_form() 
	{TxtMessage="";
	
	if (document.demande.EMAIL.value == "")
	TxtMessage = TxtMessage + " - votre email.\n";
	if (document.demande.REMARQUE.value == "")
	TxtMessage = TxtMessage + " - vos remarques.\n";
	if (TxtMessage != "") {
		TxtMessage="Vous n'avez pas saisi les informations suivantes :\n" + TxtMessage;
		alert (TxtMessage);
        return false;
		}
	else {
		return true;
		}
	}
</script>
<form action="confirm.php" method="POST" name="demande" onsubmit="return check_form()"><FONT SIZE="-1">
<CENTER><TABLE BORDER='0'>
<tr><td>
<IMG SRC='../../logo/etoile2.JPG'>
</td><tr>
      <tr> 
        <td valign="top" width="170"><B>Votre Email</B><BR><FONT SIZE='-2' COLOR='RED'>[&nbsp;OBLIGATOIRE&nbsp;]<FONT></td>
        <td width="430"> 
          <input type="text" size="50" name="EMAIL">
        </td>
      </tr>
      <tr> 
        <td valign="top" width="170">&nbsp;</td>
        <td width="430">&nbsp;</td>
      </tr>
<tr> 
        <td colspan="2"> <B>Vos remarques...</B><BR><FONT SIZE='-2' COLOR='RED'>[&nbsp;OBLIGATOIRE&nbsp;]<FONT>&nbsp;</font></p>
          <p> 
            <textarea name="REMARQUE" rows="5" cols="50" wrap="virtual"></textarea></BR>
            <input type="submit" value="Envoyer">
            <input type="reset" value="Annuler">
		</p>
          <p></p>
                 </td>
      </tr>
<tr>
<td colspan="2" align="center"><IMG SRC="../../logo/barre.JPG"></td></tr>
<tr><td colspan="2" align="center">*Nous traitons uniquement les messages concernant l'interface</td></tr>
</TABLE></CENTER>
<?

print("</FORM>\n");

?>

</body>
</html>