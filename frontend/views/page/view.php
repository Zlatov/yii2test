<?php

use common\components\ztree\Ztree;

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

