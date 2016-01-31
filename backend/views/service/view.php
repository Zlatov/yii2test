<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $model common\models\Service */

$this->title = $model->header;
$this->params['breadcrumbs'][] = ['label' => 'Услуги', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="service-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы действительно хотите удалить эту услугу?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <?php
        // echo "<pre>";
        // print_r(ArrayHelper::getColumn($model->getSecs()->all(),'header'));
        // die;
    ?>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'sid',
            'header',
            [
                'label' => 'Секции',
                'value' => implode(', ', ArrayHelper::getColumn($secService,'header')),
            ],
            // 'text:ntext',
            'order',
        ],
    ]) ?>

</div>
