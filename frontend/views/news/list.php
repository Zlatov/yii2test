<?php
use  yii\helpers\Url;
?>
<div class="row">
	<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
	<?php foreach ($sections as $key => $value): ?>
		<a href="<?= Url::to(['news/list','section'=>$value['sid']]) ?>"><?= $value['header'] ?></a><br>
	<?php endforeach ?>
	</div>
	<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
	<?php foreach ($news as $key => $value): ?>
		<div>
			<?= $value->ttTimeStamp($value->created_at) ?>
			<?php //= $value->created_at ?>
			<h3><?= $value->header ?></h3>
		</div>
	<?php endforeach ?>
	</div>
</div>

<?php
// echo "<pre>";
// print_r($news);
// echo "</pre>";

// echo "<pre>";
// print_r($sections);
// echo "</pre>";

