<?php

use yii\helpers\Url;
use yii\widgets\LinkPager;

end($branch);
$endkey = key($branch);
foreach ($branch as $key => $value) {
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

<div class="row">
	<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
		<h3>Разделы</h3>
		<?php foreach ($sections as $key => $value): ?>
			<a href="<?= Url::to(['service/list','section'=>$value['sid']]) ?>"><?= $value['header'] ?></a><br>
		<?php endforeach ?>
	</div>
	<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
		<h1>Услуги</h1>
		<?php if (count($service)!==0): ?>
			<?php foreach ($service as $key => $value): ?>
				<?php // echo "<pre>"; print_r($value); die(); ?>
				<?php // echo "<pre>"; print_r($value->sec0->sid); die(); ?>
				<div>
					<h3><a href="<?= Url::to(['service/view','sid'=>$value->sid]); ?>"><?= $value->header ?></a></h3>
				</div>
			<?php endforeach; ?>
			<?= LinkPager::widget(['pagination' => $pagination,]); ?>
		<?php else: ?>
			<p>Нет записей</p>
		<?php endif; ?>
	</div>
</div>