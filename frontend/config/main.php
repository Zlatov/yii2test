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

                // mainpage
                '' => 'page/mainpage',

                // site
                'user/signup' => 'site/signup',
                'user/logout' => 'site/logout',
                'user/login' => 'site/login',
                'user/request-password-reset' => 'site/request-password-reset',

                // news
                // 'news/<sid:\w+>.html' => 'news/view',
                [
                    'class' => 'yii\web\UrlRule',
                    'pattern' => 'news/<section:[\w-]+>/<sid:[\w-]+>',
                    'route' => 'news/view',
                    'suffix' => '.html',
                ],
                [
                    'class' => 'yii\web\UrlRule',
                    'pattern' => 'news/<page:\d+>',
                    'route' => 'news/list',
                    'suffix' => '/',
                ],
                [
                    'class' => 'yii\web\UrlRule',
                    'pattern' => 'news/<section:[\w-]+>',
                    'route' => 'news/list',
                    'suffix' => '/',
                ],
                [
                    'class' => 'yii\web\UrlRule',
                    'pattern' => 'news/<section:[\w-]+>/<page:\d+>',
                    'route' => 'news/list',
                    'suffix' => '/',
                ],
                [
                    'class' => 'yii\web\UrlRule',
                    'pattern' => 'news',
                    'route' => 'news/list',
                    'suffix' => '/',
                ],

                //page
                [
                    'class' => 'yii\web\UrlRule',
                    'pattern' => '<sid:[\w-]+>',
                    'route' => 'page/view',
                    'suffix' => '/',
                ],

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
