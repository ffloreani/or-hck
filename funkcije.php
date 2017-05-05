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
  $postBroj = getAttribute("post-broj");
  
  return implode(' ', array($ulica, $kucniBroj)) . ", " . implode(' ', array($mjesto, $postBroj));
}

function getOpenHours($isWorkweek, $drustvo) {
  if ($isWorkweek === true) {
    $workday = $drustvo->getElementsByTagName("radni-dan")[0];
    return $workday->getAttribute("od") . " - " . $workday->getAttribute("do");
  } else {
    $weekend = $drustvo->getElementsByTagName("subota")[0];
    if ($weekend->length > 0) {
      return $weekend->getAttribute("od") . " - " . $weekend->getAttribute("do");
    } else {
      return "Ne radi";
    }
  }
}

function getFacebookLink($drustvo) {
  return "https://facebook.com/" . getElement("fb-id", $drustvo);
}

?>