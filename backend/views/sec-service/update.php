<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\SecService */

$this->title = 'Update Sec Service: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Sec Services', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="sec-service-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
