<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="html" version="1.0" encoding="UTF-8" indent="yes"/>
<xsl:include href="head.xsl"/>

<xsl:template match="park">
    <html><head><link href='../../doc_commune/770284/css_extranet/general.css' rel='stylesheet' type='text/css'/></head><body>
    <xsl:apply-templates select="commune"/>
    <table width="100%">
    <xsl:apply-templates select="parcelle"/>
    </table></body></html>
</xsl:template>

<xsl:template match="parcelle">
    <xsl:apply-templates select="bati"/>
    <tr><td>Section</td><td><xsl:value-of select="@section"/></td><td>Numéro</td><td><xsl:value-of select="@numero"/></td></tr>
    <tr><td>Adresse</td><td colspan="3"><xsl:value-of select="adresse"/></td></tr>
    <tr><td>Contenance</td><td><xsl:value-of select="contenance"/> m²</td><td>Date de l'acte</td><td><xsl:value-of select="date_acte"/></td></tr>
    <tr><td colspan="4"><table align="center" width="90%"><caption class="tt2">Propriétaires</caption><xsl:apply-templates select="proprietaires" mode="prop"/></table></td></tr>
    <xsl:apply-templates select="batiments" mode="bati"/>
</xsl:template>

<xsl:template match="proprietaires" mode="prop">
    <xsl:apply-templates select="proprietaire" mode="prop"/>
</xsl:template>

<xsl:template match="proprietaire" mode="prop">
    <tr><td>Nom</td><td><xsl:value-of select="nom"/></td></tr>
    <tr><td rowspan="5">Adresse</td><td><xsl:value-of select="lign3"/></td></tr>
    <tr><td><xsl:value-of select="lign4"/></td></tr>
    <tr><td><xsl:value-of select="lign5"/></td></tr>
    <tr><td><xsl:value-of select="lign6"/></td></tr>
    <tr><td><xsl:value-of select="pays"/></td></tr>
</xsl:template>


<xsl:template match="batiments" mode="bati">
    <tr><td colspan="4"><table align="center" width="90%"><caption class="tt2">Locaux</caption>
    <xsl:apply-templates select="batiment" mode="bati"/>
    </table></td></tr>
</xsl:template>

<xsl:template match="batiment" mode="bati">
    <tr class="tt4"><xsl:apply-templates select='/park/droit'/>
    <td>Escalier</td><td><xsl:value-of select="escalier"/></td>
    <td>Niveau</td><td><xsl:value-of select="niveau"/></td>
    <td>Local</td><td><xsl:value-of select="porte"/></td></tr>
    <xsl:apply-templates select="proprietaire" mode="copro"/>
</xsl:template>

<xsl:template match='/park/droit'>
    <xsl:choose>
	<xsl:when test = ".='a'">
	    <td><a href="fic_bat.php?invar1={/park/parcelle/batiments/batiment/@invar}">Batiment</a></td>
	</xsl:when>
	<xsl:when test = ".='e'">
	    <td><a href="fic_bat.php?invar1={/park/parcelle/batiments/batiment/@invar}">Batiment</a></td>
	</xsl:when>
	<xsl:otherwise>
	    <td>Batiment</td>
	</xsl:otherwise>
    </xsl:choose>
</xsl:template>

<xsl:template match="proprietaire" mode="copro">
    <tr><td>Nom</td><td colspan="4"><xsl:value-of select="nom"/></td><td colspan="2"><xsl:apply-templates select="ccodro"/></td></tr>
    <tr><td rowspan="5">Adresse</td><td colspan="6"><xsl:value-of select="lign3"/></td></tr>
    <tr><td colspan="6"><xsl:value-of select="lign4"/></td></tr>
    <tr><td colspan="6"><xsl:value-of select="lign5"/></td></tr>
    <tr><td colspan="6"><xsl:value-of select="lign6"/></td></tr>
    <tr><td colspan="6"><xsl:value-of select="pays"/></td></tr>
</xsl:template>

<xsl:template match="bati">
    <xsl:choose>
	<xsl:when test = ".= 'true'">
	    <caption class="tt1">Fiche parcelle bâtie<img src="../../doc_commune/770284/skins/sig.png" onclick="window.opener.svgWin.cadreparcelle('{@ind}')" alt="cadrer sur le SIG" align="right"/></caption>
	</xsl:when>
	<xsl:otherwise>
	   <caption class="tt1">Fiche parcelle non bâtie<img src="../../doc_commune/770284/skins/sig.png" onclick="window.opener.svgWin.cadreparcelle('{@ind}')" alt="cadrer sur le SIG" align="right"/></caption>
	</xsl:otherwise>
    </xsl:choose>
</xsl:template>

<xsl:template match="ccodro">
    <xsl:choose>
	<xsl:when test = ".= 'P'">
	    <z>Propriétaire</z>
	</xsl:when>
	<xsl:when test = ".= 'U'">
	    <z>Usufruitier</z>
	</xsl:when>
	<xsl:when test = ".= 'N'">
	    <z>Nu-propriétaire</z>
	</xsl:when>
	<xsl:when test = ".= 'B'">
	    <z>Bailleur à construction</z>
	</xsl:when>
	<xsl:when test = ".= 'R'">
	    <z>Preneur à construction</z>
	</xsl:when>
	<xsl:when test = ".= 'F'">
	    <z>Foncier</z>
	</xsl:when>
	<xsl:when test = ".= 'T'">
	    <z>Tenuyer</z>
	</xsl:when>
	<xsl:when test = ".= 'D'">
	    <z>Domanier</z>
	</xsl:when>
	<xsl:when test = ".= 'V'">
	    <z>Bailleur d'un bail à réhabilitation</z>
	</xsl:when>
	<xsl:when test = ".= 'W'">
	    <z>Preneur d'un bail à réhabilitation</z>
	</xsl:when>
	<xsl:when test = ".= 'A'">
	    <z>Locataire-atrributaire</z>
	</xsl:when>
	<xsl:when test = ".= 'E'">
	    <z>Emphytéote</z>
	</xsl:when>
	<xsl:when test = ".= 'K'">
	    <z>Antichrésiste</z>
	</xsl:when>
	<xsl:when test = ".= 'L'">
	    <z>Fonctionnaire logé</z>
	</xsl:when>
	<xsl:when test = ".= 'G'">
	    <z>Gérant, mandataire, gestionnaire</z>
	</xsl:when>
	<xsl:when test = ".= 'H'">
	    <z>Associé d'une transparence fiscale</z>
	</xsl:when>
	<xsl:when test = ".= 'S'">
	    <z>Syndic de copropriété</z>
	</xsl:when>
    </xsl:choose>
</xsl:template>

</xsl:stylesheet>