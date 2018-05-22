<?php
require_once( __DIR__ . '/deepl.php' );

// DE, EN, FR, ES, IT, NL, PL are available
// or use > {LANG_CODE} to force the translation language
$default_language = 'DE'; 
$dl = new DeeplTranslate($default_language);
$nfdInput="du&#x308;se";
$input=html_entity_decode($nfdInput);
$result=$dl->translate($input);
echo $result;
if (strpos($result, "#x308")) {
  echo "FAILED\n"; exit (1);
} else {
  echo "OK\n"; exit (0);
}
?>
