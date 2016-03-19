<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'Тестовый сайт',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);

    $mainMenu = Yii::$app->db->createCommand('call main_menu')->queryAll();

    $menuItems = [];
    foreach ($mainMenu as $key => $value) {
    // foreach ($this->params['mainMenu'] as $key => $value) {
        if (is_null($value['pid'])) {
            $menuItems[$value['id']] =
                [
                    'label' => $value['header'],
                    'url' => ['page/view','sid'=>$value['sid']],
                ];
        }
        else {
            $menuItems[$value['pid']]['items'][] =
                [
                    'label' => $value['header'],
                    'url' => ['page/view','sid'=>$value['sid']],
                ];
        }
    }

    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Зарегистрироваться', 'url' => ['/site/signup']];
        $menuItems[] = ['label' => 'Войти', 'url' => ['/site/login']];
    } else {
        $menuItems[] = [
            'label' => 'Панель пользователя (' . Yii::$app->user->identity->username . ')',
            'items' => [
                [
                    'label' => 'Корзина',
                    'url' => ['/site/basket'],
                ],
                [
                    'label' => 'Покупки',
                    'url' => ['/site/buy'],
                ],
                [
                    'label' => 'Профиль пользователя',
                    'url' => ['/site/about'],
                ],
                [
                    'label' => 'Обратная связь',
                    'url' => ['/site/contact'],
                ],
                [
                    'label' => 'Сброс пароля',
                    'url' => ['/site/request-password-reset'],
                ],
                [
                    'label' => 'Выход',
                    'url' => ['/site/logout'],
                    'linkOptions' => ['data-method' => 'post']
                ],
            ]
        ];
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
