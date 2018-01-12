<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    //'language' => 'ru-RU',
    'sourceLanguage' => 'en-US',
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [

        
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        'urlManager' => [
            'class' => 'codemix\localeurls\UrlManager',

            'languages' => ['en-US', 'en', 'ru-Ru', 'ru'],
            //'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'voc' => 'test/index',
                'trans' => 'simple-translate/index',
                'voc-view/<id:\d+>' => 'vocabulary/view',
                
            ],
            'ignoreLanguageUrlPatterns' => [
                // route pattern => url pattern
                //'#^site/(login|register)#' => '#^(signin|signup)#',
                '#^vocabulary/translate#' => '#^vocabulary/translate#',
                '#^simple-translate/translate#' => '#^simple-translate/translate#',
            ],
        ],
        'view' => [
            'class' => 'yii\web\View',
            'renderers' => [
                'twig' => [
                    'class' => 'yii\twig\ViewRenderer',
                    'cachePath' => '@runtime/Twig/cache',
                    // Array of twig options:
                    'options' => [
                        'auto_reload' => true,
                    ],
                    'globals' => [
                        'html' => ['class' => '\yii\helpers\Html'],
                        'format' => ['class' => 'yii\i18n\Formatter'],
                    ],
                    'functions' => array(
                        'lang' => 'Yii::t',
                        //'hello' => 'Hello::widget',
                        //'dateformat' => 'Yii::$app->formatter->asDate',
                    ),
                    'uses' => ['yii\bootstrap'],
                    'extensions' => [
                        //'Twig\Extensions\I18nExtension',
                    ],

                ],
                // ...

            ],
        ],


    ],
    'params' => $params,
];
