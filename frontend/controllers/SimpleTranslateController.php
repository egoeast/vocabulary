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

    /**
     *
     */
    public function actionTest()
    {
        $lang = 'en-ru';
        $text =  'test';
        $traslator = new Translator(new YandexTranslator());
        $translation = $traslator->translate($text, $lang);
        var_dump($translation);
    }

    /**
     * @return array
     */
    public function actionTranslate()
    {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            $lang =  $data['lang'];
            $text =  $data['text'];
            $traslator = new Translator(new YandexTranslator());
            $translation = $traslator->translate($text, $lang);
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return [
                'result' => $translation,
            ];
        }
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        if (Yii::$app->user->can('simpleTranslate')) {
            $translation = new Translation();
            if ($translation->load(Yii::$app->request->post()) && $translation->validate()) {
                $text = $translation->text;
                $lang = 'en-ru';
                $translator = new Translator(new YandexTranslator());
                $translation->translation = $translator->translate($text, $lang);
                $translation->date = date('Y-m-d H:i:s', time());
                $translation->save();
            }
            $vocabularies = Yii::$app->user->getIdentity()->vocabularies;
            return $this->render('index.twig', ['translation' => $translation, 'vocabularies' => $vocabularies]);
        }
        else $this->redirect('site/need-to-register');
    }

}
