<?php
require_once('./vendor/autoload.php');

use Octfx\DeepLy\DeepLy;

class DeeplTranslate
{
    private $deepLy;
    private $baseTargets;

    private $langIcons = array(
        'default'       => 'icon.png',
        DeepLy::LANG_DE => 'icons/de.png',
        DeepLy::LANG_EN => 'icons/en.png',
        DeepLy::LANG_ES => 'icons/es.png',
        DeepLy::LANG_FR => 'icons/fr.png',
        DeepLy::LANG_IT => 'icons/it.png',
        DeepLy::LANG_JA => 'icons/jp.png',
        DeepLy::LANG_NL => 'icons/nl.png',
        DeepLy::LANG_PL => 'icons/pl.png',
        DeepLy::LANG_PT => 'icons/pt.png',
        DeepLy::LANG_RU => 'icons/ru.png',
        DeepLy::LANG_ZH => 'icons/zh.png',
    );

    function __construct($key, $defaultTargets)
    {
        $this->deepLy      = new DeepLy($key);
        $this->baseTargets = explode(' ', $defaultTargets);
    }

    private function unique_multidim_array($array, $key)
    {
        $temp_array = array();
        $key_array  = array();
        $i          = 0;
        foreach ($array as $val) {
            if (!in_array($val[$key], $key_array)) {
                $key_array[$i] = $val[$key];
                $temp_array[$i] = $val;
            }
            $i++;
        }
        return $temp_array;
    }

    private function get_lang_icon($lang)
    {
        return isset($this->langIcons[$lang])
            ? $this->langIcons[$lang]
            : $this->langIcons['default'];
    }

    private function empty_result($query)
    {
        $output['items'] = array(array(
            'uid'      => NULL,
            'arg'      => $query,
            'title'    => 'DeepL no translation found',
            'subtitle' => $query,
            'icon'     => $this->langIcons['default'],
            'valid'    => 'no',
        ));
        return $output;
    }

    private function get_targets($query)
    {
        if (strpos($query, '>')) {
            $query    = trim(substr($query, strpos($query, '>') + 1));
            $query    = strtoupper(str_replace(array(',', ' , ', ' ,', ', ', '  '), ' ', $query));
            $exploded = explode(' ', $query);
            $targets  = array_filter($exploded, function ($lang, $key) {
                return in_array($lang, DeepLy::TARGET_LANG_CODES);
            }, ARRAY_FILTER_USE_BOTH);
            return count($targets) > 0
                ? $targets
                : $this->baseTargets;
        } else {
            return $this->baseTargets;
        }
    }

    private function get_input_language($text)
    {
        try {
            return $this->deepLy->detectLanguage($text);
        } catch (\Exception $exception) {
            return false;
        }
    }

    private function clean_query($query)
    {
        return strpos($query, '>')
            ? trim(substr($query, 0, strpos($query, '>')))
            : $query;
    }

    private function strip_punctuation($query)
    {
        return str_replace(array('.', '!', '?'), ' ', $query);
    }

    public function translate($query)
    {
        $proposals = array();
        $results   = array();
        $query     = iconv("UTF-8-MAC", "UTF-8", $query);
        $source    = $this->get_input_language($query);
        $targets   = $this->get_targets($query);
        $process   = $this->clean_query($query);
        try {
            try {
                foreach ($targets as $target) {
                    if ($target !== $source) {
                        $translation = $this->deepLy->translate($process, $target);
                        $proposals[] = array(
                            "lang"        => $target,
                            "translation" => $translation
                        );
                    }
                }
            } catch (\Exception $exception) {
                $proposals[] = array(
                    "lang"        => "default",
                    "translation" => "Sorry, no translation available!"
                );
            }
            foreach ($this->unique_multidim_array($proposals, 'translation') as $proposal) {
                $temp = array(
                    'uid'          => NULL,
                    'arg'          => $proposal['translation'],
                    'title'        => $proposal['translation'],
                    'subtitle'     => $process,
                    'icon'         => array('path' => $this->get_lang_icon($proposal['lang'])),
                    'valid'        => 'yes',
                    'autocomplete' => 'autocomplete',
                );
                array_push($results, $temp);
            }
            if (empty($results)) {
                return json_encode($this->empty_result($query));
            } else {
                $output['items'] = $results;
                return json_encode($output);
            }
        } catch (\Exception $exception) {
            return json_encode($this->empty_result($query));
        }
    }
}
