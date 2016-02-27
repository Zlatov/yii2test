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

                'user/signup' => 'site/signup',
                'user/logout' => 'site/logout',
                'user/login' => 'site/login',
                'user/request-password-reset' => 'site/request-password-reset',

                // 'news/<sid:\w+>.html' => 'news/view',
                [
                    'class' => 'yii\web\UrlRule',
                    'pattern' => 'news/<sid:\w+>',
                    'route' => 'news/view',
                    'suffix' => '.html',
                ],
                'news/<page:\d+>' => 'news/list',
                'news/<section:[\w-]+>' => 'news/list',
                'news/<section:[\w-]+>/<page:\d+>' => 'news/list',
                // 'news/<action:update>/<id:\d+>' => 'news/<action>',
                // 'news/<action:\w+>' => 'news/<action>',
                'news' => 'news/list',


                // '<action:(.*)>' => 'page/<action>',
                '<sid:[\w-]+>' => 'page/view',

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
