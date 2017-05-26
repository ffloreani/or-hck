<?php
error_reporting( E_ALL );

require_once('funkcije.php');

$branchCode = $_GET['sifra'];

$xmlDom = new DOMDocument();
$xmlDom->load( 'podaci.xml' );

$xPath = new DOMXPath($xmlDom);

$xmlQuery = '/drustva/drustvo[contains(@sifra, "'. $branchCode . '")]';
$drustva = $xPath->query($xmlQuery);

foreach($drustva as $drustvo) {
	echo '<div id="details-content"><table class="details-table">';
		echo '<tr><td class="desc">Ravnatelj</td>';
		echo '<td class="info">' . getElementValue("ravnatelj", $drustvo) . '</td></tr>';
		
		echo '<tr><td class="desc">Adresa</td>';
		echo '<td class="info">' . getAddress($drustvo) . '</td></tr>';
		
		echo '<tr><td class="desc">Radno vrijeme</td>';
		echo '<td class="info">' . getOpenHours(true, $drustvo) . '</td></tr>';
		
		echo '<tr><td class="desc">Web stranica</td>';
		if (containsElement("web", $drustvo) == true) {
 			echo '<td class="info"><a class="links" href="' . getElementValue("web", $drustvo) . '" target="_blank"><i class="fa fa-lg fa-external-link"></i></a></td></tr>';
		}
	
		echo '<tr><td class="desc">E-mail</td>';
		echo '<td class="info">' . getElementValue("e-mail", $drustvo) . '</td></tr>';
	echo '</table></div>';
}

?>