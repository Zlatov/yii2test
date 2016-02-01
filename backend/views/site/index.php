<?php

/* @var $this yii\web\View */
use yii\helpers\Html;

$this->title = 'My Yii Application';
?>
<div class="site-index">

<!--     <div class="jumbotron">
        <h1>Панель администрирования!</h1>
    </div> -->

    <div class="body-content">

        <div class="row">
            <div class="col-lg-3">
                <h2>Новости</h2>
                <p>
                    <?= Html::a('Новости', ['news/index'], ['class' => 'btn btn-success']) ?>
                    <?= Html::a('Секции новостей', ['sec-news/index'], ['class' => 'btn btn-success']) ?>
                </p>
            </div>
            <div class="col-lg-3">
                <h2>Услуги</h2>
                <p>
                    <?= Html::a('Услуги', ['service/index'], ['class' => 'btn btn-success']) ?>
                    <?= Html::a('Секции услуг', ['sec-service/index'], ['class' => 'btn btn-success']) ?>
                </p>
            </div>
            <div class="col-lg-3">
                <h2>Страницы</h2>
                <p>
                    <?= Html::a('Страницы', ['page/index'], ['class' => 'btn btn-success']) ?>
                </p>
            </div>
            <div class="col-lg-3">
                <h2>Товары</h2>
            </div>
        </div>

    </div>
</div>
