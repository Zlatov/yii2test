<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Service */

$this->title = 'Редактирование услуги: ' . ' ' . $model->header;
$this->params['breadcrumbs'][] = ['label' => 'Услуги', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->header, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="service-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'secServiceList' => $secServiceList,
    ]) ?>

</div>
