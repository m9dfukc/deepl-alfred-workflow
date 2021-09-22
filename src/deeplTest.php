<?php
require_once( __DIR__ . '/deepl.php' );

$key = readline('Enter your DeepLy Api Key: ');
$defaultTargets = 'DE EN'; 
$dl = new DeeplTranslate($key, $defaultTargets);
$nfdInput="du&#x308;se";
$input=html_entity_decode($nfdInput);
$result=$dl->translate($input);
echo $result;
if (strpos($result, "#x308")) {
  echo " => FAILED\n"; exit (1);
} else {
  echo " => OK\n"; exit (0);
}
?>
