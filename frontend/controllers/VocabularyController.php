<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\Vocabulary;
use common\models\User;
use yii\helpers\VarDumper;

class VocabularyController extends Controller
{
    public function actionIndex()
    {
        //$user = User::findOne(Yii::$app->user->getId());
        //$user = Yii::$app->user->identity;
        $vocabularies = Yii::$app->user->getIdentity()->vocabularies;
        //VarDumper::dump($vocabularies);
        return $this->render('index.twig', ['vocabularies' => $vocabularies]);
    }

    public function actionView($id)
    {
        $voc = Vocabulary::findOne($id);
        $trans = $voc->translations;
        //VarDumper::dump($trans);
        return $this->render('view.twig', ['voc' => $voc, 'trans'=> $trans]);
    }

    public function actionCreate()
    {   if(!Yii::$app->user->isGuest)
        {
        $voc = new Vocabulary();
        if ($voc->load(Yii::$app->request->post()) && $voc->validate()) {
            $voc->id_user = Yii::$app->user->getId();
            $voc->save();
            return $this->redirect(['vocabulary/index']);
        }
        return $this->render('create.twig', ['voc' => $voc]);
        }
        else echo('Nope');
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

    public function actionDelete($id)
    {
        $voc = Vocabulary::findOne($id);
        $voc->delete();
        return $this->redirect(['vocabulary/index']);
    }

}
