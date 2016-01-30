<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\SecServiceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Секции услуг';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sec-service-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать секцию', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            // [
            //     'class' => 'yii\grid\SerialColumn',
            //     'contentOptions' => ['style' => 'max-width:20px;'],
            // ],
            // ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'id',
                'contentOptions' => ['style' => 'width:40px;'],
            ],
            // [
            //     'attribute' => 'sid',
            //     'format' => 'raw',
            //     'label' => 'Стр. ид.',
            //     'contentOptions' => ['style' => 'width:100px;'],
            // ],
            'sid',
            'header',
            // 'order',

            [
                'class' => 'yii\grid\ActionColumn',
                'contentOptions' => ['style' => 'width:70px;'],
            ],
        ],
    ]); ?>

</div>
