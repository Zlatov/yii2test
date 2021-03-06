<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\SecNewsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sec News';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sec-news-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Sec News', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'sid',
            'header',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
