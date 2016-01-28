<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\SecNews */

$this->title = 'Create Sec News';
$this->params['breadcrumbs'][] = ['label' => 'Sec News', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sec-news-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
