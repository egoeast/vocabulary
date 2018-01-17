<?php

namespace frontend\controllers;

use common\components\Translator;
use Faker\Provider\cs_CZ\DateTime;
use Yii;
use yii\web\Controller;
use frontend\models\Translation;
use common\components\YandexTranslator;

class SimpleTranslateController extends Controller
{

    public function actionTest()
    {
        $lang = 'en-ru';
        $text =  'test';
        $traslator = new Translator(new YandexTranslator());
        $translation = $traslator->translate($text, $lang);
        var_dump($translation);
        //return $this->render('test.twig', ['translation' => $translation]);
    }

    public function actionTranslate()
    {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            $lang =  $data['pair'];
            //$lang = 'jk-op';
            $text =  $data['text'];
            $traslator = new Translator(new YandexTranslator());
            $translation = $traslator->translate($text, $lang);

            //if ($translation['code'] != 200)
            //    Yii::$app->session->setFlash('error',Yii::t('frontend', $translation['message'] ));
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return [
                'result' => $translation['text'][0],
            ];
        }
    }

    public function actionIndex()
    {
        if (Yii::$app->user->can('simpleTranslate')) {
            //Yii::$app->language = 'ru-RU';
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
