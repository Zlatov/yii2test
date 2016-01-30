<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\SecService */

$this->title = 'Create Sec Service';
$this->params['breadcrumbs'][] = ['label' => 'Sec Services', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sec-service-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
