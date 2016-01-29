<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\components\helpers\Text;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\NewsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Новости';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="row">
        <div class="col-sm-6">
            <p>
                <?= Html::a('Создать новую', ['create'], ['class' => 'btn btn-success']) ?>
            </p>
        </div>
        <div class="col-sm-6">
            <div class="list-group">
                <?php foreach($news_count as $item): ?>
                <a href="<?= Yii::$app->urlManager->createUrl(['news/create','sectionid'=>$item['id']]); ?>" class="list-group-item<?= ($item['countnews']!=='0')?'':' list-group-item-danger' ?>"><span class="badge"><?= $item['countnews'] ?> <?= Text::declension($item['countnews'],'новостей новость новости') ?></span><?= $item['header'] ?></a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            // ['class' => 'yii\grid\SerialColumn'],

            'id',
            'sid',
            'header',
            // 'text:ntext',
            // 'updated_at',
            'created_at',
            // 'sec',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
