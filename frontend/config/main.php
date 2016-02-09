<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => true,
            'rules' => [
                '' => 'page/mainpage',

                // '<action:(.*)>' => 'page/<action>',
                '<sid:[\w-]+>' => 'page/view',

                // 'news/<sid:\w+>.html' => 'news/view',
                [
                    'class' => 'yii\web\UrlRule',
                    'pattern' => 'news/<sid:\w+>',
                    'route' => 'news/view',
                    'suffix' => '.html',
                ],

                'news/<action:update>/<id:\d+>' => 'news/<action>',
                'news/<action:\w+>' => 'news/<action>',
            ]
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
    ],
    'params' => $params,
];
