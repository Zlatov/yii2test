<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\components\TreeList;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Страницы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать страницу', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    
    <?php
    if (isset($errors)&&is_array($errors)&&count($errors)) {
        echo '<div class="panel panel-danger">';
        echo '<div class="panel-heading">Обнаружены ошибки!</div>';
        echo '<div class="panel-body">';
        foreach ($errors as $key => $error) {
            foreach ($error as $errorString) {
                echo "$errorString";
            }
        }
        echo '</div>';
        echo '</div>';
    }
    ?>

    <?= TreeList::widget([
        'treeList' => $pageList
    ]); ?>

</div>
