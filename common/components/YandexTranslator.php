<?php
namespace common\components;

use common\components\TranslatorInterface;

class YandexTranslator implements TranslatorInterface
{
    public function simpleTranslate($text, $langPair)
    {
        $apiKey = 'trnsl.1.1.20171116T103815Z.de890509a05594eb.07ad8f63c2e9da3b843adc43104ebcde9bb0e6d4';
        $params = array( 'key' => $apiKey, 'text' => $text, 'lang' => $langPair,);
        $query = http_build_query($params);
        $response = file_get_contents('https://translate.yandex.net/api/v1.5/tr.json/translate?'.$query);
        $data = json_decode($response, true);
        $text = $data['text'][0];
        return $text;
    }
}