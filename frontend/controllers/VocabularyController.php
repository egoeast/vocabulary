<?php

namespace frontend\controllers;

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

    public function yandexDicTranslate($text, $lang)
    {
        $apiKey = 'dict.1.1.20180108T091007Z.c0aa30a3840d3f35.44b82cf3c4bb97fb814e3451ac75f7591c462e0e';
        $params = array( 'key' => $apiKey,'lang' => $lang, 'text' => $text );
        $query = http_build_query($params);
        $response = file_get_contents('https://dictionary.yandex.net/api/v1/dicservice.json/lookup?'.$query);
        $data = json_decode($response, true);
        //$text = $data['text'][0];
        return $data;
    }

    public function actionTranslate()
    {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            //$lang = $data['pair'];
            //$lang =  $data['pair'];
            $text =  $data['text'];
            $translation = $this->yandexDicTranslate($text, 'en-ru');
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

    public function actionView($id)
    {
        $voc = Vocabulary::findOne($id);
        $trans = $voc->translations;
        //VarDumper::dump($trans);
        $translation = new Translation();
        //Yii::$app->session->setFlash('info', 'This is the message');
        //Yii::$app->language = 'ru-RU';
        return $this->render('view.twig', ['voc' => $voc, 'trans' => $trans, 'translation' => $translation]);
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
