<?php

namespace frontend\controllers;

use frontend\models\Translation;
use yii\web\Controller;
use Yii;

class TranslationController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionDelete($id)
    {
        $translation = new Translation();
        $translation->findOne($id)->delete();
        return  $this->redirect(Yii::$app->request->referrer);
    }

}
