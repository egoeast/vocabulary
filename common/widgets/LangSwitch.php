<?php
namespace common\widgets;

use yii\helpers\Html;
use yii\bootstrap\Widget;

class LangSwitch extends Widget
{
    public $cssClass;
    public function init(){}

    public function run() {

        return $this->render('view', [
            'cssClass' => $this->cssClass,
        ]);

    }
}