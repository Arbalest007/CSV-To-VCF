<?php

/*
Importing the VCard Lib via Composer Autoload
*/
require_once __DIR__ . '/vendor/autoload.php';
use JeroenDesloovere\VCard\VCard;

$filename = 'tester.csv';

//Create an empty multidimensional array
$contacts = array();
/*
Structure:
[First Name][Last Name][Phone Number]
*/

//Open up CSV for reading
$istream = fopen("tester.csv", "r");
$filepath = 'C:\output';

/*
While there are still rows to read in the CSV, copy them
into Contacts array. Each row represents one person's info.
*/
$counter = 0;
while(($row = fgetcsv($istream, 1000, ",")) !== FALSE) {
  $contacts[] = $row;
  //$contacts[] = $row;
  //var_dump($row);
  //$counter += 1;
}

fclose($istream);

//Loovere VCard Instantiation
//$vcard = new VCard();
$vcardObjects = [];
//echo sizeof($contacts);
//echo "\nEnd of Program";

//Creating a vcard array that we will export
for($x = 0; $x < sizeof($contacts); $x++) {
  //Skip column description
  if($x==0)
    continue;

  $vcardTemp = new VCard();

  //***Debugging/Testing***
  //$temp = $contacts[$x];
  //echo $contacts[$x][0];
  //echo $contacts[$x][1];
  //echo $contacts[$x][2];

  //***Format***
  //lastName, firstName, additional, prefix, suffix
  $vcardTemp->addName($contacts[$x][0], $contacts[$x][1]);
  $vcardTemp->addPhoneNumber($contacts[$x][2], 'CELL');
  $vcardTemp->addPhoneNumber($contacts[$x][3], 'WORK');
  $vcardTemp->addEmail($contacts[$x][4], 'WORK');
  $vcardTemp->addJobtitle($contacts[$x][5]);

  //Insert vcard into the array
  $vcardObjects[] = $vcardTemp;
}

$vcardFinal = new VCard();
$vcardFinal->saveMultiple($vcardObjects);

//return $vcardObjects->download();

echo "<pre>";
var_dump($vcardObjects);
echo "</pre>";

//return $vcard->download();
?>
