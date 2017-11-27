<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\Translation;

class SimpleTranslateController extends Controller
{
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
            //return "sad";

            $translation->save();
        }
        return $this->render('index.twig', ['translation' => $translation]);
    }

}
