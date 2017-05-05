<?php

function containsElement($elemName, $node) {
  return $node->getElementsByTagName($elemName)->length > 0;
}

function getElementValue($elemName, $node) {
  return $node->getElementsByTagName($elemName)[0]->nodeValue;
}

function getAddress($drustvo) {
  $ulica = getElementValue("ulica", $drustvo);
  $kucniBroj = getElementValue("kucni-broj", $drustvo);
  $mjesto = getElementValue("mjesto", $drustvo);
  $postBroj = $drustvo->getAttribute("post-broj");
  
  return implode(' ', array($ulica, $kucniBroj)) . ", " . implode(' ', array($mjesto, $postBroj));
}

function getOpenHours($isWorkweek, $drustvo) {
  if ($isWorkweek === true) {
    $workday = $drustvo->getElementsByTagName("radni-dan")[0];
    return $workday->getAttribute("od") . " - " . $workday->getAttribute("do");
  } else {
    $weekend = $drustvo->getElementsByTagName("subota");
    if ($weekend->length > 0) {
      $saturday = $weekend[0];
      return $saturday->getAttribute("od") . " - " . $saturday->getAttribute("do");
    } else {
      return "Ne radi";
    }
  }
}

function getFacebookLink($drustvo) {
  return "https://facebook.com/" . getElementValue("fb-id", $drustvo);
}

?>