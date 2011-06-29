<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="html" version="1.0" encoding="UTF-8" indent="yes"/>
<xsl:include href="head.xsl"/>

<xsl:template match="park">
    <html>
    <script language="JScript">
    <![CDATA[ 
    function co() 
    { 
        <?xml-stylesheet type="application/xml" href="tab_cad.xsl"?>;
    } 
     ]]>
    </script> 
    <head><link href='../../doc_commune/770284/css_extranet/general.css' rel='stylesheet' type='text/css'/></head><body>
    <xsl:apply-templates select="commune"/>
    <table width="100%">
    <tr><th>Numéro</th><th>Contenance</th><th>adresse</th><th>Propriétaire</th><th>Adresse Propriétaire</th><th>Cadrage SIG</th></tr>
    <xsl:apply-templates select="parcelle"/>
    </table></body></html>
</xsl:template>

<xsl:template match="parcelle">
    <tr><td><a href='test_parcelle.php?ind={@ind}'><xsl:value-of select="@section"/><xsl:value-of select="@numero"/></a></td><td><xsl:value-of select="contenance"/> m²</td><td><xsl:value-of select="adresse"/></td><td><xsl:value-of select="proprietaires/proprietaire/nom"/></td><td>
    <xsl:value-of select="proprietaires/proprietaire/lign3"/>
    <xsl:value-of select="proprietaires/proprietaire/lign4"/>
    <xsl:value-of select="proprietaires/proprietaire/lign5"/>
    <xsl:value-of select="proprietaires/proprietaire/lign6"/>
    <xsl:value-of select="proprietaires/proprietaire/pays"/></td>
    <td><img src="../../doc_commune/770284/skins/sig.png" onclick="window.opener.svgWin.cadreparcelle('{@ind}')" alt="cadrer sur le SIG" /></td>
   </tr>
</xsl:template>


</xsl:stylesheet>