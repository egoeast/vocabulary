<?php
namespace common\widgets;

use Yii;
use yii\bootstrap\Widget;


class Hello extends Widget
{
    public $message;

    public function init()
    {
        parent::init();
        if ($this->message === null) {
            $this->message = 'Hello World';
        }
    }

    public function run()
    {
        return $this->message;
    }
}