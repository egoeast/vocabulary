<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\Vocabulary;
use yii\helpers\VarDumper;

class VocabularyController extends Controller
{
    public function actionIndex()
    {
        $vocabularies = Vocabulary::find()->all();
        //VarDumper::dump($vocabularies);
        return $this->render('index.twig', ['vocabularies' => $vocabularies]);
    }

    public function actionCreate()
    {
        $voc = new Vocabulary();
        if($voc->load(Yii::$app->request->post()) && $voc->validate())
        {
            $voc->save();
            $voc = new Vocabulary();
            return $this->render('create.twig', ['voc' => $voc]);
        }
        return $this->render('create.twig', ['voc' => $voc]);
    }

    public function actionUpdate($id)
    {
        $voc = Vocabulary::findOne($id);
        //VarDumper::dump($voc);
        if($voc->load(Yii::$app->request->post()) && $voc->validate())
        {
            $voc->update();
            //$voc = new Vocabulary();
            return $this->render('create.twig', ['voc' => $voc]);
        }
        return $this->render('update.twig', ['voc' => $voc]);
    }

}
