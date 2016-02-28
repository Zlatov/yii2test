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
			<a href="<?= Url::to(['news/list','section'=>$value['sid']]) ?>"><?= $value['header'] ?></a><br>
		<?php endforeach ?>
	</div>
	<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
		<h1>Новости</h1>
		<?php if (count($news)!==0): ?>
			<?php foreach ($news as $key => $value): ?>
				<?php // echo "<pre>"; print_r($value->sec0->sid); die(); ?>
				<div>
					<?= $value->ttTimeStamp($value->created_at) ?>
					<?php //= $value->created_at ?>
					<h3><a href="<?= Url::to(['news/view','sid'=>$value->sid, 'section'=>$value->sec0->sid]); ?>"><?= $value->header ?></a></h3>
				</div>
			<?php endforeach; ?>
			<?= LinkPager::widget(['pagination' => $pagination,]); ?>
		<?php else: ?>
			<p>Нет записей</p>
		<?php endif; ?>
	</div>
</div>