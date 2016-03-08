<?php

use yii\helpers\Url;

?>

<h1>Товары</h1>
<div class="row">
	<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
		<div class="list-group">
			<?php foreach ($categories as $key => $value): ?>
				<a href="<?= Url::to(['product/list','category'=>$value['sid']]) ?>" class="list-group-item"><?= $value['header'] ?></a>
			<?php endforeach ?>
		</div>
	</div>
	<div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
		<?php foreach ($products as $key => $value): ?>
			<h3><a href="<?= Url::to(['product/view','category'=>$value['category_sid'],'id'=>$value['id']]) ?>"><?= $value['header'] ?><span class="pull-right"><?= $value['price'] ?></span></a></h3>
		<?php endforeach ?>
	</div>
</div>
