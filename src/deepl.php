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
        $this->wf 	      = new Workflows('de.m9dfukc.deepltranslate');
        $this->deepLy     = new DeepLy();
        $this->baseTarget = $this->get_supported($lang);
    }

    private function get_lang_icon($lang) {
        return isset($this->langIcons[$lang])
            ? $this->langIcons[$lang]
            : $this->langIcons['default'];
    }

    private function empty_result($query) {
        return array (array (
            'uid'      => NULL,
            'arg'      => $query,
            'title'    => 'DeepL no translation found',
            'subtitle' => $query,
            'icon'     => $this->langIcons['default'],
            'valid'    => 'no',
        ));
    }

    private function get_supported($lang) {
        $lang = strtoupper($lang);
        return $this->deepLy->supportsLangCode($lang)
            ? $lang
            : DeepLy::LANG_EN;
    }

    private function get_targets($query) {
        if (strpos($query, '>')) {
            $query    = trim(substr($query, strpos($query, '>') + 1));
            $query    = strtoupper(str_replace(array(',', ' , ', ' ,', ', ', '  '), ' ', $query));
            $exploded = explode(' ', $query);
            $targets  = array_filter($exploded, function($lang, $key) {
                return in_array($lang, DeepLy::LANG_CODES);
            }, ARRAY_FILTER_USE_BOTH);
            return count($targets) > 0
                ? $targets
                : array($this->baseTarget);
        } else {
            return array ($this->baseTarget);
        }
    }

    private function clean_query($query) {
        return strpos($query, '>')
            ? trim(substr($query, 0, strpos($query, '>')))
            : $query;
    }

    private function strip_punctuation($query) {
        return str_replace(array('.', '!', '?'), ' ', $query);
    }

    public function translate($query) {
        $proposals = array();
        $results   = array();
        $targets   = $this->get_targets($query);
        $process   = $this->clean_query($query);
        $maxItems  = count($targets) > 1 ? 3 : 4;
        try {
            try {
                foreach($targets as $target) {
                    $sentence = $this->strip_punctuation($process);
                    foreach($this->deepLy->proposeTranslations($sentence, $target) as $index => $translation) {
                        if ($index >= $maxItems) break;
                        $proposals[] = array (
                            "lang"        => $this->deepLy->getTranslationBag()->getTargetLanguage(),
                            "translation" => $translation
                        );
                    }
                }
            } catch (\Exception $exception) {
                foreach($targets as $target) {
                    $sentences = $this->deepLy->splitText($query);
                    $sentence  = implode($this->deepLy->translateSentences($sentences, $lang), ' ');
                    foreach($sentence as $index => $translation) {
                        if ($index >= $maxItems) break;
                        $proposals[] = array (
                            "lang"        => $this->deepLy->getTranslationBag()->getTargetLanguage(),
                            "translation" => $translation
                        );
                    }
                }
            }
            $targetLang = $this->deepLy->getTranslationBag()->getTargetLanguage();
            foreach($proposals as $proposal) {
                $temp = array(
                    'uid'          => NULL,
                    'arg'          => $proposal['translation'],
                    'title'        => $proposal['translation'],
                    'subtitle'     => $process,
                    'icon'         => $this->get_lang_icon($proposal['lang']),
                    'valid'        => 'yes',
                    'autocomplete' => 'autocomplete',
                );
                array_push($results, $temp);
            }
            if (empty($results)) {
                return $this->wf->toXML($this->empty_result($query));
            } else {
                return $this->wf->toXML($results);
            }
        } catch (\Exception $exception) {
            return $this->wf->toXML($this->empty_result($query));
        }
    }
}
?>
