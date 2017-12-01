<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\Translation;

class SimpleTranslateController extends Controller
{
    public function yandexTranslate($text, $lang)
    {
        $apiKey = 'trnsl.1.1.20171116T103815Z.de890509a05594eb.07ad8f63c2e9da3b843adc43104ebcde9bb0e6d4';
        $params = array( 'key' => $apiKey, 'text' => $text, 'lang' => $lang,);
        $query = http_build_query($params);
        $response = file_get_contents('https://translate.yandex.net/api/v1.5/tr.json/translate?'.$query);
        $data = json_decode($response, true);
        $text = $data['text'][0];
        return $text;
    }

    public function actionIndex()
    {
        //\Yii::$app->language = 'ru-RU';
        //$lang = \Yii::$app->language;
        $translation = new Translation();
        //$translation->text ='123';
        //$translation->translation ='123';
        //$translation->id_voc = '1';
        //$translation->save();
        if($translation->load(Yii::$app->request->post()) && $translation->validate())
        {
            $text = $translation->text;
            $lang = 'en-ru';
            $translation->translation = $this->yandexTranslate($text, $lang);
            //return "sad";

            $translation->save();
        }
        return $this->render('index.twig', ['translation' => $translation]);
    }

}
