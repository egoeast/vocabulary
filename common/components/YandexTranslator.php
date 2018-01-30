<?php
namespace common\components;

use common\components\TranslatorInterface;
use yii\httpclient\Client;

class YandexTranslator implements TranslatorInterface
{
    /**
     * @var string
     */
    private $apiKey = 'trnsl.1.1.20171116T103815Z.de890509a05594eb.07ad8f63c2e9da3b843adc43104ebcde9bb0e6d4';
    private $apiKeyDict = 'dict.1.1.20180108T091007Z.c0aa30a3840d3f35.44b82cf3c4bb97fb814e3451ac75f7591c462e0e';

    /**
     * @var string
     */
    private $url = 'https://translate.yandex.net/api/v1.5/tr.json/translate?';
    private $urlDict = 'https://dictionary.yandex.net/api/v1/dicservice.json/lookup?';

    /**
     * Перевод без использования словаря
     * @param $text
     * @param $lang
     * @return mixed
     */
    public function simpleTranslate($text, $lang)
    {
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('post')
            ->setUrl($this->url)
            ->setData(['key' => $this->apiKey, 'text' => $text, 'lang' => $lang])
            ->send();
        return $response->data;
    }

    /**
     * Перевод с помощью словаря. Результат - статья из словаря
     * @param $text
     * @param $lang
     * @return mixed
     */
    public function dictTranslate($text, $lang)
    {
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('post')
            ->setUrl($this->urlDict)
            ->setData(['key' => $this->apiKeyDict, 'text' => $text, 'lang' => $lang])
            ->send();
        return $response->data;
    }

}