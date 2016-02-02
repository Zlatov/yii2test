<?php 
use  yii\helpers\Html;
?>

<li>#<?= $val['id'] ?> (<?= is_null($val['pid'])?'Null':$val['pid'] ?>) <?= $val['header'] ?> 
<?= Html::a('<span class="glyphicon glyphicon-eye-open"></span>', 
	Yii::$app->urlManager->createUrl([Yii::$app->controller->id.'/view','id'=>$val['id']])) ?> 
<?= Html::a('<span class="glyphicon glyphicon-pencil"></span>', 
	Yii::$app->urlManager->createUrl([Yii::$app->controller->id.'/update','id'=>$val['id']])) ?> 
<?= $enableDel?Html::a(
		'<span class="glyphicon glyphicon-trash"></span>',
		[Yii::$app->controller->id.'/delete', 'id'=>$val['id']],
		['data' => ['confirm' => "Are you sure you want to delete profile?",'method' => 'post']]
):'' ?> 
