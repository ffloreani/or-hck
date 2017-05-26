<?php
error_reporting( E_ALL );

require_once('funkcije.php');

$fb_id = $_GET['fbid'];

$xmlDom = new DOMDocument();
$xmlDom->load( 'podaci.xml' );

$xPath = new DOMXPath($xmlDom);

$results = $xPath->query("/drustva/drustvo[fb-id='$fb_id']");

foreach($results as $res) {
  $value = getElementValue("counter", $res);
  $res->getElementsByTagName("counter")[0]->nodeValue = $value + 1;
  echo $value + 1;
  break;
}

?>