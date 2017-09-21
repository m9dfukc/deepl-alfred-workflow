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

function output_translation($query, $lang, $tile = "") {
    $wf 		 = new Workflows('de.m9dfukc.deepltranslate');
    $deepLy	 = new DeepLy();
    try {
        $results    = array();
        $proposals  = $deepLy->proposeTranslations($query, DeepLy::LANG_DE, DeepLy::LANG_AUTO);
        foreach($proposals as $proposal) {
            $temp = array(
                'uid'          => NULL,
                'arg'          => $proposal,
                'title'        => $proposal,
                'subtitle'     => $title,
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
