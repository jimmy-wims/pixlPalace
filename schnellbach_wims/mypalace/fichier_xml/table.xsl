<?xml version="1.0" encoding="ISO-8859-1" ?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:output method="html"/>
	<xsl:template match="/">
		<html>
		<xsl:text>
	</xsl:text>
			<body>
			<xsl:text>	
		</xsl:text>
			<xsl:apply-templates />
				<h4 text-align="left"><xsl:text> Pix-L-Palace  by Schnellbach-Tanguy et Wims-Jimmy</xsl:text></h4>
			</body>
				<xsl:text>	
		</xsl:text>
		</html>
	</xsl:template>
	
	<xsl:template match="/personne">
		<h1 text-align="center"><xsl:value-of select="identitee" />
			<xsl:text> Voici la liste de vos </xsl:text>
			<U><xsl:text> amis </xsl:text></U>
			<xsl:text> ainsi que leurs</xsl:text><U> <xsl:text> publications</xsl:text></U> <xsl:text> public et amis  </xsl:text>
		</h1>
		<table border="4" width="100%" height="auto">
			<xsl:apply-templates select="information"/>
		</table>
	</xsl:template>

	<xsl:template match="personne/information">
		<tr>
			<td>
				<table border="2" cellspacing="10px" width="100%">
					<tr  align="center" bgcolor="#00FF00">
						<td>
							<xsl:value-of select="prenom" />
							<xsl:text> - </xsl:text>
							<xsl:value-of select="nom" />
							<xsl:text>  :  </xsl:text>
							<xsl:value-of select="adressemail" />
							<xsl:value-of select="date" />
						</td>
					</tr>
					<tr  text-align="left" >
						<td>
							<xsl:for-each select="posts/post">
								<xsl:text>- </xsl:text><xsl:value-of select="@type" /><xsl:text> :  </xsl:text><xsl:value-of select="current()"/><br/>
							</xsl:for-each>
						</td>
					</tr>
				</table>
				<br/>
			</td>
		</tr>
	</xsl:template>
</xsl:stylesheet>