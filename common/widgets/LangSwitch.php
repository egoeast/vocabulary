<?php
namespace common\widgets;

use Yii;
use yii\helpers\Html;
use yii\bootstrap\Widget;

class LangSwitch extends Widget
{
    public $cssClass;
    public function init(){}

    public function run() {
        Yii::$app->language = 'ru-RU';
        return $this->render('view', [
            'cssClass' => $this->cssClass,
        ]);

    }
}