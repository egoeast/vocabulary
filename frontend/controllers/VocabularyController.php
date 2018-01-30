<?php

namespace frontend\controllers;

use common\components\Translator;
use common\components\YandexTranslator;
use Yii;
use yii\web\Controller;
use frontend\models\Vocabulary;
use frontend\models\Translation;

class VocabularyController extends Controller
{


    private $languages = [
        'ru' => 'Russian',
        'en' => 'English',
        'de' => 'German',
        'pl' => 'Polish',
    ];
    /**
     * @return string
     */
    public function actionIndex()
    {
        $vocabularies = Yii::$app->user->getIdentity()->vocabularies;
        return $this->render('index.twig', ['vocabularies' => $vocabularies]);
    }

    /**
     * @return array
     */
    public function actionTranslate()
    {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            $lang = $data['pair'];
            $text = $data['text'];
            $translator = new Translator(new YandexTranslator());
            $translation = $translator->dictTranslate($text, $lang);
            foreach ($translation['def'] as $key => $value) {
                $translation['def'][$key]['pos'] = Yii::t('frontend', $translation['def'][$key]['pos']);
            }
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return [
                'result' => $translation,
            ];
        }
    }

    /**
     * @param $id
     * @return string
     * @throws \Exception
     * @throws \Throwable
     */
    public function actionView($id)
    {
        $translation = new Translation();
        if ($translation->load(Yii::$app->request->post()) && $translation->validate()) {
            $text = $translation->text;
            $tr = new Translation();
            $tr = Translation::find()->where(['text' => $text,
                'id_voc' => $id
            ])->one();
            //var_dump($tr);
            if ($tr != null) {
                $tr->translation = $translation->translation;
                $tr->date = date('Y-m-d H:i:s', time());
                $tr->update();
            } else {
                $translation->date = date('Y-m-d H:i:s', time());
                $translation->id_voc = $id;
                //$translation->date = Yii::$app->formatter->asDate('now', 'Y-m-d H:i:s');
                //$translation->date = new DateTime(time());

                $translation->save();
            }
            //echo date('Y-m-d H:i:s', time());
            //echo Yii::app()->dateFormatter->formatDateTime(time(), 'long', 'short');

        }


        $voc = Vocabulary::findOne($id);
        $trans = $voc->getTranslations()->orderBy('date DESC')->all();
        $translation = new Translation();
        return $this->render('view.twig', ['voc' => $voc, 'trans' => $trans, 'translation' => $translation,]);
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        if (!Yii::$app->user->isGuest) {
            $voc = new Vocabulary();
            if ($voc->load(Yii::$app->request->post()) && $voc->validate()) {
                $voc->id_user = Yii::$app->user->getId();
                $voc->save();
                return $this->redirect(['vocabulary/index']);
            }
            return $this->render('create.twig', ['voc' => $voc, 'languages' => $this->languages]);
        } else echo('Nope');
    }

    /**
     * @param $id
     * @return string
     */
    public function actionUpdate($id)
    {
        $voc = Vocabulary::findOne($id);
        if ($voc->load(Yii::$app->request->post()) && $voc->validate()) {
            $voc->update();
            return $this->render('create.twig', ['voc' => $voc]);
        }
        return $this->render('update.twig', ['voc' => $voc, 'languages' => $this->languages]);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     */
    public function actionDelete($id)
    {
        $voc = Vocabulary::findOne($id);
        $voc->delete();
        return $this->redirect(['vocabulary/index']);
    }

}
