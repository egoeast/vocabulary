<?php

namespace frontend\controllers;

use Faker\Provider\cs_CZ\DateTime;
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

    public function actionTranslate()
    {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            //$lang = $data['pair'];
            $lang =  $data['pair'];
            $text =  $data['text'];
            $translation = $this->yandexTranslate($text, $lang);
            //$searchby= explode(":", $data['searchby']);
            //$searchname= $searchname[0];
            //$searchby= $searchby[0];
            //$search = // your logic;
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return [
                'result' => $translation,

                //'pair' => $data['pair'],
            ];
        }
        //$lang = 'en-ru';
        //$translation->translation = $this->yandexTranslate($text, $lang);
    }

    public function actionIndex()
    {
        if (Yii::$app->user->can('simpleTranslate')) {
            Yii::$app->language = 'ru-RU';
            //$lang = \Yii::$app->language;
            $translation = new Translation();
            //$translation->text ='123';
            //$translation->translation ='123';
            //$translation->id_voc = '1';
            //$translation->save();
            //Yii::$app->formatter->locale = 'ru-RU';
            //echo Yii::$app->formatter->asDate(time(), 'long', 'short');

            // echo Yii::$app->dateFormatter->formatDateTime(time(), 'long', 'short');
            if ($translation->load(Yii::$app->request->post()) && $translation->validate()) {
                $text = $translation->text;
                $lang = 'en-ru';
                $translation->translation = $this->yandexTranslate($text, $lang);
                //echo date('Y-m-d H:i:s', time());
                //echo 'sad';
                //echo Yii::app()->dateFormatter->formatDateTime(time(), 'long', 'short');
                $translation->date = date('Y-m-d H:i:s', time());
                //$translation->date = Yii::$app->formatter->asDate('now', 'Y-m-d H:i:s');


                //$translation->date = new DateTime(time());
                //return "sad";

                $translation->save();
            }
            //echo Yii::$app->formatter->asDate(date('Y-m-d H:i:s', time()));
            $vocabularies = Yii::$app->user->getIdentity()->vocabularies;
            return $this->render('index.twig', ['translation' => $translation, 'vocabularies' => $vocabularies]);
        }
        else $this->redirect('site/need-to-register');
    }

}
