<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
<xsl:output method="html" doctype-system="about:legacy-compat" encoding="UTF-8" indent="yes" />

	<xsl:template match="/">
		<xsl:text disable-output-escaping="yes">&lt;!DOCTYPE html&gt;</xsl:text>
		<html lang="hr">
		<head>
			<meta charset="UTF-8"/>
			<title>HCK news feed</title>
			<link rel="shortcut icon" type="image/png" href="./favicon.ico"/>
			<link rel="stylesheet" href="./dizajn.css" type="text/css"/>
			<script src="https://use.fontawesome.com/3b6cd20c64.js"></script>
		</head>
		<body>
			<div id="wrapper">
				<header class="masthead">
					<div class="logo">
						<a href="index.html"><img src="./res/hck_logo.gif" alt="Logo HCK"/></a>
					</div>
					<span class="masthead-search">
						<a href="obrazac.html"><i class="fa fa-search fa-2x fa-flip-horizontal"></i></a>
					</span>
				</header>

				<nav class="sidebar">
					<ul class="side">
						<li><a href="index.html"><i class="fa fa-home fa-fw"></i><xsl:text>&#160;</xsl:text>POČETNA</a></li>
						<li><a href="obrazac.html"><i class="fa fa-search fa-fw"></i><xsl:text>&#160;</xsl:text>PRETRAGA</a></li>
						<li><a href="podaci.xml"><i class="fa fa-table fa-fw"></i><xsl:text>&#160;</xsl:text>PODACI</a></li>
						<li><a href="http://www.hck.hr/hr" target="_blank"><i class="fa fa-plus fa-fw"></i><xsl:text>&#160;</xsl:text>HCK WEB</a></li>
						<li><a href="http://www.fer.unizg.hr/predmet/or"><i class="fa fa-desktop fa-fw"></i><xsl:text>&#160;</xsl:text>OR @ FER</a></li>
						<li><a href="http://www.fer.unizg.hr" target="_blank"><i class="fa fa-university fa-fw"></i><xsl:text>&#160;</xsl:text>FER UNIZG</a></li>
						<li><a href="mailto:filip.floreani@fer.hr"><i class="fa fa-envelope fa-fw"></i><xsl:text>&#160;</xsl:text>E-MAIL</a></li>
					</ul>
				</nav>

				<div class="main">
					<div class="branches xml-branches">
						<h1 class="headline">Podaci o društvima</h1>
						<div class="tbl-header">
							<table>
								<tr>
									<th>Naziv</th>
									<th>Ravnatelj/ica</th>
									<th>Radno vrijeme</th>
									<th>Adresa</th>
									<th style="text-align:center;">Web</th>
									<th style="text-align:center;">Facebook</th>
								</tr>
							</table>
						</div>
						<div class="tbl-content" style="max-height:50%; margin-bottom:60px;">
							<table>
								<xsl:for-each select="/drustva/drustvo">
									<tr>
										<td> <!-- Branch title -->
											<xsl:value-of select="naziv"/><br/>
										</td>
										<td> <!-- Branch director -->
											<xsl:value-of select="ravnatelj"/><br/>
										</td>
										<td> <!-- Working hours -->
											Radni dan: <xsl:value-of select="radno-vrijeme/radni-dan/@od"/> - <xsl:value-of select="radno-vrijeme/radni-dan/@do"/><br/>
                                          	
											Subota: 
											<xsl:variable name="saturdayWH" select="radno-vrijeme/subota/@od"/>
                                            <xsl:choose>
												<xsl:when test="$saturdayWH">
													<xsl:value-of select="radno-vrijeme/subota/@od"/> - <xsl:value-of select="radno-vrijeme/subota/@do"/><br/>
												</xsl:when>
												<xsl:otherwise>Ne radi</xsl:otherwise>
											</xsl:choose>
										</td>
										<td> <!-- Address -->
											<xsl:value-of select="adresa/ulica"/><xsl:text>&#160;</xsl:text><xsl:value-of select="adresa/kucni-broj"/>,<xsl:text>&#160;</xsl:text><xsl:value-of select="adresa/mjesto"/><br/>
										</td>
										<td style="text-align:center;"> <!-- Web link -->
											<xsl:if test="web">
												<a class="links">
													<xsl:attribute name="href"><xsl:value-of select="web"/></xsl:attribute>
													<xsl:attribute name="target">_blank</xsl:attribute>
													<span><i class="fa fa-lg fa-fw fa-external-link"></i></span>
												</a>
											</xsl:if>
										</td>
										<td style="text-align:center;"> <!-- Facebook link -->
											<xsl:variable name="face-id">
												<xsl:value-of select="fb-id"/> 
											</xsl:variable>
											<a class="links" href="https://facebook.com/{$face-id}" target="_blank">
												<i class="fa fa-lg fa-fw fa-facebook-square"></i>
											</a>
										</td>
									</tr>
								</xsl:for-each>
							</table>
						</div>
					</div>
				</div>
				
				<footer class="main-footer" style="position: fixed; bottom:0; right:0; left: 0;">
					<p>&#169; Filip Floreani (Otvoreno računarstvo) 2017.</p>
				</footer>
			</div>
		</body>
		</html>
	</xsl:template>
</xsl:stylesheet>