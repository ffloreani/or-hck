<?php

// Constructs the full XPath filter from the values received in the GET request
function constructXPathFilter($branchTypes, $director, $town, $activities, $phoneType, $phoneNumber) {
  $allBranchesFilter = "/drustva/drustvo";
  $branchTypeFilter = isset($branchTypes) ? constructBranchTypeFilter($branchTypes) : "";
  $directorFilter = isSetAndNotEmpty($director) ? constructDirectorFilter($director) : "";
  $townFilter = isSetAndNotEmpty($town) ? constructTownFilter($town) : "";
  $activitiesFilter = isset($activities) ? constructActivitiesFilter($activities) : "";
  $phoneFilter = isset($phoneType) && isSetAndNotEmpty($phoneNumber) ? constructPhoneFilter($phoneType, $phoneNumber) : "";
  
  return implode('', array($allBranchesFilter, $branchTypeFilter, $directorFilter, $townFilter, $activitiesFilter, $phoneFilter));
}

// Constructs the XPath filter for the branch type (city/county, state, national)
function constructBranchTypeFilter($branchTypes) {
  $branchFilter = "";
  $i = 0;
  
  foreach($branchTypes as $type) {
    if ($i == 0) {
      $branchFilter .= "contains(" . textToLowercase() . ", '" . strtolower($type) . "')";
      $i = 1;
    } else {
      $branchFilter .= " or contains(" . textToLowercase() . ", '" . strtolower($type) . "')";
    }
  }
  
  return "[@vrsta[$branchFilter]]";
}

// Constructs the XPath filter for the branch director
function constructDirectorFilter($director) {
  $lcText = textToLowercase();
  $director = strtolower($director);
  return "[ravnatelj[contains($lcText, '$director')]]";
}

// Constructs the XPath filter for the town of a branch 
function constructTownFilter($town) {
  $lcText = textToLowercase();
  $town = strtolower($town);
  return "[adresa/mjesto[contains($lcText, '$town')]]";
}

// Constructs the XPath filter for branch activities, linking them with OR operators
function constructActivitiesFilter($activities) {
  $activityFilter = "";
  $i = 0;
  
  foreach($activities as $activity) {
    if ($i == 0) {
      $activityFilter .= "contains(" . textToLowercase(). ", '" . strtolower($activity) . "')";
    } else {
      $activityFilter .= "or contains(" . textToLowercase(). ", '" . strtolower($activity) . "')";
    }
  }
  
  return "[aktivnosti/aktivnost[$activityFilter]]";
}

// Constructs the XPath filter for the phone number of a given type (landline, cell, fax)
function constructPhoneFilter($phoneType, $phoneNumber) {
  $phoneNumber = str_replace(' ', '', $phoneNumber);
  return "[telefon[@tip='$phoneType']/broj[contains(text(), '$phoneNumber')]]";
}

// XPath function for translating a piece of text into lowercase values
function textToLowercase() {
  return "translate(text(), 'ABCČĆDĐEFGHIJKLMNOPQRSŠTUVWXYZŽ', 'abcčćdđefghijklmnopqrsštuvwxyzž')";
}

// Checks if the element exists and it's not an empty string
function isSetAndNotEmpty($string) {
  return isset($string) && strlen(trim($string)) > 0;
}

// Returns true if the node or it's children have a child of elemName, false otherwise
function containsElement($elemName, $node) {
  return $node->getElementsByTagName($elemName)->length > 0;
}

// Gets the text value of an element with the given name which is a child of the given node or it's children
function getElementValue($elemName, $node) {
  return $node->getElementsByTagName($elemName)[0]->nodeValue;
}

// Returns the full address in the format "street name and number, town postal_code"
function getAddress($drustvo) {
  $ulica = getElementValue("ulica", $drustvo);
  $kucniBroj = getElementValue("kucni-broj", $drustvo);
  $mjesto = getElementValue("mjesto", $drustvo);
  $postBroj = $drustvo->getAttribute("post-broj");
  
  return implode(' ', array($ulica, $kucniBroj)) . ", " . implode(' ', array($mjesto, $postBroj));
}

// If the isWorkweek = true, returns the business hours for weekdays. If isWorkweek = false, returns business hours for saturdays, otherwise returns "Ne radi"
function getOpenHours($isWorkweek, $drustvo) {
  if ($isWorkweek === true) {
    $workday = $drustvo->getElementsByTagName("radni-dan")[0];
    return $workday->getAttribute("od") . " - " . $workday->getAttribute("do");
  } else {
    $weekend = $drustvo->getElementsByTagName("subota");
    if ($weekend->length > 0) {
      return $weekend->item(0)->getAttribute("od") . " - " . $weekend->getAttribute("do");
    } else {
      return "Ne radi";
    }
  }
}

// Returns the full URL to the branch's Facebook page
function getFacebookLink($drustvo) {
  return "https://facebook.com/" . getElementValue("fb-id", $drustvo);
}

?>