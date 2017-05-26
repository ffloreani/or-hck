<?php
error_reporting( E_ALL );

require_once('funkcije.php');
require_once('counter.php');

$xmlDom = new DOMDocument();
$xmlDom->load( 'podaci.xml' );

$xPath = new DOMXPath($xmlDom);

$branchType = isset($_GET['branch-type']) ? $_GET['branch-type'] : "";
$director = isset($_GET['director']) ? $_GET['director'] : "";
$town = isset($_GET['town']) ? $_GET['town'] : "";
$activities = isset($_GET['activities']) ? $_GET['activities'] : "";
$phoneType = isset($_GET['phone-type']) ? $_GET['phone-type'] : "";
$phoneNumber = isset($_GET['phone-number']) ? $_GET['phone-number'] : "";

$xmlQuery = constructXPathFilter($branchType, $director, $town, $activities, $phoneType, $phoneNumber);

$filteredNodes = $xPath->query($xmlQuery);
?>

<html lang="hr">
<head>
    <meta charset="UTF-8"/>
    <title>HCK news feed</title>
    <link rel="shortcut icon" type="image/png" href="./favicon.ico"/>
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.0.3/dist/leaflet.css" integrity="sha512-07I2e+7D8p6he1SIM+1twR5TIrhUQn9+I6yjqD53JQjFiMf8EtC93ty0/5vJTZGF8aAocvHYNEDJajGdNx1IsQ==" crossorigin=""/>
    <link rel="stylesheet" href="./dizajn.css" type="text/css"/>
</head>
<body>
    <div id="wrapper">
        <header class="masthead">
            <div class="logo">
                <a href="index.html"><img src="res/hck_logo.gif" alt="Logo HCK"/></a>
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
            	<li><a href="potresi.php"><i class="fa fa-globe fa-fw"></i>&nbsp;POTRESI</a></li>
            </ul>
        </nav>

        <div class="main-search">
            <div class="branches-search">
                <h1 class="headline">Rezultati pretrage</h1>
                <div class="tbl-header">
                    <table>
						<col span="1" class="column-narrow">
							<tr>
								<th style="text-align:center;"></th>
								<th>Društvo</th>
								<th style="text-align:center;">Info</th>
								<th>#Click</th>
							</tr>
                    </table>
                </div>
                <div class="tbl-content" style="max-height:50%; margin-bottom:60px;">
                    <table>
                        <col span="1" class="column-narrow">
						<?php foreach($filteredNodes as $drustvo) { 
							$coors = getFullCoorsArray($drustvo);
							$lat = $coors[0];
							$lon = $coors[1];
							$branchTitle = getElementValue("naziv", $drustvo);
							$fbid = getElementValue("fb-id", $drustvo);
							$detailsUrl = "detalji.php?sifra=" . getAttribute("sifra", $drustvo);
							$counter = getElementValue("counter", $drustvo);
						?>
                            <tr onmouseover="this.style.backgroundColor='#efefef'" onmouseout="this.style.backgroundColor='#ffffff';">
                                <td style="text-align: center;"> <!-- Branch profile picture -->
									<img src=<?php echo getFBPictureUrl($drustvo); ?> height="50px" width="50px" alt=""/>
								</td>
                             	<td> <!-- Branch title -->
                                    <?php echo $branchTitle; ?>
                                </td>
								<td style="text-align: center;">
									<a class="links" onclick=<?php echo '"showDetails(' . $lat . ', ' . $lon . ', \'' . $branchTitle . '\', \'' . $detailsUrl . '\', ' . $fbid . ')"'; ?>>
                                        <i class="fa fa-lg fa-fw fa-info-circle"></i>
                                    </a>
								</td>
								<td>
									<span data-id=<?php echo '_' . $fbid;?>><?php echo $counter; ?></span>
								</td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
			</div>
			<div class="details">
        		<h2 class="headline">Detalji</h2>
				<div id="details-content"></div>
				<div id="map"></div>
			</div>
        </div>

        <footer class="main-footer" style="position: fixed; bottom:0; right:0; left: 0;">
            <p>&#169; Filip Floreani (Otvoreno računarstvo) 2017.</p>
        </footer>
    </div>
		
	<script src="https://use.fontawesome.com/3b6cd20c64.js"></script>
	<script src="https://unpkg.com/leaflet@1.0.3/dist/leaflet.js" integrity="sha512-A7vV8IFfih/D732iSSKi20u/ooOfj/AGehOKq0f4vLT1Zr2Y+RX7C+w8A1gaSasGtRUZpF/NZgzSAu4/Gc41Lg==" crossorigin=""></script>
	<script type="text/javascript" src='./detalji.js'></script>
</body>
</html>