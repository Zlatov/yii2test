<?php
use yii\bootstrap\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use common\components\helpers\Text;

$this->title = 'Покупки';
$this->params['breadcrumbs'][] = $this->title;

?>

<h1><?= Html::encode($this->title) ?></h1>


<?php foreach ($buyList as $buy): ?>
	<div class="row">
		<div class="col-sm-12">
			<p>Покупка совершена <strong><?= Text::tsToStr($buy['trade_ts']) ?></strong>, куплено <strong><?= $buy['count_product'] ?></strong> различных товаров, общее количество <strong><?= $buy['count_units'] ?></strong> на сумму <strong><?= $buy['total_price'] ?></strong> &#8381;.</p>
		</div>
	</div>
<?php endforeach ?>

<p><?= Text::tsToStr('2016-03-19 16:15:30') ?></p>
<p><?= Text::tsToStr('2016-03-19 16:15:25') ?></p>
<p><?= Text::tsToStr('2016-03-19 16:14:30') ?></p>
<p><?= Text::tsToStr('2016-03-19 15:15:30') ?></p>
<p><?= Text::tsToStr('2016-03-18 16:15:30') ?></p>
<p><?= Text::tsToStr('2016-02-19 16:15:30') ?></p>
<p><?= Text::tsToStr('2015-02-19 16:15:30') ?></p>


<?php if (count($buyList)===1 && $buyList[0]['count_product']==='0'): ?>
	<p>У вас нет совершенных покупок.</p>
<?php endif ?>
