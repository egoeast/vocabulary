<?php
namespace common\widgets\LangSwitch;
use yii\helpers\Html;
use Yii;
?>

<div class="btn-group <?= $cssClass; ?>">
    <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
        <span class="uppercase"><?= $_SESSION['_language'] ?></span>
        <span class="caret"></span>
    </a>

    <ul class="dropdown-menu">
        <li class="item-lang">
            <?= Html::a('English', array_merge(
                \Yii::$app->request->get(),
                [\Yii::$app->controller->route, 'language' => 'en-US']
            )); ?>
        </li>
        <li class="item-lang">
            <?= Html::a('Русский', array_merge(
                \Yii::$app->request->get(),
                [\Yii::$app->controller->route, 'language' => 'ru-RU']
            )); ?>
        </li>
    </ul>
</div>