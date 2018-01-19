<?php

namespace frontend\controllers;

use common\components\Translator;
use common\components\YandexTranslator;
use Yii;
use yii\web\Controller;
use frontend\models\Vocabulary;
use common\models\User;
use yii\helpers\VarDumper;
use frontend\models\Translation;

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

    public function actionTranslate()
    {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            $lang =  $data['pair'];
            $text =  $data['text'];
            $translator = new Translator(new YandexTranslator());
            $translation = $translator->dictTranslate($text, $lang);
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return [
                'result' => $translation,

                //'pair' => $data['pair'],
            ];
        }
        //$lang = 'en-ru';
        //$translation->translation = $this->yandexTranslate($text, $lang);
    }

    public function actionView($id)
    {
        $translation = new Translation();
        if ($translation->load(Yii::$app->request->post()) && $translation->validate()) {
            $text = $translation->text;
            //var_dump($translation);
            //$lang = 'en-ru';
            //$translation->translation = $this->yandexTranslate($text, $lang);
            //echo date('Y-m-d H:i:s', time());
            //echo 'sad';
            //echo Yii::app()->dateFormatter->formatDateTime(time(), 'long', 'short');
            $translation->date = date('Y-m-d H:i:s', time());
            $translation->id_voc = $id;
            //$translation->date = Yii::$app->formatter->asDate('now', 'Y-m-d H:i:s');


            //$translation->date = new DateTime(time());
            //return "sad";

            $translation->save();
        }


        $voc = Vocabulary::findOne($id);
        $trans = $voc->translations;
        //VarDumper::dump($trans);
        $translation = new Translation();
        //Yii::$app->session->setFlash('info', 'This is the message')
        //Yii::$app->language = 'ru-U';
        //if (isset($_GET['lang']))
        //    $lang = $_GET['lang'];
        return $this->render('view.twig', ['voc' => $voc, 'trans' => $trans, 'translation' => $translation,]);
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
