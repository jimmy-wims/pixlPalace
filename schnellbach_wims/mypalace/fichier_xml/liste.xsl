<?xml version="1.0" encoding="ISO-8859-1" ?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:output method="html"/>
	<xsl:template match="/">
		<html>
			<body>
				<xsl:apply-templates />
				<br/>
				<h4 text-align="left"><xsl:text> Pix-L-Palace  by Schnellbach-Tanguy et Wims-Jimmy</xsl:text></h4>
			</body>
		</html>
	</xsl:template>
	
	<xsl:template match="/personne">
		<u>
			<h1 text-align="center"><xsl:value-of select="identitee" />
				<xsl:text> voici vos infos </xsl:text>
			</h1>
		</u>
		<xsl:apply-templates select="information"/>
	</xsl:template>

	<xsl:template match="personne/information">
		<ul>
			<li>
				<xsl:value-of select="adressemail" />
			</li>
			<li>
				<xsl:value-of select="date" />
			</li>
			<li>
				<xsl:value-of select="mana" />
			</li>
			<li>
				<xsl:value-of select="vie" />
			</li>
			<li>
				<xsl:value-of select="xp" />
			</li>
			<li>
				<xsl:value-of select="niveau" />
			</li>
			<br/>
		</ul>
		<h2><xsl:text>Voici vos post</xsl:text></h2>
		<ul>
			<xsl:for-each select="posts/post">
				<li>
					<xsl:value-of select="@type" /><xsl:text> :  </xsl:text><xsl:value-of select="current()"/><br/>
				</li>
			</xsl:for-each>
		</ul>
	</xsl:template>
</xsl:stylesheet>