<?php
require_once( './vendor/autoload.php' );
use AlfredApp\Workflows;
use ChrisKonnertz\DeepLy\DeepLy;

function empty_result($query) {
    return array (
        'uid'          => 'deepl-error',
        'arg'          => $query,
        'title'        => 'DeepL no translation found',
        'subtitle'     => 'no translation',
        'icon'         => 'icon.png',
        'valid'        => 'no',
    );
}

function output_translation($query, $lang, $title = "") {
    $wf 		  = new Workflows('de.m9dfukc.deepltranslate');
    $deepLy	  = new DeepLy();
    $lang     = strtoupper($lang);
    $lang     = strpos($query, '>') ?
                    strtoupper(trim(substr($query, strpos($query, '>') + 1))) :
                    $lang;
    $lang     = $deepLy->supportsLangCode($lang) ? $lang : 'EN';
    $query    = strpos($query, '>') ?
                    trim(substr($query, 0, strpos($query, '>'))) :
                    $query;

    try {
        $results    = array();
        $proposals  = $deepLy->proposeTranslations($query, $lang);
        foreach($proposals as $proposal) {
            $temp = array(
                'uid'          => NULL,
                'arg'          => $proposal,
                'title'        => $proposal,
                'icon'         => 'icon.png',
                'valid'        => 'yes',
                'autocomplete' => 'autocomplete',
            );
            array_push($results, $temp);
        }
        if (empty($results)) return $wf->toXML(empty_result($query));
        else return $wf->toXML($results);
    } catch (\Exception $exception) {
        return $wf->toXML(empty_result($query));
    }
}
?>
