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
    public $layout = 'main.twig';

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
            foreach ($translation['def'] as $key => $value ) {
                $translation['def'][$key]['pos'] = Yii::t('frontend', $translation['def'][$key]['pos']);
            }
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
        //$translator = new Translator(new YandexTranslator());
        //$translation1 = $translator->dictTranslate('test', 'en-ru');
        //$translation1 = $translation1['def'];

        //var_dump($translation1['def'][0]);
        $translation = new Translation();
        if ($translation->load(Yii::$app->request->post()) && $translation->validate()) {
            $text = $translation->text;
            $tr = new Translation();
            $tr = Translation::find()->where(['text' => $text,
                                            'id_voc' => $id
            ])->one();
            //var_dump($tr);
            if ($tr!=null)
            {
                $tr->translation = $translation->translation;
                $tr->date = date('Y-m-d H:i:s', time());
                $tr->update();
            } else
            {
                $translation->date = date('Y-m-d H:i:s', time());
                $translation->id_voc = $id;
                //$translation->date = Yii::$app->formatter->asDate('now', 'Y-m-d H:i:s');


                //$translation->date = new DateTime(time());
                //return "sad";

                $translation->save();
            }
            //var_dump($translation);
            //$lang = 'en-ru';
            //$translation->translation = $this->yandexTranslate($text, $lang);
            //echo date('Y-m-d H:i:s', time());
            //echo 'sad';
            //echo Yii::app()->dateFormatter->formatDateTime(time(), 'long', 'short');

        }


        $voc = Vocabulary::findOne($id);
        $trans = $voc->getTranslations()->orderBy('date DESC')->all();
        //VarDumper::dump($trans);
        $translation = new Translation();
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
