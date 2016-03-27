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
            // 'loginUrl' => ['site/login'],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => true,
            'rules' => [

                // MainPage
                '' => 'page/mainpage',

                // Site (User)
                [
                    'class' => 'yii\web\UrlRule',
                    'pattern' => 'user',
                    'route' => 'site/index',
                    'suffix' => '/',
                ],
                'user/basket' => 'site/basket',
                'user/buy' => 'site/buy',
                'user/signup' => 'site/signup',
                'user/logout' => 'site/logout',
                'user/login' => 'site/login',
                'user/about' => 'site/about',
                'user/contact' => 'site/contact',
                'user/request-password-reset' => 'site/request-password-reset',
                'user/reset-password' => 'site/reset-password',

                // News
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


                // Service
                [
                    'class' => 'yii\web\UrlRule',
                    'pattern' => 'service/<sid:[\w-]+>',
                    'route' => 'service/view',
                    'suffix' => '.html',
                ],
                [
                    'class' => 'yii\web\UrlRule',
                    'pattern' => 'service/<page:\d+>',
                    'route' => 'service/list',
                    'suffix' => '/',
                ],
                [
                    'class' => 'yii\web\UrlRule',
                    'pattern' => 'service/<section:[\w-]+>',
                    'route' => 'service/list',
                    'suffix' => '/',
                ],
                [
                    'class' => 'yii\web\UrlRule',
                    'pattern' => 'service/<section:[\w-]+>/<page:\d+>',
                    'route' => 'service/list',
                    'suffix' => '/',
                ],
                [
                    'class' => 'yii\web\UrlRule',
                    'pattern' => 'service',
                    'route' => 'service/list',
                    'suffix' => '/',
                ],

                // Product
                [
                    'class' => 'yii\web\UrlRule',
                    'pattern' => 'products',
                    'route' => 'product/index',
                    'suffix' => '/',
                ],
                [
                    'class' => 'yii\web\UrlRule',
                    'pattern' => 'products/<category:[\w-]+>',
                    'route' => 'product/list',
                    'suffix' => '/',
                ],
                [
                    'class' => 'yii\web\UrlRule',
                    'pattern' => 'products/<category:[\w-]+>/<page:\d+>',
                    'route' => 'product/list',
                    'suffix' => '/',
                ],
                [
                    'class' => 'yii\web\UrlRule',
                    'pattern' => 'products/<category:[\w-]+>/<id:\d+>',
                    'route' => 'product/view',
                    'suffix' => '.html',
                ],

                // Page
                [
                    'class' => 'yii\web\UrlRule',
                    'pattern' => '<sid:[\w-]+>',
                    'route' => 'page/view',
                    'suffix' => '/',
                ],

            ]
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => false,
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
