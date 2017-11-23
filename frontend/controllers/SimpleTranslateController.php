<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\Translation;

class SimpleTranslateController extends Controller
{
    public function actionIndex()
    {
        \Yii::$app->language = 'ru-RU';
        $lang = \Yii::$app->language;
        $translation = new Translation();
        if($translation->load(Yii::$app->request->post()) && $translation->validate())
        {
            $translation->save();
        }
        return $this->render('index.twig', ['translation' => $translation, 'langq' => $lang]);
    }

}
