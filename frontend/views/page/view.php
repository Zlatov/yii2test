<?php

use common\components\ztree\Ztree;

end($pages_branch);
$endkey = key($pages_branch);
foreach ($pages_branch as $key => $value) {
	if ($key!==$endkey)
	{
		$this->params['breadcrumbs'][] = ['label' => $value['header'], 'url' => ['page/view', 'sid' => $value['sid']]];
	}
	else
	{
		$this->params['breadcrumbs'][] = ['label' => $value['header']];
	}
}

?>

<h1><?= $model->header ?></h1>


<div class="row">
	<div class="col-md-4">
<?= Ztree::widget([
	'ztree' => $current_menu,
	'current_id' => $model->id,
]) ?>
	</div>
	<div class="col-md-8">
<?= $model->text ?>
	</div>
</div>

