<?php
namespace common\components;

use common\components\TranslatorInterface;
use yii\httpclient\Client;

class YandexTranslator implements TranslatorInterface
{
    private $apiKey = 'trnsl.1.1.20171116T103815Z.de890509a05594eb.07ad8f63c2e9da3b843adc43104ebcde9bb0e6d4';
    private $url = 'https://translate.yandex.net/api/v1.5/tr.json/translate?';
    public function simpleTranslate($text, $langPair)
    {
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('post')
            ->setUrl($this->url)
            ->setData(['key' => $this->apiKey, 'text' => $text, 'lang' => $langPair])
            ->send();
            return $response->data;

    }
}