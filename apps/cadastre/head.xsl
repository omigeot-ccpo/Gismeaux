<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="html" version="1.0" encoding="UTF-8" indent="yes"/>

<xsl:template match="commune">
    <table width="100%" align="center"><tr>
    <xsl:apply-templates select="logo_commune"/>
    <td class="tt3"> Commune de <xsl:value-of select="@nom"/></td>
    <xsl:apply-templates select="logo_agglo"/>
    </tr></table>
</xsl:template>

<xsl:template match="logo_commune">
    <td width="{@larg}" align="center">
    <img src="../{@nom}" width="{@larg}" height="35" border="0"/></td>
</xsl:template>

<xsl:template match="logo_agglo">
    <td width="{@larg}" align="center">
    <img src="../{@nom}" width="{@larg}" height="35" border="0"/></td>
</xsl:template>
</xsl:stylesheet>