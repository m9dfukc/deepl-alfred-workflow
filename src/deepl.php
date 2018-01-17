<?php
require_once( './vendor/autoload.php' );
use AlfredApp\Workflows;
use ChrisKonnertz\DeepLy\DeepLy;

class DeeplTranslate
{
    private $deepLy;
    private $wf;
    private $baseLang;

    private $langIcons = array (
        'default'       => 'icon.png',
        DeepLy::LANG_DE => 'icons/de.png',
        DeepLy::LANG_EN => 'icons/en.png',
        DeepLy::LANG_FR => 'icons/fr.png',
        DeepLy::LANG_ES => 'icons/es.png',
        DeepLy::LANG_IT => 'icons/it.png',
        DeepLy::LANG_NL => 'icons/nl.png',
        DeepLy::LANG_PL => 'icons/pl.png',
    );

    function __construct($lang) {
        $this->wf 	    = new Workflows('de.m9dfukc.deepltranslate');
        $this->deepLy   = new DeepLy();
        $this->baseLang = $lang;
    }

    private function get_lang_icon($lang) {
        return isset($this->langIcons[$lang])
            ? $this->langIcons[$lang]
            : $this->langIcons['default'];
    }

    private function empty_result($query) {
        return array (
            'uid'     => NULL,
            'arg'     => $query,
            'title'   => 'DeepL no translation found',
            'icon'    => $this->langIcons['default'],
            'valid'   => 'no',
        );
    }

    public function translate($query) {
        $lang  = strtoupper($this->baseLang);
        $lang  = strpos($query, '>')
            ? strtoupper(trim(substr($query, strpos($query, '>') + 1)))
            : $lang;
        $lang  = $this->deepLy->supportsLangCode($lang)
            ? $lang
            : DeepLy::LANG_EN;
        $query = strpos($query, '>')
            ? trim(substr($query, 0, strpos($query, '>')))
            : $query;
        try {
            $results    = array();
            $proposals  = $this->deepLy->proposeTranslations($query, $lang);
            $targetLang = $this->deepLy->getTranslationBag()->getTargetLanguage();
            foreach($proposals as $proposal) {
                $temp = array(
                    'uid'          => NULL,
                    'arg'          => $proposal,
                    'title'        => $proposal,
                    'subtitle'     => $query,
                    'icon'         => $this->get_lang_icon($targetLang),
                    'valid'        => 'yes',
                    'autocomplete' => 'autocomplete',
                );
                array_push($results, $temp);
            }
            if (empty($results)) return $this->wf->toXML($thi->empty_result($query));
            else return $this->wf->toXML($results);
        } catch (\Exception $exception) {
            return $this->wf->toXML($this->empty_result($query));
        }
    }
}
?>
