<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\SecNews */

$this->title = 'Update Sec News: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Sec News', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="sec-news-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
